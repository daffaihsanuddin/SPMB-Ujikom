

<?php $__env->startSection('title', 'Dashboard Eksekutif'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Eksekutif</h2>
                    <p class="text-muted mb-0">Ringkasan KPI dan Monitoring Penerimaan Murid Baru</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Update: <?php echo e(now()->format('d/m/Y H:i')); ?></small>
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
                        <div class="stat-number"><?php echo e($stats['total_pendaftar']); ?></div>
                        <small>Total Pendaftar</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number"><?php echo e($stats['pendaftar_hari_ini']); ?></div>
                        <small>Pendaftar Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number"><?php echo e($stats['lulus_administrasi']); ?></div>
                        <small>Lulus Administrasi</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card kpi-card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="text-center">
                        <div class="stat-number"><?php echo e($stats['sudah_bayar']); ?></div>
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
                                     style="width: <?php echo e($rasioPendaftarKuota['persentase_terisi']); ?>%">
                                    <?php echo e($rasioPendaftarKuota['persentase_terisi']); ?>% Terisi
                                </div>
                                <div class="progress-bar bg-light text-dark" 
                                     style="width: <?php echo e($rasioPendaftarKuota['persentase_sisa']); ?>%">
                                    <?php echo e($rasioPendaftarKuota['persentase_sisa']); ?>% Tersedia
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4 class="mb-0"><?php echo e($rasioPendaftarKuota['persentase_terisi']); ?>%</h4>
                            <small class="text-muted">Kuota Terisi</small>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-success mb-0"><?php echo e($rasioPendaftarKuota['pendaftar_lulus']); ?></h5>
                                <small>Pendaftar Lulus</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-primary mb-0"><?php echo e($rasioPendaftarKuota['kuota']); ?></h5>
                                <small>Total Kuota</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2">
                                <h5 class="text-info mb-0"><?php echo e($rasioPendaftarKuota['sisa_kuota']); ?></h5>
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
                    <?php if($trenPendaftaran->count() > 0): ?>
                        <canvas id="trenChart" height="250"></canvas>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data tren pendaftaran</p>
                        </div>
                    <?php endif; ?>
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
                    <?php if($statusPendaftaran->count() > 0): ?>
                        <canvas id="statusChart" height="250"></canvas>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data status</p>
                        </div>
                    <?php endif; ?>
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
                                <?php $__currentLoopData = $pendaftarPerJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($item['nama']); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($item['kode']); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?php echo e($item['pendaftar_total']); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?php echo e($item['pendaftar_lulus']); ?></span>
                                        </td>
                                        <td class="text-center"><?php echo e($item['kuota']); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-<?php echo e($item['sisa_kuota'] == 0 ? 'danger' : ($item['sisa_kuota'] < 5 ? 'warning' : 'success')); ?>">
                                                <?php echo e($item['sisa_kuota']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar <?php echo e($item['persentase_terisi'] >= 100 ? 'bg-danger' : 'bg-success'); ?>"
                                                    style="width: <?php echo e(min($item['persentase_terisi'], 100)); ?>%"
                                                    title="<?php echo e($item['persentase_terisi']); ?>%">
                                                    <?php echo e($item['persentase_terisi']); ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php if($asalSekolah->count() > 0): ?>
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
                                    <?php $__currentLoopData = $asalSekolah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-primary"><?php echo e($index + 1); ?></span>
                                            </td>
                                            <td><?php echo e($item->nama_sekolah); ?></td>
                                            <td class="text-center"><?php echo e($item->kabupaten); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-success"><?php echo e($item->total); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-school fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data asal sekolah</p>
                        </div>
                    <?php endif; ?>
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
                    <?php if($sebaranWilayah->count() > 0): ?>
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
                                    <?php $__currentLoopData = $sebaranWilayah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-info"><?php echo e($index + 1); ?></span>
                                            </td>
                                            <td><?php echo e($item->kecamatan); ?></td>
                                            <td class="text-center"><?php echo e($item->kabupaten); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-primary"><?php echo e($item->total); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data sebaran wilayah</p>
                        </div>
                    <?php endif; ?>
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
                    <?php if($pendaftarPerGelombang->count() > 0): ?>
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
                                    <?php $__currentLoopData = $pendaftarPerGelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($item['nama']); ?></td>
                                            <td class="text-center"><?php echo e($item['tahun']); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-primary"><?php echo e($item['total_pendaftar']); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success"><?php echo e($item['lulus']); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-<?php echo e($item['persentase_lulus'] >= 70 ? 'success' : ($item['persentase_lulus'] >= 50 ? 'warning' : 'danger')); ?>">
                                                    <?php echo e($item['persentase_lulus']); ?>%
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-wave-square fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data gelombang</p>
                        </div>
                    <?php endif; ?>
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
                            <a href="<?php echo e(route('kepsek.laporan-pendaftar')); ?>" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>Data Lengkap Pendaftar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('kepsek.laporan-statistik')); ?>" class="btn btn-outline-success w-100">
                                <i class="fas fa-chart-bar me-2"></i>Laporan Statistik
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('kepsek.export-laporan-pendaftar')); ?>" class="btn btn-outline-danger w-100" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tren Pendaftaran Chart
            <?php if($trenPendaftaran->count() > 0): ?>
            const trenCtx = document.getElementById('trenChart').getContext('2d');
            const trenChart = new Chart(trenCtx, {
                type: 'line',
                data: {
                    labels: [<?php echo $trenPendaftaran->map(function($item) { 
                        return "'" . date('d M', strtotime($item->tanggal)) . "'"; 
                    })->join(','); ?>],
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: [<?php echo e($trenPendaftaran->pluck('total')->join(',')); ?>],
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
            <?php endif; ?>

            // Status Pendaftaran Chart
            <?php if($statusPendaftaran->count() > 0): ?>
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: [<?php echo $statusPendaftaran->map(function($item) { 
                        return "'" . $item['status_text'] . "'"; 
                    })->join(','); ?>],
                    datasets: [{
                        data: [<?php echo e($statusPendaftaran->pluck('total')->join(',')); ?>],
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
            <?php endif; ?>
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.kepsek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/dashboard.blade.php ENDPATH**/ ?>