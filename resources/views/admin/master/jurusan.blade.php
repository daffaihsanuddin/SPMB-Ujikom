@extends('layouts.admin')

@section('title', 'Master Data - Jurusan')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Master Data Jurusan</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                <i class="fas fa-plus me-2"></i>Tambah Jurusan
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Jurusan</th>
                                <th>Kuota</th>
                                <th>Pendaftar</th>
                                <th>Sisa Kuota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jurusan as $item)
                            @php
                                $sisaKuota = max(0, $item->kuota - $item->pendaftar_count);
                                $persentase = $item->kuota > 0 ? round(($item->pendaftar_count / $item->kuota) * 100, 2) : 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $item->kode }}</strong></td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kuota }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->pendaftar_count > 0 ? 'primary' : 'secondary' }}">
                                        {{ $item->pendaftar_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 {{ $sisaKuota == 0 ? 'text-danger fw-bold' : '' }}">
                                            {{ $sisaKuota }}
                                        </span>
                                        @if($item->kuota > 0)
                                        <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                            <div class="progress-bar 
                                                @if($persentase >= 100) bg-danger
                                                @elseif($persentase >= 80) bg-warning
                                                @else bg-success @endif" 
                                                style="width: {{ min($persentase, 100) }}%">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editJurusanModal"
                                            data-id="{{ $item->id }}"
                                            data-kode="{{ $item->kode }}"
                                            data-nama="{{ $item->nama }}"
                                            data-kuota="{{ $item->kuota }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.jurusan.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Hapus jurusan {{ $item->nama }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($jurusan->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data jurusan</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
                        <i class="fas fa-plus me-2"></i>Tambah Jurusan Pertama
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="tambahJurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.jurusan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Jurusan</label>
                        <input type="text" class="form-control" id="kode" name="kode" required maxlength="10" 
                               placeholder="Contoh: RPL, TKJ, MM">
                        <div class="form-text">Kode unik untuk jurusan (maksimal 10 karakter)</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required maxlength="100"
                               placeholder="Contoh: Rekayasa Perangkat Lunak">
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="kuota" name="kuota" required min="1"
                               placeholder="Contoh: 50">
                        <div class="form-text">Jumlah maksimal siswa yang dapat diterima</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jurusan -->
<div class="modal fade" id="editJurusanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editJurusanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_kode" class="form-label">Kode Jurusan</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit_kuota" class="form-label">Kuota</label>
                        <input type="number" class="form-control" id="edit_kuota" name="kuota" required min="1">
                        <div class="form-text">
                            <span id="currentPendaftar"></span> pendaftar pada jurusan ini
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editJurusanModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const kode = button.getAttribute('data-kode');
            const nama = button.getAttribute('data-nama');
            const kuota = button.getAttribute('data-kuota');
            const pendaftarCount = button.closest('tr').querySelector('.badge').textContent;

            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kuota').value = kuota;
            document.getElementById('currentPendaftar').textContent = pendaftarCount;

            document.getElementById('editJurusanForm').action = '/admin/jurusan/' + id;
        });
    });
</script>
@endpush