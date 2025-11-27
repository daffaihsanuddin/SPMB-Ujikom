<?php
// app/Http/Controllers/KeuanganController.php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarBerkas;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    // Dashboard Keuangan
    public function dashboard()
    {
        $stats = [
            'total_pendaftar' => Pendaftar::count(),
            'menunggu_verifikasi' => Pendaftar::where('status', 'ADM_PASS')->count(),
            'sudah_bayar' => Pendaftar::where('status', 'PAID')->count(),
            'total_pemasukan' => Pendaftar::where('status', 'PAID')
                ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                ->sum('gelombang.biaya_daftar')
        ];

        $pembayaranTerbaru = Pendaftar::with(['user', 'jurusan', 'gelombang'])
            ->where('status', 'ADM_PASS')
            ->orderBy('tgl_verifikasi_adm', 'desc')
            ->take(5)
            ->get();

        $pemasukanHariIni = Pendaftar::where('status', 'PAID')
            ->whereDate('tgl_verifikasi_payment', today())
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->sum('gelombang.biaya_daftar');

        return view('keuangan.dashboard', compact('stats', 'pembayaranTerbaru', 'pemasukanHariIni'));
    }
    // Verifikasi Pembayaran
    public function verifikasiPembayaran()
    {
        $pendaftar = Pendaftar::with([
            'user',
            'jurusan',
            'gelombang',
            'berkas' => function ($query) {
                $query->where('catatan', 'Bukti Pembayaran');
            }
        ])
            ->where('status', 'ADM_PASS')
            ->where(function ($query) {
                $query->whereNull('tgl_verifikasi_payment')
                    ->orWhere('status', 'ADM_PASS');
            })
            ->orderBy('tgl_verifikasi_adm', 'asc')
            ->paginate(10);

        return view('keuangan.verifikasi-pembayaran', compact('pendaftar'));
    }

    // Detail Pembayaran
    public function showPembayaran($id)
    {
        $pendaftar = Pendaftar::with([
            'user',
            'jurusan',
            'gelombang',
            'berkas' => function ($query) {
                $query->where('catatan', 'Bukti Pembayaran');
            },
            'dataSiswa'
        ])->findOrFail($id);

        // Cek apakah pendaftar sudah lulus administrasi
        if ($pendaftar->status !== 'ADM_PASS') {
            return redirect()->route('keuangan.verifikasi-pembayaran')
                ->with('error', 'Pendaftar belum lulus administrasi.');
        }

        $buktiBayar = $pendaftar->berkas->where('catatan', 'Bukti Pembayaran')->first();

        return view('keuangan.detail-pembayaran', compact('pendaftar', 'buktiBayar'));
    }

    // Proses Verifikasi Pembayaran
    public function prosesVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PAID,REJECT_PAYMENT', // Ubah dari ADM_REJECT ke REJECT_PAYMENT
            'catatan' => 'required_if:status,REJECT_PAYMENT|nullable|string|max:500'
        ]);

        $pendaftar = Pendaftar::findOrFail($id);

        // Validasi: hanya bisa verifikasi yang statusnya ADM_PASS
        if ($pendaftar->status !== 'ADM_PASS') {
            return redirect()->back()
                ->with('error', 'Hanya bisa memverifikasi pendaftar yang sudah lulus administrasi.');
        }

        DB::beginTransaction();

        try {
            $statusSebelumnya = $pendaftar->status;

            // Update status pendaftar
            $pendaftar->update([
                'status' => $request->status === 'PAID' ? 'PAID' : 'ADM_PASS', // Jika reject, tetap ADM_PASS
                'user_verifikasi_payment' => auth()->user()->nama,
                'tgl_verifikasi_payment' => now()
            ]);

            // Update berkas bukti bayar jika ada
            $buktiBayar = PendaftarBerkas::where('pendaftar_id', $pendaftar->id)
                ->where('catatan', 'Bukti Pembayaran')
                ->first();

            if ($buktiBayar) {
                $buktiBayar->update([
                    'valid' => $request->status === 'PAID',
                    'catatan' => $request->status === 'PAID'
                        ? 'Bukti bayar valid'
                        : ($request->catatan ?? 'Bukti bayar tidak valid')
                ]);
            }

            // Jika pembayaran ditolak, buat log khusus
            if ($request->status === 'REJECT_PAYMENT') {
                // Buat berkas catatan penolakan
                PendaftarBerkas::create([
                    'pendaftar_id' => $pendaftar->id,
                    'jenis' => 'LAINNYA',
                    'nama_file' => 'catatan_penolakan_payment.txt',
                    'url' => 'catatan/penolakan',
                    'ukuran_kb' => 0,
                    'catatan' => 'Pembayaran ditolak: ' . ($request->catatan ?? 'Tidak memenuhi syarat'),
                    'valid' => true
                ]);
            }

            // Catat log aktivitas
            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aksi' => 'VERIFIKASI_PEMBAYARAN',
                'objek' => 'PENDAFTAR',
                'objek_data' => json_encode([
                    'pendaftar_id' => $pendaftar->id,
                    'no_pendaftaran' => $pendaftar->no_pendaftaran,
                    'status_sebelumnya' => $statusSebelumnya,
                    'status_setelah' => $request->status === 'PAID' ? 'PAID' : 'ADM_PASS',
                    'catatan' => $request->catatan
                ]),
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

            DB::commit();

            $statusText = $request->status === 'PAID' ? 'Terverifikasi' : 'Ditolak';
            return redirect()->route('keuangan.verifikasi-pembayaran')
                ->with('success', "Pembayaran {$pendaftar->no_pendaftaran} berhasil {$statusText}");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Rekap Keuangan
    public function rekapKeuangan(Request $request)
    {
        // Query dasar untuk data pendaftar
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang'])
            ->where('status', 'PAID')
            ->whereNotNull('tgl_verifikasi_payment');

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tgl_verifikasi_payment', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tgl_verifikasi_payment', '<=', $request->end_date);
        }

        // Filter by jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter by gelombang
        if ($request->has('gelombang_id') && $request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        $pendaftar = $query->orderBy('tgl_verifikasi_payment', 'desc')
            ->paginate(15);

        // Statistics for rekap - BUAT QUERY TERPISAH
        $statistikQuery = Pendaftar::where('status', 'PAID')
            ->whereNotNull('tgl_verifikasi_payment');

        // Terapkan filter yang sama untuk statistik
        if ($request->has('start_date') && $request->start_date) {
            $statistikQuery->whereDate('tgl_verifikasi_payment', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $statistikQuery->whereDate('tgl_verifikasi_payment', '<=', $request->end_date);
        }

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $statistikQuery->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->has('gelombang_id') && $request->gelombang_id) {
            $statistikQuery->where('gelombang_id', $request->gelombang_id);
        }

        // Hitung statistik dengan query yang benar
        $totalPeserta = $statistikQuery->count();

        $totalPendapatan = $statistikQuery->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->sum('gelombang.biaya_daftar');

        $rataRata = $totalPeserta > 0 ? $totalPendapatan / $totalPeserta : 0;

        $statistik = [
            'total_pendapatan' => $totalPendapatan,
            'total_peserta' => $totalPeserta,
            'rata_rata' => $rataRata
        ];

        $jurusan = Jurusan::all();
        $gelombang = Gelombang::all();

        return view('keuangan.rekap-keuangan', compact(
            'pendaftar',
            'statistik',
            'jurusan',
            'gelombang'
        ));
    }

    // Export PDF
    public function exportPDF(Request $request)
    {
        $query = Pendaftar::with(['user', 'jurusan', 'gelombang'])
            ->where('status', 'PAID')
            ->whereNotNull('tgl_verifikasi_payment');

        // Apply filters
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tgl_verifikasi_payment', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tgl_verifikasi_payment', '<=', $request->end_date);
        }

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->has('gelombang_id') && $request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        $data = $query->orderBy('tgl_verifikasi_payment', 'desc')->get();

        // Hitung statistik untuk export
        $statistikQuery = Pendaftar::where('status', 'PAID')
            ->whereNotNull('tgl_verifikasi_payment');

        if ($request->has('start_date') && $request->start_date) {
            $statistikQuery->whereDate('tgl_verifikasi_payment', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $statistikQuery->whereDate('tgl_verifikasi_payment', '<=', $request->end_date);
        }

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $statistikQuery->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->has('gelombang_id') && $request->gelombang_id) {
            $statistikQuery->where('gelombang_id', $request->gelombang_id);
        }

        $totalPendapatan = $statistikQuery->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->sum('gelombang.biaya_daftar');

        $totalPeserta = $statistikQuery->count();

        $statistik = [
            'total_pendapatan' => $totalPendapatan,
            'total_peserta' => $totalPeserta,
            'rata_rata' => $totalPeserta > 0 ? $totalPendapatan / $totalPeserta : 0
        ];

        // Data filter untuk ditampilkan di PDF
        $filterInfo = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'jurusan' => $request->jurusan_id ? Jurusan::find($request->jurusan_id)->nama : 'Semua',
            'gelombang' => $request->gelombang_id ? Gelombang::find($request->gelombang_id)->nama : 'Semua',
            'tanggal_cetak' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('keuangan.export-pdf', compact('data', 'statistik', 'filterInfo'));

        $filename = 'rekap-keuangan-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    // Statistik Keuangan
    public function statistik()
    {
        try {
            // Pendapatan per bulan tahun ini - FIXED QUERY
            $pendapatanPerBulan = Pendaftar::select(
                DB::raw('MONTH(tgl_verifikasi_payment) as bulan'),
                DB::raw('YEAR(tgl_verifikasi_payment) as tahun'),
                DB::raw('COUNT(*) as total_peserta'),
                DB::raw('SUM(gelombang.biaya_daftar) as total_pendapatan')
            )
                ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                ->where('pendaftar.status', 'PAID')
                ->whereNotNull('pendaftar.tgl_verifikasi_payment')
                ->whereYear('pendaftar.tgl_verifikasi_payment', date('Y'))
                ->groupBy(DB::raw('YEAR(tgl_verifikasi_payment)'), DB::raw('MONTH(tgl_verifikasi_payment)'))
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();

            // Pendapatan per jurusan - FIXED QUERY
            $pendapatanPerJurusan = Pendaftar::select(
                'jurusan.nama',
                DB::raw('COUNT(*) as total_peserta'),
                DB::raw('SUM(gelombang.biaya_daftar) as total_pendapatan')
            )
                ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
                ->where('pendaftar.status', 'PAID')
                ->whereNotNull('pendaftar.tgl_verifikasi_payment')
                ->groupBy('jurusan.id', 'jurusan.nama')
                ->orderBy('total_pendapatan', 'desc')
                ->get();

            // Pendapatan per gelombang - FIXED QUERY
            $pendapatanPerGelombang = Pendaftar::select(
                'gelombang.nama',
                DB::raw('COUNT(*) as total_peserta'),
                DB::raw('SUM(gelombang.biaya_daftar) as total_pendapatan')
            )
                ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                ->where('pendaftar.status', 'PAID')
                ->whereNotNull('pendaftar.tgl_verifikasi_payment')
                ->groupBy('gelombang.id', 'gelombang.nama')
                ->orderBy('total_pendapatan', 'desc')
                ->get();

            // Statistik harian 30 hari terakhir
            $pendapatanHarian = Pendaftar::select(
                DB::raw('DATE(tgl_verifikasi_payment) as tanggal'),
                DB::raw('COUNT(*) as total_peserta'),
                DB::raw('SUM(gelombang.biaya_daftar) as total_pendapatan')
            )
                ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                ->where('pendaftar.status', 'PAID')
                ->whereNotNull('pendaftar.tgl_verifikasi_payment')
                ->where('pendaftar.tgl_verifikasi_payment', '>=', now()->subDays(30))
                ->groupBy(DB::raw('DATE(tgl_verifikasi_payment)'))
                ->orderBy('tanggal', 'asc')
                ->get();

            // Ringkasan statistik
            $ringkasan = [
                'total_pendapatan' => $pendapatanPerBulan->sum('total_pendapatan'),
                'total_peserta' => $pendapatanPerBulan->sum('total_peserta'),
                'rata_rata_per_bulan' => $pendapatanPerBulan->avg('total_pendapatan'),
                'bulan_tertinggi' => $pendapatanPerBulan->sortByDesc('total_pendapatan')->first(),
                'jurusan_tertinggi' => $pendapatanPerJurusan->sortByDesc('total_pendapatan')->first(),
            ];

            return view('keuangan.statistik', compact(
                'pendapatanPerBulan',
                'pendapatanPerJurusan',
                'pendapatanPerGelombang',
                'pendapatanHarian',
                'ringkasan'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            return view('keuangan.statistik', [
                'pendapatanPerBulan' => collect(),
                'pendapatanPerJurusan' => collect(),
                'pendapatanPerGelombang' => collect(),
                'pendapatanHarian' => collect(),
                'ringkasan' => [
                    'total_pendapatan' => 0,
                    'total_peserta' => 0,
                    'rata_rata_per_bulan' => 0,
                    'bulan_tertinggi' => null,
                    'jurusan_tertinggi' => null,
                ],
                'error' => $e->getMessage()
            ]);
        }
    }
}