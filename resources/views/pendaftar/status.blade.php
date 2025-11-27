@extends('layouts.pendaftar')

@section('title', 'Status Pendaftaran')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Status Pendaftaran</h2>
        <p class="text-muted">Pantau progress pendaftaran Anda</p>
    </div>
</div>

@if(!$pendaftaran)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4>Belum Ada Data Pendaftaran</h4>
                <p class="text-muted">Silakan isi formulir pendaftaran terlebih dahulu.</p>
                <a href="{{ route('pendaftar.formulir') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Isi Formulir Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <!-- Informasi Utama -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td>{{ $pendaftaran->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>{{ $pendaftaran->dataSiswa->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>{{ $pendaftaran->jurusan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td>{{ $pendaftaran->gelombang->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>{{ $pendaftaran->tanggal_daftar->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Status Saat Ini -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Saat Ini</h5>
            </div>
            <div class="card-body text-center">
                @php
                    $statusConfig = [
                        'SUBMIT' => ['color' => 'warning', 'icon' => 'clock', 'message' => 'Menunggu verifikasi administrasi'],
                        'ADM_PASS' => ['color' => 'success', 'icon' => 'check-circle', 'message' => 'Lulus administrasi, silakan lanjutkan pembayaran'],
                        'ADM_REJECT' => ['color' => 'danger', 'icon' => 'times-circle', 'message' => 'Tidak lulus administrasi'],
                        'PAID' => ['color' => 'info', 'icon' => 'money-bill-wave', 'message' => 'Pembayaran terverifikasi']
                    ];
                    $config = $statusConfig[$pendaftaran->status] ?? ['color' => 'secondary', 'icon' => 'question-circle', 'message' => 'Status tidak diketahui'];
                @endphp
                
                <div class="mb-3">
                    <i class="fas fa-{{ $config['icon'] }} fa-3x text-{{ $config['color'] }} mb-3"></i>
                    <h4 class="text-{{ $config['color'] }}">
                        {{ $pendaftaran->status }}
                    </h4>
                </div>
                <p class="text-muted">{{ $config['message'] }}</p>

                @if($pendaftaran->status === 'ADM_PASS')
                <a href="{{ route('pendaftar.pembayaran') }}" class="btn btn-success mt-2">
                    <i class="fas fa-money-bill-wave me-2"></i>Lanjutkan Pembayaran
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Timeline Progress -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Timeline Progress</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($timeline as $item)
                    <div class="timeline-item {{ $item['completed'] ? 'completed' : '' }} {{ $item['active'] ? 'active' : '' }}">
                        <div class="card mb-3 {{ $item['active'] ? 'border-primary' : '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 {{ $item['active'] ? 'text-primary' : '' }}">
                                            {{ $item['status'] }}
                                        </h6>
                                        <p class="card-text text-muted mb-1">{{ $item['description'] }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $item['date'] }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($item['completed'])
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        @elseif($item['active'])
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        @else
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Detail Verifikasi -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Verifikasi Administrasi</h6>
                        @if($pendaftaran->tgl_verifikasi_adm)
                        <table class="table table-sm">
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class="badge bg-{{ $pendaftaran->status === 'ADM_PASS' ? 'success' : 'danger' }}">
                                        {{ $pendaftaran->status === 'ADM_PASS' ? 'Lulus' : 'Tidak Lulus' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>{{ $pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Verifikator</td>
                                <td>{{ $pendaftaran->user_verifikasi_adm ?? '-' }}</td>
                            </tr>
                        </table>
                        @else
                        <p class="text-muted">Menunggu verifikasi administrasi</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Verifikasi Pembayaran</h6>
                        @if($pendaftaran->tgl_verifikasi_payment)
                        <table class="table table-sm">
                            <tr>
                                <td>Status</td>
                                <td><span class="badge bg-success">Terverifikasi</span></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>{{ $pendaftaran->tgl_verifikasi_payment->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Verifikator</td>
                                <td>{{ $pendaftaran->user_verifikasi_payment ?? '-' }}</td>
                            </tr>
                        </table>
                        @else
                        <p class="text-muted">
                            @if($pendaftaran->status === 'ADM_PASS')
                            Silakan lakukan pembayaran dan upload bukti
                            @else
                            Menunggu verifikasi pembayaran
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Berkas</h5>
            </div>
            <div class="card-body">
                @if($pendaftaran->berkas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftaran->berkas as $berkas)
                            <tr>
                                <td>{{ $berkasTypes[$berkas->jenis] ?? $berkas->jenis }}</td>
                                <td>
                                    @if($berkas->valid)
                                    <span class="badge bg-success">Valid</span>
                                    @else
                                    <span class="badge bg-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>{{ $berkas->catatan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">Belum ada berkas yang diupload</p>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('pendaftar.upload-berkas') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file-upload me-2"></i>Kelola Berkas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection