

<?php $__env->startSection('title', 'Upload Berkas Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Upload Berkas Pendaftaran</h2>
        <p class="text-muted">Upload berkas-berkas yang diperlukan untuk proses seleksi</p>
        
        <!-- Alert khusus untuk status ditolak -->
        <?php if($pendaftaran->status === 'ADM_REJECT'): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Pendaftaran Anda Ditolak!</strong> 
            <?php if($pendaftaran->tgl_verifikasi_adm): ?>
                pada <?php echo e($pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i')); ?>

            <?php endif; ?>
            <?php if($pendaftaran->user_verifikasi_adm): ?>
                oleh <?php echo e($pendaftaran->user_verifikasi_adm); ?>

            <?php endif; ?>
            <br>
            <small>Silakan perbaiki data dan berkas Anda, kemudian kirim ulang untuk verifikasi.</small>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!$pendaftaran): ?>
<!-- ... kode untuk belum ada pendaftaran ... -->
<?php else: ?>
<div class="row">
    <!-- Informasi Pendaftaran -->
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
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge bg-<?php echo e(['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                                [$pendaftaran->status]); ?>">
                                <?php echo e($pendaftaran->status); ?>

                            </span>
                        </td>
                    </tr>
                    <?php if($pendaftaran->status === 'ADM_REJECT' && $pendaftaran->tgl_verifikasi_adm): ?>
                    <tr>
                        <td><strong>Tanggal Ditolak</strong></td>
                        <td><?php echo e($pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <?php if($pendaftaran->user_verifikasi_adm): ?>
                    <tr>
                        <td><strong>Oleh</strong></td>
                        <td><?php echo e($pendaftaran->user_verifikasi_adm); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php endif; ?>
                </table>

                <!-- Tombol Aksi Berdasarkan Status -->
                <?php if($canSubmit): ?>
                <!-- Tombol Kirim Pertama Kali -->
                <div class="mt-3 p-3 bg-light rounded">
                    <form method="POST" action="<?php echo e(route('pendaftar.kirim-verifikator')); ?>" id="kirimForm">
                        <?php echo csrf_field(); ?>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Kirim ke Verifikator
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2 text-center">
                            <i class="fas fa-info-circle me-1"></i>
                            Pastikan semua berkas sudah lengkap dan benar
                        </small>
                    </form>
                </div>

                <?php elseif($canResubmit): ?>
                <!-- Tombol Kirim Ulang (Status Ditolak) -->
                <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded">
                    <form method="POST" action="<?php echo e(route('pendaftar.kirim-verifikator')); ?>" id="kirimUlangForm">
                        <?php echo csrf_field(); ?>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-redo me-2"></i>Kirim Ulang ke Verifikator
                            </button>
                        </div>
                    </form>
                    <small class="text-warning d-block mt-2 text-center">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Periksa dan perbaiki data sebelum mengirim ulang
                    </small>
                </div>

                <?php elseif($isWaitingVerification): ?>
                <!-- Sedang Menunggu Verifikasi -->
                <div class="mt-3 p-3 bg-info bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-info btn-lg" disabled>
                            <i class="fas fa-clock me-2"></i>Menunggu Verifikasi
                        </button>
                    </div>
                    <small class="text-info d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Pendaftaran sedang dalam proses verifikasi
                    </small>
                </div>

                <?php elseif($isVerified): ?>
                <!-- Sudah Diverifikasi -->
                <div class="mt-3 p-3 bg-success bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check me-2"></i>Sudah Diverifikasi
                        </button>
                    </div>
                    <small class="text-success d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Pendaftaran sudah selesai diverifikasi
                    </small>
                </div>

                <?php else: ?>
                <!-- Belum Lengkap -->
                <div class="mt-3 p-3 bg-secondary bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-paper-plane me-2"></i>Kirim ke Verifikator
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Lengkapi semua berkas wajib terlebih dahulu
                    </small>
                </div>
                <?php endif; ?>

                <!-- Info Catatan Penolakan -->
                <?php if($pendaftaran->status === 'ADM_REJECT'): ?>
                    <?php
                        $berkasDitolak = $pendaftaran->berkas->where('valid', false)->whereNotNull('catatan');
                    ?>
                    <?php if($berkasDitolak->count() > 0): ?>
                    <div class="mt-3">
                        <h6 class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Catatan Perbaikan:</h6>
                        <div class="small text-muted">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $berkasDitolak; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($berkas->catatan): ?>
                                    <li><strong><?php echo e($berkasTypes[$berkas->jenis] ?? $berkas->jenis); ?>:</strong> <?php echo e($berkas->catatan); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Panduan Upload -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Panduan Upload</h5>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <ul class="ps-3 mb-0">
                        <li>Format file: PDF, JPG, JPEG, PNG</li>
                        <li>Ukuran maksimal: 2MB per file</li>
                        <li>Pastikan file jelas dan terbaca</li>
                        <li>Upload semua berkas yang diperlukan</li>
                        <li>Berkas yang sudah divalidasi tidak dapat dihapus</li>
                        <li><strong>Jika ditolak, perbaiki berkas dan kirim ulang</strong></li>
                    </ul>
                </small>
            </div>
        </div>
    </div>

    <!-- Form Upload Berkas -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upload Berkas Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('pendaftar.upload-berkas.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis" class="form-label">Jenis Berkas <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis Berkas</option>
                                <?php $__currentLoopData = $berkasTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(old('jenis') == $key ? 'selected' : ''); ?>>
                                    <?php echo e($value); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="berkas" class="form-label">File Berkas <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="berkas" name="berkas" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">
                                Format: PDF, JPG, JPEG, PNG (Max: 2MB)
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Upload Berkas
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Berkas yang Sudah Diupload -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Berkas yang Sudah Diupload</h5>
            </div>
            <div class="card-body">
                <?php if($pendaftaran->berkas->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftaran->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($berkasTypes[$berkas->jenis] ?? $berkas->jenis); ?></strong>
                                    <?php if($berkas->catatan): ?>
                                    <br><small class="text-muted"><?php echo e($berkas->catatan); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fas fa-file-<?php echo e(in_array(pathinfo($berkas->nama_file, PATHINFO_EXTENSION), ['pdf']) ? 'pdf' : 'image'); ?> me-2"></i>
                                    <?php echo e(Str::limit($berkas->nama_file, 30)); ?>

                                </td>
                                <td><?php echo e(number_format($berkas->ukuran_kb, 0)); ?> KB</td>
                                <td>
                                    <?php if($berkas->valid): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Valid
                                    </span>
                                    <?php else: ?>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($berkas->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(Storage::url($berkas->url)); ?>" target="_blank" 
                                           class="btn btn-outline-primary" title="Lihat Berkas">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if(!$berkas->valid): ?>
                                        <form action="<?php echo e(route('pendaftar.upload-berkas.destroy', $berkas->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('Hapus berkas <?php echo e($berkasTypes[$berkas->jenis] ?? $berkas->jenis); ?>?')" 
                                                    title="Hapus Berkas">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <?php else: ?>
                                        <button class="btn btn-outline-secondary" disabled title="Berkas sudah divalidasi">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada berkas yang diupload</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Progress Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Progress Kelengkapan Berkas</h5>
            </div>
            <div class="card-body">
                <?php
                    $requiredTypes = ['IJAZAH', 'RAPOR', 'KK', 'AKTA'];
                    $uploadedTypes = $pendaftaran->berkas->pluck('jenis')->toArray();
                    $completed = array_intersect($requiredTypes, $uploadedTypes);
                    $progress = count($requiredTypes) > 0 ? (count($completed) / count($requiredTypes)) * 100 : 0;
                ?>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Kelengkapan Berkas Wajib</span>
                        <span><?php echo e(count($completed)); ?>/<?php echo e(count($requiredTypes)); ?></span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar <?php echo e($progress == 100 ? 'bg-success' : 'bg-warning'); ?>" 
                             style="width: <?php echo e($progress); ?>%"></div>
                    </div>
                </div>

                <div class="row">
                    <?php $__currentLoopData = $requiredTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-2">
                        <div class="d-flex align-items-center">
                            <?php if(in_array($type, $uploadedTypes)): ?>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-success"><?php echo e($berkasTypes[$type] ?? $type); ?></span>
                            <?php else: ?>
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <span class="text-danger"><?php echo e($berkasTypes[$type] ?? $type); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($progress == 100): ?>
                    <?php if($pendaftaran->status === 'ADM_REJECT'): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Berkas sudah lengkap!</strong> 
                        Silakan periksa catatan perbaikan dan klik <strong>"Kirim Ulang ke Verifikator"</strong>.
                    </div>
                    <?php elseif($pendaftaran->status === 'SUBMIT'): ?>
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Selamat!</strong> Semua berkas wajib sudah diupload. 
                        Klik tombol <strong>"Kirim ke Verifikator"</strong> untuk melanjutkan proses.
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Berkas lengkap!</strong> 
                        Pendaftaran Anda sedang dalam proses verifikasi.
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Pastikan semua berkas wajib sudah diupload sebelum mengirim ke verifikator.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... kode JavaScript sebelumnya ...

        // SweetAlert untuk konfirmasi kirim ulang (status ditolak)
        const kirimUlangForm = document.getElementById('kirimUlangForm');
        if (kirimUlangForm) {
            kirimUlangForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Kirim Ulang ke Verifikator?',
                    html: `
                        <div class="text-start">
                            <p>Anda akan mengirim ulang pendaftaran ke verifikator dengan detail:</p>
                            <ul>
                                <li><strong>No. Pendaftaran:</strong> <?php echo e($pendaftaran->no_pendaftaran); ?></li>
                                <li><strong>Nama:</strong> <?php echo e($pendaftaran->dataSiswa->nama ?? '-'); ?></li>
                                <li><strong>Jurusan:</strong> <?php echo e($pendaftaran->jurusan->nama); ?></li>
                            </ul>
                            <p class="text-warning"><strong>Pastikan Anda sudah:</strong></p>
                            <ul class="text-warning">
                                <li>Memperbaiki data formulir jika diperlukan</li>
                                <li>Memperbaiki berkas berdasarkan catatan</li>
                                <li>Memastikan semua berkas sudah benar</li>
                            </ul>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Kirim Ulang!',
                    cancelButtonText: 'Batal',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        kirimUlangForm.submit();
                    }
                });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/upload-berkas.blade.php ENDPATH**/ ?>