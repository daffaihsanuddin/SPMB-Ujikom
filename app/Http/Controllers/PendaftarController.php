<?php
// app/Http/Controllers/PendaftarController.php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarAsalSekolah;
use App\Models\PendaftarBerkas;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Wilayah;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class PendaftarController extends Controller
{
    // Dashboard Pendaftar
    public function dashboard()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with(['jurusan', 'gelombang', 'dataSiswa', 'berkas'])
            ->where('user_id', $user->id)
            ->first();

        $stats = [
            'status' => $pendaftaran ? $pendaftaran->status : 'BELUM_DAFTAR',
            'berkas_uploaded' => $pendaftaran ? $pendaftaran->berkas->count() : 0,
            'berkas_valid' => $pendaftaran ? $pendaftaran->berkas->where('valid', true)->count() : 0,
        ];

        return view('pendaftar.dashboard', compact('pendaftaran', 'stats'));
    }

    // Form Pendaftaran
    public function showFormulir()
    {
        $user = auth()->user();

        // Cek apakah sudah ada pendaftaran
        $pendaftaran = Pendaftar::where('user_id', $user->id)->first();
        if ($pendaftaran) {
            return redirect()->route('pendaftar.dashboard')
                ->with('info', 'Anda sudah melakukan pendaftaran.');
        }

        // Hanya ambil jurusan yang masih ada kuotanya
        $jurusan = Jurusan::where('kuota', '>', 0)->get();

        // Jika tidak ada jurusan yang tersedia
        if ($jurusan->isEmpty()) {
            return redirect()->route('pendaftar.dashboard')
                ->with('error', 'Maaf, saat ini tidak ada jurusan yang tersedia. Silakan coba lagi nanti.');
        }

        $gelombang = Gelombang::where('tgl_selesai', '>=', now())->get();

        // Optimasi query wilayah - hanya ambil kolom yang diperlukan
        $wilayah = Wilayah::select('id', 'kecamatan', 'kelurahan', 'kabupaten')
            ->orderBy('kabupaten')
            ->orderBy('kecamatan')
            ->orderBy('kelurahan')
            ->get();

        return view('pendaftar.formulir', compact('jurusan', 'gelombang', 'wilayah'));
    }

    // Simpan Formulir Pendaftaran
// Simpan Formulir Pendaftaran
    public function storeFormulir(Request $request)
    {
        $user = auth()->user();

        // Validasi data siswa
        $request->validate([
            // Data Siswa
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:120',
            'jk' => 'required|in:L,P',
            'tmp_lahir' => 'required|string|max:60',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',

            // Data Orang Tua
            'nama_ayah' => 'required|string|max:120',
            'pekerjaan_ayah' => 'required|string|max:100',
            'hp_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:120',
            'pekerjaan_ibu' => 'required|string|max:100',
            'hp_ibu' => 'required|string|max:20',

            // Asal Sekolah
            'npsn' => 'required|string|max:20',
            'nama_sekolah' => 'required|string|max:150',
            'kabupaten' => 'required|string|max:100',
            'nilai_rata' => 'required|numeric|min:0|max:100',

            // Pilihan
            'jurusan_id' => 'required|exists:jurusan,id',
            'gelombang_id' => 'required|exists:gelombang,id',
        ]);

        // Validasi tambahan: cek kuota jurusan
        $jurusan = Jurusan::find($request->jurusan_id);
        if (!$jurusan || $jurusan->kuota <= 0) {
            return redirect()->back()
                ->with('error', 'Maaf, kuota untuk jurusan ini sudah penuh. Silakan pilih jurusan lain.')
                ->withInput();
        }

        // Validasi: cek apakah user sudah mendaftar di jurusan ini
        $existingPendaftaran = Pendaftar::where('user_id', $user->id)
            ->where('jurusan_id', $request->jurusan_id)
            ->first();

        if ($existingPendaftaran) {
            return redirect()->back()
                ->with('error', 'Anda sudah terdaftar di jurusan ini. Silakan pilih jurusan lain.')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate nomor pendaftaran
            $noPendaftaran = 'PDB-' . date('Y') . '-' . Str::random(6);

            // Buat data pendaftar
            $pendaftar = Pendaftar::create([
                'user_id' => $user->id,
                'no_pendaftaran' => $noPendaftaran,
                'tanggal_daftar' => now(),
                'gelombang_id' => $request->gelombang_id,
                'jurusan_id' => $request->jurusan_id,
                'status' => 'SUBMIT'
            ]);

            // Kurangi kuota jurusan
            $jurusan->decrement('kuota');

            // Simpan data siswa
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'wilayah_id' => $request->wilayah_id,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);

            // Simpan data orang tua
            PendaftarDataOrtu::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'hp_ayah' => $request->hp_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'hp_ibu' => $request->hp_ibu,
                'wali_nama' => $request->wali_nama,
                'wali_hp' => $request->wali_hp,
            ]);

            // Simpan asal sekolah
            PendaftarAsalSekolah::create([
                'pendaftar_id' => $pendaftar->id,
                'npsn' => $request->npsn,
                'nama_sekolah' => $request->nama_sekolah,
                'kabupaten' => $request->kabupaten,
                'nilai_rata' => $request->nilai_rata,
            ]);

            // Catat log aktivitas
            LogAktivitas::create([
                'user_id' => $user->id,
                'aksi' => 'PENDAFTARAN_BARU',
                'objek' => 'PENDAFTAR',
                'objek_id' => $pendaftar->id,
                'objek_data' => json_encode([
                    'pendaftar_id' => $pendaftar->id,
                    'no_pendaftaran' => $pendaftar->no_pendaftaran,
                    'jurusan_id' => $request->jurusan_id,
                    'gelombang_id' => $request->gelombang_id
                ]),
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

            DB::commit();

            return redirect()->route('pendaftar.upload-berkas')
                ->with('success', 'Pendaftaran berhasil! Silakan upload berkas yang diperlukan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Kembalikan kuota jika gagal
            if (isset($jurusan)) {
                $jurusan->increment('kuota');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Upload Berkas
    public function showUploadBerkas()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with('berkas')->where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir')
                ->with('error', 'Silakan isi formulir pendaftaran terlebih dahulu.');
        }

        $berkasTypes = [
            'IJAZAH' => 'Ijazah/Surat Tanda Tamat',
            'RAPOR' => 'Rapor Nilai',
            'KIP' => 'Kartu Indonesia Pintar',
            'KKS' => 'Kartu Keluarga Sejahtera',
            'AKTA' => 'Akta Kelahiran',
            'KK' => 'Kartu Keluarga',
            'LAINNYA' => 'Berkas Lainnya'
        ];

        // Hitung progress kelengkapan berkas
        $requiredTypes = ['IJAZAH', 'RAPOR', 'KK', 'AKTA'];
        $uploadedTypes = $pendaftaran->berkas->pluck('jenis')->toArray();
        $completed = array_intersect($requiredTypes, $uploadedTypes);
        $progress = count($requiredTypes) > 0 ? (count($completed) / count($requiredTypes)) * 100 : 0;

        // Cek status untuk menentukan tombol yang muncul
        $canSubmit = $progress == 100 && $pendaftaran->status === 'SUBMIT';
        $canResubmit = $pendaftaran->status === 'ADM_REJECT' && $progress == 100;
        $isWaitingVerification = $pendaftaran->status === 'SUBMIT' && $progress == 100;
        $isVerified = in_array($pendaftaran->status, ['ADM_PASS', 'PAID']);

        return view('pendaftar.upload-berkas', compact(
            'pendaftaran',
            'berkasTypes',
            'progress',
            'canSubmit',
            'canResubmit',
            'isWaitingVerification',
            'isVerified'
        ));
    }

    // Kirim ke Verifikator (untuk pertama kali)
    public function kirimKeVerifikator(Request $request)
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with('berkas')->where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Cek apakah status memungkinkan untuk dikirim
        if (!in_array($pendaftaran->status, ['SUBMIT', 'ADM_REJECT'])) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Pendaftaran sudah dalam proses verifikasi atau selesai.');
        }

        // Cek kelengkapan berkas wajib
        $requiredTypes = ['IJAZAH', 'RAPOR', 'KK', 'AKTA'];
        $uploadedTypes = $pendaftaran->berkas->pluck('jenis')->toArray();
        $completed = array_intersect($requiredTypes, $uploadedTypes);

        if (count($completed) < count($requiredTypes)) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Silakan lengkapi semua berkas wajib sebelum mengirim ke verifikator.');
        }

        DB::beginTransaction();

        try {
            // Reset status verifikasi sebelumnya jika ditolak
            $resetData = [
                'status' => 'SUBMIT',
                'user_verifikasi_adm' => null,
                'tgl_verifikasi_adm' => null,
                'user_verifikasi_payment' => null,
                'tgl_verifikasi_payment' => null
            ];

            // Jika sebelumnya ditolak, reset juga validasi berkas
            if ($pendaftaran->status === 'ADM_REJECT') {
                // Reset validasi semua berkas
                PendaftarBerkas::where('pendaftar_id', $pendaftaran->id)
                    ->update(['valid' => false, 'catatan' => null]);
            }

            $pendaftaran->update($resetData);

            // Catat log aktivitas
            $logAction = $pendaftaran->getOriginal('status') === 'ADM_REJECT' ? 'KIRIM_ULANG_VERIFIKATOR' : 'KIRIM_KE_VERIFIKATOR';

            LogAktivitas::create([
                'user_id' => $user->id,
                'aksi' => $logAction,
                'objek' => 'PENDAFTAR',
                'objek_data' => json_encode([
                    'pendaftar_id' => $pendaftaran->id,
                    'no_pendaftaran' => $pendaftaran->no_pendaftaran,
                    'status_sebelumnya' => $pendaftaran->getOriginal('status'),
                    'status_baru' => 'SUBMIT'
                ]),
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

            DB::commit();

            $message = $pendaftaran->getOriginal('status') === 'ADM_REJECT'
                ? 'Pendaftaran berhasil dikirim ulang ke verifikator! Silakan tunggu hasil verifikasi kembali.'
                : 'Pendaftaran berhasil dikirim ke verifikator! Status Anda sekarang: Menunggu Verifikasi Administrasi.';

            return redirect()->route('pendaftar.upload-berkas')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Update Formulir Pendaftaran
// Update Formulir Pendaftaran
    public function updateFormulir(Request $request)
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Hanya bisa update jika status ditolak
        if ($pendaftaran->status !== 'ADM_REJECT') {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Anda hanya dapat mengedit formulir jika pendaftaran ditolak.');
        }

        // Validasi data siswa
        $request->validate([
            // ... validasi lainnya sama
        ]);

        // Validasi kuota jurusan (jika pindah jurusan)
        if ($request->jurusan_id != $pendaftaran->jurusan_id) {
            $jurusanBaru = Jurusan::find($request->jurusan_id);
            if (!$jurusanBaru || $jurusanBaru->kuota <= 0) {
                return redirect()->back()
                    ->with('error', 'Maaf, kuota untuk jurusan ini sudah penuh. Silakan pilih jurusan lain.')
                    ->withInput();
            }
        }

        DB::beginTransaction();

        try {
            // Jika pindah jurusan, update kuota
            if ($request->jurusan_id != $pendaftaran->jurusan_id) {
                // Kembalikan kuota jurusan lama
                $jurusanLama = Jurusan::find($pendaftaran->jurusan_id);
                $jurusanLama->increment('kuota');

                // Kurangi kuota jurusan baru
                $jurusanBaru = Jurusan::find($request->jurusan_id);
                $jurusanBaru->decrement('kuota');
            }

            // Update data pendaftar
            $pendaftaran->update([
                'gelombang_id' => $request->gelombang_id,
                'jurusan_id' => $request->jurusan_id,
                // Status tetap ADM_REJECT sampai dikirim ulang
            ]);

            // ... update data lainnya

            DB::commit();

            return redirect()->route('pendaftar.upload-berkas')
                ->with('success', 'Formulir pendaftaran berhasil diperbarui! Silakan periksa berkas dan kirim ulang ke verifikator.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Simpan Berkas
    public function storeBerkas(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:IJAZAH,RAPOR,KIP,KKS,AKTA,KK,LAINNYA',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048' // 2MB max
        ]);

        $user = auth()->user();
        $pendaftaran = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir')
                ->with('error', 'Silakan isi formulir pendaftaran terlebih dahulu.');
        }

        try {
            $file = $request->file('berkas');
            $fileName = time() . '_' . Str::slug($request->jenis) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('berkas', $fileName, 'public');

            PendaftarBerkas::create([
                'pendaftar_id' => $pendaftaran->id,
                'jenis' => $request->jenis,
                'nama_file' => $fileName,
                'url' => $filePath,
                'ukuran_kb' => $file->getSize() / 1024,
                'valid' => false
            ]);

            return redirect()->back()
                ->with('success', 'Berkas berhasil diupload! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Status Pendaftaran
    public function status()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with(['jurusan', 'gelombang', 'berkas', 'dataSiswa'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir')
                ->with('info', 'Silakan isi formulir pendaftaran terlebih dahulu.');
        }

        // Timeline status
        $timeline = $this->getTimeline($pendaftaran);

        return view('pendaftar.status', compact('pendaftaran', 'timeline'));
    }

    // Pembayaran
    public function showPembayaran()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with(['gelombang', 'jurusan'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir');
        }

        if ($pendaftaran->status !== 'ADM_PASS') {
            return redirect()->route('pendaftar.status')
                ->with('error', 'Anda belum lulus verifikasi administrasi.');
        }

        return view('pendaftar.pembayaran', compact('pendaftaran'));
    }

    // Upload Bukti Bayar
    public function storeBuktiBayar(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $user = auth()->user();
        $pendaftaran = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftaran || $pendaftaran->status !== 'ADM_PASS') {
            return redirect()->route('pendaftar.status')
                ->with('error', 'Anda belum lulus verifikasi administrasi.');
        }

        try {
            $file = $request->file('bukti_bayar');
            $fileName = time() . '_bukti_bayar.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_bayar', $fileName, 'public');

            // Simpan sebagai berkas pembayaran - TIDAK mengubah status ke PAID
            PendaftarBerkas::create([
                'pendaftar_id' => $pendaftaran->id,
                'jenis' => 'LAINNYA',
                'nama_file' => $fileName,
                'url' => $filePath,
                'ukuran_kb' => $file->getSize() / 1024,
                'catatan' => 'Bukti Pembayaran',
                'valid' => false // Tetap false sampai diverifikasi keuangan
            ]);

            // JANGAN update status pendaftaran di sini
            // Biarkan status tetap 'ADM_PASS' sampai keuangan memverifikasi

            return redirect()->route('pendaftar.status')
                ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi keuangan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    // Cetak Kartu
    public function cetakKartu()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::with(['jurusan', 'gelombang', 'dataSiswa', 'dataOrtu', 'asalSekolah'])
            ->where('user_id', $user->id)
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.formulir');
        }

        $tahunAjaran = $this->getTahunAjaran($pendaftaran->gelombang->tahun);
        $sekolahInfo = $this->getSekolahInfo();

        return view('pendaftar.cetak-kartu', compact('pendaftaran', 'tahunAjaran', 'sekolahInfo'));
    }

    // Helper: Get Tahun Ajaran
    private function getTahunAjaran($tahun)
    {
        return $tahun . '/' . ($tahun + 1);
    }

    // Helper: Get Info Sekolah
    private function getSekolahInfo()
    {
        return [
            'nama' => 'SMK BAKTI NUSANTARA 666',
            'email' => 'esemka.baknus666@gmail.com',
            'alamat' => 'Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622',
            'telp' => '02263730220',
            'website' => 'www.smkbn666.sch.id'
        ];
    }

    // Helper: Get Timeline
    private function getTimeline($pendaftaran)
    {
        $timeline = [
            [
                'status' => 'Draft',
                'completed' => true,
                'active' => false,
                'date' => $pendaftaran->created_at->format('d/m/Y'),
                'description' => 'Formulir pendaftaran disimpan'
            ],
            [
                'status' => 'Dikirim',
                'completed' => in_array($pendaftaran->status, ['SUBMIT', 'ADM_PASS', 'ADM_REJECT', 'PAID']),
                'active' => $pendaftaran->status === 'SUBMIT',
                'date' => $pendaftaran->tanggal_daftar->format('d/m/Y'),
                'description' => 'Pendaftaran dikirim untuk verifikasi'
            ],
            [
                'status' => 'Verifikasi Administrasi',
                'completed' => in_array($pendaftaran->status, ['ADM_PASS', 'ADM_REJECT', 'PAID']),
                'active' => $pendaftaran->status === 'ADM_PASS' || $pendaftaran->status === 'ADM_REJECT',
                'date' => $pendaftaran->tgl_verifikasi_adm ? $pendaftaran->tgl_verifikasi_adm->format('d/m/Y') : '-',
                'description' => $pendaftaran->status === 'ADM_PASS' ? 'Lulus administrasi' :
                    ($pendaftaran->status === 'ADM_REJECT' ? 'Tidak lulus administrasi' : 'Menunggu verifikasi')
            ],
            [
                'status' => 'Pembayaran',
                'completed' => $pendaftaran->status === 'PAID',
                'active' => $pendaftaran->status === 'PAID',
                'date' => $pendaftaran->tgl_verifikasi_payment ? $pendaftaran->tgl_verifikasi_payment->format('d/m/Y') : '-',
                'description' => $pendaftaran->status === 'PAID' ? 'Pembayaran terverifikasi' : 'Menunggu pembayaran'
            ]
        ];

        return $timeline;
    }
    public function destroyBerkas($id)
    {
        $user = auth()->user();
        $pendaftaran = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftaran) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $berkas = PendaftarBerkas::where('pendaftar_id', $pendaftaran->id)
            ->where('id', $id)
            ->first();

        if (!$berkas) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Berkas tidak ditemukan.');
        }

        if ($berkas->valid) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Tidak dapat menghapus berkas yang sudah divalidasi.');
        }

        try {
            // Hapus file dari storage - gunakan path yang benar
            if (Storage::disk('public')->exists($berkas->url)) {
                Storage::disk('public')->delete($berkas->url);
            }

            // Hapus record dari database
            $berkas->delete();

            return redirect()->route('pendaftar.upload-berkas')
                ->with('success', 'Berkas berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('pendaftar.upload-berkas')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}