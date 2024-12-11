<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="<?= base_url('assets/images/avatars/default.png') ?>" 
                                 alt="Profile" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?= $user->username ?></h4>
                                <p class="text-muted font-size-sm">
                                    Bergabung sejak <?= date('d M Y', strtotime($user->created_at)) ?>
                                </p>
                                <p>
                                    <span class="badge badge-<?= $user->is_admin ? 'primary' : 'info' ?>">
                                        <?= $user->is_admin ? 'Admin' : 'User' ?>
                                    </span>
                                    <span class="badge badge-<?= $user->is_active ? 'success' : 'warning' ?>">
                                        <?= $user->is_active ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </p>
                                <?php if($user->is_banned): ?>
                                <div class="alert alert-danger">
                                    <strong>User Dibanned</strong><br>
                                    Sampai: <?= date('d M Y H:i', strtotime($user->banned_until)) ?><br>
                                    Alasan: <?= $user->ban_reason ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">Informasi Kontak</h6>
                        <div>
                            <p class="mb-2">
                                <i class="mdi mdi-email text-info mr-2"></i> <?= $user->email ?>
                            </p>
                            <?php if($user->whatsapp): ?>
                            <p class="mb-2">
                                <i class="mdi mdi-whatsapp text-success mr-2"></i> <?= $user->whatsapp ?>
                            </p>
                            <?php endif; ?>
                            <?php if($user->telegram): ?>
                            <p class="mb-0">
                                <i class="mdi mdi-telegram text-primary mr-2"></i> <?= $user->telegram ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Statistik User</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $stats['total_stickers'] ?></h3>
                                        <p class="mb-0">Total Sticker</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-info text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $stats['total_trades'] ?></h3>
                                        <p class="mb-0">Total Trade</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body text-center">
                                        <h3><?= $stats['success_trades'] ?></h3>
                                        <p class="mb-0">Trade Berhasil</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">Pertukaran Terakhir</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Partner</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($recent_trades as $trade): ?>
                                    <tr>
                                        <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                        <td><?= $trade->partner_username ?></td>
                                        <td>
                                            <span class="badge badge-<?= get_trade_status_badge($trade->status) ?>">
                                                <?= ucfirst($trade->status) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <h5 class="mt-4">Koleksi Sticker</h5>
                        <div class="row">
                            <?php foreach($owned_stickers as $sticker): ?>
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <div class="card">
                                    <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                         class="card-img-top" alt="<?= $sticker->name ?>">
                                    <div class="card-body p-2 text-center">
                                        <small class="d-block text-muted"><?= $sticker->name ?></small>
                                        <span class="badge badge-info">x<?= $sticker->quantity ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 