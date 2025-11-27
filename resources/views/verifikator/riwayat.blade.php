@extends('layouts.verifikator')

@section('title', 'Riwayat Verifikasi')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Riwayat Verifikasi</h2>
                    <p class="text-muted">Daftar semua pendaftar yang sudah/sedang menunggu verifikasi</p>
                </div>
                <div>
                    <a href="{{ route('verifikator.index') }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-check me-2"></i>Verifikasi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('verifikator.riwayat') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="verifikasi_status" class="form-label">Status Verifikasi</label>
                                <select class="form-select" id="verifikasi_status" name="verifikasi_status">
                                    <option value="">Semua</option>
                                    <option value="sudah" {{ request('verifikasi_status') == 'sudah' ? 'selected' : '' }}>
                                        Sudah Diverifikasi
                                    </option>
                                    <option value="belum" {{ request('verifikasi_status') == 'belum' ? 'selected' : '' }}>
                                        Belum Diverifikasi
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status Pendaftaran</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="LULUS" {{ request('status') == 'LULUS' ? 'selected' : '' }}>LULUS</option>
                                    <option value="ADM_REJECT" {{ request('status') == 'ADM_REJECT' ? 'selected' : '' }}>TOLAK
                                    </option>
                                    <option value="SUBMIT" {{ request('status') == 'SUBMIT' ? 'selected' : '' }}>MENUNGGU
                                    </option>
                                    <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>SUDAH BAYAR
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal Verifikasi</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('verifikator.riwayat') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-refresh me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $summary['total_data'] }}</h4>
                            <small>Total Data</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-database fa-2x"></i>
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
                            <h4 class="mb-0">{{ $summary['sudah_diverifikasi'] }}</h4>
                            <small>Sudah Diverifikasi</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $summary['belum_diverifikasi'] }}</h4>
                            <small>Belum Diverifikasi</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
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
                            <h4 class="mb-0">{{ $summary['lulus_administrasi'] }}</h4>
                            <small>Lulus Administrasi</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Status Pendaftaran</th>
                                    <th>Status Verifikasi</th>
                                    <th>Verifikator</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftar as $item)
                                    <tr>
                                        <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                        <td>{{ $item->user->nama }}</td>
                                        <td>{{ $item->jurusan->nama }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'SUBMIT' => 'warning',
                                                    'ADM_PASS' => 'success',
                                                    'ADM_REJECT' => 'danger',
                                                    'PAID' => 'info'
                                                ][$item->status];

                                                $statusText = [
                                                    'SUBMIT' => 'MENUNGGU',
                                                    'ADM_PASS' => 'LULUS',
                                                    'ADM_REJECT' => 'TOLAK',
                                                    'PAID' => 'SUDAH BAYAR'
                                                ][$item->status];
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->tgl_verifikasi_adm)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Sudah Diverifikasi
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>Belum Diverifikasi
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->user_verifikasi_adm ?? '-' }}</td>
                                        <td>
                                            @if($item->tgl_verifikasi_adm)
                                                {{ $item->tgl_verifikasi_adm->format('d/m/Y H:i') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <!-- Tombol Detail -->
                                                <a href="{{ route('verifikator.show.riwayat', $item->id) }}"
                                                    class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Tombol Verifikasi untuk yang belum diverifikasi -->
                                                @if(!$item->tgl_verifikasi_adm)
                                                    <a href="{{ route('verifikator.show', $item->id) }}"
                                                        class="btn btn-outline-primary" title="Verifikasi Sekarang">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak Ada Data</h5>
                                            <p class="text-muted">Tidak ada data yang sesuai dengan filter yang dipilih</p>
                                            <a href="{{ route('verifikator.riwayat') }}" class="btn btn-primary">
                                                <i class="fas fa-refresh me-2"></i>Reset Filter
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pendaftar->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $pendaftar->firstItem() ?? 0 }} - {{ $pendaftar->lastItem() ?? 0 }} dari
                                {{ $pendaftar->total() }} data
                            </div>
                            <nav>
                                {{ $pendaftar->appends(request()->query())->links() }}
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Riwayat Perubahan -->
    <div class="modal fade" id="logModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="logContent">
                        <!-- Content akan diisi via AJAX -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showLog(pendaftarId) {
            // Tampilkan loading
            document.getElementById('logContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat riwayat...</p>
                </div>
            `;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('logModal'));
            modal.show();

            // Load data via AJAX
            fetch(`/verifikator/${pendaftarId}/logs`)
                .then(response => response.json())
                .then(data => {
                    let content = '';

                    if (data.logs && data.logs.length > 0) {
                        content = `
                            <h6>Riwayat Perubahan untuk: <strong>${data.no_pendaftaran}</strong></h6>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                            <th>User</th>
                                            <th>Perubahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        data.logs.forEach(log => {
                            let perubahanInfo = '';
                            try {
                                const perubahan = JSON.parse(log.objek_data);
                                if (perubahan.status_lama && perubahan.status_baru) {
                                    perubahanInfo = `Status: ${perubahan.status_lama} → ${perubahan.status_baru}`;
                                } else if (perubahan.catatan) {
                                    perubahanInfo = `Catatan: ${perubahan.catatan}`;
                                } else {
                                    perubahanInfo = log.aksi;
                                }
                            } catch (e) {
                                perubahanInfo = log.aksi;
                            }

                            content += `
                                <tr>
                                    <td>${new Date(log.waktu).toLocaleString('id-ID')}</td>
                                    <td><span class="badge bg-info">${log.aksi}</span></td>
                                    <td>${log.user.nama}</td>
                                    <td>
                                        <small>${perubahanInfo}</small>
                                    </td>
                                </tr>
                            `;
                        });

                        content += `
                                    </tbody>
                                </table>
                            </div>
                        `;
                    } else {
                        content = `
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada riwayat perubahan</p>
                            </div>
                        `;
                    }

                    document.getElementById('logContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('logContent').innerHTML = `
                        <div class="alert alert-danger">
                            Terjadi kesalahan saat memuat data.
                        </div>
                    `;
                });
        }

        // Auto-submit filter when certain fields change
        document.addEventListener('DOMContentLoaded', function () {
            const autoSubmitFields = ['verifikasi_status', 'status', 'jurusan_id'];

            autoSubmitFields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('change', function () {
                        this.form.submit();
                    });
                }
            });
        });
    </script>
@endpush