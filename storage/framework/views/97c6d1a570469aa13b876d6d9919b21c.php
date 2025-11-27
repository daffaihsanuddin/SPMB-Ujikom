

<?php $__env->startSection('title', 'Monitoring Berkas Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Monitoring Berkas Pendaftar</h2>
        <p class="text-muted">Kelola dan pantau kelengkapan berkas pendaftar</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Pendaftar</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                                <td><?php echo e($item->user->nama); ?></td>
                                <td><?php echo e($item->jurusan->nama); ?></td>
                                <td><?php echo e($item->gelombang->nama); ?></td>
                                <td><?php echo e($item->tanggal_daftar->format('d/m/Y')); ?></td>
                                <td>
                                    <?php
                                        $statusClass = [
                                            'SUBMIT' => 'warning',
                                            'ADM_PASS' => 'success',
                                            'ADM_REJECT' => 'danger',
                                            'PAID' => 'info'
                                        ][$item->status];
                                    ?>
                                    <span class="badge bg-<?php echo e($statusClass); ?>">
                                        <?php echo e($item->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php
                                        $berkasCount = $item->berkas->count();
                                        $berkasValid = $item->berkas->where('valid', true)->count();
                                    ?>
                                    <small>
                                        <?php echo e($berkasValid); ?>/<?php echo e($berkasCount); ?> Valid
                                    </small>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.detail-berkas', $item->id)); ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/monitoring/berkas.blade.php ENDPATH**/ ?>