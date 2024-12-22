<?php 
$data['title'] = 'Dashboard Admin';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Dashboard</h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-download me-2"></i>
                Export Laporan
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value"><?= number_format($total_users) ?></div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-collection"></i>
                </div>
                <div class="stat-value"><?= number_format($total_stickers) ?></div>
                <div class="stat-label">Total Stiker</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="stat-value"><?= number_format($total_trades) ?></div>
                <div class="stat-label">Total Pertukaran</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-activity"></i>
                </div>
                <div class="stat-value"><?= number_format($active_users) ?></div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row">
        <div class="col-md-8">
            <div class="chart-container mb-4">
                <h5 class="mb-3">Statistik Pertukaran</h5>
                <canvas id="tradesChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <h5 class="mb-3">Status Pertukaran</h5>
                <canvas id="tradeStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="admin-table">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">Aktivitas Terbaru</h5>
            <a href="<?= base_url('admin/activities') ?>" class="btn btn-sm btn-outline-light">
                Lihat Semua
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_activities as $activity): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle"></i>
                                <?= $activity->username ?>
                            </div>
                        </td>
                        <td><?= $activity->description ?></td>
                        <td><?= time_elapsed_string($activity->created_at) ?></td>
                        <td>
                            <span class="badge bg-<?= $activity->status_class ?>">
                                <?= $activity->status ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?> 