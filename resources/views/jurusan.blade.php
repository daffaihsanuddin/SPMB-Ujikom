@extends('layouts.public')

@section('title', 'Program Jurusan')
@section('content')
<!-- Header Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Program Jurusan</h1>
                <p class="lead">Temukan jurusan yang tepat untuk masa depan Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Jurusan List -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($jurusan as $item)
            @php
                $persentase = $item->kuota > 0 ? round(($item->pendaftar_count / $item->kuota) * 100, 2) : 0;
                $sisaKuota = max(0, $item->kuota - $item->pendaftar_count);
            @endphp
            <div class="col-lg-6">
                <div class="card card-hover h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="card-title fw-bold text-primary">{{ $item->nama }}</h4>
                                <p class="card-text text-muted mb-2">
                                    <strong>Kode:</strong> {{ $item->kode }}
                                </p>
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <strong>Kuota:</strong> {{ $item->kuota }} siswa | 
                                        <strong>Terdaftar:</strong> {{ $item->pendaftar_count }} | 
                                        <strong>Sisa:</strong> {{ $sisaKuota }}
                                    </small>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($persentase >= 100) bg-danger
                                        @elseif($persentase >= 80) bg-warning
                                        @else bg-success @endif" 
                                        style="width: {{ min($persentase, 100) }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ min($persentase, 100) }}% terisi</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="icon-wrapper bg-primary rounded-circle mx-auto mb-3" 
                                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-laptop-code fa-2x text-white"></i>
                                </div>
                                @if($sisaKuota > 0)
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                    Daftar Sekarang
                                </a>
                                @else
                                <span class="badge bg-danger">Kuota Penuh</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($jurusan->isEmpty())
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada data jurusan</h4>
                <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Info Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h3 class="fw-bold mb-3">Butuh Bantuan Memilih Jurusan?</h3>
                <p class="text-muted mb-4">
                    Konsultasikan pilihan jurusan Anda dengan guru BK kami. Dapatkan panduan berdasarkan 
                    minat, bakat, dan potensi Anda.
                </p>
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    <i class="fas fa-comments me-2"></i>Konsultasi Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection