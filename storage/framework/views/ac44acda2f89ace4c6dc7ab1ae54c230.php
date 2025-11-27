

<?php $__env->startSection('title', 'Edit Formulir Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Edit Formulir Pendaftaran</h2>
            <a href="<?php echo e(route('pendaftar.upload-berkas')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Anda sedang mengedit formulir karena pendaftaran sebelumnya ditolak. 
            Pastikan semua data sudah benar sebelum disimpan.
        </div>
    </div>
</div>

<form method="POST" action="<?php echo e(route('pendaftar.update-formulir')); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Data Pribadi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nik" name="nik" 
                           value="<?php echo e(old('nik', $pendaftaran->dataSiswa->nik)); ?>" required maxlength="20">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama" 
                           value="<?php echo e(old('nama', $pendaftaran->dataSiswa->nama)); ?>" required maxlength="120">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?php echo e(old('jk', $pendaftaran->dataSiswa->jk) == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                        <option value="P" <?php echo e(old('jk', $pendaftaran->dataSiswa->jk) == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" 
                           value="<?php echo e(old('tmp_lahir', $pendaftaran->dataSiswa->tmp_lahir)); ?>" required maxlength="60">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" 
                           value="<?php echo e(old('tgl_lahir', $pendaftaran->dataSiswa->tgl_lahir?->format('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="wilayah_id" class="form-label">Wilayah Domisili <span class="text-danger">*</span></label>
                    <select class="form-select" id="wilayah_id" name="wilayah_id" required>
                        <option value="">Pilih Wilayah</option>
                        <?php $__currentLoopData = $wilayah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($wil->id); ?>" <?php echo e(old('wilayah_id', $pendaftaran->dataSiswa->wilayah_id) == $wil->id ? 'selected' : ''); ?>>
                            <?php echo e($wil->kecamatan); ?> - <?php echo e($wil->kelurahan); ?> (<?php echo e($wil->kabupaten); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo e(old('alamat', $pendaftaran->dataSiswa->alamat)); ?></textarea>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_ayah" class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" 
                           value="<?php echo e(old('nama_ayah', $pendaftaran->dataOrtu->nama_ayah)); ?>" required maxlength="120">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" 
                           value="<?php echo e(old('pekerjaan_ayah', $pendaftaran->dataOrtu->pekerjaan_ayah)); ?>" required maxlength="100">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="hp_ayah" class="form-label">No. HP Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="hp_ayah" name="hp_ayah" 
                           value="<?php echo e(old('hp_ayah', $pendaftaran->dataOrtu->hp_ayah)); ?>" required maxlength="20">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" 
                           value="<?php echo e(old('nama_ibu', $pendaftaran->dataOrtu->nama_ibu)); ?>" required maxlength="120">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" 
                           value="<?php echo e(old('pekerjaan_ibu', $pendaftaran->dataOrtu->pekerjaan_ibu)); ?>" required maxlength="100">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="hp_ibu" class="form-label">No. HP Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="hp_ibu" name="hp_ibu" 
                           value="<?php echo e(old('hp_ibu', $pendaftaran->dataOrtu->hp_ibu)); ?>" required maxlength="20">
                </div>
            </div>
        </div>
    </div>

    <!-- Asal Sekolah -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-school me-2"></i>Data Asal Sekolah</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="npsn" class="form-label">NPSN <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="npsn" name="npsn" 
                           value="<?php echo e(old('npsn', $pendaftaran->asalSekolah->npsn)); ?>" required maxlength="20">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" 
                           value="<?php echo e(old('nama_sekolah', $pendaftaran->asalSekolah->nama_sekolah)); ?>" required maxlength="150">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kabupaten" class="form-label">Kabupaten <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" 
                           value="<?php echo e(old('kabupaten', $pendaftaran->asalSekolah->kabupaten)); ?>" required maxlength="100">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nilai_rata" class="form-label">Nilai Rata-rata <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="nilai_rata" name="nilai_rata" 
                           value="<?php echo e(old('nilai_rata', $pendaftaran->asalSekolah->nilai_rata)); ?>" 
                           step="0.01" min="0" max="100" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilihan Jurusan dan Gelombang -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-list me-2"></i>Pilihan Pendaftaran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jurusan_id" class="form-label">Pilihan Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select" id="jurusan_id" name="jurusan_id" required>
                        <option value="">Pilih Jurusan</option>
                        <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($jur->id); ?>" <?php echo e(old('jurusan_id', $pendaftaran->jurusan_id) == $jur->id ? 'selected' : ''); ?>>
                            <?php echo e($jur->nama); ?> (Kuota: <?php echo e($jur->kuota); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gelombang_id" class="form-label">Gelombang <span class="text-danger">*</span></label>
                    <select class="form-select" id="gelombang_id" name="gelombang_id" required>
                        <option value="">Pilih Gelombang</option>
                        <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($gel->id); ?>" <?php echo e(old('gelombang_id', $pendaftaran->gelombang_id) == $gel->id ? 'selected' : ''); ?>>
                            <?php echo e($gel->nama); ?> (<?php echo e($gel->tgl_mulai->format('d/m/Y')); ?> - <?php echo e($gel->tgl_selesai->format('d/m/Y')); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo e(route('pendaftar.upload-berkas')); ?>" class="btn btn-secondary me-md-2">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/edit-formulir.blade.php ENDPATH**/ ?>