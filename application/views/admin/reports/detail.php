<?php $this->load->view('templates/admin_header', ['title' => 'Detail Laporan']); ?>

<div class="main-content">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Detail Laporan</h4>
                    <p class="text-muted mb-0">
                        Periode: <?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date)) ?>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light" onclick="printReport()">
                        <i class="bi bi-printer me-2"></i>Cetak
                    </button>
                    <button class="btn btn-primary" onclick="exportReport()">
                        <i class="bi bi-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary me-3">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Pengguna Baru</h6>
                            <h3 class="card-title mb-0"><?= number_format($new_users) ?></h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php $user_growth = calculate_growth($previous_users, $new_users); ?>
                        <span class="badge bg-<?= $user_growth >= 0 ? 'success' : 'danger' ?> me-2">
                            <?= $user_growth ?>%
                        </span>
                        <small class="text-muted">vs periode sebelumnya</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success me-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Total Pertukaran</h6>
                            <h3 class="card-title mb-0"><?= number_format($total_trades) ?></h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php $trade_growth = calculate_growth($previous_trades, $total_trades); ?>
                        <span class="badge bg-<?= $trade_growth >= 0 ? 'success' : 'danger' ?> me-2">
                            <?= $trade_growth ?>%
                        </span>
                        <small class="text-muted">vs periode sebelumnya</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-info me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Sukses Rate</h6>
                            <h3 class="card-title mb-0"><?= number_format($success_rate, 1) ?>%</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" style="width: <?= $success_rate ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-warning me-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Rata-rata Waktu</h6>
                            <h3 class="card-title mb-0"><?= number_format($avg_completion_time) ?> jam</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Trend Pertukaran</h5>
                        <select class="form-select" style="width: auto;" onchange="updateTradeChart(this.value)">
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>
                    <canvas id="tradeChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Status Pertukaran</h5>
                    <canvas id="statusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Categories -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Kategori Terpopuler</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th class="text-center">Total Stiker</th>
                            <th class="text-center">Total Pertukaran</th>
                            <th class="text-center">Sukses Rate</th>
                            <th class="text-end">Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($top_categories as $category): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="category-icon rounded-circle bg-primary p-2 me-2">
                                            <i class="bi bi-<?= isset($category->icon) ? $category->icon : 'collection' ?>"></i>
                                        </div>
                                        <?= $category->name ?>
                                    </div>
                                </td>
                                <td class="text-center"><?= number_format($category->sticker_count) ?></td>
                                <td class="text-center"><?= number_format($category->trade_count) ?></td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="progress me-2" style="width: 100px; height: 4px;">
                                            <div class="progress-bar" style="width: <?= $category->success_rate ?>%"></div>
                                        </div>
                                        <span><?= number_format($category->success_rate, 1) ?>%</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <?php if($category->trend > 0): ?>
                                        <i class="bi bi-arrow-up-right text-success"></i>
                                    <?php elseif($category->trend < 0): ?>
                                        <i class="bi bi-arrow-down-right text-danger"></i>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-right text-muted"></i>
                                    <?php endif; ?>
                                    <?= abs($category->trend) ?>%
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Trade Chart
const tradeCtx = document.getElementById('tradeChart').getContext('2d');
const tradeChart = new Chart(tradeCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_labels) ?>,
        datasets: [{
            label: 'Total Pertukaran',
            data: <?= json_encode($chart_data) ?>,
            borderColor: '#6366f1',
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(99, 102, 241, 0.1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Sukses', 'Pending', 'Dibatalkan'],
        datasets: [{
            data: [
                <?= $status_stats->success ?>, 
                <?= $status_stats->pending ?>, 
                <?= $status_stats->cancelled ?>
            ],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function updateTradeChart(period) {
    fetch(`<?= base_url('admin/reports/get_trade_data/') ?>${period}`)
        .then(response => response.json())
        .then(data => {
            tradeChart.data.labels = data.labels;
            tradeChart.data.datasets[0].data = data.values;
            tradeChart.update();
        });
}

function printReport() {
    window.print();
}

function exportReport() {
    window.location.href = '<?= base_url('admin/reports/export/' . $report_id) ?>';
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd;
        break-inside: avoid;
    }
}

.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
    color: white;
}

.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}
</style>

<?php $this->load->view('templates/admin_footer'); ?> 