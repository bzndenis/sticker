<?php 
$data['title'] = 'Laporan Pertukaran';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Laporan Pertukaran</h2>
        <div>
            <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary me-2">Kembali</a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Parameter Laporan -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Parameter Laporan</h5>
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-borderless">
                        <tr>
                            <td>Periode</td>
                            <td>: <?= ucfirst($period) ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td>: <?= date('d M Y', strtotime($start_date)) ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai</td>
                            <td>: <?= date('d M Y', strtotime($end_date)) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-8">
                    <canvas id="tradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Laporan -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th class="text-center">Total Pertukaran</th>
                            <th class="text-center">Diterima</th>
                            <th class="text-center">Ditolak</th>
                            <th class="text-center">Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_all = 0;
                        $total_accepted = 0;
                        $total_rejected = 0;
                        $total_pending = 0;
                        ?>
                        <?php foreach($trades as $trade): ?>
                            <?php
                            $total_all += $trade->total;
                            $total_accepted += $trade->accepted;
                            $total_rejected += $trade->rejected;
                            $total_pending += $trade->pending;
                            ?>
                            <tr>
                                <td><?= $trade->period ?></td>
                                <td class="text-center"><?= $trade->total ?></td>
                                <td class="text-center text-success"><?= $trade->accepted ?></td>
                                <td class="text-center text-danger"><?= $trade->rejected ?></td>
                                <td class="text-center text-warning"><?= $trade->pending ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-light fw-bold">
                            <td>Total</td>
                            <td class="text-center"><?= $total_all ?></td>
                            <td class="text-center text-success"><?= $total_accepted ?></td>
                            <td class="text-center text-danger"><?= $total_rejected ?></td>
                            <td class="text-center text-warning"><?= $total_pending ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$data['extra_js'] = '
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById("tradeChart");
new Chart(ctx, {
    type: "line",
    data: {
        labels: ' . json_encode(array_column($trades, 'period')) . ',
        datasets: [{
            label: "Total Pertukaran",
            data: ' . json_encode(array_column($trades, 'total')) . ',
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: "Grafik Pertukaran"
            }
        },
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
$this->load->view('templates/footer', $data); 
?> 