<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna - Admin Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/admin_navbar'); ?>

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Pengguna</h2>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Pengguna</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td>Username</td>
                                <td>: <?= $user->username ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: <?= $user->email ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>: <?= $user->is_admin ? 'Admin' : 'User' ?></td>
                            </tr>
                            <tr>
                                <td>Bergabung</td>
                                <td>: <?= date('d M Y', strtotime($user->created_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Statistik</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td>Total Koleksi</td>
                                <td>: <?= count($collections) ?></td>
                            </tr>
                            <tr>
                                <td>Total Pertukaran</td>
                                <td>: <?= count($trades) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Progress Koleksi</h5>
                        <?php foreach($collections as $collection): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0"><?= $collection->name ?></h6>
                                    <small class="text-muted">
                                        <?= $collection->owned ?> dari <?= $collection->total ?> stiker
                                    </small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: <?= $collection->progress ?>%"
                                         aria-valuenow="<?= $collection->progress ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?= number_format($collection->progress, 1) ?>%
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Pertukaran</h5>
                        <?php if(empty($trades)): ?>
                            <p class="text-muted">Belum ada riwayat pertukaran.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Stiker Diminta</th>
                                            <th>Stiker Ditawarkan</th>
                                            <th>Dengan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($trades as $trade): ?>
                                            <tr>
                                                <td><?= date('d M Y', strtotime($trade->created_at)) ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = [
                                                        'pending' => 'warning',
                                                        'accepted' => 'success',
                                                        'rejected' => 'danger'
                                                    ];
                                                    $status_text = [
                                                        'pending' => 'Pending',
                                                        'accepted' => 'Diterima',
                                                        'rejected' => 'Ditolak'
                                                    ];
                                                    ?>
                                                    <span class="badge bg-<?= $status_class[$trade->status] ?>">
                                                        <?= $status_text[$trade->status] ?>
                                                    </span>
                                                </td>
                                                <td><?= $trade->requested_sticker_name ?></td>
                                                <td><?= $trade->offered_sticker_name ?></td>
                                                <td>
                                                    <?= $trade->requester_id == $user->id ? 
                                                        $trade->owner_username : 
                                                        $trade->requester_username ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 