<div class="main-panel">
    <div class="content-wrapper">
        <!-- Progress Per Kategori -->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Progress Koleksi per Kategori</h4>
                        <div class="row">
                            <?php foreach($stats['category_progress'] as $progress): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= $progress['name'] ?></h6>
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-success" 
                                                 role="progressbar" 
                                                 style="width: <?= ($progress['owned']/$progress['total'])*100 ?>%">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small><?= $progress['owned'] ?>/<?= $progress['total'] ?> Dimiliki</small>
                                            <small><?= $progress['tradeable'] ?> Dapat Ditukar</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Aktivitas Terbaru</h4>
                        <div class="list-wrapper">
                            <?php foreach($stats['recent_activities'] as $activity): ?>
                            <div class="d-flex align-items-center pb-3">
                                <img src="<?= base_url('assets/images/stickers/'.$activity->image) ?>" 
                                     class="mr-3" style="width: 40px" alt="sticker">
                                <div>
                                    <p class="mb-0"><?= $activity->sticker_name ?></p>
                                    <small class="text-muted">
                                        <?php 
                                        switch($activity->activity_type) {
                                            case 'trade':
                                                echo 'Pertukaran';
                                                break;
                                            case 'new':
                                                echo 'Sticker Baru';
                                                break;
                                            default:
                                                echo 'Update Koleksi';
                                        }
                                        ?> - 
                                        <?= time_elapsed_string($activity->activity_date) ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Pertukaran -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik Pertukaran</h4>
                        <div class="row text-center">
                            <div class="col-4">
                                <h3><?= $stats['trade_stats']->total_trades ?></h3>
                                <p>Total Pertukaran</p>
                            </div>
                            <div class="col-4">
                                <h3><?= $stats['trade_stats']->success_trades ?></h3>
                                <p>Berhasil</p>
                            </div>
                            <div class="col-4">
                                <h3><?= $stats['trade_stats']->pending_trades ?></h3>
                                <p>Menunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 