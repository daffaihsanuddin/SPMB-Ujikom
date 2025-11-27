<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik SPMB</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
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
        .stat-cards {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }
        .stat-card {
            flex: 1;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            margin: 3px 0;
        }
        .stat-label {
            font-size: 9px;
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #34495e;
        }
        td {
            padding: 5px;
            border: 1px solid #dee2e6;
            font-size: 8px;
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
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            text-align: center;
            font-size: 7px;
            line-height: 8px;
            color: white;
        }
        .section-title {
            color: #2c3e50;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
            margin: 15px 0 10px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STATISTIK PENERIMAAN PESERTA DIDIK BARU</h1>
        <h2>Tahun Ajaran {{ $tahun }}/{{ $tahun + 1 }}</h2>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Statistik Utama -->
    <div class="stat-cards">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="stat-number">{{ number_format($totalPendaftar, 0) }}</div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="stat-number">{{ number_format($totalKuota, 0) }}</div>
            <div class="stat-label">Total Kuota</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);">
            <div class="stat-number">{{ $rasioPendaftarKuota }}%</div>
            <div class="stat-label">Rasio Pendaftar/Kuota</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stat-number">{{ $statistikGelombang->count() }}</div>
            <div class="stat-label">Jumlah Gelombang</div>
        </div>
    </div>

    <!-- Statistik per Bulan -->
    <div class="section-title">
        <i class="fas fa-chart-line"></i> Statistik Pendaftaran per Bulan (Tahun {{ $tahun }})
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th class="text-center">Jumlah Pendaftar</th>
                <th class="text-center">Persentase</th>
                <th style="width: 30%;">Progress</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBulanan = array_sum(array_column($bulananLengkap, 'total'));
            @endphp
            @foreach($bulananLengkap as $item)
            @php
                $persentase = $totalBulanan > 0 ? round(($item['total'] / $totalBulanan) * 100, 1) : 0;
            @endphp
            <tr>
                <td><strong>{{ $item['nama_bulan'] }}</strong></td>
                <td class="text-center">{{ $item['total'] }}</td>
                <td class="text-center">{{ $persentase }}%</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $persentase }}%; background-color: #3498db;">
                            {{ $persentase }}%
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            <tr style="background-color: #e3f2fd; font-weight: bold;">
                <td><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{ $totalBulanan }}</strong></td>
                <td class="text-center"><strong>100%</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Statistik per Jurusan -->
    <div class="section-title">
        <i class="fas fa-graduation-cap"></i> Statistik per Jurusan
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Jurusan</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Pendaftar</th>
                <th class="text-center">Kuota</th>
                <th class="text-center">Tersisa</th>
                <th class="text-center">Rasio</th>
                <th style="width: 25%;">Progress Kuota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistikJurusan as $item)
            @php
                $tersisa = max(0, $item->kuota - $item->pendaftar_count);
                $rasio = $item->kuota > 0 ? round(($item->pendaftar_count / $item->kuota) * 100, 1) : 0;
                $progressColor = $rasio >= 100 ? '#e74c3c' : ($rasio >= 80 ? '#f39c12' : '#27ae60');
            @endphp
            <tr>
                <td>{{ $item->nama }}</td>
                <td class="text-center"><strong>{{ $item->kode }}</strong></td>
                <td class="text-center">{{ $item->pendaftar_count }}</td>
                <td class="text-center">{{ $item->kuota }}</td>
                <td class="text-center {{ $tersisa == 0 ? 'text-danger' : 'text-success' }}">
                    {{ $tersisa }}
                </td>
                <td class="text-center">
                    <span class="badge badge-{{ $rasio >= 100 ? 'danger' : ($rasio >= 80 ? 'warning' : 'success') }}">
                        {{ $rasio }}%
                    </span>
                </td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min($rasio, 100) }}%; background-color: {{ $progressColor }};">
                            {{ min($rasio, 100) }}%
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            @php
                $totalPendaftarJurusan = $statistikJurusan->sum('pendaftar_count');
                $totalKuotaJurusan = $statistikJurusan->sum('kuota');
                $totalRasio = $totalKuotaJurusan > 0 ? round(($totalPendaftarJurusan / $totalKuotaJurusan) * 100, 1) : 0;
            @endphp
            <tr style="background-color: #2c3e50; color: white; font-weight: bold;">
                <td><strong>TOTAL</strong></td>
                <td class="text-center">-</td>
                <td class="text-center"><strong>{{ $totalPendaftarJurusan }}</strong></td>
                <td class="text-center"><strong>{{ $totalKuotaJurusan }}</strong></td>
                <td class="text-center"><strong>{{ max(0, $totalKuotaJurusan - $totalPendaftarJurusan) }}</strong></td>
                <td class="text-center"><strong>{{ $totalRasio }}%</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Statistik Status -->
    <div class="section-title">
        <i class="fas fa-chart-pie"></i> Distribusi Status Pendaftaran
    </div>
    
    <table style="width: 60%; margin: 0 auto;">
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Persentase</th>
                <th style="width: 40%;">Progress</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStatus = $statistikStatus->sum('total');
                $statusLabels = [
                    'SUBMIT' => ['label' => 'Menunggu Verifikasi', 'color' => '#ffc107'],
                    'ADM_PASS' => ['label' => 'Lulus Administrasi', 'color' => '#28a745'],
                    'ADM_REJECT' => ['label' => 'Ditolak', 'color' => '#dc3545'],
                    'PAID' => ['label' => 'Sudah Bayar', 'color' => '#17a2b8']
                ];
            @endphp
            @foreach($statistikStatus as $item)
            @php
                $statusInfo = $statusLabels[$item->status] ?? ['label' => $item->status, 'color' => '#6c757d'];
                $persentase = $totalStatus > 0 ? round(($item->total / $totalStatus) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $statusInfo['label'] }}</td>
                <td class="text-center">{{ $item->total }}</td>
                <td class="text-center">{{ $persentase }}%</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $persentase }}%; background-color: {{ $statusInfo['color'] }};">
                            {{ $persentase }}%
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            <tr style="background-color: #e3f2fd; font-weight: bold;">
                <td><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{ $totalStatus }}</strong></td>
                <td class="text-center"><strong>100%</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dicetak secara otomatis dari Sistem Penerimaan Murid Baru Online</p>
        <p>© {{ date('Y') }} SPMB Online - Semua Hak Dilindungi Undang-Undang</p>
    </div>
</body>
</html>