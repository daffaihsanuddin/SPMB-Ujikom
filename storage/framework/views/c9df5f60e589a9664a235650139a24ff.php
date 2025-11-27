<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Wilayah Pendaftar</title>
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
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .summary-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
        }
        .summary-number {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        .summary-label {
            font-size: 9px;
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
        .progress-bar {
            background: #e9ecef;
            border-radius: 3px;
            height: 8px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #3498db;
        }
        .top-wilayah {
            margin-bottom: 20px;
        }
        .top-item {
            margin-bottom: 8px;
        }
        .top-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            color: #7f8c8d;
            font-size: 10px;
        }
        .filter-info {
            background: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .section-title {
            color: #2c3e50;
            font-size: 14px;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #dee2e6;
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
        <h1>LAPORAN STATISTIK WILAYAH PENDAFTAR</h1>
        <div class="subtitle">Sistem Penerimaan Murid Baru Online</div>
        <div>Dicetak pada: <?php echo e(date('d/m/Y H:i:s')); ?></div>
    </div>

    <!-- Filter Information -->
    <?php if($searchTerm): ?>
    <div class="filter-info">
        <strong>Filter pencarian:</strong> "<?php echo e($searchTerm); ?>"
    </div>
    <?php endif; ?>

    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-number"><?php echo e($summary['total_wilayah']); ?></div>
            <div class="summary-label">Total Wilayah</div>
        </div>
        <div class="summary-card">
            <div class="summary-number"><?php echo e($summary['total_pendaftar']); ?></div>
            <div class="summary-label">Total Pendaftar</div>
        </div>
        <div class="summary-card">
            <div class="summary-number"><?php echo e($summary['rata_rata']); ?></div>
            <div class="summary-label">Rata-rata per Wilayah</div>
        </div>
        <div class="summary-card">
            <div class="summary-number"><?php echo e($summary['wilayah_terbanyak']); ?></div>
            <div class="summary-label">Wilayah Terbanyak</div>
        </div>
    </div>

    <!-- Top 5 Wilayah -->
    <?php if($summary['top_5_wilayah']->count() > 0): ?>
    <div class="section-title">5 Besar Wilayah dengan Pendaftar Terbanyak</div>
    <div class="top-wilayah">
        <?php $__currentLoopData = $summary['top_5_wilayah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="top-item">
            <div class="top-info">
                <span><strong><?php echo e($index + 1); ?>. <?php echo e($item->kecamatan); ?> - <?php echo e($item->kelurahan); ?></strong></span>
                <span><?php echo e($item->total); ?> pendaftar (<?php echo e($item->persentase); ?>%)</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo e($item->persentase); ?>%"></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <!-- Main Data Table -->
    <div class="section-title">Detail Statistik per Wilayah</div>
    
    <?php if($statistik->count() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Jumlah Pendaftar</th>
                <th>Persentase</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $statistik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->kecamatan); ?></td>
                <td><?php echo e($item->kelurahan); ?></td>
                <td><?php echo e($item->total); ?></td>
                <td><?php echo e($item->persentase); ?>%</td>
                <td style="width: 100px;">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo e($item->persentase); ?>%"></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td colspan="3" style="text-align: right;">Total:</td>
                <td><?php echo e($summary['total_pendaftar']); ?></td>
                <td>100%</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>
    <div style="text-align: center; padding: 40px; color: #7f8c8d;">
        <p>Tidak ada data statistik wilayah yang ditemukan dengan filter yang diterapkan.</p>
    </div>
    <?php endif; ?>

    <!-- Distribution Analysis -->
    <?php if($statistik->count() > 0): ?>
    <div class="section-title">Analisis Distribusi</div>
    <table class="table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Wilayah</th>
                <th>Total Pendaftar</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $categories = [
                    'Tinggi (≥ 10)' => $statistik->where('total', '>=', 10),
                    'Sedang (5-9)' => $statistik->whereBetween('total', [5, 9]),
                    'Rendah (1-4)' => $statistik->whereBetween('total', [1, 4]),
                    'Tidak Ada (0)' => $statistik->where('total', 0)
                ];
            ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($label); ?></td>
                <td><?php echo e($data->count()); ?></td>
                <td><?php echo e($data->sum('total')); ?></td>
                <td><?php echo e($summary['total_pendaftar'] > 0 ? round(($data->sum('total') / $summary['total_pendaftar']) * 100, 1) : 0); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Page Info -->
    <div class="page-info">
        Laporan Statistik Wilayah - Halaman <span class="page-number"></span>
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
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/export/statistik-wilayah-pdf.blade.php ENDPATH**/ ?>