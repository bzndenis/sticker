<?php $this->load->view('templates/header', ['title' => 'Daftar Pertukaran']); ?>
<?php $this->load->view('templates/navbar'); ?>
<div class="container my-4">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary me-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Total Pertukaran</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->total_trades) ?></h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-warning me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Menunggu</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->pending_trades) ?></h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Berhasil</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->success_trades) ?></h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-info me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Completion Rate</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->completion_rate, 1) ?>%</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" style="width: <?= $stats->completion_rate ?>%"></div>
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
                                <th>Stiker Diminta</th>
                                <th>Stiker Ditawarkan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($trades as $trade): ?>
                                <?php
                                // Set status class and text
                                $status_class = '';
                                $status_text = '';
                                switch($trade->status) {
                                    case 'pending':
                                        $status_class = 'warning';
                                        $status_text = 'Menunggu';
                                        break;
                                    case 'accepted':
                                        $status_class = 'success';
                                        $status_text = 'Diterima';
                                        break;
                                    case 'rejected':
                                        $status_class = 'danger';
                                        $status_text = 'Ditolak';
                                        break;
                                }
                                ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($trade->created_at)) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('uploads/stickers/'.$trade->requested_image) ?>" 
                                                 class="rounded me-2" alt="Sticker" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div>Stiker #<?= $trade->requested_number ?></div>
                                                <small class="text-muted">
                                                    Milik <?= $trade->owner_username ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('uploads/stickers/'.$trade->offered_image) ?>" 
                                                 class="rounded me-2" alt="Sticker"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div>Stiker #<?= $trade->offered_number ?></div>
                                                <small class="text-muted">
                                                    Milik <?= $trade->requester_username ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $status_class ?>">
                                            <?= $status_text ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('trades/view/'.$trade->id) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(empty($trades)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2">Belum ada pertukaran</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
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