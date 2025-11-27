<?php $__env->startSection('title', 'Master Data - Jurusan'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Master Data Jurusan</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                <i class="fas fa-plus me-2"></i>Tambah Jurusan
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Jurusan</th>
                                <th>Kuota</th>
                                <th>Pendaftar</th>
                                <th>Sisa Kuota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $sisaKuota = max(0, $item->kuota - $item->pendaftar_count);
                                $persentase = $item->kuota > 0 ? round(($item->pendaftar_count / $item->kuota) * 100, 2) : 0;
                            ?>
                            <tr>
                                <td><strong><?php echo e($item->kode); ?></strong></td>
                                <td><?php echo e($item->nama); ?></td>
                                <td><?php echo e($item->kuota); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($item->pendaftar_count > 0 ? 'primary' : 'secondary'); ?>">
                                        <?php echo e($item->pendaftar_count); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 <?php echo e($sisaKuota == 0 ? 'text-danger fw-bold' : ''); ?>">
                                            <?php echo e($sisaKuota); ?>

                                        </span>
                                        <?php if($item->kuota > 0): ?>
                                        <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                            <div class="progress-bar 
                                                <?php if($persentase >= 100): ?> bg-danger
                                                <?php elseif($persentase >= 80): ?> bg-warning
                                                <?php else: ?> bg-success <?php endif; ?>" 
                                                style="width: <?php echo e(min($persentase, 100)); ?>%">
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editJurusanModal"
                                            data-id="<?php echo e($item->id); ?>"
                                            data-kode="<?php echo e($item->kode); ?>"
                                            data-nama="<?php echo e($item->nama); ?>"
                                            data-kuota="<?php echo e($item->kuota); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?php echo e(route('admin.jurusan.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus jurusan <?php echo e($item->nama); ?>?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($jurusan->isEmpty()): ?>
                <div class="text-center py-4">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data jurusan</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                        <i class="fas fa-plus me-2"></i>Tambah Jurusan Pertama
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="tambahJurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.jurusan.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jurusan</label>
                        <input type="text" class="form-control" id="kode" name="kode" required maxlength="10" 
                               placeholder="Contoh: RPL, TKJ, MM">
                        <div class="form-text">Kode unik untuk jurusan (maksimal 10 karakter)</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required maxlength="100"
                               placeholder="Contoh: Rekayasa Perangkat Lunak">
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="kuota" name="kuota" required min="1"
                               placeholder="Contoh: 50">
                        <div class="form-text">Jumlah maksimal siswa yang dapat diterima</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jurusan -->
<div class="modal fade" id="editJurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editJurusanForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_kode" class="form-label">Kode Jurusan</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit_kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="edit_kuota" name="kuota" required min="1">
                        <div class="form-text">
                            <span id="currentPendaftar"></span> pendaftar pada jurusan ini
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editJurusanModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const kode = button.getAttribute('data-kode');
            const nama = button.getAttribute('data-nama');
            const kuota = button.getAttribute('data-kuota');
            const pendaftarCount = button.closest('tr').querySelector('.badge').textContent;

            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kuota').value = kuota;
            document.getElementById('currentPendaftar').textContent = pendaftarCount;

            document.getElementById('editJurusanForm').action = '/admin/jurusan/' + id;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/master/jurusan.blade.php ENDPATH**/ ?>