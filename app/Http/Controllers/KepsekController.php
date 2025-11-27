<?php
// app/Http/Controllers/KepsekController.php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarAsalSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KepsekController extends Controller
{
    // Dashboard Eksekutif - DIPERBAIKI
    public function dashboard()
    {
        // Statistik Utama - DIPERBAIKI dengan status yang benar
        $stats = [
            'total_pendaftar' => Pendaftar::count(),
            'pendaftar_hari_ini' => Pendaftar::whereDate('tanggal_daftar', today())->count(),
            'pendaftar_bulan_ini' => Pendaftar::whereMonth('tanggal_daftar', now()->month)
                ->whereYear('tanggal_daftar', now()->year)
                ->count(),
            // : Lulus termasuk ADM_PASS dan PAID
            'lulus_administrasi' => Pendaftar::whereIn('status', ['ADM_PASS', 'PAID'])->count(),
            'sudah_bayar' => Pendaftar::where('status', 'PAID')->count(),
            'ditolak' => Pendaftar::where('status', 'ADM_REJECT')->count(),
            'menunggu_verifikasi' => Pendaftar::where('status', 'SUBMIT')->count(),
        ];

        // : Hitung total kuota dan sisa kuota
        $totalKuota = Jurusan::sum('kuota');
        $totalPendaftarLulus = Pendaftar::whereIn('status', ['ADM_PASS', 'PAID'])->count();
        $sisaKuota = max(0, $totalKuota - $totalPendaftarLulus);

        // Rasio Pendaftar vs Kuota - DIPERBAIKI
        $rasioPendaftarKuota = [
            'pendaftar_lulus' => $totalPendaftarLulus,
            'kuota' => $totalKuota,
            'sisa_kuota' => $sisaKuota,
            'persentase_terisi' => $totalKuota > 0 ?
                round(($totalPendaftarLulus / $totalKuota) * 100, 2) : 0,
            'persentase_sisa' => $totalKuota > 0 ?
                round(($sisaKuota / $totalKuota) * 100, 2) : 0
        ];

        // Tren Pendaftaran 30 Hari Terakhir - DIPERBAIKI
        $trenPendaftaran = Pendaftar::select(
            DB::raw('DATE(tanggal_daftar) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('tanggal_daftar', '>=', now()->subDays(30))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // : Pendaftar per Jurusan dengan Kuota dan Sisa Kuota
        $pendaftarPerJurusan = Jurusan::withCount([
            'pendaftar as total_pendaftar',
            'pendaftar as pendaftar_lulus' => function ($query) {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            }
        ])
        ->get()
        ->map(function ($jurusan) {
            $sisaKuota = max(0, $jurusan->kuota - $jurusan->pendaftar_lulus);
            return [
                'nama' => $jurusan->nama,
                'kode' => $jurusan->kode,
                'pendaftar_total' => $jurusan->total_pendaftar,
                'pendaftar_lulus' => $jurusan->pendaftar_lulus,
                'kuota' => $jurusan->kuota,
                'sisa_kuota' => $sisaKuota,
                'persentase_terisi' => $jurusan->kuota > 0 ?
                    round(($jurusan->pendaftar_lulus / $jurusan->kuota) * 100, 2) : 0,
                'status_kuota' => $sisaKuota == 0 ? 'penuh' : ($sisaKuota < 5 ? 'hampir_penuh' : 'tersedia')
            ];
        });

        // Pendaftar per Gelombang - DIPERBAIKI
        $pendaftarPerGelombang = Gelombang::withCount([
            'pendaftar as total',
            'pendaftar as lulus' => function ($query) {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            }
        ])
        ->get()
        ->map(function ($gelombang) {
            return [
                'nama' => $gelombang->nama,
                'tahun' => $gelombang->tahun,
                'total_pendaftar' => $gelombang->total,
                'lulus' => $gelombang->lulus,
                'persentase_lulus' => $gelombang->total > 0 ?
                    round(($gelombang->lulus / $gelombang->total) * 100, 2) : 0
            ];
        });

        // Asal Sekolah (Top 10) - DIPERBAIKI query
        $asalSekolah = PendaftarAsalSekolah::select(
            'nama_sekolah',
            'kabupaten',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('nama_sekolah', 'kabupaten')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Sebaran Wilayah (Top 10 Kecamatan) - DIPERBAIKI query
        $sebaranWilayah = PendaftarDataSiswa::select(
            'wilayah.kecamatan',
            'wilayah.kabupaten',
            DB::raw('COUNT(*) as total')
        )
            ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
            ->groupBy('wilayah.kecamatan', 'wilayah.kabupaten')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Status Pendaftaran - DIPERBAIKI
        $statusPendaftaran = Pendaftar::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                $statusText = [
                    'SUBMIT' => 'Menunggu Verifikasi',
                    'ADM_PASS' => 'Lulus Administrasi',
                    'ADM_REJECT' => 'Ditolak',
                    'PAID' => 'Sudah Bayar'
                ];
                
                return [
                    'status' => $item->status,
                    'status_text' => $statusText[$item->status] ?? $item->status,
                    'total' => $item->total
                ];
            });

        return view('kepsek.dashboard', compact(
            'stats',
            'rasioPendaftarKuota',
            'trenPendaftaran',
            'pendaftarPerJurusan',
            'pendaftarPerGelombang',
            'asalSekolah',
            'sebaranWilayah',
            'statusPendaftaran'
        ));
    }

    // Laporan Detail Pendaftar - DIPERBAIKI
    public function laporanPendaftar(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang', 'dataSiswa', 'asalSekolah']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'LULUS') {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            } else {
                $query->where('status', $request->status);
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

        $pendaftar = $query->orderBy('tanggal_daftar', 'desc')->get();

        $jurusan = Jurusan::all();
        $gelombang = Gelombang::all();

        // Hitung statistik
        $statistik = [
            'total' => $pendaftar->count(),
            'lulus' => $pendaftar->whereIn('status', ['ADM_PASS', 'PAID'])->count(),
            'ditolak' => $pendaftar->where('status', 'ADM_REJECT')->count(),
            'menunggu' => $pendaftar->where('status', 'SUBMIT')->count(),
        ];

        return view('kepsek.laporan.pendaftar', compact('pendaftar', 'jurusan', 'gelombang', 'statistik'));
    }

    // Laporan Statistik - DIPERBAIKI
    public function laporanStatistik(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        // Statistik per Bulan - DIPERBAIKI
        $statistikBulanan = Pendaftar::select(
            DB::raw('YEAR(tanggal_daftar) as tahun'),
            DB::raw('MONTH(tanggal_daftar) as bulan'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status IN ("ADM_PASS", "PAID") THEN 1 ELSE 0 END) as lulus')
        )
            ->whereYear('tanggal_daftar', $tahun)
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Buat array lengkap 12 bulan
        $bulananLengkap = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan = $statistikBulanan->firstWhere('bulan', $i);
            $bulananLengkap[] = [
                'bulan' => $i,
                'nama_bulan' => $this->getNamaBulan($i),
                'total' => $dataBulan ? $dataBulan->total : 0,
                'lulus' => $dataBulan ? $dataBulan->lulus : 0,
                'persentase_lulus' => $dataBulan && $dataBulan->total > 0 ? 
                    round(($dataBulan->lulus / $dataBulan->total) * 100, 2) : 0
            ];
        }

        // : Statistik per Jurusan dengan Kuota dan Sisa
        $statistikJurusan = Jurusan::withCount([
            'pendaftar as total_pendaftar',
            'pendaftar as pendaftar_lulus' => function ($query) use ($tahun) {
                $query->whereIn('status', ['ADM_PASS', 'PAID'])
                      ->whereYear('tanggal_daftar', $tahun);
            }
        ])->get()
        ->map(function ($jurusan) {
            $sisaKuota = max(0, $jurusan->kuota - $jurusan->pendaftar_lulus);
            return [
                'nama' => $jurusan->nama,
                'kode' => $jurusan->kode,
                'kuota' => $jurusan->kuota,
                'total_pendaftar' => $jurusan->total_pendaftar,
                'pendaftar_lulus' => $jurusan->pendaftar_lulus,
                'sisa_kuota' => $sisaKuota,
                'persentase_terisi' => $jurusan->kuota > 0 ? 
                    round(($jurusan->pendaftar_lulus / $jurusan->kuota) * 100, 2) : 0
            ];
        });

        // Statistik Status - DIPERBAIKI
        $statistikStatus = Pendaftar::whereYear('tanggal_daftar', $tahun)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                $statusText = [
                    'SUBMIT' => 'Menunggu Verifikasi',
                    'ADM_PASS' => 'Lulus Administrasi', 
                    'ADM_REJECT' => 'Ditolak',
                    'PAID' => 'Sudah Bayar'
                ];
                
                return [
                    'status' => $item->status,
                    'status_text' => $statusText[$item->status] ?? $item->status,
                    'total' => $item->total
                ];
            });

        // Statistik per Gelombang - DIPERBAIKI
        $statistikGelombang = Gelombang::withCount([
            'pendaftar as total' => function ($query) use ($tahun) {
                $query->whereYear('tanggal_daftar', $tahun);
            },
            'pendaftar as lulus' => function ($query) use ($tahun) {
                $query->whereIn('status', ['ADM_PASS', 'PAID'])
                      ->whereYear('tanggal_daftar', $tahun);
            }
        ])->get();

        // Tahun-tahun tersedia untuk filter
        $tahunTersedia = Pendaftar::select(DB::raw('YEAR(tanggal_daftar) as tahun'))
            ->groupBy(DB::raw('YEAR(tanggal_daftar)'))
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Total dan rasio untuk tahun ini
        $totalPendaftar = Pendaftar::whereYear('tanggal_daftar', $tahun)->count();
        $totalLulus = Pendaftar::whereYear('tanggal_daftar', $tahun)
            ->whereIn('status', ['ADM_PASS', 'PAID'])
            ->count();
        $totalKuota = Jurusan::sum('kuota');
        $sisaKuota = max(0, $totalKuota - $totalLulus);

        $ringkasan = [
            'total_pendaftar' => $totalPendaftar,
            'total_lulus' => $totalLulus,
            'total_kuota' => $totalKuota,
            'sisa_kuota' => $sisaKuota,
            'persentase_lulus' => $totalPendaftar > 0 ? round(($totalLulus / $totalPendaftar) * 100, 2) : 0,
            'persentase_terisi' => $totalKuota > 0 ? round(($totalLulus / $totalKuota) * 100, 2) : 0
        ];

        return view('kepsek.laporan.statistik', compact(
            'bulananLengkap',
            'statistikJurusan',
            'statistikStatus',
            'statistikGelombang',
            'tahun',
            'tahunTersedia',
            'ringkasan'
        ));
    }

    // Helper function untuk nama bulan
    private function getNamaBulan($bulan)
    {
        $bulanNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulanNames[$bulan] ?? 'Unknown';
    }
    
    // Export Laporan PDF - DIPERBAIKI
    public function exportLaporanPendaftar(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang', 'dataSiswa', 'asalSekolah']);

        // Filter sama seperti di laporan
        if ($request->has('status') && $request->status) {
            if ($request->status === 'LULUS') {
                $query->whereIn('status', ['ADM_PASS', 'PAID']);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $pendaftar = $query->orderBy('tanggal_daftar', 'desc')->get();

        // Hitung statistik yang benar
        $totalPendaftar = $pendaftar->count();
        $totalLulus = $pendaftar->whereIn('status', ['ADM_PASS', 'PAID'])->count();
        $totalSudahBayar = $pendaftar->where('status', 'PAID')->count();
        $totalDitolak = $pendaftar->where('status', 'ADM_REJECT')->count();

        $statistik = [
            'total_pendaftar' => $totalPendaftar,
            'lulus_administrasi' => $totalLulus,
            'sudah_bayar' => $totalSudahBayar,
            'ditolak' => $totalDitolak,
            'persentase_lulus' => $totalPendaftar > 0 ? round(($totalLulus / $totalPendaftar) * 100, 2) : 0,
        ];

        $pdf = PDF::loadView('kepsek.export.laporan-pendaftar', compact('pendaftar', 'statistik'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-pendaftar-' . now()->format('Y-m-d') . '.pdf');
    }

    // Export Statistik PDF - DIPERBAIKI
    public function exportStatistik(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        // Data statistik bulanan
        $statistikBulanan = Pendaftar::select(
            DB::raw('YEAR(tanggal_daftar) as tahun'),
            DB::raw('MONTH(tanggal_daftar) as bulan'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status IN ("ADM_PASS", "PAID") THEN 1 ELSE 0 END) as lulus')
        )
            ->whereYear('tanggal_daftar', $tahun)
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Buat array lengkap 12 bulan
        $bulananLengkap = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan = $statistikBulanan->firstWhere('bulan', $i);
            $bulananLengkap[] = [
                'bulan' => $i,
                'nama_bulan' => $this->getNamaBulan($i),
                'total' => $dataBulan ? $dataBulan->total : 0,
                'lulus' => $dataBulan ? $dataBulan->lulus : 0
            ];
        }

        // Statistik per Jurusan dengan Kuota
        $statistikJurusan = Jurusan::withCount([
            'pendaftar as total_pendaftar' => function ($query) use ($tahun) {
                $query->whereYear('tanggal_daftar', $tahun);
            },
            'pendaftar as pendaftar_lulus' => function ($query) use ($tahun) {
                $query->whereIn('status', ['ADM_PASS', 'PAID'])
                      ->whereYear('tanggal_daftar', $tahun);
            }
        ])->get()
        ->map(function ($jurusan) {
            $sisaKuota = max(0, $jurusan->kuota - $jurusan->pendaftar_lulus);
            return [
                'nama' => $jurusan->nama,
                'kode' => $jurusan->kode,
                'kuota' => $jurusan->kuota,
                'total_pendaftar' => $jurusan->total_pendaftar,
                'pendaftar_lulus' => $jurusan->pendaftar_lulus,
                'sisa_kuota' => $sisaKuota,
                'persentase_terisi' => $jurusan->kuota > 0 ? 
                    round(($jurusan->pendaftar_lulus / $jurusan->kuota) * 100, 2) : 0
            ];
        });

        // Total dan rasio
        $totalPendaftar = Pendaftar::whereYear('tanggal_daftar', $tahun)->count();
        $totalLulus = Pendaftar::whereYear('tanggal_daftar', $tahun)
            ->whereIn('status', ['ADM_PASS', 'PAID'])
            ->count();
        $totalKuota = Jurusan::sum('kuota');
        $sisaKuota = max(0, $totalKuota - $totalLulus);

        $ringkasan = [
            'total_pendaftar' => $totalPendaftar,
            'total_lulus' => $totalLulus,
            'total_kuota' => $totalKuota,
            'sisa_kuota' => $sisaKuota,
            'persentase_lulus' => $totalPendaftar > 0 ? round(($totalLulus / $totalPendaftar) * 100, 2) : 0,
            'persentase_terisi' => $totalKuota > 0 ? round(($totalLulus / $totalKuota) * 100, 2) : 0
        ];

        $pdf = PDF::loadView('kepsek.export.statistik', compact(
            'bulananLengkap',
            'statistikJurusan',
            'ringkasan',
            'tahun'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('statistik-SPMB-' . $tahun . '-' . now()->format('Y-m-d') . '.pdf');
    }
}