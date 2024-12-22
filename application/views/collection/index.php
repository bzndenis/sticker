<?php $this->load->view('templates/header', ['title' => 'Koleksi Stiker']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary me-3">
                            <i class="bi bi-collection"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Total Stiker</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->total_stickers) ?></h3>
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
                        <div class="stat-icon bg-success me-3">
                            <i class="bi bi-grid"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Stiker Unik</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->unique_stickers) ?></h3>
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
                        <div class="stat-icon bg-warning me-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Dapat Ditukar</h6>
                            <h3 class="card-title mb-0"><?= number_format($stats->tradeable_stickers) ?></h3>
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
                        <div class="stat-icon bg-info me-3">
                            <i class="bi bi-percent"></i>
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

    <!-- Collection Categories -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Koleksi Stiker</h4>
                <a href="<?= base_url('stickers/manage') ?>" class="btn btn-primary">
                    <i class="bi bi-gear-fill me-2"></i>Kelola Stiker
                </a>
            </div>

            <div class="row g-4">
                <?php foreach($collections as $collection): ?>
                    <div class="col-md-4">
                        <div class="card h-100 floating">
                            <div class="card-body">
                                <h5 class="card-title"><?= $collection->name ?></h5>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar" style="width: <?= $collection->progress ?>%"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <?= $collection->owned ?>/<?= $collection->total ?> Stiker
                                    </small>
                                    <a href="<?= base_url('stickers/category/'.$collection->id) ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-grid me-2"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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

.floating {
    transition: transform 0.3s ease;
}

.floating:hover {
    transform: translateY(-5px);
}
</style>

<?php $this->load->view('templates/footer'); ?> 