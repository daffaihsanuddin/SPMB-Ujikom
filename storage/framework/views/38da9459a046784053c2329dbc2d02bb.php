

<?php $__env->startSection('title', 'Verifikasi Pembayaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Verifikasi Pembayaran</h2>
                <p class="text-muted">Daftar pembayaran yang menunggu verifikasi</p>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-warning fs-6 p-2">
                    <i class="fas fa-clock me-1"></i><?php echo e($pendaftar->total()); ?> Menunggu
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th>Biaya</th>
                                <th>Lulus Admin</th>
                                <th>Bukti Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                                <td><?php echo e($item->user->nama); ?></td>
                                <td><?php echo e($item->jurusan->nama); ?></td>
                                <td><?php echo e($item->gelombang->nama); ?></td>
                                <td>Rp <?php echo e(number_format($item->gelombang->biaya_daftar, 0, ',', '.')); ?></td>
                                <td><?php echo e($item->tgl_verifikasi_adm?->format('d/m/Y') ?? '-'); ?></td>
                                <td>
                                    <?php
                                        $buktiBayar = $item->berkas->where('catatan', 'Bukti Pembayaran')->first();
                                    ?>
                                    <?php if($buktiBayar): ?>
                                    <span class="badge bg-success">Ada</span>
                                    <?php else: ?>
                                    <span class="badge bg-danger">Tidak Ada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('keuangan.show-pembayaran', $item->id)); ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-clipboard-check me-1"></i>Verifikasi
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-success">Tidak Ada Pembayaran Menunggu</h5>
                                    <p class="text-muted">Semua pembayaran sudah diverifikasi</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($pendaftar->hasPages()): ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan <?php echo e($pendaftar->firstItem() ?? 0); ?> - <?php echo e($pendaftar->lastItem() ?? 0); ?> dari <?php echo e($pendaftar->total()); ?> data
                    </div>
                    <nav>
                        <?php echo e($pendaftar->links()); ?>

                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/keuangan/verifikasi-pembayaran.blade.php ENDPATH**/ ?>