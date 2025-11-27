<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Keuangan - SPMB</title>
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
        .header h2 {
            margin: 5px 0;
            color: #34495e;
            font-size: 14px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #34495e;
        }
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            font-size: 9px;
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
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
        .page-break {
            page-break-after: always;
        }
        .summary-row {
            background-color: #e3f2fd !important;
            font-weight: bold;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAPITULASI KEUANGAN</h1>
        <h2>Sistem Penerimaan Murid Baru Online</h2>
        <p>Periode: <?php echo e($filterInfo['start_date'] ? date('d/m/Y', strtotime($filterInfo['start_date'])) : 'Semua'); ?> - 
           <?php echo e($filterInfo['end_date'] ? date('d/m/Y', strtotime($filterInfo['end_date'])) : 'Semua'); ?></p>
    </div>

    <!-- Informasi Filter -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Jurusan:</span>
            <span class="info-value"><?php echo e($filterInfo['jurusan']); ?></span>
        </div>
            <div class="info-row">
            <span class="info-label">Gelombang:</span>
            <span class="info-value"><?php echo e($filterInfo['gelombang']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value"><?php echo e($filterInfo['tanggal_cetak']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Ditandatangani Oleh:</span>
            <span class="info-value">Bagian Keuangan</span>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
        <div style="flex: 1; background: #28a745; color: white; padding: 10px; border-radius: 5px; text-align: center;">
            <div style="font-size: 16px; font-weight: bold;">Rp <?php echo e(number_format($statistik['total_pendapatan'], 0, ',', '.')); ?></div>
            <div style="font-size: 10px;">Total Pendapatan</div>
        </div>
        <div style="flex: 1; background: #17a2b8; color: white; padding: 10px; border-radius: 5px; text-align: center;">
            <div style="font-size: 16px; font-weight: bold;"><?php echo e($statistik['total_peserta']); ?></div>
            <div style="font-size: 10px;">Total Peserta</div>
        </div>
        <div style="flex: 1; background: #ffc107; color: black; padding: 10px; border-radius: 5px; text-align: center;">
            <div style="font-size: 16px; font-weight: bold;">Rp <?php echo e(number_format($statistik['rata_rata'], 0, ',', '.')); ?></div>
            <div style="font-size: 10px;">Rata-rata per Peserta</div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">No. Pendaftaran</th>
                <th style="width: 15%;">Nama</th>
                <th style="width: 12%;">Jurusan</th>
                <th style="width: 12%;">Gelombang</th>
                <th style="width: 10%;">Biaya</th>
                <th style="width: 12%;">Tanggal Bayar</th>
                <th style="width: 10%;">Verifikator</th>
                <th style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->no_pendaftaran); ?></td>
                <td><?php echo e($item->user->nama); ?></td>
                <td><?php echo e($item->jurusan->nama); ?></td>
                <td><?php echo e($item->gelombang->nama); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($item->gelombang->biaya_daftar, 0, ',', '.')); ?></td>
                <td class="text-center"><?php echo e($item->tgl_verifikasi_payment->format('d/m/Y')); ?></td>
                <td><?php echo e($item->user_verifikasi_payment); ?></td>
                <td class="text-center">
                    <span class="badge badge-success">TERBAYAR</span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <!-- Baris Total -->
            <tr class="summary-row">
                <td colspan="5" class="text-center"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp <?php echo e(number_format($statistik['total_pendapatan'], 0, ',', '.')); ?></strong></td>
                <td colspan="3" class="text-center"><strong><?php echo e($statistik['total_peserta']); ?> Peserta</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Ringkasan per Jurusan -->
    <?php if($data->count() > 0): ?>
    <div style="margin-top: 20px;">
        <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px; font-size: 14px;">
            Ringkasan per Jurusan
        </h3>
        
        <table>
            <thead>
                <tr>
                    <th>Jurusan</th>
                    <th class="text-center">Jumlah Peserta</th>
                    <th class="text-right">Total Pendapatan</th>
                    <th class="text-right">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $jurusanSummary = [];
                    foreach($data as $item) {
                        $jurusanId = $item->jurusan_id;
                        if (!isset($jurusanSummary[$jurusanId])) {
                            $jurusanSummary[$jurusanId] = [
                                'nama' => $item->jurusan->nama,
                                'count' => 0,
                                'total' => 0
                            ];
                        }
                        $jurusanSummary[$jurusanId]['count']++;
                        $jurusanSummary[$jurusanId]['total'] += $item->gelombang->biaya_daftar;
                    }
                ?>
                
                <?php $__currentLoopData = $jurusanSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($summary['nama']); ?></td>
                    <td class="text-center"><?php echo e($summary['count']); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($summary['total'], 0, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($summary['total'] / $summary['count'], 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Ringkasan per Gelombang -->
    <?php if($data->count() > 0): ?>
    <div style="margin-top: 20px;">
        <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px; font-size: 14px;">
            Ringkasan per Gelombang
        </h3>
        
        <table>
            <thead>
                <tr>
                    <th>Gelombang</th>
                    <th class="text-center">Jumlah Peserta</th>
                    <th class="text-right">Total Pendapatan</th>
                    <th class="text-right">Biaya per Peserta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $gelombangSummary = [];
                    foreach($data as $item) {
                        $gelombangId = $item->gelombang_id;
                        if (!isset($gelombangSummary[$gelombangId])) {
                            $gelombangSummary[$gelombangId] = [
                                'nama' => $item->gelombang->nama,
                                'count' => 0,
                                'total' => 0,
                                'biaya' => $item->gelombang->biaya_daftar
                            ];
                        }
                        $gelombangSummary[$gelombangId]['count']++;
                        $gelombangSummary[$gelombangId]['total'] += $item->gelombang->biaya_daftar;
                    }
                ?>
                
                <?php $__currentLoopData = $gelombangSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($summary['nama']); ?></td>
                    <td class="text-center"><?php echo e($summary['count']); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($summary['total'], 0, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($summary['biaya'], 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Penerimaan Murid Baru Online</p>
        <p>© <?php echo e(date('Y')); ?> SPMB Online - Hak Cipta Dilindungi</p>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\ppdb\resources\views/keuangan/export-pdf.blade.php ENDPATH**/ ?>