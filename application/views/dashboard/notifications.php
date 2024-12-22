<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/navbar'); ?>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Notifikasi</h4>
                        
                        <?php if(empty($notifications)): ?>
                            <p class="text-muted">Tidak ada notifikasi baru.</p>
                        <?php else: ?>
                            <?php foreach($notifications as $notif): ?>
                                <div class="border-bottom mb-3 pb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?= $notif->title ?></h6>
                                            <p class="mb-1"><?= $notif->message ?></p>
                                            <small class="text-muted">
                                                <?= date('d M Y H:i', strtotime($notif->created_at)) ?>
                                            </small>
                                        </div>
                                        <?php if($notif->action_url): ?>
                                            <a href="<?= base_url($notif->action_url) ?>" 
                                               class="btn btn-primary btn-sm">
                                                <?= $notif->action_text ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 