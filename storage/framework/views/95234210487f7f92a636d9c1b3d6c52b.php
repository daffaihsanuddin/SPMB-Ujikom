

<?php $__env->startSection('title', 'Detail Riwayat Verifikasi'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Detail Riwayat Verifikasi</h2>
            </div>
            <div>
                <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Informasi Utama -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td><?php echo e($pendaftar->no_pendaftaran); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td><?php echo e($pendaftar->tanggal_daftar->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>
                            <span class="badge bg-primary"><?php echo e($pendaftar->jurusan->nama); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td><?php echo e($pendaftar->gelombang->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <?php
                                $statusClass = [
                                    'SUBMIT' => 'warning',
                                    'ADM_PASS' => 'success',
                                    'ADM_REJECT' => 'danger',
                                    'PAID' => 'info'
                                ][$pendaftar->status];
                            ?>
                            <span class="badge bg-<?php echo e($statusClass); ?>">
                                <?php echo e($pendaftar->status); ?>

                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Verifikasi -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-check me-2"></i>Informasi Verifikasi
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Verifikator</strong></td>
                        <td><?php echo e($pendaftar->user_verifikasi_adm ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Verifikasi</strong></td>
                        <td>
                            <?php if($pendaftar->tgl_verifikasi_adm): ?>
                                <?php echo e($pendaftar->tgl_verifikasi_adm->format('d/m/Y H:i')); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Akhir</strong></td>
                        <td>
                            <?php if($pendaftar->status === 'ADM_PASS'): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>LULUS
                                </span>
                            <?php elseif($pendaftar->status === 'ADM_REJECT'): ?>
                                <span class="badge bg-danger">
                                    <i class="fas fa-times me-1"></i>TIDAK LULUS
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Ringkasan Berkas -->
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>Ringkasan Berkas
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $totalBerkas = $pendaftar->berkas->count();
                    $berkasValid = $pendaftar->berkas->where('valid', true)->count();
                    $persentaseValid = $totalBerkas > 0 ? round(($berkasValid / $totalBerkas) * 100, 2) : 0;
                ?>
                
                <div class="text-center mb-3">
                    <div class="display-6 fw-bold text-<?php echo e($persentaseValid == 100 ? 'success' : 'warning'); ?>">
                        <?php echo e($persentaseValid); ?>%
                    </div>
                    <small class="text-muted">Validitas Berkas</small>
                </div>
                
                <div class="d-flex justify-content-between">
                    <span>Total Berkas:</span>
                    <strong><?php echo e($totalBerkas); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Berkas Valid:</span>
                    <strong class="text-success"><?php echo e($berkasValid); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Berkas Invalid:</span>
                    <strong class="text-danger"><?php echo e($totalBerkas - $berkasValid); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Detail -->
    <div class="col-lg-8 mb-4">
        <!-- Data Calon Siswa -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate me-2"></i>Data Calon Siswa
                </h5>
            </div>
            <div class="card-body">
                <?php if($pendaftar->dataSiswa): ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama Lengkap</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->nama); ?></td>
                            </tr>
                            <tr>
                                <td><strong>NIK</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->nik); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->tmp_lahir); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->tgl_lahir->format('d/m/Y')); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Alamat</strong></td>
                                <td><?php echo e($pendaftar->dataSiswa->alamat); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Koordinat</strong></td>
                                <td>
                                    <?php if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng): ?>
                                        <?php echo e($pendaftar->dataSiswa->lat); ?>, <?php echo e($pendaftar->dataSiswa->lng); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data siswa tidak tersedia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Data Orang Tua/Wali
                </h5>
            </div>
            <div class="card-body">
                <?php if($pendaftar->dataOrtu): ?>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Ayah</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->nama_ayah); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->pekerjaan_ayah); ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->hp_ayah); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Ibu</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->nama_ibu); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->pekerjaan_ibu); ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->hp_ibu); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php if($pendaftar->dataOrtu->wali_nama): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2">Wali</h6>
                        <table class="table table-sm">
                            <tr>
                                <td width="20%"><strong>Nama Wali</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->wali_nama); ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. HP Wali</strong></td>
                                <td><?php echo e($pendaftar->dataOrtu->wali_hp); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data orang tua tidak tersedia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Asal Sekolah -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-school me-2"></i>Asal Sekolah
                </h5>
            </div>
            <div class="card-body">
                <?php if($pendaftar->asalSekolah): ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>NPSN</strong></td>
                                <td><?php echo e($pendaftar->asalSekolah->npsn); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Sekolah</strong></td>
                                <td><?php echo e($pendaftar->asalSekolah->nama_sekolah); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td width="40%"><strong>Kabupaten</strong></td>
                                <td><?php echo e($pendaftar->asalSekolah->kabupaten); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nilai Rata-rata</strong></td>
                                <td>
                                    <span class="badge bg-primary fs-6">
                                        <?php echo e($pendaftar->asalSekolah->nilai_rata); ?>

                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-3">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Data asal sekolah tidak tersedia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Berkas Pendaftaran -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-upload me-2"></i>Berkas Pendaftaran
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
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftar->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($berkas->jenis); ?></strong>
                                </td>
                                <td>
                                    <i class="fas fa-file-<?php echo e(in_array(pathinfo($berkas->nama_file, PATHINFO_EXTENSION), ['pdf']) ? 'pdf text-danger' : 'image text-primary'); ?> me-2"></i>
                                    <?php echo e(Str::limit($berkas->nama_file, 25)); ?>

                                </td>
                                <td>
                                    <?php if($berkas->valid): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Valid
                                    </span>
                                    <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Invalid
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($berkas->catatan): ?>
                                    <small class="text-muted"><?php echo e($berkas->catatan); ?></small>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($berkas->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(Storage::url($berkas->url)); ?>" target="_blank" 
                                       class="btn btn-sm btn-outline-primary" title="Lihat Berkas">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                    <p>Belum ada berkas yang diupload</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Verifikasi -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745 !important;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #6c757d;
    z-index: 2;
}

.timeline-content {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -21px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.verifikator', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/verifikator/detail-riwayat.blade.php ENDPATH**/ ?>