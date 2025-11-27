

<?php $__env->startSection('title', 'FAQ - Pertanyaan Umum'); ?>
<?php $__env->startSection('content'); ?>
<!-- Header Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-3">Pertanyaan Umum (FAQ)</h1>
                <p class="lead">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Search Box -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="fas fa-search fa-2x text-primary mb-3"></i>
                                    <h4 class="fw-bold">Cari Pertanyaan</h4>
                                    <p class="text-muted">Ketik kata kunci untuk menemukan jawaban yang Anda butuhkan</p>
                                </div>
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" id="faqSearch" 
                                           placeholder="Contoh: biaya pendaftaran, syarat berkas, jadwal...">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Categories -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button class="btn btn-outline-primary active filter-btn" data-filter="all">
                                Semua Kategori
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="pendaftaran">
                                Pendaftaran
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="berkas">
                                Berkas & Dokumen
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="biaya">
                                Biaya & Pembayaran
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="seleksi">
                                Seleksi & Pengumuman
                            </button>
                            <button class="btn btn-outline-primary filter-btn" data-filter="jurusan">
                                Program Jurusan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- FAQ Items -->
                <div class="accordion" id="faqAccordion">
                    <!-- Pendaftaran Category -->
                    <div class="faq-item" data-category="pendaftaran">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq1" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Bagaimana cara mendaftar di SMK BAKTI NUSANTARA 666?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pendaftaran dilakukan secara online melalui website ini dengan langkah-langkah berikut:</p>
                                    <ol>
                                        <li>Klik tombol "Daftar Sekarang" di halaman utama</li>
                                        <li>Isi formulir registrasi dengan email dan password</li>
                                        <li>Verifikasi email Anda melalui link yang dikirim</li>
                                        <li>Login ke akun dan lengkapi formulir pendaftaran</li>
                                        <li>Unggah dokumen yang diperlukan</li>
                                        <li>Submit pendaftaran dan tunggu proses verifikasi</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item" data-category="pendaftaran">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq2" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Kapan periode pendaftaran dibuka?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pendaftaran dibuka dalam beberapa gelombang:</p>
                                    <ul>
                                        <li><strong>Gelombang 1:</strong> Januari - Maret</li>
                                        <li><strong>Gelombang 2:</strong> April - Juni</li>
                                        <li><strong>Gelombang 3:</strong> Juli - September (jika kuota masih tersedia)</li>
                                    </ul>
                                    <p class="mb-0">Untuk informasi gelombang aktif saat ini, silakan cek halaman 
                                    <a href="<?php echo e(route('pendaftaran')); ?>">Informasi Pendaftaran</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Berkas & Dokumen Category -->
                    <div class="faq-item" data-category="berkas">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq3" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Apa saja dokumen yang perlu disiapkan?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Dokumen yang perlu disiapkan untuk pendaftaran:</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Dokumen Wajib:</h6>
                                            <ul>
                                                <li>Fotokopi ijazah SMP/sederajat (legalisir)</li>
                                                <li>Fotokopi rapor kelas 7-9 (legalisir)</li>
                                                <li>Fotokopi akta kelahiran</li>
                                                <li>Fotokopi Kartu Keluarga (KK)</li>
                                                <li>Pas foto 3x4 (latar merah)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Dokumen Pendukung (opsional):</h6>
                                            <ul>
                                                <li>Kartu Indonesia Pintar (KIP)</li>
                                                <li>Kartu Keluarga Sejahtera (KKS)</li>
                                                <li>Sertifikat prestasi (jika ada)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item" data-category="berkas">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq4" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Apa format file yang diterima untuk upload dokumen?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Kami menerima dokumen dalam format berikut:</p>
                                    <ul>
                                        <li><strong>PDF</strong> - Maksimal 2MB per file</li>
                                        <li><strong>JPG/JPEG</strong> - Maksimal 1MB per file</li>
                                        <li><strong>PNG</strong> - Maksimal 1MB per file</li>
                                    </ul>
                                    <p class="text-warning mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Pastikan dokumen terbaca jelas dan tidak blur.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biaya & Pembayaran Category -->
                    <div class="faq-item" data-category="biaya">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq5" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Berapa biaya pendaftaran?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Biaya pendaftaran berbeda untuk setiap gelombang:</p>
                                    <ul>
                                        <li><strong>Gelombang 1:</strong> Rp 200.000,-</li>
                                        <li><strong>Gelombang 2:</strong> Rp 250.000,-</li>
                                        <li><strong>Gelombang 3:</strong> Rp 300.000,-</li>
                                    </ul>
                                    <p class="mb-0">Biaya sudah termasuk biaya administrasi dan tes seleksi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item" data-category="biaya">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq6" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Bagaimana cara pembayaran biaya pendaftaran?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pembayaran dapat dilakukan melalui:</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Transfer Bank:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-university me-2 text-primary"></i>BCA: 123-456-7890</li>
                                                <li><i class="fas fa-university me-2 text-primary"></i>BRI: 987-654-3210</li>
                                                <li><i class="fas fa-university me-2 text-primary"></i>Mandiri: 555-888-9999</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Digital Payment:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-qrcode me-2 text-success"></i>QRIS</li>
                                                <li><i class="fas fa-mobile-alt me-2 text-info"></i>Virtual Account</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="mb-0">Setelah pembayaran, upload bukti transfer di dashboard pendaftaran.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seleksi & Pengumuman Category -->
                    <div class="faq-item" data-category="seleksi">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq7" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Bagaimana proses seleksi dilakukan?
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Proses seleksi meliputi beberapa tahap:</p>
                                    <ol>
                                        <li><strong>Seleksi Administrasi:</strong> Pemeriksaan kelengkapan dokumen</li>
                                        <li><strong>Verifikasi Pembayaran:</strong> Konfirmasi bukti pembayaran</li>
                                        <li><strong>Seleksi Akademik:</strong> Berdasarkan nilai rapor</li>
                                        <li><strong>Wawancara:</strong> Untuk mengetahui minat dan bakat</li>
                                    </ol>
                                    <p class="mb-0">Setiap tahap akan diumumkan melalui dashboard pendaftaran.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item" data-category="seleksi">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq8" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Kapan pengumuman hasil seleksi?
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pengumuman hasil seleksi akan diinformasikan:</p>
                                    <ul>
                                        <li>1-2 minggu setelah penutupan gelombang pendaftaran</li>
                                        <li>Melalui dashboard pendaftaran online</li>
                                        <li>Email pemberitahuan ke alamat email yang didaftarkan</li>
                                        <li>Website resmi sekolah</li>
                                    </ul>
                                    <p class="mb-0">Pastikan email yang didaftarkan aktif dan sering memantau dashboard.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Jurusan Category -->
                    <div class="faq-item" data-category="jurusan">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq9" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Berapa banyak jurusan yang tersedia?
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>SMK BAKTI NUSANTARA 666 menyediakan 5 program jurusan unggulan:</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li>Rekayasa Perangkat Lunak (RPL)</li>
                                                <li>Teknik Komputer Jaringan (TKJ)</li>
                                                <li>Multimedia (MM)</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li>Akuntansi (AKT)</li>
                                                <li>Pemasaran (PMS)</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="mb-0">Lihat detail setiap jurusan di halaman 
                                    <a href="<?php echo e(route('jurusan')); ?>">Program Jurusan</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item" data-category="jurusan">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq10" aria-expanded="false">
                                    <i class="fas fa-question-circle text-primary me-3"></i>
                                    Bisakah saya mengganti jurusan setelah mendaftar?
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Perubahan jurusan masih memungkinkan dengan ketentuan:</p>
                                    <ul>
                                        <li>Dilakukan sebelum batas akhir pendaftaran gelombang</li>
                                        <li>Kuota jurusan tujuan masih tersedia</li>
                                        <li>Mengajukan permohonan melalui email atau datang langsung</li>
                                        <li>Dikonfirmasi oleh panitia penerimaan</li>
                                    </ul>
                                    <p class="text-warning mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Setelah batas waktu, tidak dapat dilakukan perubahan jurusan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="text-center py-5 d-none">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ditemukan hasil pencarian</h5>
                    <p class="text-muted">Coba gunakan kata kunci yang berbeda atau 
                    <a href="<?php echo e(route('contact')); ?>">hubungi kami</a> untuk bantuan lebih lanjut.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Still Have Questions Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3 class="fw-bold mb-3">Masih Ada Pertanyaan?</h3>
                <p class="text-muted mb-4">
                    Jika Anda tidak menemukan jawaban yang dicari, jangan ragu untuk menghubungi kami. 
                    Tim support kami siap membantu Anda.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="<?php echo e(route('contact')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Hubungi Kami
                    </a>
                    <a href="tel:+622112345678" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Telepon Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    const noResults = document.getElementById('noResults');
    const accordion = document.getElementById('faqAccordion');

    // Filter by category
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            let visibleCount = 0;
            faqItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            noResults.classList.toggle('d-none', visibleCount > 0);
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
                
                // Auto expand if search term found
                if (searchTerm.length > 0) {
                    const collapseId = item.querySelector('.accordion-collapse').id;
                    const bsCollapse = new bootstrap.Collapse(document.getElementById(collapseId), {
                        toggle: false
                    });
                    bsCollapse.show();
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        noResults.classList.toggle('d-none', visibleCount > 0);
    });

    // Auto close other accordions when one is opened
    accordion.addEventListener('show.bs.collapse', function(e) {
        const allCollapses = accordion.querySelectorAll('.accordion-collapse.show');
        allCollapses.forEach(collapse => {
            if (collapse.id !== e.target.id) {
                const bsCollapse = new bootstrap.Collapse(collapse, {
                    toggle: false
                });
                bsCollapse.hide();
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/faq.blade.php ENDPATH**/ ?>