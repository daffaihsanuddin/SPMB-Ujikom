<?php
// app/Http/Controllers/VerifikatorController.php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarBerkas;
use App\Models\LogAktivitas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VerifikatorController extends Controller
{
    // Dashboard Verifikator
    public function dashboard()
    {
        $stats = [
            'total_menunggu' => Pendaftar::where('status', 'SUBMIT')->count(),
            'total_diverifikasi' => Pendaftar::whereIn('status', ['ADM_PASS', 'ADM_REJECT', 'PAID'])
                ->whereNotNull('tgl_verifikasi_adm')
                ->count(),
            'total_lulus' => Pendaftar::whereIn('status', ['ADM_PASS', 'PAID'])->count(),
            'total_tolak' => Pendaftar::where('status', 'ADM_REJECT')->count(),
        ];

        // Data untuk chart (opsional)
        $verifikasiHarian = Pendaftar::select(
            DB::raw('DATE(tgl_verifikasi_adm) as tanggal'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status IN ("ADM_PASS", "PAID") THEN 1 ELSE 0 END) as lulus'),
            DB::raw('SUM(CASE WHEN status = "ADM_REJECT" THEN 1 ELSE 0 END) as tolak')
        )
            ->whereIn('status', ['ADM_PASS', 'ADM_REJECT', 'PAID'])
            ->whereNotNull('tgl_verifikasi_adm')
            ->where('tgl_verifikasi_adm', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(tgl_verifikasi_adm)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('verifikator.dashboard', compact('stats', 'verifikasiHarian'));
    }

    // Daftar Pendaftar yang Perlu Diverifikasi
    public function index()
    {
        $pendaftar = Pendaftar::with(['user', 'jurusan', 'gelombang', 'berkas', 'dataSiswa'])
            ->where('status', 'SUBMIT')
            ->orderBy('tanggal_daftar', 'asc')
            ->paginate(10);

        return view('verifikator.index', compact('pendaftar'));
    }

    // Detail Pendaftar untuk Verifikasi
    public function show($id)
    {
        $pendaftar = Pendaftar::with([
            'user',
            'jurusan',
            'gelombang',
            'berkas',
            'dataSiswa',
            'dataOrtu',
            'asalSekolah',
            'dataSiswa.wilayah'
        ])->findOrFail($id);

        // Cek apakah pendaftar sudah diverifikasi
        if ($pendaftar->status !== 'SUBMIT') {
            return redirect()->route('verifikator.index')
                ->with('error', 'Pendaftar ini sudah diverifikasi.');
        }

        return view('verifikator.show', compact('pendaftar'));
    }

    // Proses Verifikasi - DIPERBAIKI
    public function verifikasi(Request $request, $id)
    {
        \Log::info('Verifikasi Request Data:', $request->all());
        \Log::info('Pendaftar ID:', ['id' => $id]);

        $request->validate([
            'status' => 'required|in:ADM_PASS,ADM_REJECT',
            'catatan' => 'nullable|string|max:500',
            'berkas' => 'nullable|array',
            'berkas.*.id' => 'required|exists:pendaftar_berkas,id',
            'berkas.*.valid' => 'required|boolean',
            'berkas.*.catatan' => 'nullable|string|max:255'
        ]);

        $pendaftar = Pendaftar::with(['berkas'])->findOrFail($id);

        // Validasi: pastikan status masih SUBMIT
        if ($pendaftar->status !== 'SUBMIT') {
            return redirect()->route('verifikator.index')
                ->with('error', 'Pendaftar ' . $pendaftar->no_pendaftaran . ' sudah diverifikasi sebelumnya.');
        }

        DB::beginTransaction();

        try {
            // Update status pendaftar
            $pendaftar->update([
                'status' => $request->status,
                'user_verifikasi_adm' => auth()->user()->nama,
                'tgl_verifikasi_adm' => now()
            ]);

            \Log::info('Status pendaftar diupdate:', [
                'pendaftar_id' => $pendaftar->id,
                'status' => $request->status
            ]);

            // Update status berkas jika ada
            if ($request->has('berkas') && is_array($request->berkas)) {
                \Log::info('Data berkas untuk divalidasi:', $request->berkas);
                
                foreach ($request->berkas as $berkasData) {
                    $berkas = PendaftarBerkas::find($berkasData['id']);
                    if ($berkas) {
                        $berkas->update([
                            'valid' => (bool)$berkasData['valid'],
                            'catatan' => $berkasData['catatan'] ?? null
                        ]);
                        \Log::info('Berkas divalidasi:', [
                            'berkas_id' => $berkas->id,
                            'valid' => $berkasData['valid']
                        ]);
                    }
                }
            }

            // Catat log aktivitas
            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aksi' => 'VERIFIKASI_ADMINISTRASI',
                'objek' => 'PENDAFTAR',
                'objek_id' => $pendaftar->id,
                'objek_data' => json_encode([
                    'pendaftar_id' => $pendaftar->id,
                    'no_pendaftaran' => $pendaftar->no_pendaftaran,
                    'status' => $request->status,
                    'catatan' => $request->catatan,
                    'verifikator' => auth()->user()->nama,
                    'tanggal_verifikasi' => now()->format('Y-m-d H:i:s')
                ]),
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

            DB::commit();

            $statusText = $request->status === 'ADM_PASS' ? 'LULUS' : 'DITOLAK';
            $message = "Pendaftar {$pendaftar->no_pendaftaran} berhasil diverifikasi: {$statusText}";
            
            \Log::info('Verifikasi berhasil:', ['message' => $message]);

            return redirect()->route('verifikator.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error dalam verifikasi:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Export PDF Statistik
    public function exportPdf(Request $request)
    {
        // Ambil data statistik - PAID termasuk lulus
        $statistik = (object) [
            'menunggu' => Pendaftar::where('status', 'SUBMIT')->count(),
            'lulus' => Pendaftar::whereIn('status', ['ADM_PASS', 'PAID'])->count(),
            'tolak' => Pendaftar::where('status', 'ADM_REJECT')->count(),
        ];

        // Statistik berdasarkan jurusan - PAID termasuk lulus
        $statistikJurusan = Jurusan::select('id', 'nama', 'kode')
            ->withCount([
                'pendaftar as total_lulus' => function ($query) {
                    $query->whereIn('status', ['ADM_PASS', 'PAID']);
                },
                'pendaftar as total_tolak' => function ($query) {
                    $query->where('status', 'ADM_REJECT');
                }
            ])
            ->get()
            ->map(function ($jurusan) {
                $jurusan->total = $jurusan->total_lulus + $jurusan->total_tolak;
                $jurusan->persentase_lulus = $jurusan->total > 0 ?
                    round(($jurusan->total_lulus / $jurusan->total) * 100, 1) : 0;
                return $jurusan;
            })
            ->filter(function ($jurusan) {
                return $jurusan->total > 0;
            });

        // Data untuk header
        $data = [
            'statistik' => $statistik,
            'statistikJurusan' => $statistikJurusan,
            'tanggal' => now()->format('d/m/Y'),
            'waktu' => now()->format('H:i:s'),
            'verifikator' => auth()->user()->nama,
            'total_verifikasi' => $statistik->lulus + $statistik->tolak,
            'persentase_lulus' => ($statistik->lulus + $statistik->tolak) > 0 ?
                round(($statistik->lulus / ($statistik->lulus + $statistik->tolak)) * 100, 1) : 0,
            'persentase_tolak' => ($statistik->lulus + $statistik->tolak) > 0 ?
                round(($statistik->tolak / ($statistik->lulus + $statistik->tolak)) * 100, 1) : 0,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('verifikator.export.statistik-pdf', $data);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Download PDF
        return $pdf->download('statistik-verifikasi-' . now()->format('Y-m-d') . '.pdf');
    }

    // Export PDF Detail
    public function exportPdfDetail(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'berkas'])
            ->whereIn('status', ['ADM_PASS', 'ADM_REJECT', 'PAID'])
            ->whereNotNull('tgl_verifikasi_adm')
            ->orderBy('tgl_verifikasi_adm', 'desc');

        // Filter jika ada
        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->has('status') && $request->status) {
            if ($request->status === 'LULUS') {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $pendaftar = $query->get();

        $data = [
            'pendaftar' => $pendaftar,
            'tanggal' => now()->format('d/m/Y'),
            'judul' => 'Laporan Detail Verifikasi',
            'filter_jurusan' => $request->jurusan_id ?
                Jurusan::find($request->jurusan_id)->nama : 'Semua Jurusan',
            'filter_status' => $request->status ?
                ($request->status === 'LULUS' ? 'LULUS (ADM_PASS + PAID)' : 'TOLAK') : 'Semua Status'
        ];

        $pdf = Pdf::loadView('verifikator.export.detail-pdf', $data);
        return $pdf->download('laporan-detail-verifikasi-' . now()->format('Y-m-d') . '.pdf');
    }

    // Riwayat Verifikasi
    public function riwayat(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'berkas'])
            ->whereIn('status', ['ADM_PASS', 'ADM_REJECT', 'PAID', 'SUBMIT'])
            ->orderBy('tgl_verifikasi_adm', 'desc');

        // Filter berdasarkan status verifikasi
        if ($request->has('verifikasi_status') && $request->verifikasi_status !== '') {
            if ($request->verifikasi_status === 'sudah') {
                $query->whereNotNull('tgl_verifikasi_adm');
            } elseif ($request->verifikasi_status === 'belum') {
                $query->whereNull('tgl_verifikasi_adm');
            }
        }

        // Filter berdasarkan status pendaftaran
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'LULUS') {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id !== '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan tanggal verifikasi
        if ($request->has('tanggal') && $request->tanggal !== '') {
            $query->whereDate('tgl_verifikasi_adm', $request->tanggal);
        }

        $pendaftar = $query->paginate(10);

        // Hitung statistik untuk summary cards
        $totalData = $pendaftar->total();
        $sudahDiverifikasi = Pendaftar::whereNotNull('tgl_verifikasi_adm')->count();
        $belumDiverifikasi = Pendaftar::whereNull('tgl_verifikasi_adm')->count();
        $lulusAdministrasi = Pendaftar::whereIn('status', ['ADM_PASS', 'PAID'])->count();

        $summary = [
            'total_data' => $totalData,
            'sudah_diverifikasi' => $sudahDiverifikasi,
            'belum_diverifikasi' => $belumDiverifikasi,
            'lulus_administrasi' => $lulusAdministrasi
        ];

        $jurusan = Jurusan::all();

        return view('verifikator.riwayat', compact('pendaftar', 'summary', 'jurusan'));
    }

    // Detail Riwayat - TANPA EDIT
    public function showRiwayat($id)
    {
        $pendaftar = Pendaftar::with([
            'user',
            'jurusan',
            'gelombang',
            'dataSiswa',
            'dataOrtu',
            'asalSekolah',
            'berkas'
        ])->findOrFail($id);

        return view('verifikator.detail-riwayat', compact('pendaftar'));
    }

    // Method untuk testing debug
    public function testVerifikasi($id)
    {
        $pendaftar = Pendaftar::find($id);
        
        if (!$pendaftar) {
            return response()->json(['error' => 'Pendaftar tidak ditemukan'], 404);
        }

        return response()->json([
            'pendaftar' => [
                'id' => $pendaftar->id,
                'no_pendaftaran' => $pendaftar->no_pendaftaran,
                'status' => $pendaftar->status,
                'tgl_verifikasi_adm' => $pendaftar->tgl_verifikasi_adm,
                'user_verifikasi_adm' => $pendaftar->user_verifikasi_adm
            ],
            'berkas_count' => $pendaftar->berkas->count()
        ]);
    }
}