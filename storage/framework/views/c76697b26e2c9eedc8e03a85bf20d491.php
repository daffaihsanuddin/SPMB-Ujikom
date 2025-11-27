

<?php $__env->startSection('title', 'Pembayaran Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Pembayaran Pendaftaran</h2>
        <p class="text-muted">Lakukan pembayaran dan upload bukti transfer</p>
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
<?php elseif($pendaftaran->status !== 'ADM_PASS'): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                <h4>Menunggu Verifikasi Administrasi</h4>
                <p class="text-muted">Anda belum lulus verifikasi administrasi. Silakan tunggu atau periksa status pendaftaran.</p>
                <a href="<?php echo e(route('pendaftar.status')); ?>" class="btn btn-primary">
                    <i class="fas fa-history me-2"></i>Lihat Status
                </a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<?php
    // Definisikan variabel buktiBayar dengan nilai default
    $buktiBayar = $pendaftaran->berkas->where('catatan', 'Bukti Pembayaran')->first();
?>

<div class="row">
    <!-- Informasi Pembayaran -->
    <div class="col-md-5 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave me-2"></i>Informasi Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-receipt fa-3x text-success mb-3"></i>
                    <h3 class="text-success">Rp <?php echo e(number_format($pendaftaran->gelombang->biaya_daftar, 0, ',', '.')); ?></h3>
                    <p class="text-muted">Biaya Pendaftaran</p>
                </div>

                <table class="table table-bordered">
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
                </table>
            </div>
        </div>

        <!-- Instruksi Pembayaran -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Instruksi Pembayaran</h5>
            </div>
            <div class="card-body">
                <ol class="ps-3">
                    <li>Transfer biaya pendaftaran ke rekening berikut:</li>
                </ol>
                
                <div class="alert alert-info">
                    <strong>Bank BCA</strong><br>
                    No. Rekening: <strong>1234-5678-9012</strong><br>
                    Atas Nama: <strong>SMK BAKTI NUSANTARA 666</strong>
                </div>

                <p class="text-muted small">
                    <strong>Catatan:</strong><br>
                    - Transfer tepat sesuai nominal<br>
                    - Simpan bukti transfer untuk diupload<br>
                    - Proses verifikasi membutuhkan waktu 1x24 jam
                </p>
            </div>
        </div>
    </div>

    <!-- Form Upload Bukti Bayar -->
    <div class="col-md-7 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <?php if($pendaftaran->status === 'PAID'): ?>
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h4 class="text-success">Pembayaran Terverifikasi</h4>
                    <p class="text-muted">Bukti pembayaran Anda sudah diverifikasi oleh pihak keuangan.</p>
                    
                    <?php if($pendaftaran->tgl_verifikasi_payment): ?>
                    <p class="text-muted">
                        Diverifikasi pada: <?php echo e($pendaftaran->tgl_verifikasi_payment->format('d/m/Y H:i')); ?>

                    </p>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('pendaftar.cetak-kartu')); ?>" class="btn btn-success mt-2">
                        <i class="fas fa-print me-2"></i>Cetak Kartu Pendaftaran
                    </a>
                </div>
                <?php elseif($buktiBayar && !$buktiBayar->valid): ?>
                <div class="text-center py-4">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h4 class="text-warning">Menunggu Verifikasi Keuangan</h4>
                    <p class="text-muted">Bukti pembayaran Anda sedang diverifikasi oleh pihak keuangan.</p>
                    
                    <?php if($buktiBayar->created_at): ?>
                    <p class="text-muted">
                        Diupload pada: <?php echo e($buktiBayar->created_at->format('d/m/Y H:i')); ?>

                    </p>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <form method="POST" action="<?php echo e(route('pendaftar.pembayaran.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label for="bukti_bayar" class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" 
                               accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="form-text">
                            Format: JPG, JPEG, PNG, PDF (Max: 2MB). Pastikan bukti transfer jelas terbaca.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Preview Bukti Bayar</label>
                        <div id="previewContainer" class="border rounded p-3 text-center" style="display: none;">
                            <img id="previewImage" class="img-fluid rounded" style="max-height: 200px;">
                            <div id="previewPdf" class="d-none">
                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                <p class="mt-2 mb-0">File PDF</p>
                            </div>
                        </div>
                        <div id="noPreview" class="border rounded p-5 text-center text-muted">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <p class="mb-0">Preview akan muncul di sini</p>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Pastikan bukti transfer yang diupload jelas dan sesuai. 
                        Pembayaran yang tidak valid akan ditolak.
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- History Upload Bukti Bayar -->
        <?php if($buktiBayar): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-history me-2"></i>History Upload</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>File</strong></td>
                        <td>
                            <i class="fas fa-<?php echo e(pathinfo($buktiBayar->nama_file, PATHINFO_EXTENSION) === 'pdf' ? 'file-pdf text-danger' : 'image text-primary'); ?> me-2"></i>
                            <?php echo e($buktiBayar->nama_file); ?>

                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Upload</strong></td>
                        <td><?php echo e($buktiBayar->created_at->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <?php if($buktiBayar->valid): ?>
                            <span class="badge bg-success">Terverifikasi</span>
                            <?php else: ?>
                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if($buktiBayar->catatan && $buktiBayar->catatan !== 'Bukti Pembayaran'): ?>
                    <tr>
                        <td><strong>Catatan</strong></td>
                        <td><?php echo e($buktiBayar->catatan); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
                
                <div class="text-center">
                    <a href="<?php echo e(Storage::url($buktiBayar->url)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-2"></i>Lihat Bukti Bayar
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buktiBayarInput = document.getElementById('bukti_bayar');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const previewPdf = document.getElementById('previewPdf');
        const noPreview = document.getElementById('noPreview');

        if (buktiBayarInput) {
            buktiBayarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    noPreview.style.display = 'none';
                    previewContainer.style.display = 'block';

                    if (file.type.startsWith('image/')) {
                        previewImage.src = URL.createObjectURL(file);
                        previewImage.classList.remove('d-none');
                        previewPdf.classList.add('d-none');
                    } else if (file.type === 'application/pdf') {
                        previewImage.classList.add('d-none');
                        previewPdf.classList.remove('d-none');
                    }
                } else {
                    previewContainer.style.display = 'none';
                    noPreview.style.display = 'block';
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/pembayaran.blade.php ENDPATH**/ ?>