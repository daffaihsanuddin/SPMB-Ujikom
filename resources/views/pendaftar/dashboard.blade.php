@extends('layouts.pendaftar')

@section('title', 'Dashboard Pendaftar')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard Pendaftar</h2>
        <p class="text-muted">Selamat datang di sistem SPMB Online</p>
    </div>
</div>

@if(!$pendaftaran)
<!-- Belum Mendaftar -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h4>Anda Belum Mengisi Formulir Pendaftaran</h4>
                <p class="text-muted">Silakan isi formulir pendaftaran untuk memulai proses SPMB</p>
                <a href="{{ route('pendaftar.formulir') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit me-2"></i>Isi Formulir Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>
@else
<!-- Sudah Mendaftar -->
<div class="row">
    <!-- Status Cards -->
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendaftaran->no_pendaftaran }}</h4>
                        <p class="mb-0">No. Pendaftaran</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-id-card fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-{{ [
            'SUBMIT' => 'warning',
            'ADM_PASS' => 'success',
            'ADM_REJECT' => 'danger',
            'PAID' => 'info'
        ][$pendaftaran->status] }} text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $stats['berkas_valid'] }}/{{ $stats['berkas_uploaded'] }}</h4>
                        <p class="mb-0">Berkas Valid</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendaftaran->jurusan->nama }}</h4>
                        <p class="mb-0">Jurusan Pilihan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendaftaran->gelombang->nama }}</h4>
                        <p class="mb-0">Gelombang</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-wave-square fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Status -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Pendaftaran</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-1">Status Saat Ini:</h6>
                        <span class="badge bg-{{
                            ['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                            [$pendaftaran->status]
                        }} fs-6 p-2">
                            {{ $pendaftaran->status }}
                        </span>
                        <p class="mt-2 mb-0 text-muted">
                            @if($pendaftaran->status === 'SUBMIT')
                                Pendaftaran Anda sedang dalam proses verifikasi administrasi.
                            @elseif($pendaftaran->status === 'ADM_PASS')
                                Selamat! Anda lulus administrasi.
                            @elseif($pendaftaran->status === 'ADM_REJECT')
                                Maaf, Anda tidak lulus administrasi.
                            @elseif($pendaftaran->status === 'PAID')
                                Pembayaran Anda telah diverifikasi.
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('pendaftar.status') }}" class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>Lihat Detail Status
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('pendaftar.upload-berkas') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-file-upload me-2"></i>Upload Berkas
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('pendaftar.status') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-history me-2"></i>Lihat Status
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('pendaftar.pembayaran') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-money-bill-wave me-2"></i>Pembayaran
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('pendaftar.cetak-kartu') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-print me-2"></i>Cetak Kartu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection