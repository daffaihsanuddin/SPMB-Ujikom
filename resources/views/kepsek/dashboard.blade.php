@extends('layouts.kepsek')

@section('title', 'Dashboard Eksekutif')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Eksekutif</h2>
                    <p class="text-muted mb-0">Ringkasan KPI dan Monitoring Penerimaan Murid Baru</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Update: {{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number">{{ $stats['total_pendaftar'] }}</div>
                        <small>Total Pendaftar</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number">{{ $stats['pendaftar_hari_ini'] }}</div>
                        <small>Pendaftar Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number">{{ $stats['lulus_administrasi'] }}</div>
                        <small>Lulus Administrasi</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number">{{ $stats['sudah_bayar'] }}</div>
                        <small>Sudah Membayar</small>
                    </div>
                </div>
            </div>
        </div>
    <!-- Rasio Kuota -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Rasio Kuota Terisi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $rasioPendaftarKuota['persentase_terisi'] }}%">
                                    {{ $rasioPendaftarKuota['persentase_terisi'] }}% Terisi
                                </div>
                                <div class="progress-bar bg-light text-dark" 
                                     style="width: {{ $rasioPendaftarKuota['persentase_sisa'] }}%">
                                    {{ $rasioPendaftarKuota['persentase_sisa'] }}% Tersedia
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4 class="mb-0">{{ $rasioPendaftarKuota['persentase_terisi'] }}%</h4>
                            <small class="text-muted">Kuota Terisi</small>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-success mb-0">{{ $rasioPendaftarKuota['pendaftar_lulus'] }}</h5>
                                <small>Pendaftar Lulus</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-primary mb-0">{{ $rasioPendaftarKuota['kuota'] }}</h5>
                                <small>Total Kuota</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-info mb-0">{{ $rasioPendaftarKuota['sisa_kuota'] }}</h5>
                                <small>Sisa Kuota</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tren Pendaftaran -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Tren Pendaftaran 30 Hari Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    @if($trenPendaftaran->count() > 0)
                        <canvas id="trenChart" height="250"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data tren pendaftaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Status Pendaftaran
                    </h5>
                </div>
                <div class="card-body">
                    @if($statusPendaftaran->count() > 0)
                        <canvas id="statusChart" height="250"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data status</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pendaftar per Jurusan -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Pendaftar per Jurusan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Jurusan</th>
                                    <th class="text-center">Pendaftar</th>
                                    <th class="text-center">Lulus</th>
                                    <th class="text-center">Kuota</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-center">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendaftarPerJurusan as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item['nama'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item['kode'] }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $item['pendaftar_total'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $item['pendaftar_lulus'] }}</span>
                                        </td>
                                        <td class="text-center">{{ $item['kuota'] }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $item['sisa_kuota'] == 0 ? 'danger' : ($item['sisa_kuota'] < 5 ? 'warning' : 'success') }}">
                                                {{ $item['sisa_kuota'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $item['persentase_terisi'] >= 100 ? 'bg-danger' : 'bg-success' }}"
                                                    style="width: {{ min($item['persentase_terisi'], 100) }}%"
                                                    title="{{ $item['persentase_terisi'] }}%">
                                                    {{ $item['persentase_terisi'] }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asal Sekolah Terbanyak -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-school me-2"></i>10 Besar Asal Sekolah
                    </h5>
                </div>
                <div class="card-body">
                    @if($asalSekolah->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sekolah</th>
                                        <th class="text-center">Kabupaten</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asalSekolah as $index => $item)
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $index + 1 }}</span>
                                            </td>
                                            <td>{{ $item->nama_sekolah }}</td>
                                            <td class="text-center">{{ $item->kabupaten }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $item->total }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-school fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data asal sekolah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sebaran Wilayah -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Sebaran Wilayah (Top 10)
                    </h5>
                </div>
                <div class="card-body">
                    @if($sebaranWilayah->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kecamatan</th>
                                        <th class="text-center">Kabupaten</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sebaranWilayah as $index => $item)
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $index + 1 }}</span>
                                            </td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="text-center">{{ $item->kabupaten }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $item->total }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data sebaran wilayah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pendaftar per Gelombang -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-wave-square me-2"></i>Pendaftar per Gelombang
                    </h5>
                </div>
                <div class="card-body">
                    @if($pendaftarPerGelombang->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Gelombang</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Lulus</th>
                                        <th class="text-center">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendaftarPerGelombang as $item)
                                        <tr>
                                            <td>{{ $item['nama'] }}</td>
                                            <td class="text-center">{{ $item['tahun'] }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $item['total_pendaftar'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $item['lulus'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $item['persentase_lulus'] >= 70 ? 'success' : ($item['persentase_lulus'] >= 50 ? 'warning' : 'danger') }}">
                                                    {{ $item['persentase_lulus'] }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-wave-square fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data gelombang</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Akses Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('kepsek.laporan-pendaftar') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>Data Lengkap Pendaftar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('kepsek.laporan-statistik') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-chart-bar me-2"></i>Laporan Statistik
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('kepsek.export-laporan-pendaftar') }}" class="btn btn-outline-danger w-100" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .kpi-card {
        transition: transform 0.2s;
        border: none;
        border-radius: 10px;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
    }
    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }
    .progress {
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tren Pendaftaran Chart
            @if($trenPendaftaran->count() > 0)
            const trenCtx = document.getElementById('trenChart').getContext('2d');
            const trenChart = new Chart(trenCtx, {
                type: 'line',
                data: {
                    labels: [{!! $trenPendaftaran->map(function($item) { 
                        return "'" . date('d M', strtotime($item->tanggal)) . "'"; 
                    })->join(',') !!}],
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: [{{ $trenPendaftaran->pluck('total')->join(',') }}],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3498db',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Pendaftar'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });
            @endif

            // Status Pendaftaran Chart
            @if($statusPendaftaran->count() > 0)
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: [{!! $statusPendaftaran->map(function($item) { 
                        return "'" . $item['status_text'] . "'"; 
                    })->join(',') !!}],
                    datasets: [{
                        data: [{{ $statusPendaftaran->pluck('total')->join(',') }}],
                        backgroundColor: [
                            '#f39c12', // Menunggu Verifikasi - Orange
                            '#27ae60', // Lulus Administrasi - Green
                            '#e74c3c', // Ditolak - Red
                            '#3498db'  // Sudah Bayar - Blue
                        ],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
            @endif
        });
    </script>
@endpush