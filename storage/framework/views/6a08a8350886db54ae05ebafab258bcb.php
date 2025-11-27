<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Verifikator SPMB - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo e(asset('css/styles.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/verifikator/dashboard">SMK BAKNUS 666</a>
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
                        <!-- Dashboard -->
                        <a class="nav-link <?php echo e(request()->routeIs('verifikator.dashboard') ? 'active' : ''); ?>"
                            href="<?php echo e(route('verifikator.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>

                        <!-- Verifikasi Pendaftar -->
                        <a class="nav-link <?php echo e(request()->routeIs('verifikator.index') ? 'active' : ''); ?>"
                            href="<?php echo e(route('verifikator.index')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-check"></i></div>
                            Verifikasi Pendaftar
                            <?php
                                $menungguCount = \App\Models\Pendaftar::where('status', 'SUBMIT')->count();
                            ?>
                            <?php if($menungguCount > 0): ?>
                                <span class="badge bg-danger rounded-pill ms-2"><?php echo e($menungguCount); ?></span>
                            <?php endif; ?>
                        </a>

                        <!-- Riwayat Verifikasi -->
                        <a class="nav-link <?php echo e(request()->routeIs('verifikator.riwayat') ? 'active' : ''); ?>"
                            href="<?php echo e(route('verifikator.riwayat')); ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Verifikasi
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo e(Auth::user()->nama); ?>

                    <div class="small text-muted">Verifikator Administrasi</div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $__env->yieldContent('title'); ?></h1>
                        <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                                </ol>
                            </nav>
                        <?php endif; ?>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\ppdb\resources\views/layouts/verifikator.blade.php ENDPATH**/ ?>