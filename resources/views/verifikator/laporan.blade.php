@extends('layouts.verifikator')

@section('title', 'Laporan Verifikasi')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Laporan Verifikasi</h2>
                <p class="text-muted">Generate laporan verifikasi dalam format PDF dan Excel</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('verifikator.laporan.harian') }}" class="btn btn-outline-primary">
                    <i class="fas fa-calendar-day me-2"></i>Laporan Harian
                </a>
                <a href="{{ route('verifikator.laporan.bulanan') }}" class="btn btn-outline-info">
                    <i class="fas fa-calendar-alt me-2"></i>Laporan Bulanan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('verifikator.laporan') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ $filter['start_date'] }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ $filter['end_date'] }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select class="form-select" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusan as $jur)
                                <option value="{{ $jur->id }}" {{ $filter['jurusan_id'] == $jur->id ? 'selected' : '' }}>
                                    {{ $jur->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="ADM_PASS" {{ $filter['status'] == 'ADM_PASS' ? 'selected' : '' }}>Lulus</option>
                                <option value="ADM_REJECT" {{ $filter['status'] == 'ADM_REJECT' ? 'selected' : '' }}>Tolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filter Data
                                </button>
                                <a href="{{ route('verifikator.laporan') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-2"></i>Reset
                                </a>
                                <div class="ms-auto d-flex gap-2">
                                    <button type="button" class="btn btn-success" onclick="generatePDF()">
                                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="generateExcel()">
                                        <i class="fas fa-file-excel me-2"></i>Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-primary">{{ $stats['total'] }}</h4>
                        <p class="mb-0 small text-muted">TOTAL VERIFIKASI</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clipboard-check fa-2x text-primary opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-success">{{ $stats['lulus'] }}</h4>
                        <p class="mb-0 small text-muted">LULUS</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-success opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-danger">{{ $stats['tolak'] }}</h4>
                        <p class="mb-0 small text-muted">TOLAK</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x text-danger opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-warning">{{ $stats['menunggu'] }}</h4>
                        <p class="mb-0 small text-muted">MENUNGGU</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x text-warning opacity-75"></i>
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
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Verifikasi</h5>
                <div class="text-muted small">
                    Menampilkan {{ $pendaftar->total() }} data
                </div>
            </div>
            <div class="card-body">
                @if($pendaftar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Tanggal Verifikasi</th>
                                <th>Verifikator</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar as $item)
                            <tr>
                                <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->jurusan->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status === 'ADM_PASS' ? 'success' : 'danger' }}">
                                        {{ $item->status === 'ADM_PASS' ? 'LULUS' : 'TOLAK' }}
                                    </span>
                                </td>
                                <td>{{ $item->tgl_verifikasi_adm->format('d/m/Y H:i') }}</td>
                                <td>{{ $item->user_verifikasi_adm ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('verifikator.show', $item->id) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pendaftar->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $pendaftar->firstItem() }} - {{ $pendaftar->lastItem() }} dari {{ $pendaftar->total() }} data
                    </div>
                    <nav>
                        {{ $pendaftar->links() }}
                    </nav>
                </div>
                @endif
                @else
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Data</h5>
                    <p class="text-muted">Tidak ada data verifikasi untuk filter yang dipilih</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function generatePDF() {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("verifikator.laporan.pdf") }}';
    
    // Add filter parameters
    const params = new URLSearchParams(window.location.search);
    for (const [key, value] of params) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function generateExcel() {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("verifikator.laporan.excel") }}';
    
    // Add filter parameters
    const params = new URLSearchParams(window.location.search);
    for (const [key, value] of params) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endpush

@push('styles')
<style>
.card {
    border-radius: 10px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card.border-warning {
    border-left: 4px solid #ffc107 !important;
}

.card.border-primary {
    border-left: 4px solid #0d6efd !important;
}

.card.border-success {
    border-left: 4px solid #198754 !important;
}

.card.border-danger {
    border-left: 4px solid #dc3545 !important;
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(45deg, #218838, #1e9e8a);
}
</style>
@endpush