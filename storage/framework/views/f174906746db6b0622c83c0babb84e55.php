<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SPMB - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3 text-white">
                    <h5 class="mb-0">SPMB Admin</h5>
                    <small>Sistem Penerimaan Murid Baru</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->is('admin/master*') ? 'active' : ''); ?>" 
                           href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-2"></i>Master Data
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li>
                                <a class="dropdown-item text-white <?php echo e(request()->routeIs('admin.jurusan') ? 'active' : ''); ?>" 
                                   href="<?php echo e(route('admin.jurusan')); ?>">
                                    Jurusan & Kuota
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white <?php echo e(request()->routeIs('admin.gelombang') ? 'active' : ''); ?>" 
                                   href="<?php echo e(route('admin.gelombang')); ?>">
                                    Gelombang & Biaya
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.monitoring-berkas') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.monitoring-berkas')); ?>">
                            <i class="fas fa-file-alt me-2"></i>Monitoring Berkas
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->is('admin/peta*') ? 'active' : ''); ?>" 
                           href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-map me-2"></i>Peta Sebaran
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li>
                                <a class="dropdown-item text-white <?php echo e(request()->routeIs('admin.peta-sebaran') ? 'active' : ''); ?>" 
                                   href="<?php echo e(route('admin.peta-sebaran')); ?>">
                                    Peta Interaktif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-white <?php echo e(request()->routeIs('admin.statistik-wilayah') ? 'active' : ''); ?>" 
                                   href="<?php echo e(route('admin.statistik-wilayah')); ?>">
                                    Statistik Wilayah
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <nav class="navbar navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <span class="navbar-brand"><?php echo $__env->yieldContent('title'); ?></span>
                        <div class="d-flex">
                            <span class="navbar-text me-3">
                                <i class="fas fa-user me-1"></i><?php echo e(Auth::user()->nama); ?>

                            </span>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid py-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/layouts/1234.blade.php ENDPATH**/ ?>