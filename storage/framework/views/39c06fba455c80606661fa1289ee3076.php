<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendaftar - SPMB Online</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
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
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table th {
            background: #34495e;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        .table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        .table-striped tr:nth-child(even) {
            background: #f8f9fa;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .bg-warning { background: #f39c12; color: white; }
        .bg-success { background: #27ae60; color: white; }
        .bg-danger { background: #e74c3c; color: white; }
        .bg-info { background: #3498db; color: white; }
        .bg-primary { background: #2980b9; color: white; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #7f8c8d;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .kpi-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Halaman 1: Ringkasan Eksekutif -->
    <div class="header">
        <h1>LAPORAN EKSEKUTIF PENERIMAAN MURID BARU</h1>
        <div class="subtitle">SMK BAKTI NUSANTARA 666</div>
        <div>Periode: <?php echo e(now()->format('d F Y')); ?></div>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <strong>Dicetak oleh:</strong> <?php echo e(Auth::user()->nama); ?><br>
        <strong>Tanggal Cetak:</strong> <?php echo e(now()->format('d/m/Y H:i')); ?><br>
        <strong>Role:</strong> Kepala Sekolah
    </div>

    <!-- KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px;">
        <div class="kpi-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="stat-number"><?php echo e($stats['total_pendaftar']); ?></div>
            <small>Total Pendaftar</small>
        </div>
        <div class="kpi-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="stat-number"><?php echo e($stats['lulus_administrasi']); ?></div>
            <small>Lulus Administrasi</small>
        </div>
        <div class="kpi-card" style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
            <div class="stat-number"><?php echo e($stats['sudah_bayar']); ?></div>
            <small>Sudah Membayar</small>
        </div>
    </div>

    <!-- Statistik Per Jurusan -->
    <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px;">Statistik Per Jurusan</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Jurusan</th>
                <th class="text-center">Kuota</th>
                <th class="text-center">Pendaftar</th>
                <th class="text-center">Sisa</th>
                <th class="text-center">Rasio</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendaftarPerJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $sisa = max(0, $item['kuota'] - $item['pendaftar']);
                $rasio = $item['kuota'] > 0 ? round(($item['pendaftar'] / $item['kuota']) * 100, 2) : 0;
            ?>
            <tr>
                <td><?php echo e($item['nama']); ?></td>
                <td class="text-center"><?php echo e($item['kuota']); ?></td>
                <td class="text-center"><?php echo e($item['pendaftar']); ?></td>
                <td class="text-center <?php echo e($sisa == 0 ? 'text-danger' : ''); ?>"><?php echo e($sisa); ?></td>
                <td class="text-center <?php echo e($rasio >= 100 ? 'text-danger' : ''); ?>"><?php echo e($rasio); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot style="background: #ecf0f1; font-weight: bold;">
            <tr>
                <td>TOTAL</td>
                <td class="text-center"><?php echo e($pendaftarPerJurusan->sum('kuota')); ?></td>
                <td class="text-center"><?php echo e($pendaftarPerJurusan->sum('pendaftar')); ?></td>
                <td class="text-center"><?php echo e(max(0, $pendaftarPerJurusan->sum('kuota') - $pendaftarPerJurusan->sum('pendaftar'))); ?></td>
                <td class="text-center">
                    <?php
                        $totalRasio = $pendaftarPerJurusan->sum('kuota') > 0 ? 
                            round(($pendaftarPerJurusan->sum('pendaftar') / $pendaftarPerJurusan->sum('kuota')) * 100, 2) : 0;
                    ?>
                    <?php echo e($totalRasio); ?>%
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Status Pendaftaran -->
    <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px;">Status Pendaftaran</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $statusPendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $total = $statusPendaftaran->sum('total');
                $persentase = $total > 0 ? round(($item->total / $total) * 100, 2) : 0;
            ?>
            <tr>
                <td>
                    <span class="badge 
                        <?php if($item->status == 'SUBMIT'): ?> bg-warning
                        <?php elseif($item->status == 'ADM_PASS'): ?> bg-success
                        <?php elseif($item->status == 'ADM_REJECT'): ?> bg-danger
                        <?php else: ?> bg-info <?php endif; ?>">
                        <?php echo e($item->status); ?>

                    </span>
                </td>
                <td class="text-center"><?php echo e($item->total); ?></td>
                <td class="text-center"><?php echo e($persentase); ?>%</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="footer">
        Halaman 1 dari 2 - Laporan Eksekutif SPMB SMK Bakti Nusantara 666
    </div>

    <!-- Halaman 2: Detail Pendaftar -->
    <div class="page-break"></div>

    <div class="header">
        <h1>DATA DETAIL PENDAFTAR</h1>
        <div class="subtitle">SMK BAKTI NUSANTARA 666</div>
        <div>Periode: <?php echo e(now()->format('d F Y')); ?></div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No. Pendaftaran</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th>Gelombang</th>
                <th>Asal Sekolah</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="font-size: 9px;"><?php echo e($item->no_pendaftaran); ?></td>
                <td><?php echo e($item->user->nama); ?></td>
                <td><?php echo e($item->jurusan->nama); ?></td>
                <td><?php echo e($item->gelombang->nama); ?></td>
                <td style="font-size: 9px;">
                    <?php if($item->asalSekolah): ?>
                        <?php echo e($item->asalSekolah->nama_sekolah); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->tanggal_daftar->format('d/m/Y')); ?></td>
                <td>
                    <span class="badge 
                        <?php if($item->status == 'SUBMIT'): ?> bg-warning
                        <?php elseif($item->status == 'ADM_PASS'): ?> bg-success
                        <?php elseif($item->status == 'ADM_REJECT'): ?> bg-danger
                        <?php else: ?> bg-info <?php endif; ?>">
                        <?php echo e($item->status); ?>

                    </span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php if($pendaftar->isEmpty()): ?>
    <div style="text-align: center; padding: 20px; color: #7f8c8d;">
        <p>Tidak ada data pendaftar</p>
    </div>
    <?php endif; ?>

    <div class="footer">
        Halaman 2 dari 2 - Data Detail Pendaftar SPMB SMK Bakti Nusantara 666<br>
        Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?>

    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/export/pdf.blade.php ENDPATH**/ ?>