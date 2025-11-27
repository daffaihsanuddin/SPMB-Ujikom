@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard Admin</h2>
        <p class="text-muted">Ringkasan statistik penerimaan murid baru</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_pendaftar'] }}</h4>
                        <p class="mb-0">Total Pendaftar</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['pendaftar_submit'] }}</h4>
                        <p class="mb-0">Menunggu Verifikasi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['pendaftar_adm_pass'] }}</h4>
                        <p class="mb-0">Lulus Administrasi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['pendaftar_paid'] }}</h4>
                        <p class="mb-0">Sudah Bayar</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pendaftar per Jurusan -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pendaftar per Jurusan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Jurusan</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftarPerJurusan as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td class="text-end">{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftar per Gelombang -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pendaftar per Gelombang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Gelombang</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftarPerGelombang as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td class="text-end">{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.jurusan') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-graduation-cap me-2"></i>Kelola Jurusan
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.gelombang') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-wave-square me-2"></i>Kelola Gelombang
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.monitoring-berkas') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-file-alt me-2"></i>Monitoring Berkas
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.peta-sebaran') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-map me-2"></i>Peta Sebaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection