

<?php $__env->startSection('title', 'Dashboard Keuangan'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Dashboard Keuangan</h2>
        <p class="text-muted">Panel monitoring dan manajemen keuangan SPMB</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo e($stats['total_pendaftar']); ?></h4>
                        <p class="mb-0 small">Total Pendaftar</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo e($stats['menunggu_verifikasi']); ?></h4>
                        <p class="mb-0 small">Menunggu Verifikasi</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><?php echo e($stats['sudah_bayar']); ?></h4>
                        <p class="mb-0 small">Sudah Bayar</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">Rp <?php echo e(number_format($stats['total_pemasukan'], 0, ',', '.')); ?></h4>
                        <p class="mb-0 small">Total Pemasukan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Pemasukan Hari Ini -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-day me-2"></i>Pemasukan Hari Ini
                </h5>
            </div>
            <div class="card-body text-center py-4">
                <h1 class="text-success mb-2">Rp <?php echo e(number_format($pemasukanHariIni, 0, ',', '.')); ?></h1>
                <p class="text-muted mb-0">Total pemasukan dari pembayaran yang diverifikasi hari ini</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('keuangan.verifikasi-pembayaran')); ?>" class="btn btn-warning btn-lg text-start">
                        <i class="fas fa-money-bill-wave me-2"></i>Verifikasi Pembayaran
                        <?php if($stats['menunggu_verifikasi'] > 0): ?>
                        <span class="badge bg-danger rounded-pill float-end"><?php echo e($stats['menunggu_verifikasi']); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('keuangan.rekap-keuangan')); ?>" class="btn btn-info btn-lg text-start">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Rekap Keuangan
                    </a>
                    <a href="<?php echo e(route('keuangan.statistik')); ?>" class="btn btn-success btn-lg text-start">
                        <i class="fas fa-chart-bar me-2"></i>Lihat Statistik
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pembayaran Terbaru -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pembayaran Menunggu Verifikasi</h5>
            </div>
            <div class="card-body">
                <?php if($pembayaranTerbaru->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Biaya</th>
                                <th>Tanggal Lulus Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pembayaranTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                                <td><?php echo e($item->user->nama); ?></td>
                                <td><?php echo e($item->jurusan->nama); ?></td>
                                <td>Rp <?php echo e(number_format($item->gelombang->biaya_daftar, 0, ',', '.')); ?></td>
                                <td><?php echo e($item->tgl_verifikasi_adm?->format('d/m/Y H:i') ?? '-'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('keuangan.show-pembayaran', $item->id)); ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-search me-1"></i>Verifikasi
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-success">Tidak Ada Pembayaran Menunggu</h5>
                    <p class="text-muted">Semua pembayaran sudah diverifikasi</p>
                </div>
                <?php endif; ?>
                
                <div class="text-center mt-3">
                    <a href="<?php echo e(route('keuangan.verifikasi-pembayaran')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>Lihat Semua Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/keuangan/dashboard.blade.php ENDPATH**/ ?>