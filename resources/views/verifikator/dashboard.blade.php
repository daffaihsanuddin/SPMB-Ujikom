@extends('layouts.verifikator')

@section('title', 'Dashboard Verifikator')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard Verifikator</h2>
        <p class="text-muted">Ringkasan verifikasi administrasi pendaftaran</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_menunggu'] }}</h4>
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
                        <h4>{{ $stats['total_lulus'] }}</h4>
                        <p class="mb-0">Total Lulus</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['total_tolak'] }}</h4>
                        <p class="mb-0">Total Ditolak</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
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
                        <h4>{{ $stats['total_diverifikasi'] }}</h4>
                        <p class="mb-0">Total Diverifikasi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('verifikator.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-list me-2"></i>Verifikasi Pendaftar
                        </a>
                        <small class="text-muted d-block mt-1">
                            {{ $stats['total_menunggu'] }} menunggu
                        </small>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('verifikator.riwayat') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-history me-2"></i>Riwayat Verifikasi
                        </a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('verifikator.export.pdf') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-download me-2"></i>Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Status -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning me-2">SUBMIT</span>
                        <span>Menunggu verifikasi administrasi</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2">ADM_PASS</span>
                        <span>Lulus administrasi - menunggu pembayaran</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-danger me-2">ADM_REJECT</span>
                        <span>Tidak lulus administrasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section (Opsional) -->
@if(isset($verifikasiHarian) && $verifikasiHarian->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktivitas Verifikasi 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Lulus</th>
                                <th class="text-end">Tolak</th>
                                <th class="text-end">Persentase Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifikasiHarian as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                                <td class="text-end">{{ $data->total }}</td>
                                <td class="text-end">{{ $data->lulus }}</td>
                                <td class="text-end">{{ $data->tolak }}</td>
                                <td class="text-end">
                                    @php
                                        $persentase = $data->total > 0 ? round(($data->lulus / $data->total) * 100, 1) : 0;
                                    @endphp
                                    <span class="badge bg-{{ $persentase >= 70 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger') }}">
                                        {{ $persentase }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: transform 0.2s;
        border: none;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .card.border-warning {
        border-left: 4px solid #ffc107 !important;
    }

    .card.border-primary {
        border-left: 4px solid #0d6efd !important;
    }

    .card.border-success {
        border-left: 4px solid #198754 !important;
    }

    .card.border-danger {
        border-left: 4px solid #dc3545 !important;
    }

    .card .card-body {
        padding: 1.5rem;
    }

    .card h4 {
        font-weight: 700;
        font-size: 1.8rem;
    }

    .card .small {
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .card .fa-2x {
        font-size: 1.8rem;
    }

    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        border-radius: 100%;
    }

    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .list-group-item {
        border: none;
        padding: 1rem 0;
        border-bottom: 1px solid #eee !important;
    }

    .list-group-item:last-child {
        border-bottom: none !important;
    }

    .card-header {
        border-bottom: 1px solid #e3e6f0;
        background-color: #fff !important;
    }
</style>
@endpush