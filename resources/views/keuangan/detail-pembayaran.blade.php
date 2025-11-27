@extends('layouts.keuangan')

@section('title', 'Detail Pembayaran')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Detail Pembayaran</h2>
                    <p class="text-muted">Verifikasi bukti pembayaran pendaftar</p>
                </div>
                <div>
                    <a href="{{ route('keuangan.verifikasi-pembayaran') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(!$pendaftar)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Data Pembayaran Tidak Ditemukan</h4>
                        <p class="text-muted">Data pembayaran yang diminta tidak ditemukan.</p>
                        <a href="{{ route('keuangan.verifikasi-pembayaran') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Informasi Pembayaran -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-money-bill-wave me-2"></i>Informasi Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>No. Pendaftaran</strong></td>
                                <td>: <span class="fw-bold text-primary">{{ $pendaftar->no_pendaftaran }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>: {{ $pendaftar->user->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jurusan</strong></td>
                                <td>: {{ $pendaftar->jurusan->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gelombang</strong></td>
                                <td>: {{ $pendaftar->gelombang->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Biaya</strong></td>
                                <td>: <span class="fw-bold text-success">Rp
                                        {{ number_format($pendaftar->gelombang->biaya_daftar, 0, ',', '.') }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Status Administrasi</strong></td>
                                <td>
                                    : <span class="badge bg-success">LULUS</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Verifikasi Keuangan</strong></td>
                                <td>
                                    :
                                    @if($pendaftar->tgl_verifikasi_payment)
                                        <span class="badge bg-success">SUDAH</span>
                                        ({{ $pendaftar->tgl_verifikasi_payment->format('d/m/Y') }})
                                    @else
                                        <span class="badge bg-warning text-dark">BELUM</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Form Verifikasi -->
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-check me-2"></i>Form Verifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('keuangan.proses-verifikasi', $pendaftar->id) }}"
                            id="formVerifikasi">
                            @csrf

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Verifikasi <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="PAID">Terbayar (Setujui)</option>
                                    <option value="REJECT_PAYMENT">Tolak Pembayaran</option>
                                </select>
                            </div>

                            <div class="mb-3" id="catatanField" style="display: none;">
                                <label for="catatan" class="form-label">Alasan Penolakan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                    placeholder="Berikan alasan penolakan pembayaran..."></textarea>
                                <div class="form-text">
                                    Wajib diisi jika pembayaran ditolak. Catatan akan dikirim ke pendaftar.
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" id="btnSubmit">
                                    <i class="fas fa-check-circle me-2"></i>Simpan Verifikasi
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="col-md-8 mb-4">
                <!-- Data Pendaftar -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Data Pendaftar
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Nama Lengkap</strong></td>
                                        <td>: {{ $pendaftar->dataSiswa->nama ?? $pendaftar->user->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>: {{ $pendaftar->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>HP</strong></td>
                                        <td>: {{ $pendaftar->user->hp }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Asal Sekolah</strong></td>
                                        <td>: {{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nilai Rata-rata</strong></td>
                                        <td>: {{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Bayar -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-invoice me-2"></i>Bukti Pembayaran
                            </h5>
                            @if($buktiBayar)
                                @if($buktiBayar->valid)
                                    <span class="badge bg-success">Valid</span>
                                @else
                                    <span class="badge bg-danger">Tidak Valid</span>
                                @endif
                            @else
                                <span class="badge bg-warning text-dark">Belum Upload</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($buktiBayar)
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>File</strong></td>
                                            <td>: {{ $buktiBayar->nama_file }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ukuran</strong></td>
                                            <td>: {{ number_format($buktiBayar->ukuran_kb, 0) }} KB</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Upload</strong></td>
                                            <td>: {{ $buktiBayar->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>
                                                :
                                                @if($buktiBayar->valid)
                                                    <span class="badge bg-success">Valid</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Valid</span>
                                                    @if($buktiBayar->catatan)
                                                        <br><small class="text-muted">{{ $buktiBayar->catatan }}</small>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6 text-center">
                                    @if(pathinfo($buktiBayar->nama_file, PATHINFO_EXTENSION) === 'pdf')
                                        <div class="border rounded p-3 bg-light">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                            <p class="mb-2">File PDF</p>
                                            <a href="{{ Storage::url($buktiBayar->url) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Lihat PDF
                                            </a>
                                            <a href="{{ Storage::url($buktiBayar->url) }}" download class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <img src="{{ Storage::url($buktiBayar->url) }}" alt="Bukti Bayar"
                                                class="img-fluid rounded border" style="max-height: 300px;">
                                            <div class="mt-3">
                                                <a href="{{ Storage::url($buktiBayar->url) }}" target="_blank"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-expand me-1"></i>Lihat Full Size
                                                </a>
                                                <a href="{{ Storage::url($buktiBayar->url) }}" download class="btn btn-success btn-sm">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Bukti Bayar Tidak Tersedia</h5>
                                <p class="text-muted">Pendaftar belum mengupload bukti pembayaran</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Instruksi Pembayaran -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Panduan Verifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Yang Perlu Diperiksa:</h6>
                                <ul class="small">
                                    <li>Nominal transfer sesuai (Rp
                                        {{ number_format($pendaftar->gelombang->biaya_daftar, 0, ',', '.') }})</li>
                                    <li>Nama pengirim jelas</li>
                                    <li>Tanggal transfer valid</li>
                                    <li>Bukti tidak blur/tidak jelas</li>
                                    <li>Rekening tujuan benar</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Status yang Tersedia:</h6>
                                <ul class="small">
                                    <li><strong>Terbayar</strong> - Bukti valid, status berubah menjadi PAID</li>
                                    <li><strong>Tolak Pembayaran</strong> - Bukti tidak valid, status tetap LULUS administrasi
                                    </li>
                                </ul>
                                <div class="alert alert-warning mt-2">
                                    <small>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <strong>Perhatian:</strong> Status administrasi tidak akan berubah meskipun pembayaran
                                        ditolak
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formVerifikasi = document.getElementById('formVerifikasi');
            const btnSubmit = document.getElementById('btnSubmit');
            const statusSelect = document.getElementById('status');
            const catatanField = document.getElementById('catatanField');
            const catatanTextarea = document.getElementById('catatan');

            // Tampilkan/sembunyikan field catatan berdasarkan status
            statusSelect.addEventListener('change', function () {
                if (this.value === 'REJECT_PAYMENT') {
                    catatanField.style.display = 'block';
                    catatanTextarea.required = true;
                } else {
                    catatanField.style.display = 'none';
                    catatanTextarea.required = false;
                }
            });

            // Form submission
            formVerifikasi.addEventListener('submit', function (e) {
                e.preventDefault();

                // Validasi pilihan status
                if (!statusSelect.value) {
                    alert('Pilih status verifikasi terlebih dahulu!');
                    statusSelect.focus();
                    return;
                }

                // Validasi catatan untuk status tolak
                if (statusSelect.value === 'REJECT_PAYMENT' && !catatanTextarea.value.trim()) {
                    alert('Harap berikan alasan penolakan pembayaran!');
                    catatanTextarea.focus();
                    return;
                }

                // Konfirmasi sebelum submit
                const statusText = statusSelect.options[statusSelect.selectedIndex].text;
                const confirmation = confirm(`Apakah Anda yakin ingin menetapkan status: ${statusText}?`);

                if (confirmation) {
                    // Tampilkan loading
                    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    btnSubmit.disabled = true;

                    // Submit form
                    formVerifikasi.submit();
                }
            });
        });
    </script>
@endpush