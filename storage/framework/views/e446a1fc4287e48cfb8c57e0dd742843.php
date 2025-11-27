

<?php $__env->startSection('title', 'Rekap Keuangan'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Rekap Keuangan</h2>
                <p class="text-muted">Laporan pemasukan biaya pendaftaran</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('keuangan.export-pdf', request()->query())); ?>" 
                   class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>Filter Laporan
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('keuangan.rekap-keuangan')); ?>" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?php echo e(request('start_date')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?php echo e(request('end_date')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>" 
                                    <?php echo e(request('jurusan_id') == $item->id ? 'selected' : ''); ?>>
                                    <?php echo e($item->nama); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="gelombang_id" class="form-label">Gelombang</label>
                            <select class="form-select" id="gelombang_id" name="gelombang_id">
                                <option value="">Semua Gelombang</option>
                                <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>" 
                                    <?php echo e(request('gelombang_id') == $item->id ? 'selected' : ''); ?>>
                                    <?php echo e($item->nama); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Terapkan Filter
                            </button>
                            <a href="<?php echo e(route('keuangan.rekap-keuangan')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-refresh me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Ringkasan -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="card-title">Rp <?php echo e(number_format($statistik['total_pendapatan'], 0, ',', '.')); ?></h3>
                <p class="card-text">Total Pendapatan</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="card-title"><?php echo e($statistik['total_peserta']); ?></h3>
                <p class="card-text">Total Peserta</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="card-title">Rp <?php echo e(number_format($statistik['rata_rata'], 0, ',', '.')); ?></h3>
                <p class="card-text">Rata-rata per Peserta</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th class="text-end">Biaya</th>
                                <th class="text-center">Tanggal Bayar</th>
                                <th class="text-center">Verifikator</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                                <td><?php echo e($item->user->nama); ?></td>
                                <td><?php echo e($item->jurusan->nama); ?></td>
                                <td><?php echo e($item->gelombang->nama); ?></td>
                                <td class="text-end">Rp <?php echo e(number_format($item->gelombang->biaya_daftar, 0, ',', '.')); ?></td>
                                <td class="text-center"><?php echo e($item->tgl_verifikasi_payment->format('d/m/Y')); ?></td>
                                <td class="text-center"><?php echo e($item->user_verifikasi_payment); ?></td>
                                <td class="text-center">
                                    <span class="badge bg-success">TERBAYAR</span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak Ada Data</h5>
                                    <p class="text-muted">Tidak ada transaksi yang sesuai dengan filter</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <?php if($pendaftar->count() > 0): ?>
                        <tfoot class="table-dark">
                            <tr>
                                <td colspan="4" class="text-end"><strong>TOTAL</strong></td>
                                <td class="text-end"><strong>Rp <?php echo e(number_format($statistik['total_pendapatan'], 0, ',', '.')); ?></strong></td>
                                <td colspan="3" class="text-center"><strong><?php echo e($statistik['total_peserta']); ?> Peserta</strong></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($pendaftar->hasPages()): ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan <?php echo e($pendaftar->firstItem() ?? 0); ?> - <?php echo e($pendaftar->lastItem() ?? 0); ?> dari <?php echo e($pendaftar->total()); ?> transaksi
                    </div>
                    <nav>
                        <?php echo e($pendaftar->appends(request()->query())->links()); ?>

                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default date range to current month
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        // Format dates to YYYY-MM-DD
        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }
        
        // Set default values if no dates are selected
        if (!document.getElementById('start_date').value) {
            document.getElementById('start_date').value = formatDate(firstDay);
        }
        if (!document.getElementById('end_date').value) {
            document.getElementById('end_date').value = formatDate(lastDay);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/keuangan/rekap-keuangan.blade.php ENDPATH**/ ?>