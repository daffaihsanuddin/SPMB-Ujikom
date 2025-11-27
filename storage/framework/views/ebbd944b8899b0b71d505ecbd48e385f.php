

<?php $__env->startSection('title', 'Data Lengkap Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Data Lengkap Pendaftar</h2>
                    <p class="text-muted mb-0">Detail informasi semua calon siswa</p>
                </div>
                <div>
                    <!-- PERBAIKAN: Gunakan route yang benar -->
                    <a href="<?php echo e(route('kepsek.export-laporan-pendaftar')); ?>" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </a>
                </div>
            </div>
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
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Gelombang</th>
                                    <th>Asal Sekolah</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Nilai Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                                        <td><?php echo e($item->user->nama); ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo e($item->jurusan->nama); ?></span>
                                        </td>
                                        <td><?php echo e($item->gelombang->nama); ?></td>
                                        <td>
                                            <?php if($item->asalSekolah): ?>
                                                <?php echo e(Str::limit($item->asalSekolah->nama_sekolah, 25)); ?>

                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
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
                                        <td class="text-center">
                                            <?php if($item->asalSekolah): ?>
                                                <strong><?php echo e($item->asalSekolah->nilai_rata); ?></strong>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($pendaftar->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pendaftar</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kepsek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/laporan/pendaftar.blade.php ENDPATH**/ ?>