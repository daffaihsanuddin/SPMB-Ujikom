@extends('layouts.admin')

@section('title', 'Detail Berkas Pendaftar')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Detail Berkas Pendaftar</h2>
                <p class="text-muted">Detail lengkap data dan berkas pendaftar</p>
            </div>
            <div>
                <a href="{{ route('admin.monitoring-berkas') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@if(!$pendaftar)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h4>Data Pendaftar Tidak Ditemukan</h4>
                <p class="text-muted">Data pendaftar yang diminta tidak ditemukan.</p>
                <a href="{{ route('admin.monitoring-berkas') }}" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <!-- Informasi Utama -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-id-card me-2"></i>Informasi Pendaftaran
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>No. Pendaftaran</strong></td>
                        <td>: <span class="fw-bold text-primary">{{ $pendaftar->no_pendaftaran }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>: {{ $pendaftar->user->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: {{ $pendaftar->user->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>HP</strong></td>
                        <td>: {{ $pendaftar->user->hp }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>: {{ $pendaftar->jurusan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Gelombang</strong></td>
                        <td>: {{ $pendaftar->gelombang->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>: {{ $pendaftar->tanggal_daftar->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            : <span class="badge bg-{{
                                ['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                                [$pendaftar->status]
                            }}">
                                {{ $pendaftar->status }}
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Quick Actions - DIHAPUS TOMBOL VERIFIKASI ADMINISTRASI -->
                <div class="mt-4">
                    <h6 class="text-muted mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <!-- Hapus tombol verifikasi administrasi -->
                        @if($pendaftar->status === 'ADM_PASS' && !$pendaftar->tgl_verifikasi_payment)
                        <a href="{{ route('keuangan.show-pembayaran', $pendaftar->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-money-bill-wave me-2"></i>Verifikasi Pembayaran
                        </a>
                        @endif

                        <button class="btn btn-info btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Ringkasan Berkas
                </h5>
            </div>
            <div class="card-body">
                @php
                    $berkasCount = $pendaftar->berkas->count();
                    $berkasValid = $pendaftar->berkas->where('valid', true)->count();
                    $persentaseValid = $berkasCount > 0 ? ($berkasValid / $berkasCount) * 100 : 0;
                @endphp
                
                <div class="text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <canvas id="berkasChart" width="120" height="120"></canvas>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <h4 class="mb-0">{{ $berkasValid }}/{{ $berkasCount }}</h4>
                            <small class="text-muted">Valid</small>
                        </div>
                    </div>
                </div>

                <div class="progress mb-2" style="height: 10px;">
                    <div class="progress-bar {{ $persentaseValid == 100 ? 'bg-success' : ($persentaseValid >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                         style="width: {{ $persentaseValid }}%"></div>
                </div>
                <div class="text-center">
                    <small class="text-muted">{{ number_format($persentaseValid, 1) }}% berkas valid</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Detail -->
    <div class="col-md-8 mb-4">
        <!-- Data Diri Siswa -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Data Diri Siswa
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataSiswa)
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>NIK</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->tgl_lahir?->format('d/m/Y') ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Alamat</strong></td>
                                <td>: {{ $pendaftar->dataSiswa->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Wilayah</strong></td>
                                <td>
                                    : 
                                    @if($pendaftar->dataSiswa->wilayah)
                                        {{ $pendaftar->dataSiswa->wilayah->kecamatan }}, {{ $pendaftar->dataSiswa->wilayah->kelurahan }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Koordinat</strong></td>
                                <td>
                                    : 
                                    @if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng)
                                    {{ $pendaftar->dataSiswa->lat }}, {{ $pendaftar->dataSiswa->lng }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data diri siswa belum lengkap</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Data Orang Tua/Wali
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->dataOrtu)
                <div class="row">
                    <div class="col-md-6">
                        <h6>Ayah</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->hp_ayah ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Ibu</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->hp_ibu ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($pendaftar->dataOrtu->wali_nama)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>Wali</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="20%"><strong>Nama</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->wali_nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>HP</strong></td>
                                <td>: {{ $pendaftar->dataOrtu->wali_hp ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
                @else
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data orang tua belum lengkap</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Asal Sekolah -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-school me-2"></i>Data Asal Sekolah
                </h5>
            </div>
            <div class="card-body">
                @if($pendaftar->asalSekolah)
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="30%"><strong>NPSN</strong></td>
                        <td>: {{ $pendaftar->asalSekolah->npsn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Sekolah</strong></td>
                        <td>: {{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kabupaten</strong></td>
                        <td>: {{ $pendaftar->asalSekolah->kabupaten ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nilai Rata-rata</strong></td>
                        <td>: {{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</td>
                    </tr>
                </table>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <span class="text-muted">Data asal sekolah belum lengkap</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Berkas Pendaftaran -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Berkas Pendaftaran
                    </h5>
                    <span class="badge bg-{{ $berkasCount > 0 ? 'primary' : 'secondary' }}">
                        {{ $berkasCount }} Berkas
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if($berkasCount > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar->berkas as $berkas)
                            <tr>
                                <td>
                                    <strong>
                                        @php
                                            $jenisBerkas = [
                                                'IJAZAH' => 'Ijazah',
                                                'RAPOR' => 'Rapor',
                                                'KIP' => 'KIP',
                                                'KKS' => 'KKS',
                                                'AKTA' => 'Akta Lahir',
                                                'KK' => 'Kartu Keluarga',
                                                'LAINNYA' => 'Lainnya'
                                            ];
                                        @endphp
                                        {{ $jenisBerkas[$berkas->jenis] ?? $berkas->jenis }}
                                    </strong>
                                </td>
                                <td>
                                    <i class="fas fa-file-{{ pathinfo($berkas->nama_file, PATHINFO_EXTENSION) == 'pdf' ? 'pdf text-danger' : 'image text-primary' }} me-2"></i>
                                    {{ $berkas->nama_file }}
                                </td>
                                <td>{{ number_format($berkas->ukuran_kb, 0) }} KB</td>
                                <td>
                                    @if($berkas->valid)
                                    <span class="badge bg-success">Valid</span>
                                    @else
                                    <span class="badge bg-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>{{ $berkas->catatan ?? '-' }}</td>
                                <td>{{ $berkas->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ Storage::url($berkas->url) }}" target="_blank" 
                                           class="btn btn-outline-primary" title="Lihat Berkas">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ Storage::url($berkas->url) }}" download 
                                           class="btn btn-outline-success" title="Download Berkas">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Berkas</h5>
                    <p class="text-muted">Pendaftar belum mengupload berkas apapun</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline Status -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Timeline Status
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Status Pendaftaran -->
                    <div class="timeline-item completed">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">Pendaftaran</h6>
                                        <p class="card-text text-muted mb-1">Formulir pendaftaran dikirim</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $pendaftar->tanggal_daftar->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Verifikasi Administrasi -->
                    <div class="timeline-item {{ in_array($pendaftar->status, ['ADM_PASS','ADM_REJECT','PAID']) ? 'completed' : '' }} {{ $pendaftar->status === 'SUBMIT' ? 'active' : '' }}">
                        <div class="card mb-3 {{ $pendaftar->status === 'SUBMIT' ? 'border-primary' : '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 {{ $pendaftar->status === 'SUBMIT' ? 'text-primary' : '' }}">
                                            Verifikasi Administrasi
                                        </h6>
                                        <p class="card-text text-muted mb-1">
                                            @if($pendaftar->status === 'ADM_PASS')
                                            Lulus administrasi
                                            @elseif($pendaftar->status === 'ADM_REJECT')
                                            Tidak lulus administrasi
                                            @elseif($pendaftar->status === 'SUBMIT')
                                            Menunggu verifikasi
                                            @else
                                            Proses verifikasi
                                            @endif
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            @if($pendaftar->tgl_verifikasi_adm)
                                                {{ $pendaftar->tgl_verifikasi_adm->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    <div>
                                        @if(in_array($pendaftar->status, ['ADM_PASS','ADM_REJECT','PAID']))
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        @elseif($pendaftar->status === 'SUBMIT')
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        @else
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="timeline-item {{ $pendaftar->status === 'PAID' ? 'completed' : '' }} {{ $pendaftar->status === 'ADM_PASS' ? 'active' : '' }}">
                        <div class="card mb-3 {{ $pendaftar->status === 'ADM_PASS' ? 'border-primary' : '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 {{ $pendaftar->status === 'ADM_PASS' ? 'text-primary' : '' }}">
                                            Pembayaran
                                        </h6>
                                        <p class="card-text text-muted mb-1">
                                            @if($pendaftar->status === 'PAID')
                                            Pembayaran terverifikasi
                                            @elseif($pendaftar->status === 'ADM_PASS')
                                            Menunggu pembayaran
                                            @else
                                            Belum bisa pembayaran
                                            @endif
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            @if($pendaftar->tgl_verifikasi_payment)
                                                {{ $pendaftar->tgl_verifikasi_payment->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                    <div>
                                        @if($pendaftar->status === 'PAID')
                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                        @elseif($pendaftar->status === 'ADM_PASS')
                                        <i class="fas fa-spinner text-primary fa-spin fa-lg"></i>
                                        @else
                                        <i class="fas fa-clock text-muted fa-lg"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    @media print {
        .btn, .card-header .badge {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pie chart for berkas summary
        const ctx = document.getElementById('berkasChart').getContext('2d');
        const berkasValid = {{ $berkasValid }};
        const berkasTotal = {{ $berkasCount }};
        const berkasInvalid = berkasTotal - berkasValid;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Valid', 'Tidak Valid'],
                datasets: [{
                    data: [berkasValid, berkasInvalid],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush