{{-- resources/views/admin/export/hasil-seleksi-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Seleksi Siswa - SPMB Online</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f8f9fa; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .text-center { text-align: center; }
        .summary { margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; }
        .filter-info { margin-bottom: 15px; color: #666; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HASIL SELEKSI SISWA</h1>
        <p>SPMB Online - SMK BAKTI NUSANTARA 666</p>
        <p>Dicetak pada: {{ $filterInfo['tanggal_cetak'] }}</p>
    </div>

    <div class="filter-info">
        <strong>Filter:</strong> 
        Kategori: {{ $filterInfo['kategori'] }} | 
        Jurusan: {{ $filterInfo['jurusan'] }}
    </div>

    <div class="summary">
        <h3>Ringkasan Statistik</h3>
        <p>Total Siswa: <strong>{{ $statistik['total'] }}</strong></p>
        <p>Lulus: <strong>{{ $statistik['lulus'] }}</strong></p>
        <p>Tidak Lulus: <strong>{{ $statistik['tidak_lulus'] }}</strong></p>
        <p>Persentase Lulus: <strong>{{ $statistik['persentase_lulus'] }}%</strong></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No. Pendaftaran</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th class="text-center">Nilai</th>
                <th class="text-center">Berkas</th>
                <th class="text-center">Hasil</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $item)
            <tr>
                <td>{{ $item->no_pendaftaran }}</td>
                <td>{{ $item->dataSiswa->nama ?? $item->user->nama }}</td>
                <td>{{ $item->jurusan->nama }}</td>
                <td class="text-center">{{ $item->asalSekolah->nilai_rata ?? 0 }}</td>
                <td class="text-center">
                    @php
                        $totalBerkas = $item->berkas->count();
                        $berkasValid = $item->berkas->where('valid', true)->count();
                    @endphp
                    {{ $berkasValid }}/{{ $totalBerkas }}
                </td>
                <td class="text-center">
                    @if($item->hasil_seleksi == 'LULUS')
                        <span class="badge badge-success">LULUS</span>
                    @else
                        <span class="badge badge-danger">TIDAK LULUS</span>
                    @endif
                </td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; color: #666; font-size: 10px;">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Penerimaan Murid Baru Online</p>
    </div>
</body>
</html>