


<?php $__env->startSection('title', 'Statistik Verifikasi'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Statistik Verifikasi</h2>
                <p class="text-muted">Data statistik kinerja verifikasi administrasi</p>
            </div>
            <div>
                <a href="<?php echo e(route('verifikator.export.pdf')); ?>" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
                <a href="<?php echo e(route('verifikator.index')); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-clipboard-check me-2"></i>Verifikasi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <!-- Menunggu Verifikasi -->
    <div class="col-md-3 mb-3">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-warning"><?php echo e($statistik->menunggu ?? 0); ?></h4>
                        <p class="mb-0 small text-muted">MENUNGGU VERIFIKASI</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x text-warning opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Diverifikasi -->
    <div class="col-md-3 mb-3">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-primary"><?php echo e(($statistik->lulus ?? 0) + ($statistik->tolak ?? 0)); ?></h4>
                        <p class="mb-0 small text-muted">TOTAL DIVERIFIKASI</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clipboard-check fa-2x text-primary opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lulus Administrasi -->
    <div class="col-md-3 mb-3">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-success"><?php echo e($statistik->lulus ?? 0); ?></h4>
                        <p class="mb-0 small text-muted">LULUS ADMINISTRASI</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-success opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tidak Lulus -->
    <div class="col-md-3 mb-3">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-danger"><?php echo e($statistik->tolak ?? 0); ?></h4>
                        <p class="mb-0 small text-muted">TIDAK LULUS</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x text-danger opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo e(route('verifikator.export.pdf')); ?>" class="btn btn-danger w-100">
                            <i class="fas fa-file-pdf me-2"></i>Export Statistik PDF
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="btn btn-outline-info w-100">
                            <i class="fas fa-history me-2"></i>Lihat Riwayat
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?php echo e(route('verifikator.index')); ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-clipboard-check me-2"></i>Verifikasi Baru
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button onclick="window.print()" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transition: transform 0.2s;
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

.progress {
    border-radius: 10px;
}

.progress-bar {
    font-size: 0.75rem;
    font-weight: 600;
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.badge {
    font-size: 0.75rem;
}

.border.rounded {
    border-radius: 8px !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.verifikator', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/verifikator/statistik.blade.php ENDPATH**/ ?>