@extends('layouts.verifikator')

@section('title', 'Detail Verifikasi Pendaftar')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Detail Verifikasi Pendaftar</h2>
                <p class="text-muted">Verifikasi data dan berkas administrasi pendaftar</p>
            </div>
            <div>
                <a href="{{ route('verifikator.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Pendaftar -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td>{{ $pendaftar->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>{{ $pendaftar->tanggal_daftar->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>{{ $pendaftar->jurusan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td>{{ $pendaftar->gelombang->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge bg-warning">MENUNGGU VERIFIKASI</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Data Calon Siswa</h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataSiswa)
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>{{ $pendaftar->dataSiswa->nik }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>{{ $pendaftar->dataSiswa->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>{{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td>{{ $pendaftar->dataSiswa->tmp_lahir }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir</strong></td>
                                <td>{{ $pendaftar->dataSiswa->tgl_lahir->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>{{ $pendaftar->dataSiswa->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Wilayah</strong></td>
                                <td>
                                    @if($pendaftar->dataSiswa->wilayah)
                                    {{ $pendaftar->dataSiswa->wilayah->kecamatan }}, {{ $pendaftar->dataSiswa->wilayah->kabupaten }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Data siswa belum lengkap
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Data Orang Tua -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">Data Orang Tua</h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataOrtu)
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Ayah</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Nama Ayah</strong></td>
                                <td>{{ $pendaftar->dataOrtu->nama_ayah }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>{{ $pendaftar->dataOrtu->pekerjaan_ayah }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td>{{ $pendaftar->dataOrtu->hp_ayah }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Data Ibu</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Nama Ibu</strong></td>
                                <td>{{ $pendaftar->dataOrtu->nama_ibu }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>{{ $pendaftar->dataOrtu->pekerjaan_ibu }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td>{{ $pendaftar->dataOrtu->hp_ibu }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($pendaftar->dataOrtu->wali_nama)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Data Wali</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Nama Wali</strong></td>
                                <td>{{ $pendaftar->dataOrtu->wali_nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. HP Wali</strong></td>
                                <td>{{ $pendaftar->dataOrtu->wali_hp }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Data orang tua belum lengkap
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Asal Sekolah -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">Asal Sekolah</h5>
            </div>
            <div class="card-body">
                @if($pendaftar->asalSekolah)
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>NPSN</strong></td>
                                <td>{{ $pendaftar->asalSekolah->npsn }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Sekolah</strong></td>
                                <td>{{ $pendaftar->asalSekolah->nama_sekolah }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Kabupaten</strong></td>
                                <td>{{ $pendaftar->asalSekolah->kabupaten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nilai Rata-rata</strong></td>
                                <td>{{ $pendaftar->asalSekolah->nilai_rata }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Data asal sekolah belum lengkap
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Berkas Pendaftaran -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Berkas Pendaftaran</h5>
            </div>
            <div class="card-body">
                @if($pendaftar->berkas->count() > 0)
                <form method="POST" action="{{ route('verifikator.verifikasi', $pendaftar->id) }}" id="formVerifikasi">
                    @csrf
                    <input type="hidden" name="status" id="statusVerifikasi" value="">
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jenis Berkas</th>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th>Status</th>
                                    <th>Validasi</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendaftar->berkas as $index => $berkas)
                                <tr>
                                    <td>
                                        <strong>
                                            @php
                                                $berkasTypes = [
                                                    'IJAZAH' => 'Ijazah',
                                                    'RAPOR' => 'Rapor',
                                                    'KIP' => 'KIP',
                                                    'KKS' => 'KKS',
                                                    'AKTA' => 'Akta',
                                                    'KK' => 'KK',
                                                    'LAINNYA' => 'Lainnya'
                                                ];
                                            @endphp
                                            {{ $berkasTypes[$berkas->jenis] ?? $berkas->jenis }}
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="{{ Storage::url($berkas->url) }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-file me-2"></i>{{ $berkas->nama_file }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($berkas->ukuran_kb, 0) }} KB</td>
                                    <td>
                                        @if($berkas->valid)
                                        <span class="badge bg-success">Valid</span>
                                        @else
                                        <span class="badge bg-warning">Belum Valid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                   name="berkas[{{ $index }}][valid]" 
                                                   id="valid_{{ $berkas->id }}" 
                                                   value="1" {{ $berkas->valid ? 'checked' : '' }}>
                                            <label class="form-check-label" for="valid_{{ $berkas->id }}">Valid</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" 
                                                   name="berkas[{{ $index }}][valid]" 
                                                   id="invalid_{{ $berkas->id }}" 
                                                   value="0" {{ !$berkas->valid ? 'checked' : '' }}>
                                            <label class="form-check-label" for="invalid_{{ $berkas->id }}">Tidak Valid</label>
                                        </div>
                                        <input type="hidden" name="berkas[{{ $index }}][id]" value="{{ $berkas->id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" 
                                               name="berkas[{{ $index }}][catatan]" 
                                               value="{{ $berkas->catatan ?? '' }}" 
                                               placeholder="Catatan...">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Catatan Verifikasi -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="catatan" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                      placeholder="Masukkan catatan verifikasi (opsional)">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="history.back()">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </button>
                                <div>
                                    <button type="button" class="btn btn-danger me-2" onclick="setStatus('ADM_REJECT')">
                                        <i class="fas fa-times me-2"></i>Tolak Pendaftaran
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="setStatus('ADM_PASS')">
                                        <i class="fas fa-check me-2"></i>Luluskan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Berkas</h5>
                    <p class="text-muted">Pendaftar belum mengupload berkas apapun</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalTitle">Konfirmasi Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                <!-- Konten modal akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setStatus(status) {
    // Set nilai status
    document.getElementById('statusVerifikasi').value = status;
    
    // Tentukan pesan konfirmasi
    let title, message;
    
    if (status === 'ADM_PASS') {
        title = 'Luluskan Pendaftar';
        message = 'Apakah Anda yakin ingin <strong>MELULUSKAN</strong> pendaftar ini?<br><br>Pendaftar akan dapat melanjutkan ke tahap pembayaran.';
    } else {
        title = 'Tolak Pendaftar';
        message = 'Apakah Anda yakin ingin <strong>MENOLAK</strong> pendaftar ini?<br><br>Pendaftar tidak dapat melanjutkan ke tahap pembayaran.';
    }
    
    // Tampilkan modal konfirmasi
    document.getElementById('confirmModalTitle').textContent = title;
    document.getElementById('confirmModalBody').innerHTML = message;
    
    // Setup tombol konfirmasi
    const confirmBtn = document.getElementById('confirmSubmit');
    confirmBtn.onclick = function() {
        // Submit form
        document.getElementById('formVerifikasi').submit();
    };
    
    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

// Validasi form sebelum submit
document.getElementById('formVerifikasi').addEventListener('submit', function(e) {
    const status = document.getElementById('statusVerifikasi').value;
    if (!status) {
        e.preventDefault();
        alert('Silakan pilih aksi verifikasi terlebih dahulu.');
        return false;
    }
});

// Tambahkan style untuk modal
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .table td {
            vertical-align: middle;
        }
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush

@push('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: none;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.125);
    font-weight: 600;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.5rem;
}

.btn-danger {
    background: linear-gradient(45deg, #dc3545, #c82333);
    border: none;
}

.btn-success {
    background: linear-gradient(45deg, #198754, #13653f);
    border: none;
}

.btn-secondary {
    background: linear-gradient(45deg, #6c757d, #545b62);
    border: none;
}

.badge {
    font-size: 0.75em;
    padding: 0.4em 0.6em;
}

.form-control {
    border-radius: 6px;
}

.form-check-input {
    margin-top: 0;
}
</style>
@endpush