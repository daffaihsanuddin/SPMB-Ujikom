
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statistik Verifikasi - <?php echo e($tanggal); ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin: 5px 0;
        }
        
        .info-box {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .stat-card.menunggu { border-left: 4px solid #f39c12; }
        .stat-card.total { border-left: 4px solid #3498db; }
        .stat-card.lulus { border-left: 4px solid #27ae60; }
        .stat-card.tolak { border-left: 4px solid #e74c3c; }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #34495e;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .progress-bar {
            height: 20px;
            background-color: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin: 5px 0;
        }
        
        .progress-fill {
            height: 100%;
            text-align: center;
            line-height: 20px;
            font-size: 10px;
            color: white;
            font-weight: bold;
        }
        
        .progress-success { background-color: #27ae60; }
        .progress-danger { background-color: #e74c3c; }
        
        .summary-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        
        .badge-success { background-color: #27ae60; }
        .badge-warning { background-color: #f39c12; }
        .badge-danger { background-color: #e74c3c; }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>STATISTIK VERIFIKASI ADMINISTRASI</h1>
        <div class="subtitle">Sistem Penerimaan Murid Baru Online</div>
        <div class="subtitle">Periode: <?php echo e($tanggal); ?> <?php echo e($waktu); ?></div>
    </div>

    <!-- Informasi Dokumen -->
    <div class="info-box">
        <strong>Dokumen ini berisi:</strong> Ringkasan statistik kinerja verifikasi administrasi<br>
        <strong>Verifikator:</strong> <?php echo e($verifikator); ?><br>
        <strong>Tanggal Generate:</strong> <?php echo e($tanggal); ?> <?php echo e($waktu); ?>

    </div>

    <!-- Statistik Utama -->
    <h2 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px;">STATISTIK UTAMA</h2>
    
    <div class="stats-grid">
        <div class="stat-card menunggu">
            <div class="stat-number" style="color: #f39c12;"><?php echo e($statistik->menunggu); ?></div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
        
        <div class="stat-card total">
            <div class="stat-number" style="color: #3498db;"><?php echo e($total_verifikasi); ?></div>
            <div class="stat-label">Total Diverifikasi</div>
        </div>
        
        <div class="stat-card lulus">
            <div class="stat-number" style="color: #27ae60;"><?php echo e($statistik->lulus); ?></div>
            <div class="stat-label">Lulus Administrasi</div>
        </div>
        
        <div class="stat-card tolak">
            <div class="stat-number" style="color: #e74c3c;"><?php echo e($statistik->tolak); ?></div>
            <div class="stat-label">Tidak Lulus</div>
        </div>
    </div>

    <!-- Ringkasan Rasio -->
    <div class="summary-box">
        <h3 style="margin-top: 0; color: #2c3e50;">RASIO KELULUSAN</h3>
        
        <div style="margin-bottom: 10px;">
            <strong>Lulus: </strong><?php echo e($statistik->lulus); ?> (<?php echo e($persentase_lulus); ?>%) 
            | <strong>Tolak: </strong><?php echo e($statistik->tolak); ?> (<?php echo e($persentase_tolak); ?>%)
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill progress-success" style="width: <?php echo e($persentase_lulus); ?>%;">
                <?php echo e($persentase_lulus); ?>%
            </div>
            <div class="progress-fill progress-danger" style="width: <?php echo e($persentase_tolak); ?>%;">
                <?php echo e($persentase_tolak); ?>%
            </div>
        </div>
    </div>

    <!-- Statistik per Jurusan -->
    <h2 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px; margin-top: 30px;">STATISTIK PER JURUSAN</h2>
    
    <?php if($statistikJurusan->count() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 30%;">Jurusan</th>
                <th style="width: 15%; text-align: center;">Kode</th>
                <th style="width: 15%; text-align: center;">Total</th>
                <th style="width: 15%; text-align: center;">Lulus</th>
                <th style="width: 15%; text-align: center;">Tolak</th>
                <th style="width: 20%; text-align: center;">Persentase Lulus</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $statistikJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($jurusan->nama); ?></strong></td>
                <td style="text-align: center;"><code><?php echo e($jurusan->kode); ?></code></td>
                <td style="text-align: center;"><?php echo e($jurusan->total); ?></td>
                <td style="text-align: center; color: #27ae60;"><?php echo e($jurusan->total_lulus); ?></td>
                <td style="text-align: center; color: #e74c3c;"><?php echo e($jurusan->total_tolak); ?></td>
                <td style="text-align: center;">
                    <?php if($jurusan->persentase_lulus >= 70): ?>
                        <span class="badge badge-success"><?php echo e($jurusan->persentase_lulus); ?>%</span>
                    <?php elseif($jurusan->persentase_lulus >= 50): ?>
                        <span class="badge badge-warning"><?php echo e($jurusan->persentase_lulus); ?>%</span>
                    <?php else: ?>
                        <span class="badge badge-danger"><?php echo e($jurusan->persentase_lulus); ?>%</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align: center; padding: 20px; color: #7f8c8d;">
        <p><strong>Belum ada data statistik jurusan</strong></p>
        <p>Data akan muncul setelah ada proses verifikasi</p>
    </div>
    <?php endif; ?>

    <!-- Ringkasan Kinerja -->
    <div class="summary-box">
        <h3 style="margin-top: 0; color: #2c3e50;">RINGKASAN KINERJA</h3>
        
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; padding: 5px 0;">
                    <strong>Total Pendaftar:</strong>
                </td>
                <td style="width: 40%; padding: 5px 0;">
                    <?php echo e($statistik->menunggu + $total_verifikasi); ?>

                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">
                    <strong>Menunggu Verifikasi:</strong>
                </td>
                <td style="padding: 5px 0;">
                    <?php echo e($statistik->menunggu); ?>

                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">
                    <strong>Sudah Diverifikasi:</strong>
                </td>
                <td style="padding: 5px 0;">
                    <?php echo e($total_verifikasi); ?>

                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">
                    <strong>Rata-rata Kelulusan:</strong>
                </td>
                <td style="padding: 5px 0;">
                    <?php echo e($persentase_lulus); ?>%
                </td>
            </tr>
            <tr>
                <td style="padding: 5px 0;">
                    <strong>Jurusan Terbanyak:</strong>
                </td>
                <td style="padding: 5px 0;">
                    <?php if($statistikJurusan->count() > 0): ?>
                        <?php echo e($statistikJurusan->sortByDesc('total')->first()->nama); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh Sistem Penerimaan Murid Baru Online<br>
        Hak Cipta © <?php echo e(date('Y')); ?> - Semua Hak Dilindungi
    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/verifikator/export/statistik-pdf.blade.php ENDPATH**/ ?>