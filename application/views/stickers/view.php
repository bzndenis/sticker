<?php 
$data['title'] = $sticker->name;
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-4">
            <!-- Gambar Stiker -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                         class="img-fluid sticker-img mb-3" 
                         alt="<?= $sticker->name ?>">
                    <h4 class="card-title mb-1"><?= $sticker->name ?></h4>
                    <p class="text-muted mb-3">
                        Koleksi: <a href="<?= base_url('collections/view/'.$collection->id) ?>">
                            <?= $collection->name ?>
                        </a>
                    </p>
                    <?php if($ownership): ?>
                        <div class="d-grid gap-2">
                            <span class="badge bg-success mb-2">
                                Dimiliki: <?= $ownership->quantity ?>
                            </span>
                            <?php if($ownership->quantity > 1): ?>
                                <button onclick="toggleTrade(<?= $sticker->id ?>, <?= $ownership->is_for_trade ?>)" 
                                        class="btn <?= $ownership->is_for_trade ? 'btn-warning' : 'btn-outline-primary' ?>">
                                    <i class="bi bi-arrow-left-right"></i>
                                    <?= $ownership->is_for_trade ? 'Batalkan Tukar' : 'Tukarkan' ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <span class="badge bg-secondary">Belum Dimiliki</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistik -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Statistik</h5>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h2 class="mb-1"><?= $sticker->total_owners ?></h2>
                            <small class="text-muted">Total Pemilik</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h2 class="mb-1"><?= $sticker->total_trades ?></h2>
                            <small class="text-muted">Total Pertukaran</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Riwayat Pertukaran -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Pertukaran</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($trades)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-arrow-left-right text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">Belum ada riwayat pertukaran</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pemohon</th>
                                        <th>Pemilik</th>
                                        <th>Stiker Ditawarkan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($trades as $trade): ?>
                                        <tr>
                                            <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                            <td><?= $trade->requester_username ?></td>
                                            <td><?= $trade->owner_username ?></td>
                                            <td><?= $trade->offered_sticker_name ?></td>
                                            <td>
                                                <?php
                                                $status_class = [
                                                    'pending' => 'warning',
                                                    'accepted' => 'success',
                                                    'rejected' => 'danger'
                                                ];
                                                ?>
                                                <span class="badge bg-<?= $status_class[$trade->status] ?>">
                                                    <?= ucfirst($trade->status) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleTrade(id, currentStatus) {
    const action = currentStatus ? 'membatalkan penukaran' : 'menukarkan';
    if(confirm(`Apakah Anda yakin ingin ${action} stiker ini?`)) {
        window.location.href = '<?= base_url('stickers/toggle_trade/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 