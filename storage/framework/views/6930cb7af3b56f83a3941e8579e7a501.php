<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tabel Pendaftar</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active">Pendaftar</li>
            </ol>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Pendaftar
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NIK</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Wilayah</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>NIK</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Wilayah</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $__currentLoopData = $penda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($p->pendaftar_id); ?></td>
                                <td><?php echo e($p->nik); ?></td>
                                <td><?php echo e($p->nisn ?? '-'); ?></td>
                                <td><?php echo e($p->nama); ?></td>
                                <td><?php echo e($p->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                                <td><?php echo e($p->tmp_lahir); ?></td>
                                <td><?php echo e($p->tgl_lahir ? \Carbon\Carbon::parse($p->tgl_lahir)->format('d-m-Y') : '-'); ?></td>
                                <td><?php echo e(Str::limit($p->alamat, 50)); ?></td>
                                <td>
                                    <?php if($p->wilayah): ?>
                                        <?php echo e($p->wilayah->kelurahan); ?>, <?php echo e($p->wilayah->kecamatan); ?>, <?php echo e($p->wilayah->kabupaten); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_0): ?>
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data pendaftar</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?php echo e(asset('js/datatables-simple-demo.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/tabel_pendaftar.blade.php ENDPATH**/ ?>