

<?php $__env->startSection('title', 'Peta Sebaran Pendaftar'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Peta Sebaran Domisili</h2>
                <p class="text-muted mb-0">Visualisasi geografis calon siswa</p>
            </div>
            <div class="text-end">
                <small class="text-muted">
                    Total Data: <strong><?php echo e(count($dataMap)); ?></strong> pendaftar dengan koordinat
                </small>
            </div>
        </div>
    </div>
</div>

<?php if(count($dataMap) > 0): ?>
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-map me-2"></i>Peta Sebaran Domisili
                </h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 500px; border-radius: 8px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Agregasi per Kecamatan
                </h5>
            </div>
            <div class="card-body">
                <?php if($agregasiKecamatan->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kecamatan</th>
                                <th class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $agregasiKecamatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->kecamatan); ?></td>
                                <td class="text-end">
                                    <span class="badge bg-primary"><?php echo e($item->total); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data agregasi kecamatan</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Legenda Status -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Legenda Status
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-warning me-2">SUBMIT</span>
                        <small>Menunggu Verifikasi</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2">ADM_PASS</span>
                        <small>Lulus Administrasi</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-danger me-2">ADM_REJECT</span>
                        <small>Ditolak</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-info me-2">PAID</span>
                        <small>Sudah Bayar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Pendaftar dengan Koordinat</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Koordinat</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dataMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $statusClass = [
                                    'SUBMIT' => 'warning',
                                    'ADM_PASS' => 'success',
                                    'ADM_REJECT' => 'danger', 
                                    'PAID' => 'info'
                                ][$item['status']];
                            ?>
                            <tr>
                                <td><strong><?php echo e($item['no_pendaftaran']); ?></strong></td>
                                <td><?php echo e($item['nama']); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo e($item['jurusan']); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($item['status']); ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?></small>
                                </td>
                                <td><?php echo e(Str::limit($item['alamat'], 50)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Tampilan ketika tidak ada data -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-map-marked-alt fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">Belum Ada Data Peta</h4>
                <p class="text-muted mb-4">
                    Tidak ada data pendaftar dengan koordinat geografis yang tersedia.
                </p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi:</strong> Data peta akan muncul ketika pendaftar mengisi data domisili 
                    dengan koordinat lengkap (latitude dan longitude).
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-popup-content {
        margin: 8px 12px;
        line-height: 1.4;
    }
    .leaflet-popup-content strong {
        font-size: 1.1em;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(count($dataMap) > 0): ?>
        // Initialize map dengan koordinat default Indonesia
        const map = L.map('map').setView([-7.250445, 112.768845], 10);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add markers dengan warna berbeda berdasarkan status
        const markers = [];
        
        <?php $__currentLoopData = $dataMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $color = [
                    'SUBMIT' => 'orange',
                    'ADM_PASS' => 'green',
                    'ADM_REJECT' => 'red',
                    'PAID' => 'blue'
                ][$item['status']];
                
                $statusText = [
                    'SUBMIT' => 'Menunggu Verifikasi',
                    'ADM_PASS' => 'Lulus Administrasi',
                    'ADM_REJECT' => 'Ditolak',
                    'PAID' => 'Sudah Bayar'
                ][$item['status']];
            ?>

            // Buat custom icon berdasarkan status
            const customIcon = L.divIcon({
                html: `<div style="background-color: <?php echo e($color); ?>; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>`,
                className: 'custom-marker',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });

            const marker = L.marker([<?php echo e($item['lat']); ?>, <?php echo e($item['lng']); ?>], { icon: customIcon })
                .addTo(map)
                .bindPopup(`
                    <div style="min-width: 200px;">
                        <div class="text-center mb-2">
                            <strong><?php echo e($item['nama']); ?></strong><br>
                            <small class="text-muted"><?php echo e($item['no_pendaftaran']); ?></small>
                        </div>
                        <div class="border-top pt-2">
                            <div class="d-flex justify-content-between">
                                <span>Status:</span>
                                <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($statusText); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Jurusan:</span>
                                <strong><?php echo e($item['jurusan']); ?></strong>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted"><?php echo e($item['alamat']); ?></small>
                            </div>
                        </div>
                    </div>
                `);
            
            markers.push(marker);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // Fit map bounds to show all markers
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));

        <?php else: ?>
        // Jika tidak ada data, tampilkan pesan
        console.log('Tidak ada data koordinat untuk ditampilkan di peta.');
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.kepsek', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppdb\resources\views/kepsek/peta.blade.php ENDPATH**/ ?>