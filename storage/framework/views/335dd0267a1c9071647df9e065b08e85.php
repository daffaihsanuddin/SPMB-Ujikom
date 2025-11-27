<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Selamat Datang di <br>
                    <span class="text-warning">SMK BAKTI NUSANTARA 666</span>
                </h1>
                <p class="lead mb-4">
                    Membentuk generasi unggul yang siap bersaing di era digital dengan pendidikan berkualitas, 
                    fasilitas modern, dan kurikulum terdepan.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-accent btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                    <a href="<?php echo e(route('jurusan')); ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>Lihat Jurusan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold"><?php echo e($stats['total_pendaftar']); ?>+</h3>
                    <p class="text-muted mb-0">Total Pendaftar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold"><?php echo e($stats['jurusan_available']); ?>+</h3>
                    <p class="text-muted mb-0">Jurusan Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold"><?php echo e($stats['gelombang_aktif']); ?></h3>
                    <p class="text-muted mb-0">Gelombang Aktif</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jurusan Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title d-inline-block">Program Jurusan</h2>
                <p class="text-muted">Pilih jurusan yang sesuai dengan minat dan bakat Anda</p>
            </div>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = $jurusan->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-6">
                <div class="card card-hover h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-primary rounded-circle mx-auto mb-3" 
                             style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-laptop-code fa-2x text-white"></i>
                        </div>
                        <h5 class="card-title fw-bold"><?php echo e($item->nama); ?></h5>
                        <p class="card-text text-muted small">
                            Kuota: <?php echo e($item->kuota); ?> siswa
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-primary">
                                <?php echo e($item->pendaftar_count ?? 0); ?> Pendaftar
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?php echo e(route('jurusan')); ?>" class="btn btn-outline-primary">
                    Lihat Semua Jurusan <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title d-inline-block">Mengapa Memilih Kami?</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Guru Berpengalaman</h5>
                        <p class="text-muted mb-0">Didukung oleh tenaga pengajar profesional dan berpengalaman di bidangnya.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-laptop-code fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Fasilitas Modern</h5>
                        <p class="text-muted mb-0">Laboratorium komputer dan peralatan praktik yang lengkap dan terupdate.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-briefcase fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Kerjasama Industri</h5>
                        <p class="text-muted mb-0">Jaringan kerjasama dengan berbagai perusahaan untuk program magang.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-certificate fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Sertifikasi Kompetensi</h5>
                        <p class="text-muted mb-0">Lulusan mendapatkan sertifikat kompetensi yang diakui industri.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hands-helping fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Beasiswa Tersedia</h5>
                        <p class="text-muted mb-0">Program beasiswa untuk siswa berprestasi dan kurang mampu.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5>Kurikulum Terupdate</h5>
                        <p class="text-muted mb-0">Kurikulum yang selalu disesuaikan dengan kebutuhan industri terkini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary) 0%, #1e3a8a 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Siap Bergabung Dengan Kami?</h3>
                <p class="mb-0">Daftar sekarang dan raih masa depan cerah bersama SMK BAKTI NUSANTARA 666</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-accent btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/index.blade.php ENDPATH**/ ?>