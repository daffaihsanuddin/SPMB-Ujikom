<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Landing Page
    public function index()
    {
        $jurusan = Jurusan::all();
        $gelombangAktif = Gelombang::where('tgl_mulai', '<=', now())
            ->where('tgl_selesai', '>=', now())
            ->first();

        $stats = [
            'total_pendaftar' => Pendaftar::count(),
            'jurusan_available' => Jurusan::count(),
            'gelombang_aktif' => $gelombangAktif ? $gelombangAktif->nama : 'Tidak ada'
        ];

        return view('index', compact('jurusan', 'gelombangAktif', 'stats'));
    }

    // Informasi Jurusan
    public function jurusan()
    {
        $jurusan = Jurusan::withCount(['pendaftar'])->get();

        return view('jurusan', compact('jurusan'));
    }

    // Informasi Pendaftaran
    public function pendaftaran()
    {
        $gelombang = Gelombang::where('tgl_selesai', '>=', now())
            ->orderBy('tgl_mulai')
            ->get();

        $jurusan = Jurusan::all();

        return view('pendaftaran', compact('gelombang', 'jurusan'));
    }

    // FAQ Page
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara mendaftar di SMK Bakti Nusantara 666?',
                'answer' => 'Pendaftaran dilakukan secara online melalui website ini. Klik tombol "Daftar Sekarang" di beranda, buat akun, lengkapi formulir pendaftaran, upload berkas yang diperlukan, dan ikuti proses selanjutnya.'
            ],
            [
                'question' => 'Apa saja persyaratan yang diperlukan untuk pendaftaran?',
                'answer' => 'Persyaratan meliputi: Fotokopi ijazah/SKHUN, rapor semester 1-5, akta kelahiran, Kartu Keluarga (KK), pas foto 3x4, KIP/KKS (jika ada), dan dokumen pendukung prestasi (opsional).'
            ],
            [
                'question' => 'Berapa biaya pendaftaran dan kapan pembayarannya?',
                'answer' => 'Biaya pendaftaran berbeda untuk setiap gelombang. Gelombang 1: Rp 200.000, Gelombang 2: Rp 250.000. Pembayaran dilakukan setelah verifikasi administrasi dinyatakan lulus.'
            ],
            [
                'question' => 'Kapan pengumuman hasil seleksi?',
                'answer' => 'Pengumuman hasil seleksi akan diinformasikan melalui website, email, dan WhatsApp yang didaftarkan. Biasanya 1-2 minggu setelah penutupan pendaftaran setiap gelombang.'
            ],
            [
                'question' => 'Apakah ada beasiswa yang tersedia?',
                'answer' => 'Ya, tersedia berbagai program beasiswa untuk siswa berprestasi akademik/non-akademik dan siswa dari keluarga kurang mampu. Informasi detail dapat ditanyakan langsung ke bagian administrasi sekolah.'
            ],
            [
                'question' => 'Berapa kuota penerimaan per jurusan?',
                'answer' => 'Kuota berbeda untuk setiap jurusan: RPL (50), TKJ (40), MM (35), TKRO (45). Pendaftaran ditutup ketika kuota terpenuhi atau tanggal penutupan gelombang.'
            ],
            [
                'question' => 'Bagaimana jika saya mengalami kendala teknis saat pendaftaran?',
                'answer' => 'Silakan hubungi kami melalui halaman kontak atau WhatsApp admin di 0812-3456-7890. Tim teknis kami siap membantu dari Senin - Jumat pukul 08.00 - 16.00 WIB.'
            ],
            [
                'question' => 'Apakah bisa mengubah pilihan jurusan setelah mendaftar?',
                'answer' => 'Perubahan jurusan hanya bisa dilakukan selama status pendaftaran masih "SUBMIT" dan sebelum verifikasi administrasi. Silakan hubungi admin untuk proses perubahan.'
            ],
            [
                'question' => 'Bagaimana sistem pembelajaran di SMK Bakti Nusantara 666?',
                'answer' => 'Kami menerapkan sistem pembelajaran 70% praktik dan 30% teori, dengan program magang industri di tahun ke-3. Fasilitas lengkap dengan peralatan modern dan guru berpengalaman.'
            ],
            [
                'question' => 'Apakah ada asrama untuk siswa dari luar kota?',
                'answer' => 'Saat ini sekolah kami belum menyediakan asrama. Namun kami dapat memberikan rekomendasi kos/kontrakan yang terjangkau di sekitar sekolah.'
            ]
        ];

        return view('faq', compact('faqs'));
    }

    // Alamat & Lokasi Page
    public function alamat()
    {
        return view('alamat');
    }

    // Handle Newsletter Subscription
    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:120|unique:newsletter_subscriptions,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email ini sudah terdaftar'
        ]);

        // Here you can add code to save newsletter subscription

        return redirect()->back()
            ->with('success', 'Terima kasih! Anda telah berlangganan newsletter kami.');
    }

    // Download Brosur
    public function downloadBrosur()
    {
        $filePath = public_path('brosur/brosur-spmb.pdf');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'Brosur-SPMB-SMK-Bakti-Nusantara-666.pdf');
        }

        return redirect()->back()
            ->with('error', 'File brosur tidak ditemukan. Silakan hubungi admin.');
    }

    // Download Formulir Pendaftaran
    public function downloadFormulir()
    {
        $filePath = public_path('formulir/formulir-pendaftaran.pdf');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'Formulir-Pendaftaran-SMK-Bakti-Nusantara-666.pdf');
        }

        return redirect()->back()
            ->with('error', 'File formulir tidak ditemukan. Silakan hubungi admin.');
    }
}