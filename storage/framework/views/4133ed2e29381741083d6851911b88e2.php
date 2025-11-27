

<?php $__env->startSection('title', 'Edit Verifikasi'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Edit Verifikasi</h2>
                <p class="text-muted">Perbarui data verifikasi pendaftar</p>
            </div>
            <div>
                <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo e(route('verifikator.update', $pendaftar->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Informasi Pendaftaran -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>No. Pendaftaran</strong></td>
                                    <td><?php echo e($pendaftar->no_pendaftaran); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->nama ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIK</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->nik ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jurusan</strong></td>
                                    <td><?php echo e($pendaftar->jurusan->nama); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td width="40%"><strong>Gelombang</strong></td>
                                    <td><?php echo e($pendaftar->gelombang->nama); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Daftar</strong></td>
                                    <td><?php echo e($pendaftar->tanggal_daftar->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Sebelumnya</strong></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($pendaftar->status === 'ADM_PASS' ? 'success' : 'danger'); ?>">
                                            <?php echo e($pendaftar->status === 'ADM_PASS' ? 'LULUS' : 'TOLAK'); ?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Verifikator</strong></td>
                                    <td><?php echo e($pendaftar->user_verifikasi_adm ?? '-'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Verifikasi -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Status Verifikasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="ADM_PASS" <?php echo e(old('status', $pendaftar->status) == 'ADM_PASS' ? 'selected' : ''); ?>>LULUS</option>
                                <option value="ADM_REJECT" <?php echo e(old('status', $pendaftar->status) == 'ADM_REJECT' ? 'selected' : ''); ?>>TOLAK</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="catatan" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="catatan" name="catatan" rows="3" 
                                      placeholder="Berikan catatan jika diperlukan..."><?php echo e(old('catatan')); ?></textarea>
                            <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verifikasi Berkas -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-check me-2"></i>Verifikasi Berkas
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($pendaftar->berkas->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jenis Berkas</th>
                                    <th>Nama File</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendaftar->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($berkasTypes[$berkas->jenis] ?? $berkas->jenis); ?></strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-file-<?php echo e(in_array(pathinfo($berkas->nama_file, PATHINFO_EXTENSION), ['pdf']) ? 'pdf' : 'image'); ?> me-2"></i>
                                        <?php echo e($berkas->nama_file); ?>

                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="berkas[<?php echo e($berkas->id); ?>][valid]" value="1"
                                                   id="berkas_<?php echo e($berkas->id); ?>"
                                                   <?php echo e($berkas->valid ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="berkas_<?php echo e($berkas->id); ?>">
                                                <?php echo e($berkas->valid ? 'Valid' : 'Tidak Valid'); ?>

                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" 
                                               name="berkas[<?php echo e($berkas->id); ?>][catatan]"
                                               value="<?php echo e($berkas->catatan ?? ''); ?>"
                                               placeholder="Catatan...">
                                    </td>
                                    <td>
                                        <a href="<?php echo e(Storage::url($berkas->url)); ?>" target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada berkas yang diupload</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pendaftar (Readonly) -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Data Calon Siswa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <td width="40%"><strong>Nama Lengkap</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->nama ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIK</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->nik ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>TTL</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->tmp_lahir ?? '-'); ?>, <?php echo e($pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <td width="40%"><strong>Asal Sekolah</strong></td>
                                    <td><?php echo e($pendaftar->asalSekolah->nama_sekolah ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NPSN</strong></td>
                                    <td><?php echo e($pendaftar->asalSekolah->npsn ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nilai Rata-rata</strong></td>
                                    <td><?php echo e($pendaftar->asalSekolah->nilai_rata ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?php echo e($pendaftar->dataSiswa->alamat ?? '-'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-warning me-2">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle status berkas
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="berkas"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.parentElement.querySelector('.form-check-label');
                label.textContent = this.checked ? 'Valid' : 'Tidak Valid';
            });
        });

        // Validasi form
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const status = document.getElementById('status').value;
            if (!status) {
                e.preventDefault();
                alert('Silakan pilih status verifikasi.');
                document.getElementById('status').focus();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.verifikator', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/verifikator/edit.blade.php ENDPATH**/ ?>