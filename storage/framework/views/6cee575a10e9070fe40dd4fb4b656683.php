

<?php $__env->startSection('title', 'Laporan Statistik SPMB'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Laporan Statistik SPMB</h2>
                    <p class="text-muted mb-0">Analisis data penerimaan peserta didik baru</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <!-- Filter Tahun -->
                    <form method="GET" class="d-flex gap-2">
                        <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                            <?php $__currentLoopData = $tahunTersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahunItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tahunItem); ?>" <?php echo e($tahun == $tahunItem ? 'selected' : ''); ?>>
                                    Tahun <?php echo e($tahunItem); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <a href="<?php echo e(route('kepsek.export-statistik', ['tahun' => $tahun])); ?>" class="btn btn-danger btn-sm"
                            target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?php echo e(number_format($ringkasan['total_pendaftar'], 0)); ?></h4>
                    <small>Total Pendaftar</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?php echo e(number_format($ringkasan['total_lulus'], 0)); ?></h4>
                    <small>Total Lulus</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?php echo e(number_format($ringkasan['total_kuota'], 0)); ?></h4>
                    <small>Total Kuota</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?php echo e(number_format($ringkasan['sisa_kuota'], 0)); ?></h4>
                    <small>Sisa Kuota</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Ringkasan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Ringkasan Kinerja Penerimaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <h5 class="text-primary"><?php echo e($ringkasan['persentase_lulus']); ?>%</h5>
                                <small class="text-muted">Tingkat Kelulusan</small>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-primary" style="width: <?php echo e($ringkasan['persentase_lulus']); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <h5 class="text-success"><?php echo e($ringkasan['persentase_terisi']); ?>%</h5>
                                <small class="text-muted">Kuota Terisi</small>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: <?php echo e($ringkasan['persentase_terisi']); ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <h5 class="text-info"><?php echo e(100 - $ringkasan['persentase_terisi']); ?>%</h5>
                                <small class="text-muted">Kuota Tersisa</small>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: <?php echo e(100 - $ringkasan['persentase_terisi']); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Statistik Bulanan -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Statistik Pendaftaran per Bulan (Tahun <?php echo e($tahun); ?>)
                    </h5>
                    <span class="badge bg-primary">Total: <?php echo e(array_sum(array_column($bulananLengkap, 'total'))); ?></span>
                </div>
                <div class="card-body">
                    <canvas id="bulananChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Ringkasan Status -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Status Pendaftaran
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                        $totalStatus = $statistikStatus->sum('total');
                    ?>
                    <?php $__currentLoopData = $statistikStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted"><?php echo e($item['status_text']); ?></span>
                                <strong><?php echo e($item['total']); ?>

                                    (<?php echo e($totalStatus > 0 ? round(($item['total'] / $totalStatus) * 100, 1) : 0); ?>%)</strong>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar 
                                            <?php if($item['status'] == 'SUBMIT'): ?> bg-warning
                                            <?php elseif($item['status'] == 'ADM_PASS'): ?> bg-success
                                            <?php elseif($item['status'] == 'ADM_REJECT'): ?> bg-danger
                                            <?php elseif($item['status'] == 'PAID'): ?> bg-info
                                            <?php else: ?> bg-secondary <?php endif; ?>"
                                    style="width: <?php echo e(($item['total'] / max($totalStatus, 1)) * 100); ?>%"
                                    title="<?php echo e($item['total']); ?> pendaftar">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Chart Pie untuk Status -->
                    <div class="mt-4">
                        <canvas id="statusChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Statistik per Jurusan -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Statistik per Jurusan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Jurusan</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Lulus</th>
                                    <th class="text-center">Kuota</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-center">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $statistikJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($item['kode']); ?></strong><br>
                                            <small class="text-muted"><?php echo e($item['nama']); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?php echo e($item['total_pendaftar']); ?></span>
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
                                                    style="width: <?php echo e(min($item['persentase_terisi'], 100)); ?>%">
                                                    <?php echo e($item['persentase_terisi']); ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <th>TOTAL</th>
                                    <th class="text-center"><?php echo e($statistikJurusan->sum('total_pendaftar')); ?></th>
                                    <th class="text-center"><?php echo e($statistikJurusan->sum('pendaftar_lulus')); ?></th>
                                    <th class="text-center"><?php echo e($statistikJurusan->sum('kuota')); ?></th>
                                    <th class="text-center"><?php echo e($statistikJurusan->sum('sisa_kuota')); ?></th>
                                    <th class="text-center">
                                        <?php
                                            $totalTerisi = $statistikJurusan->sum('kuota') > 0 ? 
                                                round(($statistikJurusan->sum('pendaftar_lulus') / $statistikJurusan->sum('kuota')) * 100, 1) : 0;
                                        ?>
                                        <?php echo e($totalTerisi); ?>%
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik per Gelombang -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-wave-square me-2"></i>Statistik per Gelombang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Gelombang</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Biaya</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Lulus</th>
                                    <th class="text-center">% Lulus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $statistikGelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $persentaseLulus = $item->total > 0 ? round(($item->lulus / $item->total) * 100, 1) : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($item->nama); ?></strong><br>
                                            <small class="text-muted">Tahun <?php echo e($item->tahun); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e(\Carbon\Carbon::parse($item->tgl_mulai)->format('d/m')); ?> -
                                            <?php echo e(\Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y')); ?>

                                        </td>
                                        <td class="text-center">
                                            Rp <?php echo e(number_format($item->biaya_daftar, 0, ',', '.')); ?>

                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?php echo e($item->total); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?php echo e($item->lulus); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-<?php echo e($persentaseLulus >= 70 ? 'success' : ($persentaseLulus >= 50 ? 'warning' : 'danger')); ?>">
                                                <?php echo e($persentaseLulus); ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <a href="<?php echo e(route('kepsek.export-statistik', ['tahun' => $tahun])); ?>" class="btn btn-outline-danger w-100" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Export Statistik
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('kepsek.export-laporan-pendaftar')); ?>" class="btn btn-outline-info w-100" target="_blank">
                                <i class="fas fa-download me-2"></i>Export Data Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Statistik Bulanan Chart
            const bulananCtx = document.getElementById('bulananChart').getContext('2d');

            const labels = <?php echo json_encode(array_column($bulananLengkap, 'nama_bulan')); ?>;
            const dataTotal = <?php echo json_encode(array_column($bulananLengkap, 'total')); ?>;
            const dataLulus = <?php echo json_encode(array_column($bulananLengkap, 'lulus')); ?>;

            const bulananChart = new Chart(bulananCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Pendaftar',
                            data: dataTotal,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Lulus Administrasi',
                            data: dataLulus,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.parsed.y} orang`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function (value) {
                                    if (value % 1 === 0) {
                                        return value;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Pendaftar'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    }
                }
            });

            // Status Pendaftaran Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            
            const statusLabels = <?php echo json_encode($statistikStatus->pluck('status_text')->toArray()); ?>;
            const statusData = <?php echo json_encode($statistikStatus->pluck('total')->toArray()); ?>;
            const statusColors = [
                '#f39c12', // Menunggu Verifikasi - Orange
                '#27ae60', // Lulus Administrasi - Green  
                '#e74c3c', // Ditolak - Red
                '#3498db'  // Sudah Bayar - Blue
            ];

            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: statusColors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    },
                    cutout: '50%'
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.kepsek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/laporan/statistik.blade.php ENDPATH**/ ?>