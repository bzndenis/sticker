<div class="container my-4">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-3"><?= $total_stickers ?></h1>
                    <h5 class="card-title text-muted">Total Stiker</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-3"><?= $total_trades ?></h1>
                    <h5 class="card-title text-muted">Total Pertukaran</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h1 class="display-4 mb-3"><?= $total_collections ?></h1>
                    <h5 class="card-title text-muted">Total Koleksi</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Koleksi -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Progress Koleksi</h5>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h6 class="mb-2">Progress Keseluruhan</h6>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" 
                         style="width: <?= $collection_progress ?>%" 
                         aria-valuenow="<?= $collection_progress ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        <?= $collection_progress ?>%
                    </div>
                </div>
            </div>

            <?php if(!empty($collections)): ?>
                <?php foreach($collections as $collection): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span><?= $collection->name ?></span>
                            <small class="text-muted">
                                <?= $collection->owned ?> dari <?= $collection->total ?> stiker
                            </small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?= $collection->progress ?>%" 
                                 aria-valuenow="<?= $collection->progress ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                <?= $collection->progress ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada koleksi.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Grafik -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Statistik</h5>
                        <select id="chartPeriod" class="form-select form-select-sm" style="width: auto;">
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly" selected>Bulanan</option>
                        </select>
                    </div>
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="statsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Notifikasi</h5>
                    <?php if(!empty($notifications)): ?>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" id="markAllRead">
                                        <i class="bi bi-check-all me-2"></i>Tandai Sudah Dibaca
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" id="clearAll">
                                        <i class="bi bi-trash me-2"></i>Hapus Semua
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if(empty($notifications)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-bell text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">Tidak ada notifikasi baru</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush notification-list">
                            <?php foreach($notifications as $notif): ?>
                                <a href="<?= base_url($notif->link) ?>" 
                                   class="list-group-item list-group-item-action <?= !$notif->is_read ? 'unread' : '' ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= $notif->title ?></h6>
                                            <p class="mb-1 text-muted small"><?= $notif->message ?></p>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= time_elapsed_string($notif->created_at) ?>
                                            </small>
                                        </div>
                                        <?php if(!$notif->is_read): ?>
                                            <span class="badge bg-primary rounded-pill">Baru</span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$data['extra_js'] = "
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let statsChart;
    const ctx = document.getElementById('statsChart').getContext('2d');
    
    function updateChart(period) {
        fetch('<?= base_url('dashboard/get_chart_data') ?>?period=' + period)
            .then(response => response.json())
            .then(data => {
                if(statsChart) {
                    statsChart.destroy();
                }
                
                statsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.data.labels,
                        datasets: [{
                            label: 'Stiker Diperoleh',
                            data: data.data.stickers,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }, {
                            label: 'Pertukaran',
                            data: data.data.trades,
                            borderColor: 'rgb(54, 162, 235)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            });
    }

    // Event listener untuk perubahan periode
    document.getElementById('chartPeriod').addEventListener('change', function() {
        updateChart(this.value);
    });

    // Inisialisasi chart
    updateChart('monthly');

    // Handle notifikasi
    document.getElementById('markAllRead')?.addEventListener('click', function(e) {
        e.preventDefault();
        fetch('<?= base_url('notifications/mark_all_read') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => location.reload());
    });

    document.getElementById('clearAll')?.addEventListener('click', function(e) {
        e.preventDefault();
        if(confirm('Yakin ingin menghapus semua notifikasi?')) {
            fetch('<?= base_url('notifications/delete_all') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(() => location.reload());
        }
    });
});
</script>

<style>
.notification-list .unread {
    background-color: rgba(13, 110, 253, 0.05);
}
.notification-list .list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
.chart-container {
    min-height: 300px;
}
</style>
";
?>