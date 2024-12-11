<div class="main-panel">
    <div class="content-wrapper">
        <!-- Statistik Umum -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $general_stats['total_users'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-account-multiple icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Pengguna</h6>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $general_stats['total_stickers'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-primary">
                                    <span class="mdi mdi-sticker-emoji icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Sticker</h6>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $general_stats['total_trades'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-info">
                                    <span class="mdi mdi-swap-horizontal icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Pertukaran</h6>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $general_stats['success_trades'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-check-circle icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Pertukaran Berhasil</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Pertukaran</h4>
                        <div class="btn-group mb-3" role="group">
                            <button type="button" class="btn btn-outline-secondary active" 
                                    onclick="updateChart('trades', 'weekly')">Mingguan</button>
                            <button type="button" class="btn btn-outline-secondary" 
                                    onclick="updateChart('trades', 'monthly')">Bulanan</button>
                        </div>
                        <canvas id="tradeChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Kategori</h4>
                        <canvas id="categoryChart" style="height: 250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Users & Stickers -->
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Top Kolektor</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Total Sticker</th>
                                        <th>Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($top_collectors as $collector): ?>
                                    <tr>
                                        <td><?= $collector->username ?></td>
                                        <td><?= $collector->total_stickers ?></td>
                                        <td><?= date('d M Y', strtotime($collector->created_at)) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sticker Terpopuler</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Kategori</th>
                                        <th>Total Dimiliki</th>
                                        <th>Total Trade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($popular_stickers as $sticker): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                                 alt="<?= $sticker->name ?>" style="width: 30px">
                                            <?= $sticker->name ?>
                                        </td>
                                        <td><?= $sticker->category_name ?></td>
                                        <td><?= $sticker->total_owned ?></td>
                                        <td><?= $sticker->total_trades ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Report -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Export Laporan</h4>
                        <form action="<?= base_url('admin/statistics/export_report') ?>" method="get" class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="mdi mdi-file-pdf"></i> Export PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Inisialisasi chart
let tradeChart, categoryChart;

$(document).ready(function() {
    // Chart pertukaran
    const tradeCtx = document.getElementById('tradeChart').getContext('2d');
    tradeChart = new Chart(tradeCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Pertukaran',
                data: [],
                borderColor: '#4B49AC',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    
    // Chart kategori
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($category_stats, 'name')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($category_stats, 'total_stickers')) ?>,
                backgroundColor: [
                    '#4B49AC', '#FFC100', '#248AFD', '#FF4747', '#57B657'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    
    // Load data awal
    updateChart('trades', 'weekly');
});

function updateChart(type, period) {
    $.ajax({
        url: '<?= base_url("admin/statistics/get_chart_data") ?>',
        type: 'GET',
        data: { type: type, period: period },
        success: function(response) {
            const data = JSON.parse(response);
            
            if (type === 'trades') {
                tradeChart.data.labels = data.labels;
                tradeChart.data.datasets[0].data = data.values;
                tradeChart.update();
                
                // Update active button
                $('.btn-group .btn').removeClass('active');
                $(`.btn-group .btn:contains('${period === 'weekly' ? 'Mingguan' : 'Bulanan'}')`).addClass('active');
            }
        }
    });
}
</script> 