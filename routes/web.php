<?php

use App\Http\Controllers\KepsekController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\VerifikatorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\jurusanController;
use App\Http\Controllers\GelombangController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TabelController;
use Illuminate\Support\Facades\Route;


// Public routes
Route::get('/', [PublicController::class, 'index'])->name('index');
Route::get('/jurusan', [PublicController::class, 'jurusan'])->name('jurusan');
Route::get('/pendaftaran', [PublicController::class, 'pendaftaran'])->name('pendaftaran');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/alamat', [PublicController::class, 'alamat'])->name('alamat'); // Tambah ini


// Authentication routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// : OTP Verification routes - Sesuaikan dengan yang digunakan di form
Route::get('/verification/otp', [AuthController::class, 'showOtpVerificationForm'])->name('verification.otp');
Route::post('/verification/verify', [AuthController::class, 'verifyOtp'])->name('verification.verify');
Route::post('/verification/resend', [AuthController::class, 'resendOtp'])->name('verification.resend');

// Protected routes with role-based access
Route::middleware(['auth'])->group(function () {

    // PENDAFTAR

    // Pendaftar routes
    Route::middleware(['auth', 'role:pendaftar'])->prefix('pendaftar')->name('pendaftar.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [PendaftarController::class, 'dashboard'])->name('dashboard');

        // Formulir Pendaftaran
        Route::get('/formulir', [PendaftarController::class, 'showFormulir'])->name('formulir');
        Route::post('/formulir', [PendaftarController::class, 'storeFormulir'])->name('formulir.store');

        // Upload Berkas
        Route::get('/upload-berkas', [PendaftarController::class, 'showUploadBerkas'])->name('upload-berkas');
        Route::post('/upload-berkas', [PendaftarController::class, 'storeBerkas'])->name('upload-berkas.store');
        Route::delete('/upload-berkas/{id}', [PendaftarController::class, 'destroyBerkas'])->name('upload-berkas.destroy');

        // Kirim ke Verifikator
        Route::post('/kirim-verifikator', [PendaftarController::class, 'kirimKeVerifikator'])->name('kirim-verifikator');

        // Status
        Route::get('/status', [PendaftarController::class, 'status'])->name('status');

        // Pembayaran
        Route::get('/pembayaran', [PendaftarController::class, 'showPembayaran'])->name('pembayaran');
        Route::post('/pembayaran', [PendaftarController::class, 'storeBuktiBayar'])->name('pembayaran.store');

        // Cetak Kartu
        Route::get('/cetak-kartu', [PendaftarController::class, 'cetakKartu'])->name('cetak-kartu');
    });

    // ADMIN
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Master Data - Jurusan
        Route::get('/jurusan', [AdminController::class, 'jurusanIndex'])->name('jurusan');
        Route::post('/jurusan', [AdminController::class, 'jurusanStore'])->name('jurusan.store');
        Route::put('/jurusan/{id}', [AdminController::class, 'jurusanUpdate'])->name('jurusan.update');
        Route::delete('/jurusan/{id}', [AdminController::class, 'jurusanDestroy'])->name('jurusan.destroy');

        // Master Data - Gelombang
        Route::get('/gelombang', [AdminController::class, 'gelombangIndex'])->name('gelombang');
        Route::post('/gelombang', [AdminController::class, 'gelombangStore'])->name('gelombang.store');
        Route::put('/gelombang/{id}', [AdminController::class, 'gelombangUpdate'])->name('gelombang.update');
        Route::delete('/gelombang/{id}', [AdminController::class, 'gelombangDestroy'])->name('gelombang.destroy');

        // Monitoring Berkas
        Route::get('/monitoring-berkas', [AdminController::class, 'monitoringBerkas'])->name('monitoring-berkas');
        Route::get('/monitoring-berkas/{id}', [AdminController::class, 'detailBerkas'])->name('detail-berkas');

        // Peta Sebaran
        Route::get('/peta-sebaran', [AdminController::class, 'petaSebaran'])->name('peta-sebaran');
        Route::get('/statistik-wilayah', [AdminController::class, 'statistikWilayah'])->name('statistik-wilayah');
        Route::get('/statistik-wilayah/detail', [AdminController::class, 'getDetailWilayah'])->name('statistik-wilayah.detail');

        // Export PDF
        Route::get('/export/statistik-wilayah-pdf', [AdminController::class, 'exportStatistikWilayahPDF'])->name('export.statistik-wilayah-pdf');
        Route::get('/export/hasil-seleksi', [AdminController::class, 'exportHasilSeleksiPDF'])->name('export.hasil-seleksi');

        // Seleksi
        Route::get('/siswa/hasil-seleksi', [AdminController::class, 'siswaHasilSeleksi'])->name('siswa.hasil-seleksi');
    });

    // VERIFIKATOR ADMINISTRASI
    Route::middleware(['auth', 'role:verifikator_adm'])->prefix('verifikator')->name('verifikator.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [VerifikatorController::class, 'dashboard'])->name('dashboard');

        // Verifikasi
        Route::get('/verifikasi', [VerifikatorController::class, 'index'])->name('index');
        Route::get('/verifikasi/{id}', [VerifikatorController::class, 'show'])->name('show');
        Route::post('/verifikasi/{id}', [VerifikatorController::class, 'verifikasi'])->name('verifikasi');

        // Statistik
        Route::get('/riwayat', [VerifikatorController::class, 'riwayat'])->name('riwayat');
        Route::put('/{id}', [VerifikatorController::class, 'update'])->name('update');
        Route::get('/{id}/riwayat', [VerifikatorController::class, 'showRiwayat'])->name('show.riwayat');
        Route::get('/{id}/logs', [VerifikatorController::class, 'getLogs'])->name('logs');

        // Export routes
        Route::get('/statistik/export-pdf', [VerifikatorController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/statistik/export-detail', [VerifikatorController::class, 'exportPdfDetail'])->name('export.detail');

        // Riwayat
        Route::get('/riwayat', [VerifikatorController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat/{id}', [VerifikatorController::class, 'showRiwayat'])->name('show.riwayat');
    });

    // KEUANGAN
    Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->name('keuangan.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [KeuanganController::class, 'dashboard'])->name('dashboard');

        // Verifikasi Pembayaran
        Route::get('/verifikasi-pembayaran', [KeuanganController::class, 'verifikasiPembayaran'])->name('verifikasi-pembayaran');
        Route::get('/verifikasi-pembayaran/{id}', [KeuanganController::class, 'showPembayaran'])->name('show-pembayaran');
        Route::post('/verifikasi-pembayaran/{id}', [KeuanganController::class, 'prosesVerifikasi'])->name('proses-verifikasi');

        // Rekap Keuangan
        Route::get('/rekap-keuangan', [KeuanganController::class, 'rekapKeuangan'])->name('rekap-keuangan');
        Route::get('/export-excel', [KeuanganController::class, 'exportExcel'])->name('export-excel');
        Route::get('/export-pdf', [KeuanganController::class, 'exportPDF'])->name('export-pdf');

        // Statistik
        Route::get('/statistik', [KeuanganController::class, 'statistik'])->name('statistik');

        // Laporan
        Route::get('/laporan', [VerifikatorController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/pdf', [VerifikatorController::class, 'generatePDF'])->name('laporan.pdf');
        Route::get('/laporan/excel', [VerifikatorController::class, 'generateExcel'])->name('laporan.excel');
        Route::get('/laporan/harian', [VerifikatorController::class, 'laporanHarian'])->name('laporan.harian');
        Route::get('/laporan/bulanan', [VerifikatorController::class, 'laporanBulanan'])->name('laporan.bulanan');

        // Export
        Route::get('/rekap-keuangan/export-pdf', [KeuanganController::class, 'exportPDF'])->name('keuangan.export-pdf');
        Route::get('/rekap-keuangan/export-excel', [KeuanganController::class, 'exportExcel'])->name('keuangan.export-excel');
    });

    // KEPALA SEKOLAH
    Route::middleware(['auth', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [KepsekController::class, 'dashboard'])->name('dashboard');

        // Laporan
        Route::get('/laporan-pendaftar', [KepsekController::class, 'laporanPendaftar'])->name('laporan-pendaftar');
        Route::get('/laporan-statistik', [KepsekController::class, 'laporanStatistik'])->name('laporan-statistik');

        // Export routes
        Route::get('/export/laporan-pendaftar', [KepsekController::class, 'exportLaporanPendaftar'])->name('export-laporan-pendaftar');
        Route::get('/export/statistik', [KepsekController::class, 'exportStatistik'])->name('export-statistik');
    });
});