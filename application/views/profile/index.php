<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-wrapper mr-3">
                                <img src="<?= base_url('assets/images/avatars/default.png') ?>" 
                                     class="rounded-circle" style="width: 100px" alt="avatar">
                            </div>
                            <div>
                                <h4 class="card-title mb-1"><?= $user->username ?></h4>
                                <p class="text-muted mb-0">Bergabung sejak <?= date('d M Y', strtotime($user->created_at)) ?></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body">
                                        <h3><?= $stats['total_owned'] ?></h3>
                                        <p class="mb-0">Total Sticker Dimiliki</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-info text-white">
                                    <div class="card-body">
                                        <h3><?= $stats['total_trades'] ?></h3>
                                        <p class="mb-0">Total Pertukaran</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body">
                                        <h3><?= $stats['success_trades'] ?></h3>
                                        <p class="mb-0">Pertukaran Berhasil</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Informasi Kontak</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <strong>Email:</strong> <?= $user->email ?>
                                            </li>
                                            <?php if(isset($user->whatsapp) && $user->whatsapp): ?>
                                            <li class="mb-2">
                                                <strong>WhatsApp:</strong> <?= $user->whatsapp ?>
                                            </li>
                                            <?php endif; ?>
                                            <?php if(isset($user->telegram) && $user->telegram): ?>
                                            <li class="mb-2">
                                                <strong>Telegram:</strong> <?= $user->telegram ?>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                        <a href="<?= base_url('profile/settings') ?>" class="btn btn-outline-primary">
                                            <i class="mdi mdi-settings"></i> Edit Profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Pengaturan Notifikasi</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <?php if(isset($user->trade_notification) && $user->trade_notification): ?>
                                                <i class="mdi mdi-check-circle text-success"></i>
                                                <?php else: ?>
                                                <i class="mdi mdi-close-circle text-danger"></i>
                                                <?php endif; ?>
                                                Notifikasi Pertukaran
                                            </li>
                                            <li class="mb-2">
                                                <?php if(isset($user->chat_notification) && $user->chat_notification): ?>
                                                <i class="mdi mdi-check-circle text-success"></i>
                                                <?php else: ?>
                                                <i class="mdi mdi-close-circle text-danger"></i>
                                                <?php endif; ?>
                                                Notifikasi Chat
                                            </li>
                                            <li class="mb-2">
                                                <?php if(isset($user->email_notification) && $user->email_notification): ?>
                                                <i class="mdi mdi-check-circle text-success"></i>
                                                <?php else: ?>
                                                <i class="mdi mdi-close-circle text-danger"></i>
                                                <?php endif; ?>
                                                Notifikasi Email
                                            </li>
                                        </ul>
                                        <a href="<?= base_url('profile/notifications') ?>" class="btn btn-outline-primary">
                                            <i class="mdi mdi-bell"></i> Atur Notifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 