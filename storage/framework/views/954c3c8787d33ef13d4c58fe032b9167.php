

<?php $__env->startSection('title', 'Peta Sebaran Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2>Peta Sebaran Domisili Pendaftar</h2>
                    <p class="text-muted">Visualisasi geografis domisili calon siswa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cari Nama atau Alamat</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchMap"
                                    placeholder="Cari nama pendaftar atau alamat...">
                                <button class="btn btn-outline-secondary" type="button" onclick="clearMapSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Filter Jurusan</label>
                            <select class="form-select" id="filterJurusan" onchange="filterMap()">
                                <option value="">Semua Jurusan</option>
                                <?php $__currentLoopData = $jurusanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($jurusan); ?>"><?php echo e($jurusan); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Filter Status</label>
                            <select class="form-select" id="filterStatus" onchange="filterMap()">
                                <option value="">Semua Status</option>
                                <option value="SUBMIT">Menunggu Verifikasi</option>
                                <option value="ADM_PASS">Lulus Administrasi</option>
                                <option value="ADM_REJECT">Ditolak</option>
                                <option value="PAID">Sudah Bayar</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="button" class="btn btn-outline-primary" onclick="resetMapFilters()">
                                    <i class="fas fa-refresh"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2" id="totalMarkers"><?php echo e(count($dataMap)); ?></span>
                                    <small class="text-muted">Total Pendaftar</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2" id="visibleMarkers"><?php echo e(count($dataMap)); ?></span>
                                    <small class="text-muted">Tampil di Peta</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2" id="clusterCount">0</span>
                                    <small class="text-muted">Cluster</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Map Section -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Peta Interaktif</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-layer-group me-1"></i> Layer
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="changeMapLayer('standard')">Standard</a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeMapLayer('satellite')">Satellite</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="changeMapLayer('dark')">Dark</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px; border-radius: 0 0 8px 8px;"></div>
                    <div class="p-3 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Klik marker untuk melihat detail pendaftar
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted" id="mapBoundsInfo">
                                    Menampilkan seluruh area
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4 mb-4">
            <!-- Legend -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-pin me-2"></i>Legend Peta
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-map-marker-alt text-success me-2"></i>
                            <small>Lulus Administrasi</small>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-map-marker-alt text-warning me-2"></i>
                            <small>Menunggu Verifikasi</small>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <small>Ditolak</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-info me-2"></i>
                            <small>Sudah Bayar</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>Hasil Pencarian
                    </h5>
                </div>
                <div class="card-body">
                    <div id="searchResults" style="max-height: 200px; overflow-y: auto;">
                        <div class="text-center text-muted">
                            <small>Gunakan form pencarian untuk memfilter data</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-outline-primary text-start" onclick="zoomToAllMarkers()">
                            <i class="fas fa-expand me-2"></i>Zoom ke Semua Marker
                        </button>
                        <button class="btn btn-sm btn-outline-info text-start" onclick="clusterMarkers()">
                            <i class="fas fa-object-group me-2"></i>Cluster Marker
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Data Pendaftar dengan Koordinat</h5>
                        <small class="text-muted" id="tableCount">
                            Menampilkan <?php echo e(count($dataMap)); ?> data
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="mapDataTable">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Koordinat</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php $__currentLoopData = $dataMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="map-data-row" data-nama="<?php echo e(strtolower($item['nama'])); ?>"
                                        data-jurusan="<?php echo e(strtolower($item['jurusan'])); ?>" data-status="<?php echo e($item['status']); ?>"
                                        data-alamat="<?php echo e(strtolower($item['alamat'])); ?>" data-lat="<?php echo e($item['lat']); ?>"
                                        data-lng="<?php echo e($item['lng']); ?>">
                                        <td>
                                            <strong><?php echo e($item['nama']); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo e($item['jurusan']); ?></span>
                                        </td>
                                        <td>
                                            <?php
                                                $statusClass = [
                                                    'SUBMIT' => 'warning',
                                                    'ADM_PASS' => 'success',
                                                    'ADM_REJECT' => 'danger',
                                                    'PAID' => 'info'
                                                ][$item['status']];
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($item['status']); ?></span>
                                        </td>
                                        <td>
                                            <small><?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?></small>
                                        </td>
                                        <td><?php echo e(Str::limit($item['alamat'], 50)); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                onclick="zoomToMarker(<?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?>, '<?php echo e($item['nama']); ?>')">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="noMapResults" class="text-center py-4" style="display: none;">
                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                        <h6 class="text-muted">Tidak ada data ditemukan</h6>
                        <p class="text-muted">Coba ubah filter pencarian Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <style>
        .leaflet-popup-content {
            min-width: 250px;
        }

        .marker-cluster-small {
            background-color: rgba(181, 226, 140, 0.6);
        }

        .marker-cluster-small div {
            background-color: rgba(110, 204, 57, 0.6);
        }

        .highlight-marker {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .search-highlight {
            background-color: #fff3cd !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script>
        let map;
        let markers = [];
        let markerCluster;
        let currentLayer = 'standard';

        // Status color mapping
        const statusColors = {
            'SUBMIT': 'orange',
            'ADM_PASS': 'green',
            'ADM_REJECT': 'red',
            'PAID': 'blue'
        };

        // Status icons
        const statusIcons = {
            'SUBMIT': 'fa-clock',
            'ADM_PASS': 'fa-check-circle',
            'ADM_REJECT': 'fa-times-circle',
            'PAID': 'fa-money-bill-wave'
        };

        document.addEventListener('DOMContentLoaded', function () {
            initializeMap();
            initializeMarkers();
            updateStats();
        });

        function initializeMap() {
            // Initialize map
            map = L.map('map').setView([-7.250445, 112.768845], 10);

            // Add tile layer
            changeMapLayer('standard');

            // Add scale control
            L.control.scale().addTo(map);

            // Update bounds info when map moves
            map.on('moveend', function () {
                updateBoundsInfo();
            });
        }

        function changeMapLayer(layerType) {
            currentLayer = layerType;

            // Remove existing tile layer
            map.eachLayer(function (layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });

            let tileUrl, attribution;

            switch (layerType) {
                case 'satellite':
                    tileUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
                    attribution = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';
                    break;
                case 'dark':
                    tileUrl = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
                    attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>';
                    break;
                default:
                    tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                    attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            }

            L.tileLayer(tileUrl, {
                attribution: attribution,
                maxZoom: 19
            }).addTo(map);

            updateBoundsInfo();
        }

        function initializeMarkers() {
            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            // Create marker cluster group
            if (markerCluster) {
                map.removeLayer(markerCluster);
            }
            markerCluster = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 50
            });

            // Add markers from PHP data
            <?php $__currentLoopData = $dataMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                const marker<?php echo e($loop->index); ?> = L.marker([<?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?>], {
                    icon: L.divIcon({
                        className: 'custom-marker',
                        html: `<div style="background-color: ${statusColors['<?php echo e($item['status']); ?>']}; 
                                                         width: 20px; height: 20px; border-radius: 50%; 
                                                         border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>`,
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    })
                }).bindPopup(`
                                    <div class="text-center">
                                        <h6><strong><?php echo e($item['nama']); ?></strong></h6>
                                        <p class="mb-1">
                                            <i class="fas ${statusIcons['<?php echo e($item['status']); ?>']} me-1"></i>
                                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($item['status']); ?></span>
                                        </p>
                                        <p class="mb-1"><strong><?php echo e($item['jurusan']); ?></strong></p>
                                        <p class="mb-1 text-muted"><small><?php echo e($item['alamat']); ?></small></p>
                                        <hr class="my-2">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?>

                                        </small>
                                    </div>
                                `);

                markers.push(marker<?php echo e($loop->index); ?>);
                markerCluster.addLayer(marker<?php echo e($loop->index); ?>);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            // Add cluster group to map
            map.addLayer(markerCluster);

            // Fit bounds to show all markers
            if (markers.length > 0) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function filterMap() {
            const searchTerm = document.getElementById('searchMap').value.toLowerCase();
            const jurusanFilter = document.getElementById('filterJurusan').value.toLowerCase();
            const statusFilter = document.getElementById('filterStatus').value;

            let visibleCount = 0;
            const visibleMarkers = [];

            // Filter table rows and markers
            document.querySelectorAll('.map-data-row').forEach(row => {
                const nama = row.getAttribute('data-nama');
                const jurusan = row.getAttribute('data-jurusan');
                const status = row.getAttribute('data-status');
                const alamat = row.getAttribute('data-alamat');

                const matchesSearch = !searchTerm ||
                    nama.includes(searchTerm) ||
                    alamat.includes(searchTerm);
                const matchesJurusan = !jurusanFilter || jurusan.includes(jurusanFilter);
                const matchesStatus = !statusFilter || status === statusFilter;

                if (matchesSearch && matchesJurusan && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;

                    // Highlight search term in table
                    if (searchTerm) {
                        highlightTableRow(row, searchTerm);
                    } else {
                        removeTableHighlight(row);
                    }

                    // Show corresponding marker
                    const lat = parseFloat(row.getAttribute('data-lat'));
                    const lng = parseFloat(row.getAttribute('data-lng'));
                    const marker = findMarkerByCoords(lat, lng);
                    if (marker) {
                        markerCluster.addLayer(marker);
                        visibleMarkers.push(marker);
                    }
                } else {
                    row.style.display = 'none';
                    removeTableHighlight(row);

                    // Hide corresponding marker
                    const lat = parseFloat(row.getAttribute('data-lat'));
                    const lng = parseFloat(row.getAttribute('data-lng'));
                    const marker = findMarkerByCoords(lat, lng);
                    if (marker) {
                        markerCluster.removeLayer(marker);
                    }
                }
            });

            // Update UI
            updateFilterResults(visibleCount);
            updateSearchResultsList(visibleMarkers);

            // Re-cluster markers
            markerCluster.refreshClusters();
        }

        function findMarkerByCoords(lat, lng) {
            return markers.find(marker => {
                const markerLatLng = marker.getLatLng();
                return markerLatLng.lat === lat && markerLatLng.lng === lng;
            });
        }

        function highlightTableRow(row, searchTerm) {
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                const text = cell.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    cell.classList.add('search-highlight');
                } else {
                    cell.classList.remove('search-highlight');
                }
            });
        }

        function removeTableHighlight(row) {
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                cell.classList.remove('search-highlight');
            });
        }

        function updateFilterResults(visibleCount) {
            document.getElementById('visibleMarkers').textContent = visibleCount;
            document.getElementById('tableCount').textContent = `Menampilkan ${visibleCount} data`;

            const noResults = document.getElementById('noMapResults');
            const tableBody = document.getElementById('tableBody');

            if (visibleCount === 0) {
                noResults.style.display = 'block';
                tableBody.style.display = 'none';
            } else {
                noResults.style.display = 'none';
                tableBody.style.display = '';
            }
        }

        function updateSearchResultsList(visibleMarkers) {
            const resultsContainer = document.getElementById('searchResults');

            if (visibleMarkers.length === 0) {
                resultsContainer.innerHTML = `
                            <div class="text-center text-muted">
                                <small>Tidak ada hasil ditemukan</small>
                            </div>
                        `;
                return;
            }

            let html = '';
            visibleMarkers.slice(0, 5).forEach(marker => {
                const latLng = marker.getLatLng();
                const popup = marker.getPopup();
                html += `
                            <div class="border-bottom pb-2 mb-2">
                                <small><strong>${popup.getContent().match(/<h6><strong>(.*?)<\/strong><\/h6>/)[1]}</strong></small><br>
                                <small class="text-muted">${latLng.lat.toFixed(6)}, ${latLng.lng.toFixed(6)}</small>
                            </div>
                        `;
            });

            if (visibleMarkers.length > 5) {
                html += `<small class="text-muted">+${visibleMarkers.length - 5} hasil lainnya</small>`;
            }

            resultsContainer.innerHTML = html;
        }

        function clearMapSearch() {
            document.getElementById('searchMap').value = '';
            filterMap();
        }

        function resetMapFilters() {
            document.getElementById('searchMap').value = '';
            document.getElementById('filterJurusan').value = '';
            document.getElementById('filterStatus').value = '';
            filterMap();
        }

        function zoomToMarker(lat, lng, title) {
            map.setView([lat, lng], 15);

            // Find and open popup for the marker
            const marker = findMarkerByCoords(lat, lng);
            if (marker) {
                marker.openPopup();

                // Add highlight animation
                marker.getElement().classList.add('highlight-marker');
                setTimeout(() => {
                    marker.getElement().classList.remove('highlight-marker');
                }, 3000);
            }
        }

        function zoomToAllMarkers() {
            if (markers.length > 0) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function clusterMarkers() {
            // Already using clustering by default
            map.addLayer(markerCluster);
        }


        function updateStats() {
            document.getElementById('totalMarkers').textContent = markers.length;
            document.getElementById('clusterCount').textContent = markerCluster.getLayers().length;
        }

        function updateBoundsInfo() {
            const bounds = map.getBounds();
            const center = map.getCenter();
            const zoom = map.getZoom();

            document.getElementById('mapBoundsInfo').innerHTML = `
                        Zoom: ${zoom} | Center: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
                    `;
        }

        // Real-time search
        document.getElementById('searchMap').addEventListener('input', filterMap);

    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/admin/peta/sebaran.blade.php ENDPATH**/ ?>