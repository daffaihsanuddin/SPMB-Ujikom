

<?php $__env->startSection('title', 'Cetak Kartu Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <h2>Cetak Kartu Pendaftaran</h2>
        <p class="text-muted">Cetak kartu pendaftaran untuk keperluan administrasi</p>
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
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Kartu Pendaftaran</h5>
                    <div>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak Kartu
                        </button>
                        <a href="<?php echo e(route('pendaftar.dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Kartu Pendaftaran -->
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-primary" id="kartuPendaftaran">
                            <div class="card-header bg-primary text-white text-center">
                                <h4 class="mb-0">KARTU PENDAFTARAN SPMB</h4>
                                <p class="mb-0"><?php echo e($sekolahInfo['nama']); ?></p>
                                <p class="mb-0">TAHUN AJARAN <?php echo e($tahunAjaran); ?></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-3">
                                        <div class="border rounded p-2 bg-light">
                                            <small class="text-muted">Foto</small>
                                            <div class="mt-2" style="height: 120px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user fa-2x text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td width="40%"><strong>No. Pendaftaran</strong></td>
                                                <td>: <?php echo e($pendaftaran->no_pendaftaran); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Lengkap</strong></td>
                                                <td>: <?php echo e($pendaftaran->dataSiswa->nama ?? '-'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK</strong></td>
                                                <td>: <?php echo e($pendaftaran->dataSiswa->nik ?? '-'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>TTL</strong></td>
                                                <td>: <?php echo e($pendaftaran->dataSiswa->tmp_lahir ?? '-'); ?>, <?php echo e($pendaftaran->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftaran->dataSiswa->tgl_lahir)->format('d/m/Y') : '-'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jurusan</strong></td>
                                                <td>: <?php echo e($pendaftaran->jurusan->nama); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gelombang</strong></td>
                                                <td>: <?php echo e($pendaftaran->gelombang->nama); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tahun Gelombang</strong></td>
                                                <td>: <?php echo e($pendaftaran->gelombang->tahun); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Asal Sekolah</strong></td>
                                                <td>: <?php echo e($pendaftaran->asalSekolah->nama_sekolah ?? '-'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td><strong>Nama Ayah</strong></td>
                                                <td>: <?php echo e($pendaftaran->dataOrtu->nama_ayah ?? '-'); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Ibu</strong></td>
                                                <td>: <?php echo e($pendaftaran->dataOrtu->nama_ibu ?? '-'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>
                                                    : <span class="badge bg-<?php echo e(['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                                                        [$pendaftaran->status]); ?>">
                                                        <?php echo e($pendaftaran->status); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Daftar</strong></td>
                                                <td>: <?php echo e($pendaftaran->tanggal_daftar->format('d/m/Y')); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- QR Code Placeholder -->
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <div class="border rounded p-2 d-inline-block">
                                            <small class="text-muted">QR Code</small>
                                            <div class="mt-1" style="width: 100px; height: 100px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-qrcode fa-2x text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <small class="text-muted">
                                    Kartu ini berlaku untuk mengikuti seleksi SPMB <?php echo e($sekolahInfo['nama']); ?> Tahun
                                    <?php echo e($pendaftaran->gelombang->tahun); ?>

                                </small>
                                <br>
                                <small class="text-muted">
                                    <?php echo e($sekolahInfo['alamat']); ?>

                                    <br>
                                    Telp: <?php echo e($sekolahInfo['telp']); ?>

                                    </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Informasi Penting</h6>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>Bawa kartu ini saat tes seleksi</li>
                                    <li>Simpan kartu dengan baik</li>
                                    <li>Kartu ini sebagai bukti telah mendaftar</li>
                                    <li>Lapor jika kartu hilang</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Status Berkas</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                    $berkasCount = $pendaftaran->berkas->count();
                                    $berkasValid = $pendaftaran->berkas->where('valid', true)->count();
                                ?>
                                <div class="mb-2">
                                    <strong>Berkas Terupload:</strong> <?php echo e($berkasCount); ?> file
                                </div>
                                <div class="mb-2">
                                    <strong>Berkas Valid:</strong> <?php echo e($berkasValid); ?> file
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar <?php echo e($berkasCount > 0 ? 'bg-success' : 'bg-warning'); ?>" 
                                         style="width: <?php echo e($berkasCount > 0 ? ($berkasValid / $berkasCount) * 100 : 0); ?>%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #kartuPendaftaran, #kartuPendaftaran * {
            visibility: visible;
        }
        #kartuPendaftaran {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: 2px solid #000 !important;
        }
        .btn, .card-header:first-child, .row.mt-4 {
            display: none !important;
        }
        .card-header.bg-primary {
            background: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
        }
        .card-footer.bg-light {
            background: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
    }
    
    #kartuPendaftaran {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border: 2px solid #007bff;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/cetak-kartu.blade.php ENDPATH**/ ?>