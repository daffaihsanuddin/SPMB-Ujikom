<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peta Sebaran Pendaftar</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 18px;
        }
        .header .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
        }
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
        }
        .stat-label {
            font-size: 10px;
            color: #7f8c8d;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        .table td {
            padding: 6px;
            border: 1px solid #dee2e6;
            font-size: 9px;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-success { background: #d1edff; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            color: #7f8c8d;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .filter-info {
            background: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .page-info {
            text-align: right;
            font-size: 9px;
            color: #7f8c8d;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PETA SEBARAN PENDAFTAR</h1>
        <div class="subtitle">Sistem Penerimaan Murid Baru Online</div>
        <div>Dicetak pada: <?php echo e(date('d/m/Y H:i:s')); ?></div>
    </div>

    <!-- Filter Information -->
    <?php if($filterJurusan || $filterStatus || $searchTerm): ?>
    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        <?php if($filterJurusan): ?> • Jurusan: <?php echo e($filterJurusan); ?><br> <?php endif; ?>
        <?php if($filterStatus): ?> • Status: <?php echo e($filterStatus); ?><br> <?php endif; ?>
        <?php if($searchTerm): ?> • Pencarian: "<?php echo e($searchTerm); ?>" <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Statistics Summary -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['total']); ?></div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['per_jurusan']->count()); ?></div>
            <div class="stat-label">Jumlah Jurusan</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($stats['per_status']->count()); ?></div>
            <div class="stat-label">Jumlah Status</div>
        </div>
    </div>

    <!-- Statistics by Jurusan -->
    <?php if($stats['per_jurusan']->count() > 0): ?>
    <h3 style="color: #2c3e50; font-size: 14px; margin-bottom: 10px;">Statistik per Jurusan</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Jurusan</th>
                <th>Jumlah Pendaftar</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $stats['per_jurusan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($jurusan); ?></td>
                <td><?php echo e($count); ?></td>
                <td><?php echo e($stats['total'] > 0 ? round(($count / $stats['total']) * 100, 1) : 0); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Statistics by Status -->
    <?php if($stats['per_status']->count() > 0): ?>
    <h3 style="color: #2c3e50; font-size: 14px; margin-bottom: 10px;">Statistik per Status</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah Pendaftar</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $stats['per_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php
                        $statusLabels = [
                            'SUBMIT' => 'Menunggu Verifikasi',
                            'ADM_PASS' => 'Lulus Administrasi',
                            'ADM_REJECT' => 'Ditolak',
                            'PAID' => 'Sudah Bayar'
                        ];
                    ?>
                    <?php echo e($statusLabels[$status] ?? $status); ?>

                </td>
                <td><?php echo e($count); ?></td>
                <td><?php echo e($stats['total'] > 0 ? round(($count / $stats['total']) * 100, 1) : 0); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Main Data Table -->
    <h3 style="color: #2c3e50; font-size: 14px; margin-bottom: 10px;">Data Detail Pendaftar dengan Koordinat</h3>
    
    <?php if($dataMap->count() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pendaftaran</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Status</th>
                <th>Koordinat</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $dataMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item['no_pendaftaran']); ?></td>
                <td><?php echo e($item['nama']); ?></td>
                <td><?php echo e($item['jurusan']); ?></td>
                <td>
                    <?php
                        $statusClass = [
                            'SUBMIT' => 'warning',
                            'ADM_PASS' => 'success',
                            'ADM_REJECT' => 'danger',
                            'PAID' => 'info'
                        ][$item['status']];
                        $statusLabels = [
                            'SUBMIT' => 'Menunggu',
                            'ADM_PASS' => 'Lulus',
                            'ADM_REJECT' => 'Ditolak',
                            'PAID' => 'Bayar'
                        ];
                    ?>
                    <span class="badge badge-<?php echo e($statusClass); ?>">
                        <?php echo e($statusLabels[$item['status']] ?? $item['status']); ?>

                    </span>
                </td>
                <td><?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?></td>
                <td style="max-width: 150px;"><?php echo e($item['alamat']); ?></td>
                <td><?php echo e($item['tanggal_daftar']); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align: center; padding: 40px; color: #7f8c8d;">
        <p>Tidak ada data pendaftar yang ditemukan dengan filter yang diterapkan.</p>
    </div>
    <?php endif; ?>

    <!-- Page Info -->
    <div class="page-info">
        Laporan Peta Sebaran Pendaftar - Halaman <span class="page-number"></span>
    </div>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh Sistem Penerimaan Murid Baru Online<br>
        <?php echo e(date('d/m/Y H:i:s')); ?>

    </div>

    <script>
        // Simple page number counter
        document.addEventListener('DOMContentLoaded', function() {
            const pageNumbers = document.querySelectorAll('.page-number');
            pageNumbers.forEach((span, index) => {
                span.textContent = (index + 1);
            });
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/export/peta-sebaran-pdf.blade.php ENDPATH**/ ?>