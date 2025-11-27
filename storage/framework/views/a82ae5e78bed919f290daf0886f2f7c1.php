<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik PPDB - <?php echo e($tahun); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        .summary-label {
            font-size: 10px;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }
        .table-sm th, .table-sm td {
            padding: 4px;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-primary { background-color: #3498db !important; color: white; }
        .bg-success { background-color: #27ae60 !important; color: white; }
        .bg-danger { background-color: #e74c3c !important; color: white; }
        .bg-warning { background-color: #f39c12 !important; color: white; }
        .bg-info { background-color: #17a2b8 !important; color: white; }
        .page-break {
            page-break-after: always;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STATISTIK PPDB</h1>
        <h2>Tahun Pelajaran <?php echo e($tahun); ?>/<?php echo e($tahun + 1); ?></h2>
        <p>Dicetak pada: <?php echo e(now()->format('d F Y H:i')); ?></p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number"><?php echo e(number_format($totalPendaftar, 0)); ?></div>
                <div class="summary-label">TOTAL PENDAFTAR</div>
            </div>
            <div class="summary-item">
                <div class="summary-number"><?php echo e(number_format($totalKuota, 0)); ?></div>
                <div class="summary-label">TOTAL KUOTA</div>
            </div>
            <div class="summary-item">
                <?php
                    $rasio = $totalKuota > 0 ? round(($totalPendaftar / $totalKuota) * 100, 1) : 0;
                ?>
                <div class="summary-number"><?php echo e($rasio); ?>%</div>
                <div class="summary-label">RASIO PENDAFTAR/KUOTA</div>
            </div>
            <div class="summary-item">
                <div class="summary-number"><?php echo e($statistikGelombang->count()); ?></div>
                <div class="summary-label">GELOMBANG</div>
            </div>
        </div>
    </div>

    <!-- Statistik Bulanan -->
    <h3>Statistik Pendaftaran per Bulan</h3>
    <table class="table-sm">
        <thead>
            <tr>
                <th>Bulan</th>
                <?php $__currentLoopData = $bulananLengkap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th class="text-center"><?php echo e($bulan['nama_bulan']); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th class="text-center">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Jumlah Pendaftar</strong></td>
                <?php $__currentLoopData = $bulananLengkap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center"><?php echo e($bulan['total']); ?></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center bg-primary"><strong><?php echo e(array_sum(array_column($bulananLengkap, 'total'))); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Statistik per Jurusan -->
    <h3>Statistik per Jurusan</h3>
    <table class="table-sm">
        <thead>
            <tr>
                <th>Jurusan</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Pendaftar</th>
                <th class="text-center">Kuota</th>
                <th class="text-center">Tersisa</th>
                <th class="text-center">Rasio</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $statistikJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $tersisa = max(0, $item->kuota - $item->pendaftar_count);
                $rasio = $item->kuota > 0 ? round(($item->pendaftar_count / $item->kuota) * 100, 1) : 0;
            ?>
            <tr>
                <td><?php echo e($item->nama); ?></td>
                <td class="text-center"><strong><?php echo e($item->kode); ?></strong></td>
                <td class="text-center"><?php echo e($item->pendaftar_count); ?></td>
                <td class="text-center"><?php echo e($item->kuota); ?></td>
                <td class="text-center <?php echo e($tersisa == 0 ? 'bg-danger' : ''); ?>"><?php echo e($tersisa); ?></td>
                <td class="text-center <?php echo e($rasio >= 100 ? 'bg-danger' : ($rasio >= 80 ? 'bg-warning' : 'bg-success')); ?>">
                    <?php echo e($rasio); ?>%
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr class="bg-primary">
                <th colspan="2">TOTAL</th>
                <th class="text-center"><?php echo e($statistikJurusan->sum('pendaftar_count')); ?></th>
                <th class="text-center"><?php echo e($statistikJurusan->sum('kuota')); ?></th>
                <th class="text-center"><?php echo e(max(0, $statistikJurusan->sum('kuota') - $statistikJurusan->sum('pendaftar_count'))); ?></th>
                <th class="text-center">
                    <?php
                        $totalRasio = $statistikJurusan->sum('kuota') > 0 ? 
                            round(($statistikJurusan->sum('pendaftar_count') / $statistikJurusan->sum('kuota')) * 100, 1) : 0;
                    ?>
                    <?php echo e($totalRasio); ?>%
                </th>
            </tr>
        </tfoot>
    </table>

    <!-- Statistik Status -->
    <h3>Distribusi Status Pendaftaran</h3>
    <table class="table-sm">
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalStatus = $statistikStatus->sum('total');
            ?>
            <?php $__currentLoopData = $statistikStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php if($item->status == 'SUBMIT'): ?> Menunggu Verifikasi
                    <?php elseif($item->status == 'ADM_PASS'): ?> Lulus Administrasi
                    <?php elseif($item->status == 'ADM_REJECT'): ?> Ditolak
                    <?php elseif($item->status == 'PAID'): ?> Sudah Bayar
                    <?php else: ?> <?php echo e($item->status); ?>

                    <?php endif; ?>
                </td>
                <td class="text-center"><?php echo e($item->total); ?></td>
                <td class="text-center"><?php echo e($totalStatus > 0 ? round(($item->total / $totalStatus) * 100, 1) : 0); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr class="bg-primary">
                <th>TOTAL</th>
                <th class="text-center"><?php echo e($totalStatus); ?></th>
                <th class="text-center">100%</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Laporan ini dicetak secara otomatis dari Sistem PPDB Online<br>
        SMK Bakti Nusantara 666 - <?php echo e(now()->format('d F Y')); ?>

    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/export/statistik_pdf.blade.php ENDPATH**/ ?>