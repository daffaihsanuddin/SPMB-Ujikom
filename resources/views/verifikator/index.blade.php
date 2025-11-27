@extends('layouts.verifikator')

@section('title', 'Verifikasi Pendaftar')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Verifikasi Pendaftar</h2>
                <p class="text-muted">Daftar pendaftar yang menunggu verifikasi administrasi</p>
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
                                <th>Tanggal Daftar</th>
                                <th>Berkas</th>
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
                                <td>{{ $item->tanggal_daftar->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $berkasCount = $item->berkas->count();
                                        $berkasValid = $item->berkas->where('valid', true)->count();
                                    @endphp
                                    <span class="badge bg-{{ $berkasCount > 0 ? 'primary' : 'secondary' }} badge-verifikasi">
                                        {{ $berkasCount }} Berkas
                                    </span>
                                    @if($berkasCount > 0)
                                    <span class="badge bg-{{ $berkasValid == $berkasCount ? 'success' : 'warning' }} badge-verifikasi">
                                        {{ $berkasValid }} Valid
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('verifikator.show', $item->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-clipboard-check me-1"></i>Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-success">Tidak Ada Pendaftar Menunggu</h5>
                                    <p class="text-muted">Semua pendaftar sudah diverifikasi</p>
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