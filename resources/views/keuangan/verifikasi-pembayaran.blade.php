@extends('layouts.keuangan')

@section('title', 'Verifikasi Pembayaran')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Verifikasi Pembayaran</h2>
                <p class="text-muted">Daftar pembayaran yang menunggu verifikasi</p>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-warning fs-6 p-2">
                    <i class="fas fa-clock me-1"></i>{{ $pendaftar->total() }} Menunggu
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th>Biaya</th>
                                <th>Lulus Admin</th>
                                <th>Bukti Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftar as $item)
                            <tr>
                                <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->jurusan->nama }}</td>
                                <td>{{ $item->gelombang->nama }}</td>
                                <td>Rp {{ number_format($item->gelombang->biaya_daftar, 0, ',', '.') }}</td>
                                <td>{{ $item->tgl_verifikasi_adm?->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    @php
                                        $buktiBayar = $item->berkas->where('catatan', 'Bukti Pembayaran')->first();
                                    @endphp
                                    @if($buktiBayar)
                                    <span class="badge bg-success">Ada</span>
                                    @else
                                    <span class="badge bg-danger">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('keuangan.show-pembayaran', $item->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-clipboard-check me-1"></i>Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-success">Tidak Ada Pembayaran Menunggu</h5>
                                    <p class="text-muted">Semua pembayaran sudah diverifikasi</p>
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
                        Menampilkan {{ $pendaftar->firstItem() ?? 0 }} - {{ $pendaftar->lastItem() ?? 0 }} dari {{ $pendaftar->total() }} data
                    </div>
                    <nav>
                        {{ $pendaftar->links() }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection