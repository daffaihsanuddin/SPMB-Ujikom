<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pendaftar - SPMB</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .header h2 {
            margin: 5px 0;
            color: #34495e;
            font-size: 12px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
        }
        .stat-cards {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }
        .stat-card {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-number {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
        }
        .stat-label {
            font-size: 9px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: auto;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 8px;
            border: 1px solid #34495e;
        }
        td {
            padding: 4px;
            border: 1px solid #dee2e6;
            font-size: 7px;
            page-break-inside: avoid;
            page-break-after: auto;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 8px;
            color: #6c757d;
        }
        .badge {
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .page-break {
            page-break-after: always;
        }
        .summary-row {
            background-color: #e3f2fd !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PENDAFTAR PESERTA DIDIK BARU</h1>
        <h2>Sistem Penerimaan Murid Baru Online</h2>
        <p>Periode: <?php echo e(now()->format('d/m/Y')); ?></p>
    </div>

    <!-- Informasi Cetak -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value"><?php echo e(now()->format('d/m/Y H:i:s')); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Data:</span>
            <span class="info-value"><?php echo e($pendaftar->count()); ?> Pendaftar</span>
        </div>
        <div class="info-row">
            <span class="info-label">Ditandatangani Oleh:</span>
            <span class="info-value">Kepala Sekolah</span>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-number"><?php echo e($statistik['total_pendaftar']); ?></div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="stat-number"><?php echo e($statistik['lulus_administrasi']); ?></div>
            <div class="stat-label">Lulus Administrasi</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stat-number"><?php echo e($statistik['sudah_bayar']); ?></div>
            <div class="stat-label">Sudah Membayar</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #a8c0ff 0%, #3f2b96 100%);">
            <div class="stat-number"><?php echo e($statistik['persentase_lulus']); ?>%</div>
            <div class="stat-label">Persentase Lulus</div>
        </div>
    </div>

    <!-- Tabel Data Pendaftar -->
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">No. Pendaftaran</th>
                <th style="width: 12%;">Nama Siswa</th>
                <th style="width: 10%;">Jurusan</th>
                <th style="width: 10%;">Gelombang</th>
                <th style="width: 15%;">Asal Sekolah</th>
                <th style="width: 8%;">Tanggal Daftar</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 6%;">Nilai Rata</th>
                <th style="width: 8%;">Kabupaten</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><strong><?php echo e($item->no_pendaftaran); ?></strong></td>
                <td><?php echo e($item->user->nama); ?></td>
                <td><?php echo e($item->jurusan->nama); ?></td>
                <td><?php echo e($item->gelombang->nama); ?></td>
                <td>
                    <?php if($item->asalSekolah): ?>
                        <?php echo e($item->asalSekolah->nama_sekolah); ?>

                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?php echo e($item->tanggal_daftar->format('d/m/Y')); ?></td>
                <td class="text-center">
                    <?php
                        $statusClass = [
                            'SUBMIT' => 'warning',
                            'ADM_PASS' => 'success', 
                            'ADM_REJECT' => 'danger',
                            'PAID' => 'info'
                        ][$item->status];
                    ?>
                    <span class="badge badge-<?php echo e($statusClass); ?>">
                        <?php if($item->status == 'SUBMIT'): ?> MENUNGGU
                        <?php elseif($item->status == 'ADM_PASS'): ?> LULUS ADM
                        <?php elseif($item->status == 'ADM_REJECT'): ?> DITOLAK
                        <?php elseif($item->status == 'PAID'): ?> SUDAH BAYAR
                        <?php else: ?> <?php echo e($item->status); ?>

                        <?php endif; ?>
                    </span>
                </td>
                <td class="text-center">
                    <?php if($item->asalSekolah): ?>
                        <strong><?php echo e($item->asalSekolah->nilai_rata); ?></strong>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if($item->asalSekolah): ?>
                        <?php echo e($item->asalSekolah->kabupaten); ?>

                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Ringkasan per Status -->
    <div style="margin-top: 15px;">
        <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 3px; font-size: 11px;">
            Ringkasan per Status Pendaftaran
        </h3>
        
        <table style="width: 50%;">
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $statusSummary = [
                        'SUBMIT' => ['label' => 'Menunggu Verifikasi', 'class' => 'warning'],
                        'ADM_PASS' => ['label' => 'Lulus Administrasi', 'class' => 'success'],
                        'ADM_REJECT' => ['label' => 'Ditolak', 'class' => 'danger'],
                        'PAID' => ['label' => 'Sudah Bayar', 'class' => 'info']
                    ];
                ?>
                
                <?php $__currentLoopData = $statusSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $count = $pendaftar->where('status', $status)->count();
                    $percentage = $pendaftar->count() > 0 ? round(($count / $pendaftar->count()) * 100, 1) : 0;
                ?>
                <tr>
                    <td>
                        <span class="badge badge-<?php echo e($info['class']); ?>"><?php echo e($info['label']); ?></span>
                    </td>
                    <td class="text-center"><?php echo e($count); ?></td>
                    <td class="text-center"><?php echo e($percentage); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr class="summary-row">
                    <td><strong>TOTAL</strong></td>
                    <td class="text-center"><strong><?php echo e($pendaftar->count()); ?></strong></td>
                    <td class="text-center"><strong>100%</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Penerimaan Murid Baru Online</p>
        <p>© <?php echo e(date('Y')); ?> SPMB Online - Hak Cipta Dilindungi</p>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/export/laporan-pendaftar.blade.php ENDPATH**/ ?>