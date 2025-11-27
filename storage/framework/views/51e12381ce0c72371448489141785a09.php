<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Keuangan SPMB - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo e(route('keuangan.dashboard')); ?>">SMK BAKNUS 666</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form> -->
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
                        <a class="nav-link <?php echo e(request()->routeIs('keuangan.dashboard') ? 'active' : ''); ?>"
                            href="<?php echo e(route('keuangan.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>

                        <!-- Verifikasi Pembayaran -->
                        <a class="nav-link <?php echo e(request()->routeIs('keuangan.verifikasi-pembayaran') ? 'active' : ''); ?>"
                            href="<?php echo e(route('keuangan.verifikasi-pembayaran')); ?>">
                            <i class="fas fa-money-bill-wave me-2"></i>Verifikasi Pembayaran
                            <?php
                                $menungguCount = \App\Models\Pendaftar::where('status', 'ADM_PASS')->count();
                            ?>
                            <?php if($menungguCount > 0): ?>
                                <span class="badge bg-danger rounded-pill ms-2"><?php echo e($menungguCount); ?></span>
                            <?php endif; ?>
                        </a>

                        <!-- Rekap Keuangan -->
                        <a class="nav-link <?php echo e(request()->routeIs('keuangan.rekap-keuangan') ? 'active' : ''); ?>"
                            href="<?php echo e(route('keuangan.rekap-keuangan')); ?>">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Rekap Keuangan
                        </a>

                        <!-- Statistik -->
                        <a class="nav-link <?php echo e(request()->routeIs('keuangan.statistik') ? 'active' : ''); ?>"
                            href="<?php echo e(route('keuangan.statistik')); ?>">
                            <i class="fas fa-chart-bar me-2"></i>Statistik
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo e(Auth::user()->nama); ?> (Keuangan)
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i><?php echo e(session('info')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('js/scripts.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('assets/demo/chart-area-demo.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/demo/chart-bar-demo.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('js/datatables-simple-demo.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\ppdb\resources\views/layouts/keuangan.blade.php ENDPATH**/ ?>