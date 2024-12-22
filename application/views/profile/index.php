<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/header', ['title' => 'Profil Saya']); ?>

    <?php $this->load->view('templates/navbar'); ?>

    <div class="container my-4">
        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="card floating">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <?php if($user->avatar): ?>
                                <img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>" 
                                     class="rounded-circle" alt="Avatar"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                     style="width: 120px; height: 120px;">
                                    <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 class="mb-1"><?= $user->username ?></h4>
                        <p class="text-muted mb-3"><?= $user->email ?></p>
                        <div class="d-grid">
                            <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Statistik</h5>
                        <div class="row text-center g-3">
                            <div class="col-4">
                                <h4 class="mb-1"><?= number_format($stats->total_stickers) ?></h4>
                                <small class="text-muted">Stiker</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-1"><?= number_format($stats->total_trades) ?></h4>
                                <small class="text-muted">Pertukaran</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-1"><?= number_format($stats->completion_rate) ?>%</h4>
                                <small class="text-muted">Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collection Progress -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Progress Koleksi</h5>
                            <a href="<?= base_url('collection') ?>" class="btn btn-sm btn-outline-light">
                                Lihat Semua
                            </a>
                        </div>
                        
                        <?php foreach($collections as $collection): ?>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0"><?= $collection->name ?></h6>
                                    <span class="text-muted">
                                        <?= $collection->owned ?>/<?= $collection->total ?> Stiker
                                    </span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: <?= $collection->progress ?>%"
                                         aria-valuenow="<?= $collection->progress ?>" 
                                         aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Aktivitas Terbaru</h5>
                        <?php if(!empty($activities)): ?>
                            <?php foreach($activities as $activity): ?>
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="activity-icon rounded-circle bg-primary p-2">
                                        <i class="bi bi-<?= $activity->icon ?>"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1"><?= $activity->description ?></p>
                                        <small class="text-muted">
                                            <?= time_elapsed_string($activity->created_at) ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">Belum ada aktivitas</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 