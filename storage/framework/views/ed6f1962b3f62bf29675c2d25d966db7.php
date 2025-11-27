

<?php $__env->startSection('title', 'Detail Berkas Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Detail Berkas Pendaftar</h2>
                <p class="text-muted">Detail lengkap data dan berkas pendaftar</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.monitoring-berkas')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?php if(!$pendaftar): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4>Data Pendaftar Tidak Ditemukan</h4>
                <p class="text-muted">Data pendaftar yang diminta tidak ditemukan.</p>
                <a href="<?php echo e(route('admin.monitoring-berkas')); ?>" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Kembali ke Daftar
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
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-id-card me-2"></i>Informasi Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>No. Pendaftaran</strong></td>
                        <td>: <span class="fw-bold text-primary"><?php echo e($pendaftar->no_pendaftaran); ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>: <?php echo e($pendaftar->user->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: <?php echo e($pendaftar->user->email); ?></td>
                    </tr>
                    <tr>
                        <td><strong>HP</strong></td>
                        <td>: <?php echo e($pendaftar->user->hp); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>: <?php echo e($pendaftar->jurusan->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td>: <?php echo e($pendaftar->gelombang->nama); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>: <?php echo e($pendaftar->tanggal_daftar->format('d/m/Y H:i')); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            : <span class="badge bg-<?php echo e(['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                                [$pendaftar->status]); ?>">
                                <?php echo e($pendaftar->status); ?>

                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Quick Actions - DIHAPUS TOMBOL VERIFIKASI ADMINISTRASI -->
                <div class="mt-4">
                    <h6 class="text-muted mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <!-- Hapus tombol verifikasi administrasi -->
                        <?php if($pendaftar->status === 'ADM_PASS' && !$pendaftar->tgl_verifikasi_payment): ?>
                        <a href="<?php echo e(route('keuangan.show-pembayaran', $pendaftar->id)); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-money-bill-wave me-2"></i>Verifikasi Pembayaran
                        </a>
                        <?php endif; ?>

                        <button class="btn btn-info btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Ringkasan Berkas
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $berkasCount = $pendaftar->berkas->count();
                    $berkasValid = $pendaftar->berkas->where('valid', true)->count();
                    $persentaseValid = $berkasCount > 0 ? ($berkasValid / $berkasCount) * 100 : 0;
                ?>
                
                <div class="text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <canvas id="berkasChart" width="120" height="120"></canvas>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <h4 class="mb-0"><?php echo e($berkasValid); ?>/<?php echo e($berkasCount); ?></h4>
                            <small class="text-muted">Valid</small>
                        </div>
                    </div>
                </div>

                <div class="progress mb-2" style="height: 10px;">
                    <div class="progress-bar <?php echo e($persentaseValid == 100 ? 'bg-success' : ($persentaseValid >= 50 ? 'bg-warning' : 'bg-danger')); ?>" 
                         style="width: <?php echo e($persentaseValid); ?>%"></div>
                </div>
                <div class="text-center">
                    <small class="text-muted"><?php echo e(number_format($persentaseValid, 1)); ?>% berkas valid</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Detail -->
    <div class="col-md-8 mb-4">
        <!-- Data Diri Siswa -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Data Diri Siswa
                </h5>
            </div>
            <div class="card-body">
                <?php if($pendaftar->dataSiswa): ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>NIK</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->nik ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->nama ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->tmp_lahir ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->tgl_lahir?->format('d/m/Y') ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Alamat</strong></td>
                                <td>: <?php echo e($pendaftar->dataSiswa->alamat ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Wilayah</strong></td>
                                <td>
                                    : 
                                    <?php if($pendaftar->dataSiswa->wilayah): ?>
                                        <?php echo e($pendaftar->dataSiswa->wilayah->kecamatan); ?>, <?php echo e($pendaftar->dataSiswa->wilayah->kelurahan); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Koordinat</strong></td>
                                <td>
                                    : 
                                    <?php if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng): ?>
                                    <?php echo e($pendaftar->dataSiswa->lat); ?>, <?php echo e($pendaftar->dataSiswa->lng); ?>

                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data diri siswa belum lengkap</span>
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
                        <h6>Ayah</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->nama_ayah ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->pekerjaan_ayah ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->hp_ayah ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Ibu</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->nama_ibu ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->pekerjaan_ibu ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->hp_ibu ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php if($pendaftar->dataOrtu->wali_nama): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Wali</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="20%"><strong>Nama</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->wali_nama); ?></td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: <?php echo e($pendaftar->dataOrtu->wali_hp ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data orang tua belum lengkap</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Asal Sekolah -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-school me-2"></i>Data Asal Sekolah
                </h5>
            </div>
            <div class="card-body">
                <?php if($pendaftar->asalSekolah): ?>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%"><strong>NPSN</strong></td>
                        <td>: <?php echo e($pendaftar->asalSekolah->npsn ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Sekolah</strong></td>
                        <td>: <?php echo e($pendaftar->asalSekolah->nama_sekolah ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Kabupaten</strong></td>
                        <td>: <?php echo e($pendaftar->asalSekolah->kabupaten ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nilai Rata-rata</strong></td>
                        <td>: <?php echo e($pendaftar->asalSekolah->nilai_rata ?? '-'); ?></td>
                    </tr>
                </table>
                <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data asal sekolah belum lengkap</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Berkas Pendaftaran -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Berkas Pendaftaran
                    </h5>
                    <span class="badge bg-<?php echo e($berkasCount > 0 ? 'primary' : 'secondary'); ?>">
                        <?php echo e($berkasCount); ?> Berkas
                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php if($berkasCount > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
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
                                    <strong>
                                        <?php
                                            $jenisBerkas = [
                                                'IJAZAH' => 'Ijazah',
                                                'RAPOR' => 'Rapor',
                                                'KIP' => 'KIP',
                                                'KKS' => 'KKS',
                                                'AKTA' => 'Akta Lahir',
                                                'KK' => 'Kartu Keluarga',
                                                'LAINNYA' => 'Lainnya'
                                            ];
                                        ?>
                                        <?php echo e($jenisBerkas[$berkas->jenis] ?? $berkas->jenis); ?>

                                    </strong>
                                </td>
                                <td>
                                    <i class="fas fa-file-<?php echo e(pathinfo($berkas->nama_file, PATHINFO_EXTENSION) == 'pdf' ? 'pdf text-danger' : 'image text-primary'); ?> me-2"></i>
                                    <?php echo e($berkas->nama_file); ?>

                                </td>
                                <td><?php echo e(number_format($berkas->ukuran_kb, 0)); ?> KB</td>
                                <td>
                                    <?php if($berkas->valid): ?>
                                    <span class="badge bg-success">Valid</span>
                                    <?php else: ?>
                                    <span class="badge bg-warning">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($berkas->catatan ?? '-'); ?></td>
                                <td><?php echo e($berkas->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(Storage::url($berkas->url)); ?>" target="_blank" 
                                           class="btn btn-outline-primary" title="Lihat Berkas">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(Storage::url($berkas->url)); ?>" download 
                                           class="btn btn-outline-success" title="Download Berkas">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Berkas</h5>
                    <p class="text-muted">Pendaftar belum mengupload berkas apapun</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Timeline Status -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Timeline Status
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Status Pendaftaran -->
                    <div class="timeline-item completed">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">Pendaftaran</h6>
                                        <p class="card-text text-muted mb-1">Formulir pendaftaran dikirim</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i><?php echo e($pendaftar->tanggal_daftar->format('d/m/Y H:i')); ?>

                                        </small>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Verifikasi Administrasi -->
                    <div class="timeline-item <?php echo e(in_array($pendaftar->status, ['ADM_PASS','ADM_REJECT','PAID']) ? 'completed' : ''); ?> <?php echo e($pendaftar->status === 'SUBMIT' ? 'active' : ''); ?>">
                        <div class="card mb-3 <?php echo e($pendaftar->status === 'SUBMIT' ? 'border-primary' : ''); ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 <?php echo e($pendaftar->status === 'SUBMIT' ? 'text-primary' : ''); ?>">
                                            Verifikasi Administrasi
                                        </h6>
                                        <p class="card-text text-muted mb-1">
                                            <?php if($pendaftar->status === 'ADM_PASS'): ?>
                                            Lulus administrasi
                                            <?php elseif($pendaftar->status === 'ADM_REJECT'): ?>
                                            Tidak lulus administrasi
                                            <?php elseif($pendaftar->status === 'SUBMIT'): ?>
                                            Menunggu verifikasi
                                            <?php else: ?>
                                            Proses verifikasi
                                            <?php endif; ?>
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php if($pendaftar->tgl_verifikasi_adm): ?>
                                                <?php echo e($pendaftar->tgl_verifikasi_adm->format('d/m/Y H:i')); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    <div>
                                        <?php if(in_array($pendaftar->status, ['ADM_PASS','ADM_REJECT','PAID'])): ?>
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        <?php elseif($pendaftar->status === 'SUBMIT'): ?>
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        <?php else: ?>
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="timeline-item <?php echo e($pendaftar->status === 'PAID' ? 'completed' : ''); ?> <?php echo e($pendaftar->status === 'ADM_PASS' ? 'active' : ''); ?>">
                        <div class="card mb-3 <?php echo e($pendaftar->status === 'ADM_PASS' ? 'border-primary' : ''); ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 <?php echo e($pendaftar->status === 'ADM_PASS' ? 'text-primary' : ''); ?>">
                                            Pembayaran
                                        </h6>
                                        <p class="card-text text-muted mb-1">
                                            <?php if($pendaftar->status === 'PAID'): ?>
                                            Pembayaran terverifikasi
                                            <?php elseif($pendaftar->status === 'ADM_PASS'): ?>
                                            Menunggu pembayaran
                                            <?php else: ?>
                                            Belum bisa pembayaran
                                            <?php endif; ?>
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php if($pendaftar->tgl_verifikasi_payment): ?>
                                                <?php echo e($pendaftar->tgl_verifikasi_payment->format('d/m/Y H:i')); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    <div>
                                        <?php if($pendaftar->status === 'PAID'): ?>
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        <?php elseif($pendaftar->status === 'ADM_PASS'): ?>
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        <?php else: ?>
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        <?php endif; ?>
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
        .btn, .card-header .badge {
            display: none !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pie chart for berkas summary
        const ctx = document.getElementById('berkasChart').getContext('2d');
        const berkasValid = <?php echo e($berkasValid); ?>;
        const berkasTotal = <?php echo e($berkasCount); ?>;
        const berkasInvalid = berkasTotal - berkasValid;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Valid', 'Tidak Valid'],
                datasets: [{
                    data: [berkasValid, berkasInvalid],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/monitoring/detail-berkas.blade.php ENDPATH**/ ?>