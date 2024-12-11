<div class="main-panel">
    <div class="content-wrapper">
        <!-- Statistik Utama -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $stats['owned_stickers'] ?>/<?= $stats['total_stickers'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-sticker-emoji icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Sticker Dimiliki</h6>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $stats['tradeable_stickers'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-warning">
                                    <span class="mdi mdi-swap-horizontal icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Sticker Dapat Ditukar</h6>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?= $stats['pending_trades'] ?></h3>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-info">
                                    <span class="mdi mdi-clock-outline icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Pertukaran Pending</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Kategori -->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Progress Kategori</h4>
                        <div class="row">
                            <?php foreach($category_progress as $progress): ?>
                            <div class="col-md-3 mb-4">
                                <h6 class="text-muted font-weight-normal"><?= $progress['name'] ?></h6>
                                <div class="progress">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: <?= ($progress['owned']/$progress['total'])*100 ?>%">
                                        <?= $progress['owned'] ?>/<?= $progress['total'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru dan Riwayat Pertukaran -->
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Aktivitas Terbaru</h4>
                        <div class="list-wrapper">
                            <?php foreach($recent_activities as $activity): ?>
                            <div class="d-flex align-items-center pb-3">
                                <img src="<?= base_url('assets/images/stickers/'.$activity->image) ?>" 
                                     class="mr-3" style="width: 40px" alt="sticker">
                                <div>
                                    <p class="mb-0"><?= $activity->sticker_name ?></p>
                                    <small class="text-muted">
                                        <?= $activity->activity_type ?> - 
                                        <?= time_elapsed_string($activity->activity_date) ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Pertukaran</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Dengan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($trade_history as $trade): ?>
                                    <tr>
                                        <td><?= $trade->sticker_name ?></td>
                                        <td><?= $trade->other_user ?></td>
                                        <td>
                                            <span class="badge badge-<?= get_status_badge($trade->status) ?>">
                                                <?= $trade->status ?>
                                            </span>
                                        </td>
                                        <td><?= time_elapsed_string($trade->created_at) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi untuk memperbarui notifikasi
function checkNotifications() {
    $.ajax({
        url: '<?= base_url("dashboard/get_notifications") ?>',
        type: 'GET',
        success: function(response) {
            if(response.notifications.length > 0) {
                updateNotificationBadge(response.notifications.length);
                showNotificationToast(response.notifications[0]);
            }
        }
    });
}

// Periksa notifikasi setiap 30 detik
setInterval(checkNotifications, 30000);
</script> 