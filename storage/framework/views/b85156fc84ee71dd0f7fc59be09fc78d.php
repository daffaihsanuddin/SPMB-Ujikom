<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - SMK BAKTI NUSANTARA 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c5aa0;
            --secondary: #f8f9fa;
            --accent: #ff6b35;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-image: url('<?php echo e(asset("images/BN.jpg")); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* Overlay untuk meningkatkan keterbacaan teks */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
        }
        
        .hero-section {
            background: rgba(44, 90, 160, 0.9); /* Semi-transparent overlay */
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo e(asset("images/BN.jpg")); ?>');
            background-size: cover;
            background-position: center;
            z-index: -1;
            opacity: 0.3;
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
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--accent);
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            padding: 12px 30px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background: #1e3a8a;
            border-color: #1e3a8a;
        }
        
        .btn-accent {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
            padding: 12px 30px;
            font-weight: 500;
        }
        
        .btn-accent:hover {
            background: #e55a2b;
            border-color: #e55a2b;
            color: white;
        }
        
        .footer {
            background: rgba(44, 62, 80, 0.95);
            color: white;
            backdrop-filter: blur(10px);
        }

        /* Improved card backgrounds with transparency */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* Navbar with transparency */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        /* Section backgrounds with light transparency */
        section {
            position: relative;
        }

        section.bg-light {
            background: rgba(248, 249, 250, 0.9) !important;
        }

        /* CTA sections with overlay */
        section[style*="background: linear-gradient"] {
            position: relative;
        }

        section[style*="background: linear-gradient"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo e(asset("images/BN.jpg")); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            z-index: 0;
        }

        section[style*="background: linear-gradient"] > .container {
            position: relative;
            z-index: 1;
        }

        /* Header sections with background image */
        .bg-primary.text-white {
            position: relative;
            overflow: hidden;
        }

        .bg-primary.text-white::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo e(asset("images/BN.jpg")); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            z-index: 0;
        }

        .bg-primary.text-white > .container {
            position: relative;
            z-index: 1;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('index')); ?>">
                <i class="fas fa-school me-2"></i>
                SMK BAKTI NUSANTARA 666
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('index') ? 'active fw-bold' : ''); ?>" 
                           href="<?php echo e(route('index')); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('jurusan') ? 'active fw-bold' : ''); ?>" 
                           href="<?php echo e(route('jurusan')); ?>">Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('pendaftaran') ? 'active fw-bold' : ''); ?>" 
                           href="<?php echo e(route('pendaftaran')); ?>">Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('faq') ? 'active fw-bold' : ''); ?>" 
                           href="<?php echo e(route('faq')); ?>">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active fw-bold' : ''); ?>" 
                           href="<?php echo e(route('alamat')); ?>">Alamat</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-school me-2"></i>SMK BAKTI NUSANTARA 666
                    </h5>
                    <p class="text-light">
                        Menyediakan pendidikan berkualitas dengan kurikulum terbaru dan fasilitas modern untuk mencetak lulusan yang kompeten di dunia kerja.
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/Smkbn666" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="https://www.instagram.com/smkbaktinusantara666" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="http://www.youtube.com/@baknustv9545" class="text-light me-3"><i class="fab fa-youtube fa-lg"></i></a>
                        <a href="https://www.tiktok.com/@smkbaktinusantara666" class="text-light"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 mb-4">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo e(route('index')); ?>" class="text-light text-decoration-none">Beranda</a></li>
                        <li><a href="<?php echo e(route('jurusan')); ?>" class="text-light text-decoration-none">Jurusan</a></li>
                        <li><a href="<?php echo e(route('pendaftaran')); ?>" class="text-light text-decoration-none">Pendaftaran</a></li>
                        <li><a href="<?php echo e(route('faq')); ?>" class="text-light text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled text-light">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            JL. PERCOBAAN KM. 17 NO. 65 CILEUNYI
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            (022) 6373-0220
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            esemka.baknus666@gmail.com
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="mb-3">Jam Operasional</h6>
                    <ul class="list-unstyled text-light">
                        <li class="mb-1">Senin - Jumat: 07:00 - 16:00</li>
                        <li class="mb-1">Sabtu: 08:00 - 14:00</li>
                        <li>Minggu: Tutup</li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2026 SMK BAKTI NUSANTARA 666. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Developed with <i class="fas fa-heart text-danger"></i> by Tim IT SMK BAKNUS 666</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/layouts/public.blade.php ENDPATH**/ ?>