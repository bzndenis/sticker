<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertukaran Stiker - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/navbar'); ?>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-8">
                <h3>Stiker yang Tersedia untuk Ditukar</h3>
                <div class="row">
                    <?php foreach($available_trades as $trade): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="<?= base_url('uploads/stickers/'.$trade->image_path) ?>" 
                                             class="img-thumbnail me-3" style="width: 100px;">
                                        <div>
                                            <h5 class="card-title"><?= $trade->name ?></h5>
                                            <p class="card-text">
                                                Koleksi: <?= $trade->collection_name ?><br>
                                                Pemilik: <?= $trade->username ?>
                                            </p>
                                            <button class="btn btn-primary btn-sm" 
                                                    onclick="showTradeModal(<?= $trade->id ?>)">
                                                Tawarkan Pertukaran
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-4">
                <h3>Permintaan Pertukaran</h3>
                <?php foreach($my_trades as $trade): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>Dari: <?= $trade->requester_username ?></h6>
                            <div class="d-flex mb-2">
                                <div class="text-center me-3">
                                    <small>Diminta</small><br>
                                    <img src="<?= base_url('uploads/stickers/'.$trade->requested_sticker_image) ?>" 
                                         class="img-thumbnail" style="width: 80px;">
                                </div>
                                <div class="text-center">
                                    <small>Ditawarkan</small><br>
                                    <img src="<?= base_url('uploads/stickers/'.$trade->offered_sticker_image) ?>" 
                                         class="img-thumbnail" style="width: 80px;">
                                </div>
                            </div>
                            <?php if($trade->status == 'pending'): ?>
                                <button class="btn btn-success btn-sm me-2" 
                                        onclick="acceptTrade(<?= $trade->id ?>)">Terima</button>
                                <button class="btn btn-danger btn-sm"
                                        onclick="rejectTrade(<?= $trade->id ?>)">Tolak</button>
                            <?php else: ?>
                                <span class="badge bg-<?= $trade->status == 'accepted' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($trade->status) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 