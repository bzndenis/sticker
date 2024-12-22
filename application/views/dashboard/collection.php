<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $collection->name ?> - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/navbar'); ?>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><?= $collection->name ?></h2>
                <p class="text-muted"><?= $collection->description ?></p>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Progress Koleksi</h5>
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?= $collection->progress ?>%">
                                <?= number_format($collection->progress, 1) ?>%
                            </div>
                        </div>
                        <p class="card-text">
                            Dimiliki: <?= $collection->owned ?> dari <?= $collection->total ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach($stickers as $sticker): ?>
                <div class="col-md-3 mb-4">
                    <div class="card <?= in_array($sticker->id, array_column($user_stickers, 'sticker_id')) ? 'border-success' : '' ?>">
                        <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                             class="card-img-top" alt="<?= $sticker->name ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $sticker->name ?></h5>
                            <p class="card-text">No. <?= $sticker->number ?></p>
                            
                            <?php if(in_array($sticker->id, array_column($user_stickers, 'sticker_id'))): ?>
                                <button class="btn btn-success btn-sm" disabled>Dimiliki</button>
                            <?php else: ?>
                                <button class="btn btn-outline-primary btn-sm">Cari Pertukaran</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 