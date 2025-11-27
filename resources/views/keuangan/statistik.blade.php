@extends('layouts.keuangan')

@section('title', 'Statistik Keuangan')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Statistik Keuangan</h2>
                    <p class="text-muted mb-0">Analisis data pemasukan dan tren pembayaran</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Update: {{ now()->format('d/m/Y H:i') }}</small>
                    <a href="{{ route('keuangan.export-pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($error))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Terjadi kesalahan dalam menampilkan statistik: {{ $error }}
        </div>
    @endif

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</h4>
                            <p class="mb-0">Total Pendapatan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $ringkasan['total_peserta'] }}</h4>
                            <p class="mb-0">Total Peserta Bayar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">Rp {{ number_format($ringkasan['rata_rata_per_bulan'], 0, ',', '.') }}</h4>
                            <p class="mb-0">Rata-rata per Bulan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">
                                @if($ringkasan['bulan_tertinggi'])
                                    {{ DateTime::createFromFormat('!m', $ringkasan['bulan_tertinggi']->bulan)->format('F') }}
                                @else
                                    -
                                @endif
                            </h4>
                            <p class="mb-0">Bulan Tertinggi</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-trophy fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Grafik Pendapatan per Bulan -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Pendapatan per Bulan ({{ date('Y') }})
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="pendapatanBulananChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Pendapatan per Jurusan -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Pendapatan per Jurusan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="pendapatanJurusanChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tren Harian 30 Hari -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Tren Harian 30 Hari Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="trenHarianChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Pendapatan per Gelombang -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-wave-square me-2"></i>Pendapatan per Gelombang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Gelombang</th>
                                    <th class="text-end">Peserta</th>
                                    <th class="text-end">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendapatanPerGelombang as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-end">{{ $item->total_peserta }}</td>
                                        <td class="text-end">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @if($pendapatanPerGelombang->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                            Belum ada data
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pendapatan per Bulan -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>Detail Pendapatan per Bulan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th class="text-end">Tahun</th>
                                    <th class="text-end">Jumlah Peserta</th>
                                    <th class="text-end">Total Pendapatan</th>
                                    <th class="text-end">Rata-rata per Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendapatanPerBulan as $item)
                                    @php
                                        $namaBulan = DateTime::createFromFormat('!m', $item->bulan)->format('F');
                                        $rataPerPeserta = $item->total_peserta > 0 ? $item->total_pendapatan / $item->total_peserta : 0;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $namaBulan }}</strong></td>
                                        <td class="text-end">{{ $item->tahun }}</td>
                                        <td class="text-end">{{ $item->total_peserta }}</td>
                                        <td class="text-end">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($rataPerPeserta, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @if($pendapatanPerBulan->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-chart-bar fa-3x mb-3"></i><br>
                                            Belum ada data pendapatan
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pendapatan per Jurusan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Detail Pendapatan per Jurusan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jurusan</th>
                                    <th class="text-end">Jumlah Peserta</th>
                                    <th class="text-end">Total Pendapatan</th>
                                    <th class="text-end">Persentase</th>
                                    <th class="text-end">Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendapatanPerJurusan as $item)
                                    @php
                                        $persentase = $ringkasan['total_pendapatan'] > 0 ?
                                            ($item->total_pendapatan / $ringkasan['total_pendapatan']) * 100 : 0;
                                        $rataPerPeserta = $item->total_peserta > 0 ? $item->total_pendapatan / $item->total_peserta : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-end">{{ $item->total_peserta }}</td>
                                        <td class="text-end">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($persentase, 1) }}%</td>
                                        <td class="text-end">Rp {{ number_format($rataPerPeserta, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @if($pendapatanPerJurusan->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-graduation-cap fa-3x mb-3"></i><br>
                                            Belum ada data per jurusan
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Pendapatan Bulanan
            const bulananCtx = document.getElementById('pendapatanBulananChart').getContext('2d');

            // Siapkan data untuk semua bulan
            const semuaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dataBulanan = Array(12).fill(0);

            @foreach($pendapatanPerBulan as $item)
                dataBulanan[{{ $item->bulan }} - 1] = {{ $item->total_pendapatan }};
            @endforeach

            const bulananChart = new Chart(bulananCtx, {
                type: 'bar',
                data: {
                    labels: semuaBulan,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataBulanan,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Chart Pendapatan per Jurusan
            const jurusanCtx = document.getElementById('pendapatanJurusanChart').getContext('2d');
            const jurusanChart = new Chart(jurusanCtx, {
                type: 'doughnut',
                data: {
                    labels: [{!! $pendapatanPerJurusan->map(fn($item) => "'" . $item->nama . "'")->join(',') !!}],
                    datasets: [{
                        data: [{{ $pendapatanPerJurusan->pluck('total_pendapatan')->join(',') }}],
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Chart Tren Harian
            const harianCtx = document.getElementById('trenHarianChart').getContext('2d');
            const harianChart = new Chart(harianCtx, {
                type: 'line',
                data: {
                    labels: [{!! $pendapatanHarian->map(fn($item) => "'" . date('d M', strtotime($item->tanggal)) . "'")->join(',') !!}],
                    datasets: [{
                        label: 'Pendapatan Harian',
                        data: [{{ $pendapatanHarian->pluck('total_pendapatan')->join(',') }}],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush