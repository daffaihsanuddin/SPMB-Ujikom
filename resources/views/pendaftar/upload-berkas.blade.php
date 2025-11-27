@extends('layouts.pendaftar')

@section('title', 'Upload Berkas Pendaftaran')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Upload Berkas Pendaftaran</h2>
        <p class="text-muted">Upload berkas-berkas yang diperlukan untuk proses seleksi</p>
        
        <!-- Alert khusus untuk status ditolak -->
        @if($pendaftaran->status === 'ADM_REJECT')
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Pendaftaran Anda Ditolak!</strong> 
            @if($pendaftaran->tgl_verifikasi_adm)
                pada {{ $pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i') }}
            @endif
            @if($pendaftaran->user_verifikasi_adm)
                oleh {{ $pendaftaran->user_verifikasi_adm }}
            @endif
            <br>
            <small>Silakan perbaiki data dan berkas Anda, kemudian kirim ulang untuk verifikasi.</small>
        </div>
        @endif
    </div>
</div>

@if(!$pendaftaran)
<!-- ... kode untuk belum ada pendaftaran ... -->
@else
<div class="row">
    <!-- Informasi Pendaftaran -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pendaftaran</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td>{{ $pendaftaran->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>{{ $pendaftaran->dataSiswa->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jurusan</strong></td>
                        <td>{{ $pendaftaran->jurusan->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            <span class="badge bg-{{
                                ['SUBMIT' => 'warning', 'ADM_PASS' => 'success', 'ADM_REJECT' => 'danger', 'PAID' => 'info']
                                [$pendaftaran->status]
                            }}">
                                {{ $pendaftaran->status }}
                            </span>
                        </td>
                    </tr>
                    @if($pendaftaran->status === 'ADM_REJECT' && $pendaftaran->tgl_verifikasi_adm)
                    <tr>
                        <td><strong>Tanggal Ditolak</strong></td>
                        <td>{{ $pendaftaran->tgl_verifikasi_adm->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($pendaftaran->user_verifikasi_adm)
                    <tr>
                        <td><strong>Oleh</strong></td>
                        <td>{{ $pendaftaran->user_verifikasi_adm }}</td>
                    </tr>
                    @endif
                    @endif
                </table>

                <!-- Tombol Aksi Berdasarkan Status -->
                @if($canSubmit)
                <!-- Tombol Kirim Pertama Kali -->
                <div class="mt-3 p-3 bg-light rounded">
                    <form method="POST" action="{{ route('pendaftar.kirim-verifikator') }}" id="kirimForm">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Kirim ke Verifikator
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2 text-center">
                            <i class="fas fa-info-circle me-1"></i>
                            Pastikan semua berkas sudah lengkap dan benar
                        </small>
                    </form>
                </div>

                @elseif($canResubmit)
                <!-- Tombol Kirim Ulang (Status Ditolak) -->
                <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded">
                    <form method="POST" action="{{ route('pendaftar.kirim-verifikator') }}" id="kirimUlangForm">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-redo me-2"></i>Kirim Ulang ke Verifikator
                            </button>
                        </div>
                    </form>
                    <small class="text-warning d-block mt-2 text-center">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Periksa dan perbaiki data sebelum mengirim ulang
                    </small>
                </div>

                @elseif($isWaitingVerification)
                <!-- Sedang Menunggu Verifikasi -->
                <div class="mt-3 p-3 bg-info bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-info btn-lg" disabled>
                            <i class="fas fa-clock me-2"></i>Menunggu Verifikasi
                        </button>
                    </div>
                    <small class="text-info d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Pendaftaran sedang dalam proses verifikasi
                    </small>
                </div>

                @elseif($isVerified)
                <!-- Sudah Diverifikasi -->
                <div class="mt-3 p-3 bg-success bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check me-2"></i>Sudah Diverifikasi
                        </button>
                    </div>
                    <small class="text-success d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Pendaftaran sudah selesai diverifikasi
                    </small>
                </div>

                @else
                <!-- Belum Lengkap -->
                <div class="mt-3 p-3 bg-secondary bg-opacity-10 rounded">
                    <div class="d-grid">
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-paper-plane me-2"></i>Kirim ke Verifikator
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2 text-center">
                        <i class="fas fa-info-circle me-1"></i>
                        Lengkapi semua berkas wajib terlebih dahulu
                    </small>
                </div>
                @endif

                <!-- Info Catatan Penolakan -->
                @if($pendaftaran->status === 'ADM_REJECT')
                    @php
                        $berkasDitolak = $pendaftaran->berkas->where('valid', false)->whereNotNull('catatan');
                    @endphp
                    @if($berkasDitolak->count() > 0)
                    <div class="mt-3">
                        <h6 class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Catatan Perbaikan:</h6>
                        <div class="small text-muted">
                            <ul class="mb-0">
                                @foreach($berkasDitolak as $berkas)
                                    @if($berkas->catatan)
                                    <li><strong>{{ $berkasTypes[$berkas->jenis] ?? $berkas->jenis }}:</strong> {{ $berkas->catatan }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Panduan Upload -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Panduan Upload</h5>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <ul class="ps-3 mb-0">
                        <li>Format file: PDF, JPG, JPEG, PNG</li>
                        <li>Ukuran maksimal: 2MB per file</li>
                        <li>Pastikan file jelas dan terbaca</li>
                        <li>Upload semua berkas yang diperlukan</li>
                        <li>Berkas yang sudah divalidasi tidak dapat dihapus</li>
                        <li><strong>Jika ditolak, perbaiki berkas dan kirim ulang</strong></li>
                    </ul>
                </small>
            </div>
        </div>
    </div>

    <!-- Form Upload Berkas -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upload Berkas Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pendaftar.upload-berkas.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis" class="form-label">Jenis Berkas <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis Berkas</option>
                                @foreach($berkasTypes as $key => $value)
                                <option value="{{ $key }}" {{ old('jenis') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="berkas" class="form-label">File Berkas <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="berkas" name="berkas" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">
                                Format: PDF, JPG, JPEG, PNG (Max: 2MB)
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Upload Berkas
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Berkas yang Sudah Diupload -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Berkas yang Sudah Diupload</h5>
            </div>
            <div class="card-body">
                @if($pendaftaran->berkas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftaran->berkas as $berkas)
                            <tr>
                                <td>
                                    <strong>{{ $berkasTypes[$berkas->jenis] ?? $berkas->jenis }}</strong>
                                    @if($berkas->catatan)
                                    <br><small class="text-muted">{{ $berkas->catatan }}</small>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-file-{{ in_array(pathinfo($berkas->nama_file, PATHINFO_EXTENSION), ['pdf']) ? 'pdf' : 'image' }} me-2"></i>
                                    {{ Str::limit($berkas->nama_file, 30) }}
                                </td>
                                <td>{{ number_format($berkas->ukuran_kb, 0) }} KB</td>
                                <td>
                                    @if($berkas->valid)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Valid
                                    </span>
                                    @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                    </span>
                                    @endif
                                </td>
                                <td>{{ $berkas->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ Storage::url($berkas->url) }}" target="_blank" 
                                           class="btn btn-outline-primary" title="Lihat Berkas">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$berkas->valid)
                                        <form action="{{ route('pendaftar.upload-berkas.destroy', $berkas->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('Hapus berkas {{ $berkasTypes[$berkas->jenis] ?? $berkas->jenis }}?')" 
                                                    title="Hapus Berkas">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-outline-secondary" disabled title="Berkas sudah divalidasi">
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
                @else
                <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Belum ada berkas yang diupload</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Progress Berkas -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Progress Kelengkapan Berkas</h5>
            </div>
            <div class="card-body">
                @php
                    $requiredTypes = ['IJAZAH', 'RAPOR', 'KK', 'AKTA'];
                    $uploadedTypes = $pendaftaran->berkas->pluck('jenis')->toArray();
                    $completed = array_intersect($requiredTypes, $uploadedTypes);
                    $progress = count($requiredTypes) > 0 ? (count($completed) / count($requiredTypes)) * 100 : 0;
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Kelengkapan Berkas Wajib</span>
                        <span>{{ count($completed) }}/{{ count($requiredTypes) }}</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-warning' }}" 
                             style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                <div class="row">
                    @foreach($requiredTypes as $type)
                    <div class="col-md-6 mb-2">
                        <div class="d-flex align-items-center">
                            @if(in_array($type, $uploadedTypes))
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-success">{{ $berkasTypes[$type] ?? $type }}</span>
                            @else
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <span class="text-danger">{{ $berkasTypes[$type] ?? $type }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($progress == 100)
                    @if($pendaftaran->status === 'ADM_REJECT')
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Berkas sudah lengkap!</strong> 
                        Silakan periksa catatan perbaikan dan klik <strong>"Kirim Ulang ke Verifikator"</strong>.
                    </div>
                    @elseif($pendaftaran->status === 'SUBMIT')
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Selamat!</strong> Semua berkas wajib sudah diupload. 
                        Klik tombol <strong>"Kirim ke Verifikator"</strong> untuk melanjutkan proses.
                    </div>
                    @else
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Berkas lengkap!</strong> 
                        Pendaftaran Anda sedang dalam proses verifikasi.
                    </div>
                    @endif
                @else
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Pastikan semua berkas wajib sudah diupload sebelum mengirim ke verifikator.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ... kode JavaScript sebelumnya ...

        // SweetAlert untuk konfirmasi kirim ulang (status ditolak)
        const kirimUlangForm = document.getElementById('kirimUlangForm');
        if (kirimUlangForm) {
            kirimUlangForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Kirim Ulang ke Verifikator?',
                    html: `
                        <div class="text-start">
                            <p>Anda akan mengirim ulang pendaftaran ke verifikator dengan detail:</p>
                            <ul>
                                <li><strong>No. Pendaftaran:</strong> {{ $pendaftaran->no_pendaftaran }}</li>
                                <li><strong>Nama:</strong> {{ $pendaftaran->dataSiswa->nama ?? '-' }}</li>
                                <li><strong>Jurusan:</strong> {{ $pendaftaran->jurusan->nama }}</li>
                            </ul>
                            <p class="text-warning"><strong>Pastikan Anda sudah:</strong></p>
                            <ul class="text-warning">
                                <li>Memperbaiki data formulir jika diperlukan</li>
                                <li>Memperbaiki berkas berdasarkan catatan</li>
                                <li>Memastikan semua berkas sudah benar</li>
                            </ul>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Kirim Ulang!',
                    cancelButtonText: 'Batal',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        kirimUlangForm.submit();
                    }
                });
            });
        }
    });
</script>
@endpush