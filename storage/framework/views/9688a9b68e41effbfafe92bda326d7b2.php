

<?php $__env->startSection('title', 'Formulir Pendaftaran'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Formulir Pendaftaran</h2>
                    <p class="text-muted mb-0">Isi data diri dengan lengkap dan benar</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('pendaftar.formulir.store')); ?>" id="pendaftaranForm">
        <?php echo csrf_field(); ?>

        <!-- Card 1: Data Diri Siswa -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Data Diri Siswa
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nik" class="form-label fw-semibold">NIK <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="nik" name="nik"
                                    value="<?php echo e(old('nik')); ?>" required maxlength="20" placeholder="Masukkan NIK">
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="nama" name="nama"
                                    value="<?php echo e(old('nama')); ?>" required maxlength="120" placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="col-md-4">
                                <label for="jk" class="form-label fw-semibold">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="jk" name="jk" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?php echo e(old('jk') == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                                    <option value="P" <?php echo e(old('jk') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="tmp_lahir" class="form-label fw-semibold">Tempat Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="tmp_lahir" name="tmp_lahir"
                                    value="<?php echo e(old('tmp_lahir')); ?>" required maxlength="60" placeholder="Kota tempat lahir">
                            </div>
                            <div class="col-md-4">
                                <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="tgl_lahir" name="tgl_lahir"
                                    value="<?php echo e(old('tgl_lahir')); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Alamat & Domisili -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Alamat & Domisili
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Kolom Kiri: Pencarian Wilayah -->
                            <div class="col-md-6">
                                <label for="searchWilayah" class="form-label fw-semibold">Wilayah Domisili <span
                                        class="text-danger">*</span></label>

                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="searchWilayah"
                                        placeholder="Cari kecamatan atau kelurahan...">
                                    <button type="button" class="btn btn-outline-secondary border-start-0"
                                        onclick="clearSearch()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <!-- Virtual Scroll Container -->
                                <div class="virtual-scroll-container" id="wilayahContainer" style="display: none;">
                                    <div class="list-group" id="wilayahList">
                                        <!-- Options will be loaded here dynamically -->
                                    </div>
                                </div>

                                <!-- Hidden input untuk menyimpan nilai terpilih -->
                                <input type="hidden" id="wilayah_id" name="wilayah_id" value="<?php echo e(old('wilayah_id')); ?>">

                                <div id="selectedWilayahInfo" class="mt-3 p-3 bg-light rounded border"
                                    style="display: none;">
                                    <small class="d-block">
                                        <strong class="text-primary">Wilayah Terpilih:</strong>
                                    </small>
                                    <small>
                                        <span id="selectedKecamatan" class="fw-semibold"></span>,
                                        <span id="selectedKelurahan" class="fw-semibold"></span> -
                                        <span id="selectedKabupaten" class="fw-semibold"></span>
                                    </small>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Alamat Lengkap -->
                            <div class="col-md-6">
                                <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="8" required
                                    placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02, Kelurahan..."><?php echo e(old('alamat')); ?></textarea>
                                <div class="form-text mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Isi alamat lengkap sesuai KTP/Kartu Keluarga
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Data Orang Tua/Wali -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>Data Orang Tua/Wali
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Data Ayah -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3 text-success">
                                    <i class="fas fa-male me-2"></i>Data Ayah
                                </h6>
                                <div class="mb-3">
                                    <label for="nama_ayah" class="form-label fw-semibold">Nama Ayah <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                                        value="<?php echo e(old('nama_ayah')); ?>" required maxlength="120"
                                        placeholder="Nama lengkap ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label fw-semibold">Pekerjaan Ayah <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                        value="<?php echo e(old('pekerjaan_ayah')); ?>" required maxlength="100"
                                        placeholder="Pekerjaan ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="hp_ayah" class="form-label fw-semibold">HP Ayah <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="hp_ayah" name="hp_ayah"
                                        value="<?php echo e(old('hp_ayah')); ?>" required maxlength="20" placeholder="Nomor HP ayah">
                                </div>
                            </div>

                            <!-- Data Ibu -->
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-3 text-success">
                                    <i class="fas fa-female me-2"></i>Data Ibu
                                </h6>
                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label fw-semibold">Nama Ibu <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu"
                                        value="<?php echo e(old('nama_ibu')); ?>" required maxlength="120"
                                        placeholder="Nama lengkap ibu">
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label fw-semibold">Pekerjaan Ibu <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                        value="<?php echo e(old('pekerjaan_ibu')); ?>" required maxlength="100"
                                        placeholder="Pekerjaan ibu">
                                </div>
                                <div class="mb-3">
                                    <label for="hp_ibu" class="form-label fw-semibold">HP Ibu <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="hp_ibu" name="hp_ibu"
                                        value="<?php echo e(old('hp_ibu')); ?>" required maxlength="20" placeholder="Nomor HP ibu">
                                </div>
                            </div>

                            <!-- Data Wali (Opsional) -->
                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3 text-secondary">
                                    <i class="fas fa-user-friends me-2"></i>Data Wali (Opsional)
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="wali_nama" class="form-label fw-semibold">Nama Wali</label>
                                        <input type="text" class="form-control" id="wali_nama" name="wali_nama"
                                            value="<?php echo e(old('wali_nama')); ?>" maxlength="120" placeholder="Nama lengkap wali">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wali_hp" class="form-label fw-semibold">HP Wali</label>
                                        <input type="text" class="form-control" id="wali_hp" name="wali_hp"
                                            value="<?php echo e(old('wali_hp')); ?>" maxlength="20" placeholder="Nomor HP wali">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Data Asal Sekolah -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-school me-2"></i>Data Asal Sekolah
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="npsn" class="form-label fw-semibold">NPSN <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="npsn" name="npsn" value="<?php echo e(old('npsn')); ?>"
                                    required maxlength="20" placeholder="Kode NPSN sekolah">
                            </div>
                            <div class="col-md-6">
                                <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah"
                                    value="<?php echo e(old('nama_sekolah')); ?>" required maxlength="150"
                                    placeholder="Nama lengkap sekolah">
                            </div>

                            <div class="col-md-6">
                                <label for="kabupaten" class="form-label fw-semibold">Kabupaten <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                    value="<?php echo e(old('kabupaten')); ?>" required maxlength="100"
                                    placeholder="Kabupaten lokasi sekolah">
                            </div>
                            <div class="col-md-6">
                                <label for="nilai_rata" class="form-label fw-semibold">Nilai Rata-rata <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="nilai_rata" name="nilai_rata"
                                    value="<?php echo e(old('nilai_rata')); ?>" step="0.01" min="0" max="100" required
                                    placeholder="0.00 - 100.00">
                                <div class="form-text mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Nilai rata-rata rapor semester 1-5
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Pilihan Pendaftaran -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Pilihan Pendaftaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jurusan_id" class="form-label fw-semibold">Jurusan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="jurusan_id" name="jurusan_id" required>
                                    <option value="">Pilih Jurusan</option>
                                    <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $kuotaTersedia = $item->kuota > 0;
                                            $statusKuota = $kuotaTersedia ? 'Tersedia' : 'Penuh';
                                            $badgeColor = $kuotaTersedia ? 'bg-success' : 'bg-danger';
                                        ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('jurusan_id') == $item->id ? 'selected' : ''); ?> <?php echo e(!$kuotaTersedia ? 'disabled' : ''); ?> data-kuota="<?php echo e($item->kuota); ?>"
                                            data-tersedia="<?php echo e($kuotaTersedia ? 'true' : 'false'); ?>">
                                            <?php echo e($item->nama); ?>

                                            <span class="float-end">
                                                <span class="badge <?php echo e($badgeColor); ?>"><?php echo e($statusKuota); ?></span>
                                                (Kuota: <?php echo e($item->kuota); ?>)
                                            </span>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-text mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="info-kuota">Pilih jurusan yang diminati</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="gelombang_id" class="form-label fw-semibold">Gelombang <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="gelombang_id" name="gelombang_id" required>
                                    <option value="">Pilih Gelombang</option>
                                    <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" <?php echo e(old('gelombang_id') == $item->id ? 'selected' : ''); ?>>
                                            <?php echo e($item->nama); ?> (Rp <?php echo e(number_format($item->biaya_daftar, 0, ',', '.')); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-text mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Pilih periode gelombang pendaftaran
                                </div>
                            </div>
                        </div>

                        <!-- Alert untuk jurusan penuh -->
                        <div id="alert-kuota-penuh" class="alert alert-warning mt-3" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Jurusan yang dipilih sudah penuh. Silakan pilih jurusan lain.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 6: Submit Form -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Pastikan semua data yang diisi sudah benar.
                            Data yang sudah dikirim tidak dapat diubah.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary btn-lg me-md-3">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
            font-weight: 600;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        #selectedWilayahInfo {
            border-left: 4px solid #007bff;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .search-highlight {
            background-color: #fff3cd;
            font-weight: 600;
            padding: 1px 2px;
            border-radius: 3px;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
        }

        /* Custom scrollbar untuk select */
        .form-select {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .form-select::-webkit-scrollbar {
            width: 8px;
        }

        .form-select::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }

        .form-select::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .form-select::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .btn-lg {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .me-md-3 {
                margin-right: 0 !important;
            }
        }

        /* Hover effects */
        .card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }

        /* Virtual scrolling container */
        .virtual-scroll-container {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background: white;
            z-index: 1000;
            position: relative;
        }

        .virtual-scroll-container .list-group-item {
            border: none;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            padding: 0.75rem 1rem;
            transition: background-color 0.2s ease;
        }

        .virtual-scroll-container .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .virtual-scroll-container .list-group-item.active {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        /* Styling untuk textarea alamat */
        #alamat {
            resize: vertical;
            min-height: 120px;
        }

        /* Styling untuk koordinat */
        .coordinate-inputs .form-control {
            font-size: 0.875rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        class VirtualScrollWilayah {
            constructor() {
                this.container = document.getElementById('wilayahContainer');
                this.list = document.getElementById('wilayahList');
                this.hiddenInput = document.getElementById('wilayah_id');
                this.searchInput = document.getElementById('searchWilayah');
                this.allData = <?php echo json_encode($wilayah, 15, 512) ?>; // Data dari controller
                this.filteredData = [...this.allData];
                this.itemsPerPage = 20;
                this.currentPage = 0;

                this.init();
            }

            init() {
                this.renderItems();
                this.setupEventListeners();
                this.initializeFromOldValue();
            }

            setupEventListeners() {
                this.searchInput.addEventListener('input', this.debounce((e) => {
                    this.handleSearch(e.target.value);
                }, 200));

                this.container.addEventListener('scroll', this.debounce(() => {
                    this.handleScroll();
                }, 100));

                this.searchInput.addEventListener('focus', () => {
                    this.container.style.display = 'block';
                });

                document.addEventListener('click', (e) => {
                    if (!this.container.contains(e.target) && e.target !== this.searchInput) {
                        this.container.style.display = 'none';
                    }
                });
            }

            initializeFromOldValue() {
                const oldValue = this.hiddenInput.value;
                if (oldValue) {
                    const selectedItem = this.allData.find(item => item.id == oldValue);
                    if (selectedItem) {
                        this.searchInput.value = `${selectedItem.kecamatan}, ${selectedItem.kelurahan}, ${selectedItem.kabupaten}`;
                        this.updateSelectedInfo(selectedItem.kecamatan, selectedItem.kelurahan, selectedItem.kabupaten);
                    }
                }
            }

            handleSearch(term) {
                const searchTerm = term.toLowerCase().trim();

                if (searchTerm.length === 0) {
                    this.filteredData = [...this.allData];
                } else {
                    this.filteredData = this.allData.filter(item => {
                        const kecamatanMatch = item.kecamatan.toLowerCase().includes(searchTerm);
                        const kelurahanMatch = item.kelurahan.toLowerCase().includes(searchTerm);
                        const kabupatenMatch = item.kabupaten.toLowerCase().includes(searchTerm);

                        // Gabungkan semua kriteria pencarian
                        return kecamatanMatch || kelurahanMatch || kabupatenMatch;
                    });
                }

                this.currentPage = 0;
                this.renderItems();
            }

            renderItems() {
                const startIndex = this.currentPage * this.itemsPerPage;
                const endIndex = startIndex + this.itemsPerPage;
                const itemsToShow = this.filteredData.slice(0, endIndex);

                if (itemsToShow.length === 0) {
                    this.list.innerHTML = `
                                            <div class="list-group-item text-center text-muted">
                                                <i class="fas fa-search me-2"></i>
                                                Tidak ada wilayah ditemukan
                                            </div>
                                        `;
                    return;
                }

                this.list.innerHTML = itemsToShow.map(item => `
                                        <div class="list-group-item" data-id="${item.id}" 
                                             data-kecamatan="${item.kecamatan}"
                                             data-kelurahan="${item.kelurahan}"
                                             data-kabupaten="${item.kabupaten}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong class="d-block">${this.highlightText(item.kecamatan, this.searchInput.value)}</strong>
                                                    <small class="text-muted">
                                                        ${this.highlightText(item.kelurahan, this.searchInput.value)} - 
                                                        ${this.highlightText(item.kabupaten, this.searchInput.value)}
                                                    </small>
                                                </div>
                                                <span class="badge bg-light text-dark ms-2">${item.kabupaten}</span>
                                            </div>
                                        </div>
                                    `).join('');

                // Add click handlers
                this.list.querySelectorAll('.list-group-item').forEach(item => {
                    item.addEventListener('click', () => this.selectItem(item));
                });
            }

            highlightText(text, searchTerm) {
                if (!searchTerm || searchTerm.trim() === '') return text;

                const searchLower = searchTerm.toLowerCase();
                const textLower = text.toLowerCase();

                if (textLower.includes(searchLower)) {
                    const startIndex = textLower.indexOf(searchLower);
                    const endIndex = startIndex + searchTerm.length;

                    return text.substring(0, startIndex) +
                        '<span class="search-highlight">' +
                        text.substring(startIndex, endIndex) +
                        '</span>' +
                        text.substring(endIndex);
                }

                return text;
            }

            handleScroll() {
                const { scrollTop, scrollHeight, clientHeight } = this.container;

                if (scrollTop + clientHeight >= scrollHeight - 50) {
                    this.loadMore();
                }
            }

            loadMore() {
                if ((this.currentPage + 1) * this.itemsPerPage < this.filteredData.length) {
                    this.currentPage++;
                    this.renderItems();
                }
            }

            selectItem(itemElement) {
                const id = itemElement.getAttribute('data-id');
                const kecamatan = itemElement.getAttribute('data-kecamatan');
                const kelurahan = itemElement.getAttribute('data-kelurahan');
                const kabupaten = itemElement.getAttribute('data-kabupaten');

                this.hiddenInput.value = id;
                this.searchInput.value = `${kecamatan}, ${kelurahan}, ${kabupaten}`;
                this.container.style.display = 'none';

                // Update selected info
                this.updateSelectedInfo(kecamatan, kelurahan, kabupaten);

                // Auto-fill koordinat jika kosong
                this.autoFillCoordinates(kabupaten);
            }

            updateSelectedInfo(kecamatan, kelurahan, kabupaten) {
                document.getElementById('selectedKecamatan').textContent = kecamatan;
                document.getElementById('selectedKelurahan').textContent = kelurahan;
                document.getElementById('selectedKabupaten').textContent = kabupaten;
                document.getElementById('selectedWilayahInfo').style.display = 'block';
            }

            autoFillCoordinates(kabupaten) {
                const defaultCoords = {
                    'Kota Bandung': { lat: -6.9175, lng: 107.6191 },
                    'Kabupaten Bandung': { lat: -6.9621, lng: 107.6060 },
                    'Kota Jakarta Pusat': { lat: -6.1862, lng: 106.8341 },
                    'Kota Surabaya': { lat: -7.2504, lng: 112.7688 },
                    'Kota Medan': { lat: 3.5952, lng: 98.6722 },
                    'Kota Semarang': { lat: -6.9667, lng: 110.4167 },
                    'Kota Yogyakarta': { lat: -7.7971, lng: 110.3688 },
                    'Kota Malang': { lat: -7.9666, lng: 112.6326 },
                    'Kota Denpasar': { lat: -8.6705, lng: 115.2126 },
                    'Kota Makassar': { lat: -5.1477, lng: 119.4327 }
                };

                const latInput = document.getElementById('lat');
                const lngInput = document.getElementById('lng');

                // Cari kabupaten yang cocok (partial match)
                const matchedKabupaten = Object.keys(defaultCoords).find(key =>
                    kabupaten.toLowerCase().includes(key.toLowerCase()) ||
                    key.toLowerCase().includes(kabupaten.toLowerCase())
                );

                if (matchedKabupaten && (!latInput.value || !lngInput.value)) {
                    latInput.value = defaultCoords[matchedKabupaten].lat;
                    lngInput.value = defaultCoords[matchedKabupaten].lng;

                    // Tampilkan notifikasi
                    this.showCoordinateNotification(matchedKabupaten);
                }
            }

            showCoordinateNotification(kabupaten) {
                // Hapus notifikasi sebelumnya jika ada
                const existingNotification = document.getElementById('coordinateNotification');
                if (existingNotification) {
                    existingNotification.remove();
                }

                // Buat notifikasi baru
                const notification = document.createElement('div');
                notification.id = 'coordinateNotification';
                notification.className = 'alert alert-info alert-dismissible fade show mt-2';
                notification.innerHTML = `
                                        <i class="fas fa-info-circle me-2"></i>
                                        Koordinat otomatis diisi untuk ${kabupaten}. Anda bisa mengubahnya jika diperlukan.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    `;

                // Sisipkan setelah input koordinat
                const coordinateContainer = document.querySelector('.coordinate-inputs');
                if (coordinateContainer) {
                    coordinateContainer.parentNode.insertBefore(notification, coordinateContainer.nextSibling);
                }
            }

            debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            window.wilayahSearch = new VirtualScrollWilayah();
        });

        // Clear search function
        function clearSearch() {
            const searchInput = document.getElementById('searchWilayah');
            const container = document.getElementById('wilayahContainer');
            const hiddenInput = document.getElementById('wilayah_id');
            const selectedInfo = document.getElementById('selectedWilayahInfo');

            searchInput.value = '';
            hiddenInput.value = '';
            container.style.display = 'none';
            selectedInfo.style.display = 'none';

            // Reset filtered data
            if (window.wilayahSearch) {
                window.wilayahSearch.filteredData = [...window.wilayahSearch.allData];
                window.wilayahSearch.currentPage = 0;
                window.wilayahSearch.renderItems();
            }

            searchInput.focus();
        }

        // Form validation
        document.getElementById('pendaftaranForm').addEventListener('submit', function (e) {
            const wilayahId = document.getElementById('wilayah_id').value;
            if (!wilayahId) {
                e.preventDefault();
                alert('Silakan pilih wilayah domisili terlebih dahulu.');
                document.getElementById('searchWilayah').focus();
                return false;
            }

            // Validasi tambahan
            const requiredFields = ['nik', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'alamat',
                'nama_ayah', 'pekerjaan_ayah', 'hp_ayah',
                'nama_ibu', 'pekerjaan_ibu', 'hp_ibu',
                'npsn', 'nama_sekolah', 'kabupaten', 'nilai_rata',
                'jurusan_id', 'gelombang_id'];

            for (const field of requiredFields) {
                const input = document.getElementById(field);
                if (input && !input.value.trim()) {
                    e.preventDefault();
                    const label = input.labels[0]?.textContent || field;
                    alert(`Field "${label.replace('*', '').trim()}" harus diisi.`);
                    input.focus();
                    return false;
                }
            }

            return true;
        });

        // Tambahkan event listener untuk Enter key pada search
        document.getElementById('searchWilayah').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // Pilih item pertama jika ada
                const firstItem = document.querySelector('#wilayahList .list-group-item');
                if (firstItem) {
                    firstItem.click();
                }
            }
        });

        class KuotaManager {
            constructor() {
                this.jurusanSelect = document.getElementById('jurusan_id');
                this.kuotaInfo = document.getElementById('kuotaInfo');
                this.alertJurusanPenuh = document.getElementById('alertJurusanPenuh');
                this.submitButton = document.querySelector('button[type="submit"]');

                this.init();
            }

            init() {
                this.setupEventListeners();
                this.updateKuotaInfo();
            }

            setupEventListeners() {
                this.jurusanSelect.addEventListener('change', () => {
                    this.updateKuotaInfo();
                    this.validateSelection();
                });

                // Validasi saat form submit
                document.getElementById('pendaftaranForm').addEventListener('submit', (e) => {
                    if (!this.validateBeforeSubmit()) {
                        e.preventDefault();
                    }
                });
            }

            updateKuotaInfo() {
                const selectedOption = this.jurusanSelect.options[this.jurusanSelect.selectedIndex];

                if (selectedOption.value === '') {
                    this.kuotaInfo.textContent = 'Pilih jurusan yang diminati';
                    this.alertJurusanPenuh.style.display = 'none';
                    return;
                }

                const sisaKuota = selectedOption.getAttribute('data-sisa');
                const totalKuota = selectedOption.getAttribute('data-kuota');
                const isDisabled = selectedOption.disabled;

                if (isDisabled || sisaKuota <= 0) {
                    this.kuotaInfo.innerHTML = `<span class="text-danger">Jurusan ini sudah penuh</span>`;
                    this.alertJurusanPenuh.style.display = 'block';
                } else {
                    this.kuotaInfo.innerHTML = `
                                        Sisa kuota: <strong>${sisaKuota}</strong> dari ${totalKuota} kursi
                                        ${sisaKuota <= 5 ? '<span class="text-warning">(Hampir penuh!)</span>' : ''}
                                    `;
                    this.alertJurusanPenuh.style.display = 'none';
                }
            }

            validateSelection() {
                const selectedOption = this.jurusanSelect.options[this.jurusanSelect.selectedIndex];
                const isJurusanValid = !selectedOption.disabled && selectedOption.value !== '';

                if (!isJurusanValid) {
                    this.jurusanSelect.classList.add('is-invalid');
                } else {
                    this.jurusanSelect.classList.remove('is-invalid');
                }
            }

            validateBeforeSubmit() {
                const selectedOption = this.jurusanSelect.options[this.jurusanSelect.selectedIndex];
                const isJurusanValid = !selectedOption.disabled && selectedOption.value !== '';

                if (!isJurusanValid) {
                    alert('Silakan pilih jurusan yang masih memiliki kuota tersedia.');
                    this.jurusanSelect.focus();
                    return false;
                }

                // Validasi gelombang
                const gelombangSelect = document.getElementById('gelombang_id');
                const gelombangOption = gelombangSelect.options[gelombangSelect.selectedIndex];
                const isGelombangValid = !gelombangOption.disabled && gelombangOption.value !== '';

                if (!isGelombangValid) {
                    alert('Silakan pilih gelombang yang masih aktif.');
                    gelombangSelect.focus();
                    return false;
                }

                return true;
            }
        }

        // Initialize kuota manager
        document.addEventListener('DOMContentLoaded', function () {
            window.kuotaManager = new KuotaManager();

            // Validasi awal
            window.kuotaManager.validateSelection();
        });

        // Tambahkan styling untuk option yang disabled
        const style = document.createElement('style');
        style.textContent = `
                            select option:disabled {
                                color: #dc3545;
                                background-color: #f8d7da;
                            }

                            .is-invalid {
                                border-color: #dc3545 !important;
                            }

                            .kuota-warning {
                                background-color: #fff3cd;
                                border-left: 4px solid #ffc107;
                            }

                            .kuota-danger {
                                background-color: #f8d7da;
                                border-left: 4px solid #dc3545;
                            }
                        `;
        document.head.appendChild(style);
        document.addEventListener('DOMContentLoaded', function () {
            const jurusanSelect = document.getElementById('jurusan_id');
            const gelombangSelect = document.getElementById('gelombang_id');
            const infoKuota = document.getElementById('info-kuota');
            const alertKuotaPenuh = document.getElementById('alert-kuota-penuh');
            const submitButton = document.querySelector('button[type="submit"]');

            function updateKuotaInfo() {
                const selectedOption = jurusanSelect.options[jurusanSelect.selectedIndex];
                const kuota = selectedOption.getAttribute('data-kuota');
                const tersedia = selectedOption.getAttribute('data-tersedia') === 'true';

                if (selectedOption.value && kuota !== null) {
                    if (tersedia) {
                        infoKuota.innerHTML = `<i class="fas fa-check-circle me-1 text-success"></i>Kuota tersedia: ${kuota} kursi`;
                        infoKuota.className = 'form-text mt-1 text-success';
                        alertKuotaPenuh.style.display = 'none';
                        submitButton.disabled = false;
                    } else {
                        infoKuota.innerHTML = `<i class="fas fa-times-circle me-1 text-danger"></i>Kuota penuh: ${kuota} kursi`;
                        infoKuota.className = 'form-text mt-1 text-danger';
                        alertKuotaPenuh.style.display = 'block';
                        submitButton.disabled = true;
                    }
                } else {
                    infoKuota.innerHTML = '<i class="fas fa-info-circle me-1"></i>Pilih jurusan yang diminati';
                    infoKuota.className = 'form-text mt-1';
                    alertKuotaPenuh.style.display = 'none';
                    submitButton.disabled = false;
                }
            }

            jurusanSelect.addEventListener('change', updateKuotaInfo);

            // Initialize on page load
            updateKuotaInfo();

            // Validasi form sebelum submit
            document.getElementById('pendaftaranForm').addEventListener('submit', function (e) {
                const wilayahId = document.getElementById('wilayah_id').value;
                if (!wilayahId) {
                    e.preventDefault();
                    alert('Silakan pilih wilayah domisili terlebih dahulu.');
                    document.getElementById('searchWilayah').focus();
                    return false;
                }

                // Validasi kuota jurusan
                const selectedJurusan = jurusanSelect.options[jurusanSelect.selectedIndex];
                const tersedia = selectedJurusan.getAttribute('data-tersedia') === 'true';

                if (!tersedia) {
                    e.preventDefault();
                    alert('Maaf, jurusan yang dipilih sudah penuh. Silakan pilih jurusan lain.');
                    jurusanSelect.focus();
                    return false;
                }

                // Validasi tambahan field required
                const requiredFields = ['nik', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'alamat',
                    'nama_ayah', 'pekerjaan_ayah', 'hp_ayah',
                    'nama_ibu', 'pekerjaan_ibu', 'hp_ibu',
                    'npsn', 'nama_sekolah', 'kabupaten', 'nilai_rata',
                    'jurusan_id', 'gelombang_id'];

                for (const field of requiredFields) {
                    const input = document.getElementById(field);
                    if (input && !input.value.trim()) {
                        e.preventDefault();
                        const label = input.labels[0]?.textContent || field;
                        alert(`Field "${label.replace('*', '').trim()}" harus diisi.`);
                        input.focus();
                        return false;
                    }
                }

                return true;
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.pendaftar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/pendaftar/formulir.blade.php ENDPATH**/ ?>