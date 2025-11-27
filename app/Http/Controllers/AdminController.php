<?php

namespace App\Http\Controllers;

use App\Models\PendaftarDataSiswa;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Wilayah;
use App\Models\Pendaftar;
use App\Models\PendaftarBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $stats = [
            'total_pendaftar' => Pendaftar::count(),
            'pendaftar_submit' => Pendaftar::where('status', 'SUBMIT')->count(),
            'pendaftar_adm_pass' => Pendaftar::where('status', 'ADM_PASS')->count(),
            'pendaftar_paid' => Pendaftar::where('status', 'PAID')->count(),
        ];

        // Pendaftar per Jurusan - return sebagai collection of objects
        $pendaftarPerJurusan = Jurusan::select('id', 'nama')
            ->withCount(['pendaftar'])
            ->get()
            ->map(function ($jurusan) {
                return (object) [
                    'nama' => $jurusan->nama,
                    'total' => $jurusan->pendaftar_count
                ];
            });

        // Pendaftar per Gelombang - return sebagai collection of objects  
        $pendaftarPerGelombang = Gelombang::select('id', 'nama')
            ->withCount(['pendaftar'])
            ->get()
            ->map(function ($gelombang) {
                return (object) [
                    'nama' => $gelombang->nama,
                    'total' => $gelombang->pendaftar_count
                ];
            });

        return view('admin.dashboard', compact('stats', 'pendaftarPerJurusan', 'pendaftarPerGelombang'));
    }
    // Master Data - Jurusan
    public function jurusanIndex()
    {
        // Load jurusan dengan count pendaftar
        $jurusan = Jurusan::withCount(['pendaftar'])->get();

        return view('admin.master.jurusan', compact('jurusan'));
    }
    public function jurusanStore(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:jurusan,kode|max:10',
            'nama' => 'required|max:100',
            'kuota' => 'required|integer|min:1'
        ]);

        Jurusan::create($request->all());

        return redirect()->route('admin.jurusan')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function jurusanUpdate(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|max:10|unique:jurusan,kode,' . $id,
            'nama' => 'required|max:100',
            'kuota' => 'required|integer|min:1'
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function jurusanDestroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Check if jurusan has pendaftar
        if ($jurusan->pendaftar()->count() > 0) {
            return redirect()->route('admin.jurusan')
                ->with('error', 'Tidak dapat menghapus jurusan yang sudah memiliki pendaftar.');
        }

        $jurusan->delete();

        return redirect()->route('admin.jurusan')
            ->with('success', 'Jurusan berhasil dihapus.');
    }

    // Master Data - Gelombang
    public function gelombangIndex()
    {
        // Load gelombang dengan count pendaftar
        $gelombang = Gelombang::withCount(['pendaftar'])->get();

        return view('admin.master.gelombang', compact('gelombang'));
    }
    public function gelombangStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'tahun' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|numeric|min:0'
        ]);

        Gelombang::create($request->all());

        return redirect()->route('admin.gelombang')
            ->with('success', 'Gelombang berhasil ditambahkan.');
    }

    public function gelombangUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'tahun' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
            'biaya_daftar' => 'required|numeric|min:0'
        ]);

        $gelombang = Gelombang::findOrFail($id);
        $gelombang->update($request->all());

        return redirect()->route('admin.gelombang')
            ->with('success', 'Gelombang berhasil diperbarui.');
    }

    public function gelombangDestroy($id)
    {
        $gelombang = Gelombang::findOrFail($id);

        // Check if gelombang has pendaftar
        if ($gelombang->pendaftar()->count() > 0) {
            return redirect()->route('admin.gelombang')
                ->with('error', 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar.');
        }

        $gelombang->delete();

        return redirect()->route('admin.gelombang')
            ->with('success', 'Gelombang berhasil dihapus.');
    }

    // Monitoring Berkas
    public function monitoringBerkas()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'gelombang', 'berkas'])
            ->orderBy('tanggal_daftar', 'desc')
            ->get();

        return view('admin.monitoring.berkas', compact('pendaftar'));
    }

    public function detailBerkas($id)
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'gelombang', 'berkas', 'dataSiswa', 'dataOrtu', 'asalSekolah'])
            ->findOrFail($id);

        return view('admin.monitoring.detail-berkas', compact('pendaftar'));
    }

    // Peta Sebaran
    public function petaSebaran()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])
            ->whereHas('dataSiswa', function ($query) {
                $query->whereNotNull('lat')->whereNotNull('lng');
            })
            ->get();

        $dataMap = $pendaftar->map(function ($item) {
            return [
                'nama' => $item->dataSiswa->nama,
                'jurusan' => $item->jurusan->nama,
                'lat' => $item->dataSiswa->lat,
                'lng' => $item->dataSiswa->lng,
                'alamat' => $item->dataSiswa->alamat,
                'status' => $item->status
            ];
        });

        // Get unique jurusan list for filter
        $jurusanList = Jurusan::pluck('nama')->toArray();

        return view('admin.peta.sebaran', compact('dataMap', 'jurusanList'));
    }

    // Statistik Sebaran per Wilayah
    public function statistikWilayah()
    {
        $statistik = PendaftarDataSiswa::select(
            'wilayah.kecamatan',
            'wilayah.kelurahan',
            DB::raw('COUNT(*) as total')
        )
            ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
            ->groupBy('wilayah.kecamatan', 'wilayah.kelurahan')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.peta.statistik-wilayah', compact('statistik'));
    }

    // Method untuk AJAX detail wilayah
    public function getDetailWilayah(Request $request)
    {
        try {
            $kecamatan = $request->get('kecamatan');
            $kelurahan = $request->get('kelurahan');

            // Validasi parameter
            if (!$kecamatan || !$kelurahan) {
                return response()->json([
                    'error' => 'Parameter kecamatan dan kelurahan diperlukan'
                ], 400);
            }

            $pendaftar = Pendaftar::select(
                'pendaftar.no_pendaftaran',
                'pendaftar.status',
                'pendaftar_data_siswa.nama',
                'jurusan.nama as jurusan'
            )
                ->join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
                ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
                ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
                ->where('wilayah.kecamatan', $kecamatan)
                ->where('wilayah.kelurahan', $kelurahan)
                ->get()
                ->map(function ($item) {
                    $statusClass = [
                        'SUBMIT' => 'warning',
                        'ADM_PASS' => 'success',
                        'ADM_REJECT' => 'danger',
                        'PAID' => 'info'
                    ][$item->status] ?? 'secondary';

                    return [
                        'no_pendaftaran' => $item->no_pendaftaran,
                        'nama' => $item->nama,
                        'jurusan' => $item->jurusan,
                        'status' => $item->status,
                        'status_class' => $statusClass
                    ];
                });

            return response()->json([
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'total_pendaftar' => $pendaftar->count(),
                'pendaftar' => $pendaftar
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getDetailWilayah: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    // Export PDF untuk Statistik Wilayah 
    public function exportStatistikWilayahPDF(Request $request)
    {
        try {
            $searchTerm = $request->get('search');

            // Query statistik wilayah
            $query = PendaftarDataSiswa::select(
                'wilayah.kecamatan',
                'wilayah.kelurahan',
                DB::raw('COUNT(*) as total')
            )
                ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
                ->groupBy('wilayah.kecamatan', 'wilayah.kelurahan');

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('wilayah.kecamatan', 'like', "%{$searchTerm}%")
                        ->orWhere('wilayah.kelurahan', 'like', "%{$searchTerm}%");
                });
            }

            $statistik = $query->orderBy('total', 'desc')->get();

            // Hitung total dan persentase
            $totalAll = $statistik->sum('total');
            $statistik = $statistik->map(function ($item) use ($totalAll) {
                $item->persentase = $totalAll > 0 ? round(($item->total / $totalAll) * 100, 2) : 0;
                return $item;
            });

            // Statistik summary
            $summary = [
                'total_wilayah' => $statistik->count(),
                'total_pendaftar' => $totalAll,
                'rata_rata' => $statistik->count() > 0 ? round($totalAll / $statistik->count(), 1) : 0,
                'wilayah_terbanyak' => $statistik->max('total') ?? 0,
                'top_5_wilayah' => $statistik->take(5)
            ];

            $pdf = Pdf::loadView('admin.export.statistik-wilayah-pdf', compact('statistik', 'summary', 'searchTerm'));

            $filename = 'statistik-wilayah-pendaftar-' . date('Y-m-d-H-i-s') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Error export PDF Statistik Wilayah: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengekspor PDF: ' . $e->getMessage());
        }
    }

    public function siswaHasilSeleksi(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang', 'dataSiswa', 'asalSekolah'])
            ->where('status', 'PAID'); // Hanya yang sudah bayar

        // Filter berdasarkan kategori hasil
        if ($request->has('kategori') && $request->kategori) {
            if ($request->kategori === 'lulus') {
                // Asumsi: Lulus jika nilai rata-rata >= 75 dan semua berkas valid
                $query->whereHas('asalSekolah', function ($q) {
                    $q->where('nilai_rata', '>=', 75);
                })->whereHas('berkas', function ($q) {
                    $q->where('valid', true);
                });
            } elseif ($request->kategori === 'tidak_lulus') {
                // Tidak lulus jika nilai < 75 atau ada berkas tidak valid
                $query->where(function ($q) {
                    $q->whereHas('asalSekolah', function ($q2) {
                        $q2->where('nilai_rata', '<', 75);
                    })->orWhereHas('berkas', function ($q2) {
                        $q2->where('valid', false);
                    });
                });
            }
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan gelombang
        if ($request->has('gelombang_id') && $request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_pendaftaran', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dataSiswa', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $siswa = $query->orderBy('tgl_verifikasi_payment', 'desc')
            ->paginate(15);

        // Hitung statistik
        $totalSiswa = Pendaftar::where('status', 'PAID')->count();

        $totalLulus = Pendaftar::where('status', 'PAID')
            ->whereHas('asalSekolah', function ($q) {
                $q->where('nilai_rata', '>=', 75);
            })
            ->whereHas('berkas', function ($q) {
                $q->where('valid', true);
            })
            ->count();

        $totalTidakLulus = $totalSiswa - $totalLulus;

        $statistik = [
            'total_siswa' => $totalSiswa,
            'lulus' => $totalLulus,
            'tidak_lulus' => $totalTidakLulus,
            'persentase_lulus' => $totalSiswa > 0 ? round(($totalLulus / $totalSiswa) * 100, 2) : 0,
        ];

        $jurusan = Jurusan::all();
        $gelombang = Gelombang::all();

        return view('admin.siswa.hasil-seleksi', compact(
            'siswa',
            'statistik',
            'jurusan',
            'gelombang'
        ));
    }

    // Export PDF Hasil Seleksi
    public function exportHasilSeleksiPDF(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang', 'dataSiswa', 'asalSekolah', 'berkas'])
            ->where('status', 'PAID');

        // Filter yang sama seperti di method utama
        if ($request->has('kategori') && $request->kategori) {
            if ($request->kategori === 'lulus') {
                $query->whereHas('asalSekolah', function ($q) {
                    $q->where('nilai_rata', '>=', 75);
                })->whereHas('berkas', function ($q) {
                    $q->where('valid', true);
                });
            } elseif ($request->kategori === 'tidak_lulus') {
                $query->where(function ($q) {
                    $q->whereHas('asalSekolah', function ($q2) {
                        $q2->where('nilai_rata', '<', 75);
                    })->orWhereHas('berkas', function ($q2) {
                        $q2->where('valid', false);
                    });
                });
            }
        }

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $siswa = $query->orderBy('tgl_verifikasi_payment', 'desc')->get();

        // Tentukan kategori hasil untuk setiap siswa
        $siswa = $siswa->map(function ($item) {
            $nilaiRata = $item->asalSekolah->nilai_rata ?? 0;
            $berkasValid = $item->berkas->where('valid', true)->count() === $item->berkas->count();

            $item->hasil_seleksi = ($nilaiRata >= 75 && $berkasValid) ? 'LULUS' : 'TIDAK LULUS';
            $item->keterangan = $berkasValid ?
                "Nilai: {$nilaiRata}" :
                "Nilai: {$nilaiRata}, Berkas tidak lengkap/valid";

            return $item;
        });

        // Hitung statistik untuk PDF
        $totalSiswa = $siswa->count();
        $lulus = $siswa->where('hasil_seleksi', 'LULUS')->count();
        $tidakLulus = $totalSiswa - $lulus;

        $statistik = [
            'total' => $totalSiswa,
            'lulus' => $lulus,
            'tidak_lulus' => $tidakLulus,
            'persentase_lulus' => $totalSiswa > 0 ? round(($lulus / $totalSiswa) * 100, 2) : 0,
        ];

        $filterInfo = [
            'kategori' => $request->kategori ?
                ($request->kategori === 'lulus' ? 'LULUS' : 'TIDAK LULUS') : 'SEMUA',
            'jurusan' => $request->jurusan_id ?
                Jurusan::find($request->jurusan_id)->nama : 'SEMUA JURUSAN',
            'tanggal_cetak' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.export.hasil-seleksi-pdf', compact(
            'siswa',
            'statistik',
            'filterInfo'
        ));

        $pdf->setPaper('A4', 'landscape');

        $filename = 'hasil-seleksi-siswa-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}