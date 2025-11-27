

<?php $__env->startSection('title', 'Statistik Wilayah Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Statistik Wilayah Pendaftar</h2>
                    <p class="text-muted">Analisis sebaran pendaftar berdasarkan wilayah domisili</p>
                </div>
                <div>
                    <button type="button" class="btn btn-danger" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchWilayah"
                                    placeholder="Cari kecamatan atau kelurahan..." onkeyup="searchWilayah()">
                                <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Menampilkan:
                                    <span id="showingCount"><?php echo e($statistik->count()); ?></span> dari
                                    <span id="totalCount"><?php echo e($statistik->count()); ?></span> wilayah
                                </small>
                                <button class="btn btn-sm btn-outline-primary" onclick="resetFilters()">
                                    <i class="fas fa-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalWilayahCard"><?php echo e($statistik->count()); ?></h4>
                            <p class="mb-0">Total Wilayah</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalPendaftarCard"><?php echo e($statistik->sum('total')); ?></h4>
                            <p class="mb-0">Total Pendaftar</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="rataRataCard"><?php echo e(number_format($statistik->avg('total'), 1)); ?></h4>
                            <p class="mb-0">Rata-rata per Wilayah</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-bar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="wilayahTerbanyakCard"><?php echo e($statistik->max('total')); ?></h4>
                            <p class="mb-0">Wilayah Terbanyak</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <!-- Table Statistik -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Statistik per Wilayah</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sort me-1"></i> Urutkan
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="sortTable('kecamatan', 'asc')">Kecamatan
                                        A-Z</a></li>
                                <li><a class="dropdown-item" href="#" onclick="sortTable('kecamatan', 'desc')">Kecamatan
                                        Z-A</a></li>
                                <li><a class="dropdown-item" href="#" onclick="sortTable('total', 'desc')">Pendaftar
                                        Terbanyak</a></li>
                                <li><a class="dropdown-item" href="#" onclick="sortTable('total', 'asc')">Pendaftar
                                        Terkecil</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="statistikTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th data-sort="kecamatan">Kecamatan
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th data-sort="kelurahan">Kelurahan
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th class="text-end" data-sort="total">Jumlah Pendaftar
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                    </th>
                                    <th class="text-end">Persentase</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php
                                    $totalAll = $statistik->sum('total');
                                ?>
                                <?php $__currentLoopData = $statistik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="wilayah-row" data-kecamatan="<?php echo e(strtolower($item->kecamatan)); ?>"
                                        data-kelurahan="<?php echo e(strtolower($item->kelurahan)); ?>" data-total="<?php echo e($item->total); ?>">
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <strong class="kecamatan-text"><?php echo e($item->kecamatan); ?></strong>
                                        </td>
                                        <td class="kelurahan-text"><?php echo e($item->kelurahan); ?></td>
                                        <td class="text-end">
                                            <span class="badge bg-primary rounded-pill"><?php echo e($item->total); ?></span>
                                        </td>
                                        <td class="text-end">
                                            <?php
                                                $percentage = $totalAll > 0 ? ($item->total / $totalAll) * 100 : 0;
                                            ?>
                                            <?php echo e(number_format($percentage, 1)); ?>%
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                title="Lihat detail pendaftar"
                                                onclick="showWilayahDetail('<?php echo e($item->kecamatan); ?>', '<?php echo e($item->kelurahan); ?>')">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Total:</td>
                                    <td class="text-end" id="footerTotal"><?php echo e($totalAll); ?></td>
                                    <td class="text-end">100%</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- No Results Message -->
                    <div id="noResults" class="text-center py-5" style="display: none;">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada hasil ditemukan</h5>
                        <p class="text-muted">Coba dengan kata kunci lain atau reset pencarian</p>
                        <button class="btn btn-primary" onclick="clearSearch()">
                            <i class="fas fa-times me-2"></i>Reset Pencarian
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Visualisasi -->
        <div class="col-md-4 mb-4">
            <!-- Search Results Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Hasil Pencarian
                    </h5>
                </div>
                <div class="card-body">
                    <div id="searchSummary">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Wilayah ditemukan:</small>
                            <strong id="foundCount"><?php echo e($statistik->count()); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Total pendaftar:</small>
                            <strong id="foundTotal"><?php echo e($statistik->sum('total')); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Rata-rata:</small>
                            <strong id="foundAverage"><?php echo e(number_format($statistik->avg('total'), 1)); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top 5 Wilayah -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 5 Wilayah</h5>
                </div>
                <div class="card-body" id="topWilayahChart">
                    <?php $__currentLoopData = $statistik->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">
                                    <?php echo e($index + 1); ?>. <?php echo e($item->kecamatan); ?>

                                </small>
                                <small class="text-muted"><?php echo e($item->total); ?> pendaftar</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php
                                    $maxTop = $statistik->max('total');
                                    $width = $maxTop > 0 ? ($item->total / $maxTop) * 100 : 0;
                                ?>
                                <div class="progress-bar bg-<?php echo e(['primary', 'success', 'info', 'warning', 'danger'][$index]); ?>"
                                    style="width: <?php echo e($width); ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Filter Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-outline-primary text-start" onclick="quickFilter('high')">
                            <i class="fas fa-fire me-2"></i>Wilayah dengan ≥ 10 pendaftar
                        </button>
                        <button class="btn btn-sm btn-outline-success text-start" onclick="quickFilter('medium')">
                            <i class="fas fa-chart-line me-2"></i>Wilayah dengan 5-9 pendaftar
                        </button>
                        <button class="btn btn-sm btn-outline-warning text-start" onclick="quickFilter('low')">
                            <i class="fas fa-seedling me-2"></i>Wilayah dengan 1-4 pendaftar
                        </button>
                        <button class="btn btn-sm btn-outline-secondary text-start" onclick="quickFilter('zero')">
                            <i class="fas fa-times me-2"></i>Wilayah tanpa pendaftar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Wilayah -->
    <div class="modal fade" id="wilayahDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pendaftar per Wilayah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="wilayahDetailContent">
                        <!-- Content will be loaded via AJAX -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .progress {
            background-color: #e9ecef;
            border-radius: 4px;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            cursor: pointer;
        }

        .table th:hover {
            background-color: #f8f9fa;
        }

        .badge.rounded-pill {
            font-size: 0.75rem;
        }

        .highlight {
            background-color: #fff3cd !important;
        }

        .search-match {
            background-color: #d1ecf1;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        let allData = <?php echo json_encode($statistik); ?>;
        let currentSort = { column: null, direction: 'asc' };

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        // Search functionality
        function searchWilayah() {
            const searchTerm = document.getElementById('searchWilayah').value.toLowerCase().trim();
            const rows = document.querySelectorAll('.wilayah-row');
            let visibleCount = 0;
            let totalPendaftar = 0;

            rows.forEach(row => {
                const kecamatan = row.getAttribute('data-kecamatan');
                const kelurahan = row.getAttribute('data-kelurahan');
                const total = parseInt(row.getAttribute('data-total'));

                const matchKecamatan = kecamatan.includes(searchTerm);
                const matchKelurahan = kelurahan.includes(searchTerm);

                if (searchTerm === '' || matchKecamatan || matchKelurahan) {
                    row.style.display = '';
                    visibleCount++;
                    totalPendaftar += total;

                    // Highlight matching text
                    if (searchTerm !== '') {
                        highlightText(row, searchTerm);
                    } else {
                        removeHighlight(row);
                    }
                } else {
                    row.style.display = 'none';
                    removeHighlight(row);
                }
            });

            updateSearchResults(visibleCount, totalPendaftar);
            updateSummaryCards(visibleCount, totalPendaftar);
            toggleNoResults(visibleCount);
        }

        // Highlight matching text
        function highlightText(row, searchTerm) {
            const kecamatanCell = row.querySelector('.kecamatan-text');
            const kelurahanCell = row.querySelector('.kelurahan-text');

            [kecamatanCell, kelurahanCell].forEach(cell => {
                const text = cell.textContent;
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlighted = text.replace(regex, '<span class="search-match">$1</span>');
                cell.innerHTML = highlighted;
            });
        }

        // Remove highlight
        function removeHighlight(row) {
            const kecamatanCell = row.querySelector('.kecamatan-text');
            const kelurahanCell = row.querySelector('.kelurahan-text');

            [kecamatanCell, kelurahanCell].forEach(cell => {
                cell.innerHTML = cell.textContent;
            });
        }

        // Update search results summary
        function updateSearchResults(visibleCount, totalPendaftar) {
            document.getElementById('showingCount').textContent = visibleCount;
            document.getElementById('foundCount').textContent = visibleCount;
            document.getElementById('foundTotal').textContent = totalPendaftar;
            document.getElementById('footerTotal').textContent = totalPendaftar;

            const average = visibleCount > 0 ? (totalPendaftar / visibleCount).toFixed(1) : '0.0';
            document.getElementById('foundAverage').textContent = average;
        }

        // Update summary cards
        function updateSummaryCards(visibleCount, totalPendaftar) {
            document.getElementById('totalWilayahCard').textContent = visibleCount;
            document.getElementById('totalPendaftarCard').textContent = totalPendaftar;

            const average = visibleCount > 0 ? (totalPendaftar / visibleCount).toFixed(1) : '0.0';
            document.getElementById('rataRataCard').textContent = average;

            // Update max value (simplified - in real app you'd recalculate from filtered data)
            const maxPendaftar = Math.max(...Array.from(document.querySelectorAll('.wilayah-row[style=""]'))
                .map(row => parseInt(row.getAttribute('data-total'))));
            document.getElementById('wilayahTerbanyakCard').textContent =
                visibleCount > 0 ? maxPendaftar : 0;
        }

        // Toggle no results message
        function toggleNoResults(visibleCount) {
            const noResults = document.getElementById('noResults');
            const tableBody = document.getElementById('tableBody');

            if (visibleCount === 0) {
                noResults.style.display = 'block';
                tableBody.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                tableBody.style.display = '';
            }
        }

        // Clear search
        function clearSearch() {
            document.getElementById('searchWilayah').value = '';
            searchWilayah();
        }

        // Reset all filters
        function resetFilters() {
            clearSearch();
            currentSort = { column: null, direction: 'asc' };
            resetSortIcons();
        }

        // Quick filters
        function quickFilter(type) {
            const searchInput = document.getElementById('searchWilayah');

            switch (type) {
                case 'high':
                    searchInput.value = '';
                    filterByPendaftar(10, Infinity);
                    break;
                case 'medium':
                    searchInput.value = '';
                    filterByPendaftar(5, 9);
                    break;
                case 'low':
                    searchInput.value = '';
                    filterByPendaftar(1, 4);
                    break;
                case 'zero':
                    searchInput.value = '';
                    filterByPendaftar(0, 0);
                    break;
            }
        }

        // Filter by pendaftar count
        function filterByPendaftar(min, max) {
            const rows = document.querySelectorAll('.wilayah-row');
            let visibleCount = 0;
            let totalPendaftar = 0;

            rows.forEach(row => {
                const total = parseInt(row.getAttribute('data-total'));

                if (total >= min && total <= max) {
                    row.style.display = '';
                    visibleCount++;
                    totalPendaftar += total;
                    removeHighlight(row);
                } else {
                    row.style.display = 'none';
                    removeHighlight(row);
                }
            });

            updateSearchResults(visibleCount, totalPendaftar);
            updateSummaryCards(visibleCount, totalPendaftar);
            toggleNoResults(visibleCount);

            // Update search input placeholder to show active filter
            const searchInput = document.getElementById('searchWilayah');
            const filterText = min === max ?
                (min === 0 ? 'Tanpa pendaftar' : `${min} pendaftar`) :
                `${min}-${max} pendaftar`;
            searchInput.placeholder = `Filter: ${filterText} • Ketik untuk mencari...`;
        }

        // Sort table
        function sortTable(column, direction) {
            const rows = Array.from(document.querySelectorAll('.wilayah-row'));
            const tbody = document.getElementById('tableBody');

            rows.sort((a, b) => {
                let aValue, bValue;

                if (column === 'total') {
                    aValue = parseInt(a.getAttribute('data-total'));
                    bValue = parseInt(b.getAttribute('data-total'));
                } else {
                    aValue = a.getAttribute(`data-${column}`).toLowerCase();
                    bValue = b.getAttribute(`data-${column}`).toLowerCase();
                }

                if (direction === 'asc') {
                    return aValue > bValue ? 1 : -1;
                } else {
                    return aValue < bValue ? 1 : -1;
                }
            });

            // Clear and re-append sorted rows
            tbody.innerHTML = '';
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child');
                if (numberCell) {
                    numberCell.textContent = index + 1;
                }
                tbody.appendChild(row);
            });

            // Update sort icons
            updateSortIcons(column, direction);
            currentSort = { column, direction };
        }

        // Update sort icons
        function updateSortIcons(column, direction) {
            resetSortIcons();

            const header = document.querySelector(`th[data-sort="${column}"]`);
            if (header) {
                const icon = header.querySelector('i');
                icon.className = direction === 'asc' ?
                    'fas fa-sort-up ms-1 text-primary' :
                    'fas fa-sort-down ms-1 text-primary';
            }
        }

        // Reset sort icons
        function resetSortIcons() {
            document.querySelectorAll('th[data-sort] i').forEach(icon => {
                icon.className = 'fas fa-sort ms-1 text-muted';
            });
        }

        // Show wilayah detail (existing function)
        function showWilayahDetail(kecamatan, kelurahan) {
            // ... existing implementation ...
        }

        function exportToPDF() {
            const searchTerm = document.getElementById('searchWilayah').value;

            let url = '<?php echo e(route("admin.export.statistik-wilayah-pdf")); ?>';

            if (searchTerm) {
                url += '?search=' + encodeURIComponent(searchTerm);
            }

            window.open(url, '_blank');
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/peta/statistik-wilayah.blade.php ENDPATH**/ ?>