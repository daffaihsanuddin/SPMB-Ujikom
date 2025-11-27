@extends('layouts.admin')

@section('title', 'Monitoring Berkas Pendaftar')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Monitoring Berkas Pendaftar</h2>
        <p class="text-muted">Kelola dan pantau kelengkapan berkas pendaftar</p>
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Gelombang</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftar as $item)
                            <tr>
                                <td><strong>{{ $item->no_pendaftaran }}</strong></td>
                                <td>{{ $item->user->nama }}</td>
                                <td>{{ $item->jurusan->nama }}</td>
                                <td>{{ $item->gelombang->nama }}</td>
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
                                <td>
                                    @php
                                        $berkasCount = $item->berkas->count();
                                        $berkasValid = $item->berkas->where('valid', true)->count();
                                    @endphp
                                    <small>
                                        {{ $berkasValid }}/{{ $berkasCount }} Valid
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.detail-berkas', $item->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection