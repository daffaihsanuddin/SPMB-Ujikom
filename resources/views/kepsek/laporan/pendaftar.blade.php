@extends('layouts.kepsek')

@section('title', 'Data Lengkap Pendaftar')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Data Lengkap Pendaftar</h2>
                    <p class="text-muted mb-0">Detail informasi semua calon siswa</p>
                </div>
                <div>
                    <!-- PERBAIKAN: Gunakan route yang benar -->
                    <a href="{{ route('kepsek.export-laporan-pendaftar') }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </a>
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
                            <thead class="table-dark">
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Gelombang</th>
                                    <th>Asal Sekolah</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Nilai Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendaftar as $item)
                                    <tr>
                                        <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                        <td>{{ $item->user->nama }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->jurusan->nama }}</span>
                                        </td>
                                        <td>{{ $item->gelombang->nama }}</td>
                                        <td>
                                            @if($item->asalSekolah)
                                                {{ Str::limit($item->asalSekolah->nama_sekolah, 25) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tanggal_daftar->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'SUBMIT' => 'warning',
                                                    'ADM_PASS' => 'success',
                                                    'ADM_REJECT' => 'danger',
                                                    'PAID' => 'info'
                                                ][$item->status];
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->asalSekolah)
                                                <strong>{{ $item->asalSekolah->nilai_rata }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pendaftar->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pendaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection