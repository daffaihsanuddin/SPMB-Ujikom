<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin SPMB - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/admin/dashboard">SMK BAKNUS 666</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto"> <!-- ms-auto mendorong ke kanan -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> <?php echo e(Auth::user()->nama); ?>

                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form">
                            <?php echo csrf_field(); ?>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Side Navbar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>

                        <!--Sidenav - Master Data -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="fas fa-database me-2"><i class="fas fa-columns"></i></div>
                            Master Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.jurusan') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('admin.jurusan')); ?>">
                                    Jurusan & Kuota
                                </a>
                                <a class="nav-link <?php echo e(request()->routeIs('admin.gelombang') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('admin.gelombang')); ?>">
                                    Gelombang & Biaya
                                </a>
                            </nav>
                        </div>

                        <!-- Sidenav - Monitoring Berkas -->
                        <a class="nav-link <?php echo e(request()->routeIs('admin.monitoring-berkas') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.monitoring-berkas')); ?>">
                            <i class="fas fa-file-alt me-2"></i>Monitoring Berkas
                        </a>

                        <!-- Sidenav - Peta -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="fas fa-map me-2"><i class="fas fa-columns"></i></div>
                            Peta
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?php echo e(request()->routeIs('admin.peta-sebaran') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('admin.peta-sebaran')); ?>">
                                    Peta Interaktif
                                </a>
                                <a class="nav-link <?php echo e(request()->routeIs('admin.statistik-wilayah') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('admin.statistik-wilayah')); ?>">
                                    Statistik Wilayah
                                </a>
                            </nav>
                            <!-- Sidenav - Seleksi Siswa (NEW) -->
                        </div>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.siswa.hasil-seleksi') ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.siswa.hasil-seleksi')); ?>">
                            <i class="fas fa-user-graduate me-2"></i>Seleksi Siswa
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo e(Auth::user()->nama); ?> (<?php echo e(Auth::user()->role); ?>)
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

            <!-- Include Footer -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
            crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('assets/demo/chart-area-demo.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/demo/chart-bar-demo.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="<?php echo e(asset('js/datatables-simple-demo.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\ppdb\resources\views/layouts/admin.blade.php ENDPATH**/ ?>