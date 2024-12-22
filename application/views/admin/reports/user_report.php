<?php 
$data['title'] = 'Laporan Pengguna';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Laporan Pengguna</h2>
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
            <table class="table table-borderless">
                <tr>
                    <td width="200">Tipe Laporan</td>
                    <td>: <?= ucwords(str_replace('_', ' ', $type)) ?></td>
                </tr>
                <?php if($type != 'collection_progress'): ?>
                    <tr>
                        <td>Periode</td>
                        <td>: <?= ucfirst($period) ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- Data Laporan -->
    <div class="card">
        <div class="card-body">
            <?php if($type == 'collection_progress'): ?>
                <!-- Progress Koleksi -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th class="text-center">Total Koleksi</th>
                                <th class="text-center">Total Stiker</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($report_data as $data): ?>
                                <tr>
                                    <td><?= $data->username ?></td>
                                    <td class="text-center"><?= $data->total_collections ?></td>
                                    <td class="text-center"><?= $data->total_stickers ?></td>
                                    <td class="text-center">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: <?= $data->progress ?>%">
                                                <?= number_format($data->progress, 1) ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Pengguna Baru/Aktif -->
                <div class="row">
                    <div class="col-md-8">
                        <canvas id="userChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach($report_data as $data): 
                                        $total += $data->total;
                                    ?>
                                        <tr>
                                            <td><?= $data->period ?></td>
                                            <td class="text-center"><?= $data->total ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-light fw-bold">
                                        <td>Total</td>
                                        <td class="text-center"><?= $total ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if($type != 'collection_progress'): ?>
<?php
$data['extra_js'] = '
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById("userChart");
new Chart(ctx, {
    type: "bar",
    data: {
        labels: ' . json_encode(array_column($report_data, 'period')) . ',
        datasets: [{
            label: "' . ucwords(str_replace('_', ' ', $type)) . '",
            data: ' . json_encode(array_column($report_data, 'total')) . ',
            backgroundColor: "rgba(13, 110, 253, 0.5)",
            borderColor: "rgb(13, 110, 253)",
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: "Grafik ' . ucwords(str_replace('_', ' ', $type)) . '"
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
?>
<?php endif; ?>

<?php $this->load->view('templates/footer', isset($data) ? $data : null); ?> 