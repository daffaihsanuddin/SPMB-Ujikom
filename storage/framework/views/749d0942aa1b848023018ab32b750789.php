

<?php $__env->startSection('title', 'Informasi Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>

<!-- Header Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Informasi Pendaftaran</h1>
                <p class="lead">Proses pendaftaran mudah dan transparan</p>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title d-inline-block">Alur Pendaftaran</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary text-white">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Registrasi Akun</h5>
                            <p>Buat akun dengan email dan password yang mudah diingat</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success text-white">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Isi Formulir</h5>
                            <p>Lengkapi data pribadi, orang tua, dan pilih jurusan</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-warning text-white">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Upload Berkas</h5>
                            <p>Unggah dokumen yang diperlukan (ijazah, rapor, dll)</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-info text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Verifikasi</h5>
                            <p>Tunggu proses verifikasi oleh admin</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-danger text-white">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="timeline-content">
                            <h5>Pengumuman</h5>
                            <p>Lihat hasil seleksi melalui dashboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gelombang Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title d-inline-block">Gelombang Pendaftaran</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6">
                <div class="card card-hover h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <h4 class="card-title text-primary"><?php echo e($item->nama); ?></h4>
                        <p class="text-muted mb-3">Tahun <?php echo e($item->tahun); ?></p>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar-start me-2"></i>
                                <?php echo e(\Carbon\Carbon::parse($item->tgl_mulai)->format('d M Y')); ?>

                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar-end me-2"></i>
                                <?php echo e(\Carbon\Carbon::parse($item->tgl_selesai)->format('d M Y')); ?>

                            </small>
                        </div>
                        
                        <h5 class="text-success mb-3">Rp <?php echo e(number_format($item->biaya_daftar, 0, ',', '.')); ?></h5>
                        
                        <?php if(now()->between($item->tgl_mulai, $item->tgl_selesai)): ?>
                        <span class="badge bg-success mb-3">Sedang Berlangsung</span>
                        <?php elseif(now() < $item->tgl_mulai): ?>
                        <span class="badge bg-warning mb-3">Akan Datang</span>
                        <?php else: ?>
                        <span class="badge bg-secondary mb-3">Telah Berakhir</span>
                        <?php endif; ?>
                        
                        <div class="mt-3">
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($gelombang->isEmpty()): ?>
            <div class="col-12 text-center">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada gelombang pendaftaran</h5>
                <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Jurusan Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title d-inline-block">Pilihan Jurusan</h2>
                <p class="text-muted">Pilih jurusan yang sesuai dengan minat dan bakat Anda</p>
            </div>
        </div>
        <div class="row g-4">
            <?php if(isset($jurusan) && $jurusan->count() > 0): ?>
                <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-hover h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper text-primary mb-3">
                                <i class="fas fa-laptop-code fa-2x"></i>
                            </div>
                            <h5 class="card-title"><?php echo e($item->nama); ?></h5>
                            <p class="text-muted small">Kode: <?php echo e($item->kode); ?></p>
                            <div class="mb-3">
                                <span class="badge bg-info">Kuota: <?php echo e($item->kuota); ?></span>
                            </div>
                            <p class="card-text small text-muted">
                                <?php if($item->kode == 'RPL'): ?>
                                    Rekayasa Perangkat Lunak
                                <?php elseif($item->kode == 'TKJ'): ?>
                                    Teknik Komputer Jaringan
                                <?php elseif($item->kode == 'MM'): ?>
                                    Multimedia
                                <?php elseif($item->kode == 'TKRO'): ?>
                                    Teknik Kendaraan Ringan Otomotif
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="col-12 text-center">
                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Data jurusan belum tersedia</h5>
                <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, var(--primary) 0%, #1e3a8a 100%); color: white;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h3 class="fw-bold mb-3">Siap Bergabung Dengan Kami?</h3>
                <p class="lead mb-4">Daftar sekarang dan raih masa depan cerah bersama SMK Bakti Nusantara 666</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="<?php echo e(route('faq')); ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-question-circle me-2"></i>Lihat FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
    transform: translateX(-50%);
}

.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: 50px;
    position: relative;
}

.timeline-item:nth-child(odd) {
    flex-direction: row-reverse;
}

.timeline-item:nth-child(odd) .timeline-content {
    text-align: right;
    margin-right: 30px;
    margin-left: 0;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: 30px;
}

.timeline-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 1;
}

.timeline-content {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.section-title {
    position: relative;
    padding-bottom: 15px;
    margin-bottom: 30px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, #2c5aa0, #3498db);
    border-radius: 2px;
}

.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.icon-wrapper {
    transition: transform 0.3s ease;
}

.card-hover:hover .icon-wrapper {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .timeline::before {
        left: 30px;
    }
    
    .timeline-item {
        flex-direction: row !important;
    }
    
    .timeline-content {
        margin-left: 80px !important;
        margin-right: 0 !important;
        text-align: left !important;
    }
    
    .navbar-nav .btn {
        margin-top: 10px;
        margin-left: 0 !important;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftaran.blade.php ENDPATH**/ ?>