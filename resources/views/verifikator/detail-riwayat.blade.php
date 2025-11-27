@extends('layouts.verifikator')

@section('title', 'Detail Riwayat Verifikasi')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Detail Riwayat Verifikasi</h2>
            </div>
            <div>
                <a href="{{ route('verifikator.riwayat') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Utama -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran
                </h5>
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
                        <td>
                            <span class="badge bg-primary">{{ $pendaftar->jurusan->nama }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td>{{ $pendaftar->gelombang->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @php
                                $statusClass = [
                                    'SUBMIT' => 'warning',
                                    'ADM_PASS' => 'success',
                                    'ADM_REJECT' => 'danger',
                                    'PAID' => 'info'
                                ][$pendaftar->status];
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ $pendaftar->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Verifikasi -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-check me-2"></i>Informasi Verifikasi
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Verifikator</strong></td>
                        <td>{{ $pendaftar->user_verifikasi_adm ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Verifikasi</strong></td>
                        <td>
                            @if($pendaftar->tgl_verifikasi_adm)
                                {{ $pendaftar->tgl_verifikasi_adm->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Akhir</strong></td>
                        <td>
                            @if($pendaftar->status === 'ADM_PASS')
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>LULUS
                                </span>
                            @elseif($pendaftar->status === 'ADM_REJECT')
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>TIDAK LULUS
                                </span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Ringkasan Berkas -->
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>Ringkasan Berkas
                </h5>
            </div>
            <div class="card-body">
                @php
                    $totalBerkas = $pendaftar->berkas->count();
                    $berkasValid = $pendaftar->berkas->where('valid', true)->count();
                    $persentaseValid = $totalBerkas > 0 ? round(($berkasValid / $totalBerkas) * 100, 2) : 0;
                @endphp
                
                <div class="text-center mb-3">
                    <div class="display-6 fw-bold text-{{ $persentaseValid == 100 ? 'success' : 'warning' }}">
                        {{ $persentaseValid }}%
                    </div>
                    <small class="text-muted">Validitas Berkas</small>
                </div>
                
                <div class="d-flex justify-content-between">
                    <span>Total Berkas:</span>
                    <strong>{{ $totalBerkas }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Berkas Valid:</span>
                    <strong class="text-success">{{ $berkasValid }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Berkas Invalid:</span>
                    <strong class="text-danger">{{ $totalBerkas - $berkasValid }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Detail -->
    <div class="col-lg-8 mb-4">
        <!-- Data Calon Siswa -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate me-2"></i>Data Calon Siswa
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataSiswa)
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama Lengkap</strong></td>
                                <td>{{ $pendaftar->dataSiswa->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td>{{ $pendaftar->dataSiswa->nik }}</td>
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
                                <td width="40%"><strong>Alamat</strong></td>
                                <td>{{ $pendaftar->dataSiswa->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Koordinat</strong></td>
                                <td>
                                    @if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng)
                                        {{ $pendaftar->dataSiswa->lat }}, {{ $pendaftar->dataSiswa->lng }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data siswa tidak tersedia</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Data Orang Tua/Wali
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataOrtu)
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Ayah</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
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
                        <h6 class="border-bottom pb-2">Ibu</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
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
                        <h6 class="border-bottom pb-2">Wali</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="20%"><strong>Nama Wali</strong></td>
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
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data orang tua tidak tersedia</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Asal Sekolah -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-school me-2"></i>Asal Sekolah
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->asalSekolah)
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>NPSN</strong></td>
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
                                <td width="40%"><strong>Kabupaten</strong></td>
                                <td>{{ $pendaftar->asalSekolah->kabupaten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nilai Rata-rata</strong></td>
                                <td>
                                    <span class="badge bg-primary fs-6">
                                        {{ $pendaftar->asalSekolah->nilai_rata }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data asal sekolah tidak tersedia</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Berkas Pendaftaran -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-upload me-2"></i>Berkas Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->berkas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar->berkas as $berkas)
                            <tr>
                                <td>
                                    <strong>{{ $berkas->jenis }}</strong>
                                </td>
                                <td>
                                    <i class="fas fa-file-{{ in_array(pathinfo($berkas->nama_file, PATHINFO_EXTENSION), ['pdf']) ? 'pdf text-danger' : 'image text-primary' }} me-2"></i>
                                    {{ Str::limit($berkas->nama_file, 25) }}
                                </td>
                                <td>
                                    @if($berkas->valid)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Valid
                                    </span>
                                    @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Invalid
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($berkas->catatan)
                                    <small class="text-muted">{{ $berkas->catatan }}</small>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $berkas->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ Storage::url($berkas->url) }}" target="_blank" 
                                       class="btn btn-sm btn-outline-primary" title="Lihat Berkas">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                    <p>Belum ada berkas yang diupload</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745 !important;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #6c757d;
    z-index: 2;
}

.timeline-content {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -21px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
</style>
@endpush