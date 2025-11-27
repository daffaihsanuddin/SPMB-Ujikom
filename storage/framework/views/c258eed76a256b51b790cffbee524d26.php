

<?php $__env->startSection('title', 'Status Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Status Pendaftaran</h2>
        <p class="text-muted">Pantau progress pendaftaran Anda</p>
    </div>
</div>

<?php if(!$pendaftaran): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4>Belum Ada Data Pendaftaran</h4>
                <p class="text-muted">Silakan isi formulir pendaftaran terlebih dahulu.</p>
                <a href="<?php echo e(route('pendaftar.formulir')); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Isi Formulir Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row">
    <!-- Informasi Utama -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td><?php echo e($pendaftaran->no_pendaftaran); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><?php echo e($pendaftaran->dataSiswa->nama ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td><?php echo e($pendaftaran->jurusan->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td><?php echo e($pendaftaran->gelombang->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td><?php echo e($pendaftaran->tanggal_daftar->format('d/m/Y H:i')); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Status Saat Ini -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Saat Ini</h5>
            </div>
            <div class="card-body text-center">
                <?php
                    $statusConfig = [
                        'SUBMIT' => ['color' => 'warning', 'icon' => 'clock', 'message' => 'Menunggu verifikasi administrasi'],
                        'ADM_PASS' => ['color' => 'success', 'icon' => 'check-circle', 'message' => 'Lulus administrasi, silakan lanjutkan pembayaran'],
                        'ADM_REJECT' => ['color' => 'danger', 'icon' => 'times-circle', 'message' => 'Tidak lulus administrasi'],
                        'PAID' => ['color' => 'info', 'icon' => 'money-bill-wave', 'message' => 'Pembayaran terverifikasi']
                    ];
                    $config = $statusConfig[$pendaftaran->status] ?? ['color' => 'secondary', 'icon' => 'question-circle', 'message' => 'Status tidak diketahui'];
                ?>
                
                <div class="mb-3">
                    <i class="fas fa-<?php echo e($config['icon']); ?> fa-3x text-<?php echo e($config['color']); ?> mb-3"></i>
                    <h4 class="text-<?php echo e($config['color']); ?>">
                        <?php echo e($pendaftaran->status); ?>

                    </h4>
                </div>
                <p class="text-muted"><?php echo e($config['message']); ?></p>

                <?php if($pendaftaran->status === 'ADM_PASS'): ?>
                <a href="<?php echo e(route('pendaftar.pembayaran')); ?>" class="btn btn-success mt-2">
                    <i class="fas fa-money-bill-wave me-2"></i>Lanjutkan Pembayaran
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Timeline Progress -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Timeline Progress</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="timeline-item <?php echo e($item['completed'] ? 'completed' : ''); ?> <?php echo e($item['active'] ? 'active' : ''); ?>">
                        <div class="card mb-3 <?php echo e($item['active'] ? 'border-primary' : ''); ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 <?php echo e($item['active'] ? 'text-primary' : ''); ?>">
                                            <?php echo e($item['status']); ?>

                                        </h6>
                                        <p class="card-text text-muted mb-1"><?php echo e($item['description']); ?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i><?php echo e($item['date']); ?>

                                        </small>
                                    </div>
                                    <div>
                                        <?php if($item['completed']): ?>
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        <?php elseif($item['active']): ?>
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        <?php else: ?>
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Detail Verifikasi -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Verifikasi Administrasi</h6>
                        <?php if($pendaftaran->tgl_verifikasi_adm): ?>
                        <table class="table table-sm">
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class="badge bg-<?php echo e($pendaftaran->status === 'ADM_PASS' ? 'success' : 'danger'); ?>">
                                        <?php echo e($pendaftaran->status === 'ADM_PASS' ? 'Lulus' : 'Tidak Lulus'); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><?php echo e($pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <tr>
                                <td>Verifikator</td>
                                <td><?php echo e($pendaftaran->user_verifikasi_adm ?? '-'); ?></td>
                            </tr>
                        </table>
                        <?php else: ?>
                        <p class="text-muted">Menunggu verifikasi administrasi</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Verifikasi Pembayaran</h6>
                        <?php if($pendaftaran->tgl_verifikasi_payment): ?>
                        <table class="table table-sm">
                            <tr>
                                <td>Status</td>
                                <td><span class="badge bg-success">Terverifikasi</span></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><?php echo e($pendaftaran->tgl_verifikasi_payment->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <tr>
                                <td>Verifikator</td>
                                <td><?php echo e($pendaftaran->user_verifikasi_payment ?? '-'); ?></td>
                            </tr>
                        </table>
                        <?php else: ?>
                        <p class="text-muted">
                            <?php if($pendaftaran->status === 'ADM_PASS'): ?>
                            Silakan lakukan pembayaran dan upload bukti
                            <?php else: ?>
                            Menunggu verifikasi pembayaran
                            <?php endif; ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Berkas</h5>
            </div>
            <div class="card-body">
                <?php if($pendaftaran->berkas->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftaran->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($berkasTypes[$berkas->jenis] ?? $berkas->jenis); ?></td>
                                <td>
                                    <?php if($berkas->valid): ?>
                                    <span class="badge bg-success">Valid</span>
                                    <?php else: ?>
                                    <span class="badge bg-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($berkas->catatan ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">Belum ada berkas yang diupload</p>
                <?php endif; ?>
                
                <div class="mt-3">
                    <a href="<?php echo e(route('pendaftar.upload-berkas')); ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file-upload me-2"></i>Kelola Berkas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/status.blade.php ENDPATH**/ ?>