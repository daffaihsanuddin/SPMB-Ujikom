{{-- resources/views/admin/siswa/hasil-seleksi.blade.php --}}
@extends('layouts.admin')

@section('title', 'Hasil Seleksi Siswa')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Hasil Seleksi Siswa</h2>
                <p class="text-muted">Daftar siswa yang sudah membayar dengan kategori lulus/tidak lulus</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.siswa.hasil-seleksi') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="kategori" class="form-label">Kategori Hasil</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                <option value="lulus" {{ request('kategori') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="tidak_lulus" {{ request('kategori') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusan as $item)
                                <option value="{{ $item->id }}" {{ request('jurusan_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="gelombang_id" class="form-label">Gelombang</label>
                            <select class="form-select" id="gelombang_id" name="gelombang_id">
                                <option value="">Semua Gelombang</option>
                                @foreach($gelombang as $item)
                                <option value="{{ $item->id }}" {{ request('gelombang_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }} ({{ $item->tahun }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="No. Pendaftaran / Nama...">
                        </div>
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.siswa.hasil-seleksi') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-1"></i>Reset
                                </a>
                                <a href="{{ route('admin.export.hasil-seleksi') }}?{{ http_build_query(request()->query()) }}" 
                                   class="btn btn-success" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $statistik['total_siswa'] }}</h4>
                        <small>Total Siswa PAID</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $statistik['lulus'] }}</h4>
                        <small>Siswa Lulus</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $statistik['tidak_lulus'] }}</h4>
                        <small>Siswa Tidak Lulus</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $statistik['persentase_lulus'] }}%</h4>
                        <small>Persentase Lulus</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-pie fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kriteria Kelulusan -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Kriteria Kelulusan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Kriteria Lulus:</h6>
                        <ul class="mb-0">
                            <li>Nilai rata-rata ≥ 75</li>
                            <li>Semua berkas valid</li>
                            <li>Status pembayaran: <span class="badge bg-info">PAID</span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Kriteria Tidak Lulus:</h6>
                        <ul class="mb-0">
                            <li>Nilai rata-rata < 75, atau</li>
                            <li>Ada berkas yang tidak valid</li>
                            <li>Status pembayaran: <span class="badge bg-info">PAID</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Siswa</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th class="text-center">Nilai Rata-rata</th>
                                <th class="text-center">Berkas Valid</th>
                                <th class="text-center">Hasil Seleksi</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $item)
                                @php
                                    $nilaiRata = $item->asalSekolah->nilai_rata ?? 0;
                                    $totalBerkas = $item->berkas->count();
                                    $berkasValid = $item->berkas->where('valid', true)->count();
                                    $semuaBerkasValid = $totalBerkas > 0 && $berkasValid === $totalBerkas;
                                    
                                    $lulus = ($nilaiRata >= 75 && $semuaBerkasValid);
                                    $hasilSeleksi = $lulus ? 'LULUS' : 'TIDAK LULUS';
                                    $badgeClass = $lulus ? 'bg-success' : 'bg-danger';
                                    
                                    $keterangan = $semuaBerkasValid ? 
                                        "Nilai: {$nilaiRata}" : 
                                        "Nilai: {$nilaiRata}, Berkas valid: {$berkasValid}/{$totalBerkas}";
                                @endphp
                                <tr>
                                    <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                    <td>{{ $item->dataSiswa->nama ?? $item->user->nama }}</td>
                                    <td>{{ $item->jurusan->nama }}</td>
                                    <td>{{ $item->gelombang->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $nilaiRata >= 75 ? 'success' : 'warning' }}">
                                            {{ $nilaiRata }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $semuaBerkasValid ? 'success' : 'danger' }}">
                                            {{ $berkasValid }}/{{ $totalBerkas }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }}">{{ $hasilSeleksi }}</span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">{{ $keterangan }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($item->tgl_verifikasi_payment)
                                            {{ $item->tgl_verifikasi_payment->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Tidak Ada Data</h5>
                                        <p class="text-muted">Tidak ada siswa yang sesuai dengan filter yang dipilih</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($siswa->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $siswa->firstItem() ?? 0 }} - {{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} data
                    </div>
                    <nav>
                        {{ $siswa->appends(request()->query())->links() }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit form ketika filter berubah
    document.addEventListener('DOMContentLoaded', function() {
        const autoSubmitFields = ['kategori', 'jurusan_id', 'gelombang_id'];
        
        autoSubmitFields.forEach(field => {
            const element = document.getElementById(field);
            if (element) {
                element.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    });
</script>
@endpush