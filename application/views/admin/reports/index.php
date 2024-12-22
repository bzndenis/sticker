<?php 
$data['title'] = 'Laporan';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <h2 class="mb-4">Laporan</h2>

    <!-- Filter Laporan -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Periode</label>
                    <select name="period" class="form-select">
                        <option value="daily" <?= $period == 'daily' ? 'selected' : '' ?>>Harian</option>
                        <option value="weekly" <?= $period == 'weekly' ? 'selected' : '' ?>>Mingguan</option>
                        <option value="monthly" <?= $period == 'monthly' ? 'selected' : '' ?>>Bulanan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="<?= $start_date ?>" max="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="<?= $end_date ?>" max="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Pengguna</h6>
                            <h2 class="mb-0"><?= $total_users ?></h2>
                        </div>
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Koleksi</h6>
                            <h2 class="mb-0"><?= $total_collections ?></h2>
                        </div>
                        <i class="bi bi-collection" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Stiker</h6>
                            <h2 class="mb-0"><?= $total_stickers ?></h2>
                        </div>
                        <i class="bi bi-images" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Pertukaran</h6>
                            <h2 class="mb-0"><?= $total_trades ?></h2>
                        </div>
                        <i class="bi bi-arrow-left-right" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Grafik Pengguna Baru -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Pengguna Baru</h5>
                    <canvas id="newUsersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Pengguna Aktif -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Pengguna Aktif</h5>
                    <canvas id="activeUsersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Pertukaran -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistik Pertukaran</h5>
                    <canvas id="tradesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Progress Koleksi -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Progress Koleksi Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Total Koleksi</th>
                                    <th>Total Stiker</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($collection_progress as $progress): ?>
                                    <tr>
                                        <td><?= $progress->username ?></td>
                                        <td><?= $progress->total_collections ?></td>
                                        <td><?= $progress->total_stickers ?></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: <?= $progress->progress ?>%">
                                                    <?= number_format($progress->progress, 1) ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$data['extra_js'] = '
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Pengguna Baru
new Chart(document.getElementById("newUsersChart"), {
    type: "line",
    data: {
        labels: '.json_encode(array_column($new_users, 'period')).',
        datasets: [{
            label: "Pengguna Baru",
            data: '.json_encode(array_column($new_users, 'total')).',
            borderColor: "rgb(75, 192, 192)",
            tension: 0.1
        }]
    }
});

// Grafik Pengguna Aktif
new Chart(document.getElementById("activeUsersChart"), {
    type: "line",
    data: {
        labels: '.json_encode(array_column($active_users, 'period')).',
        datasets: [{
            label: "Pengguna Aktif",
            data: '.json_encode(array_column($active_users, 'total')).',
            borderColor: "rgb(54, 162, 235)",
            tension: 0.1
        }]
    }
});

// Grafik Pertukaran
new Chart(document.getElementById("tradesChart"), {
    type: "bar",
    data: {
        labels: '.json_encode(array_column($trades, 'period')).',
        datasets: [{
            label: "Total",
            data: '.json_encode(array_column($trades, 'total')).',
            backgroundColor: "rgb(75, 192, 192)"
        }, {
            label: "Diterima",
            data: '.json_encode(array_column($trades, 'accepted')).',
            backgroundColor: "rgb(54, 162, 235)"
        }, {
            label: "Ditolak",
            data: '.json_encode(array_column($trades, 'rejected')).',
            backgroundColor: "rgb(255, 99, 132)"
        }]
    },
    options: {
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
</script>
';
?>

<?php $this->load->view('templates/footer', $data); ?> 