@extends('layouts.admin')

@section('title', 'Master Data - Gelombang')
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Master Data Gelombang</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGelombangModal">
                    <i class="fas fa-plus me-2"></i>Tambah Gelombang
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
                                    <th>Nama Gelombang</th>
                                    <th>Tahun</th>
                                    <th>Periode</th>
                                    <th>Biaya Pendaftaran</th>
                                    <th>Status</th>
                                    <th>Pendaftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gelombang as $item)
                                    @php
                                        $today = now();
                                        $status = '';
                                        $badgeClass = '';
                                        $tooltip = '';

                                        if ($today < $item->tgl_mulai) {
                                            $status = 'Akan Datang';
                                            $badgeClass = 'bg-info';
                                            $tooltip = 'Mulai: ' . $item->tgl_mulai->format('d/m/Y');
                                        } elseif ($today >= $item->tgl_mulai && $today <= $item->tgl_selesai) {
                                            $status = 'Aktif';
                                            $badgeClass = 'bg-success';
                                            $tooltip = 'Berakhir: ' . $item->tgl_selesai->format('d/m/Y');
                                        } else {
                                            $status = 'Selesai';
                                            $badgeClass = 'bg-secondary';
                                            $tooltip = 'Telah berakhir';
                                        }

                                        $sisaHari = $today->diffInDays($item->tgl_selesai, false);
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $item->nama }}</strong>
                                            @if($status === 'Aktif' && $sisaHari <= 7)
                                                <span class="badge bg-warning ms-1" title="Hampir berakhir">
                                                    <i class="fas fa-clock me-1"></i>{{ $sisaHari }} hari
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>
                                            {{ $item->tgl_mulai->format('d/m/Y') }} -
                                            {{ $item->tgl_selesai->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">
                                                ({{ $item->tgl_mulai->diffInDays($item->tgl_selesai) + 1 }} hari)
                                            </small>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($item->biaya_daftar, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge {{ $badgeClass }}" title="{{ $tooltip }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="badge bg-{{ $item->pendaftar_count > 0 ? 'primary' : 'secondary' }} me-2">
                                                    {{ $item->pendaftar_count }}
                                                </span>
                                                <small class="text-muted">orang</small>
                                            </div>
                                            @if($item->pendaftar_count > 0)
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        @php
                                                            $statusCounts = [
                                                                'SUBMIT' => $item->pendaftar->where('status', 'SUBMIT')->count(),
                                                                'ADM_PASS' => $item->pendaftar->where('status', 'ADM_PASS')->count(),
                                                                'PAID' => $item->pendaftar->where('status', 'PAID')->count(),
                                                            ];
                                                        @endphp
                                                        <span class="badge bg-warning"
                                                            title="Menunggu verifikasi">{{ $statusCounts['SUBMIT'] }}</span>
                                                        <span class="badge bg-success"
                                                            title="Lulus administrasi">{{ $statusCounts['ADM_PASS'] }}</span>
                                                        <span class="badge bg-info"
                                                            title="Sudah bayar">{{ $statusCounts['PAID'] }}</span>
                                                    </small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editGelombangModal" data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama }}" data-tahun="{{ $item->tahun }}"
                                                    data-tgl_mulai="{{ $item->tgl_mulai->format('Y-m-d') }}"
                                                    data-tgl_selesai="{{ $item->tgl_selesai->format('Y-m-d') }}"
                                                    data-biaya_daftar="{{ $item->biaya_daftar }}" title="Edit Gelombang">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                @if($item->pendaftar_count == 0)
                                                    <form action="{{ route('admin.gelombang.destroy', $item->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Hapus gelombang {{ $item->nama }}?')"
                                                            title="Hapus Gelombang">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary" disabled
                                                        title="Tidak dapat menghapus gelombang yang sudah memiliki pendaftar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($gelombang->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data gelombang</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahGelombangModal">
                                <i class="fas fa-plus me-2"></i>Tambah Gelombang Pertama
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Gelombang -->
    <div class="modal fade" id="tambahGelombangModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.gelombang.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Gelombang Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Gelombang <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required maxlength="50"
                                    placeholder="Contoh: Gelombang 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="tahun" name="tahun" required min="2024"
                                    max="2030" value="{{ date('Y') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tgl_selesai" class="form-label">Tanggal Selesai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="biaya_daftar" class="form-label">Biaya Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="biaya_daftar" name="biaya_daftar" required
                                    min="0" step="5000" placeholder="200000">
                            </div>
                            <div class="form-text">Biaya dalam Rupiah</div>
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

    <!-- Modal Edit Gelombang -->
    <div class="modal fade" id="editGelombangModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editGelombangForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Gelombang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama" class="form-label">Nama Gelombang</label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required maxlength="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="edit_tahun" name="tahun" required min="2024"
                                    max="2030">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="edit_tgl_mulai" name="tgl_mulai" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tgl_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="edit_tgl_selesai" name="tgl_selesai" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_biaya_daftar" class="form-label">Biaya Pendaftaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="edit_biaya_daftar" name="biaya_daftar"
                                    required min="0" step="5000">
                            </div>
                            <div class="form-text">
                                <span id="currentPendaftar"></span> pendaftar pada gelombang ini
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
        document.addEventListener('DOMContentLoaded', function () {
            // Set default dates for tambah modal
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_mulai').value = today;

            // Set end date to 3 months from now
            const endDate = new Date();
            endDate.setMonth(endDate.getMonth() + 3);
            document.getElementById('tgl_selesai').value = endDate.toISOString().split('T')[0];

            // Edit modal functionality
            const editModal = document.getElementById('editGelombangModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const tahun = button.getAttribute('data-tahun');
                const tgl_mulai = button.getAttribute('data-tgl_mulai');
                const tgl_selesai = button.getAttribute('data-tgl_selesai');
                const biaya_daftar = button.getAttribute('data-biaya_daftar');
                const pendaftarCount = button.closest('tr').querySelector('.badge.bg-primary, .badge.bg-secondary').textContent;

                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_tahun').value = tahun;
                document.getElementById('edit_tgl_mulai').value = tgl_mulai;
                document.getElementById('edit_tgl_selesai').value = tgl_selesai;
                document.getElementById('edit_biaya_daftar').value = biaya_daftar;
                document.getElementById('currentPendaftar').textContent = pendaftarCount;

                document.getElementById('editGelombangForm').action = '/admin/gelombang/' + id;
            });

            // Date validation
            const tglMulai = document.getElementById('tgl_mulai');
            const tglSelesai = document.getElementById('tgl_selesai');
            const editTglMulai = document.getElementById('edit_tgl_mulai');
            const editTglSelesai = document.getElementById('edit_tgl_selesai');

            function validateDates(startField, endField) {
                if (startField.value && endField.value) {
                    const startDate = new Date(startField.value);
                    const endDate = new Date(endField.value);

                    if (endDate <= startDate) {
                        endField.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
                    } else {
                        endField.setCustomValidity('');
                    }
                }
            }

            tglMulai.addEventListener('change', () => validateDates(tglMulai, tglSelesai));
            tglSelesai.addEventListener('change', () => validateDates(tglMulai, tglSelesai));
            editTglMulai.addEventListener('change', () => validateDates(editTglMulai, editTglSelesai));
            editTglSelesai.addEventListener('change', () => validateDates(editTglMulai, editTglSelesai));
        });
    </script>
@endpush