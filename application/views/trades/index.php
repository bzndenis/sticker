<?php $this->load->view('templates/header', ['title' => 'Daftar Pertukaran']); ?>
<?php $this->load->view('templates/navbar'); ?>
<div class="container mt-4">
    <!-- Trade Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pertukaran</h5>
                    <h2 class="mb-0"><?= isset($stats->total_trades) ? $stats->total_trades : 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="mb-0"><?= isset($stats->pending_trades) ? $stats->pending_trades : 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Berhasil</h5>
                    <h2 class="mb-0"><?= isset($stats->success_trades) ? $stats->success_trades : 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Completion Rate</h5>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-info" 
                             style="width: <?= isset($stats->completion_rate) ? $stats->completion_rate : 0 ?>%">
                            <?= number_format(isset($stats->completion_rate) ? $stats->completion_rate : 0, 1) ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades List -->
    <div class="card">
        <div class="card-body">
            <?php if(empty($trades)): ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-arrow-left-right text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">Belum Ada Pertukaran</h5>
                    <p class="text-muted mb-4">
                        Mulai pertukaran stiker dengan pengguna lain
                    </p>
                    <a href="<?= base_url('feed') ?>" class="btn btn-primary">
                        <i class="bi bi-grid me-2"></i>Jelajahi Feed
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pengguna</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($trades as $trade): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($trade->created_at)) ?></td>
                                    <td>
                                        <?php 
                                        $other_user = $trade->requester_id == $this->session->userdata('user_id') 
                                            ? $trade->owner_id : $trade->requester_id;
                                        echo $other_user;
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $trade->status == 'pending' ? 'warning' : 
                                            ($trade->status == 'accepted' ? 'success' : 'danger') ?>">
                                            <?= ucfirst($trade->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('trades/view/' . $trade->id) ?>" 
                                           class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
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

<style>
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

<?php $this->load->view('templates/footer'); ?> 