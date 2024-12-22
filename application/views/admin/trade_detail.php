<?php 
$data['title'] = 'Detail Pertukaran';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pertukaran</h2>
        <a href="<?= base_url('admin/trades') ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row">
        <!-- Informasi Pertukaran -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Status Pertukaran</h5>
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
                    <div class="alert alert-<?= $status_class[$trade->status] ?> mb-3">
                        <?= $status_text[$trade->status] ?>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td>Tanggal Request</td>
                            <td>: <?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                        </tr>
                        <?php if($trade->updated_at && $trade->status != 'pending'): ?>
                            <tr>
                                <td>Tanggal Update</td>
                                <td>: <?= date('d M Y H:i', strtotime($trade->updated_at)) ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Informasi Pengguna -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Pengguna</h5>
                    <div class="mb-3">
                        <h6>Pemohon</h6>
                        <a href="<?= base_url('admin/user_detail/'.$trade->requester_id) ?>" 
                           class="text-decoration-none">
                            <?= $trade->requester_username ?>
                        </a>
                    </div>
                    <div>
                        <h6>Pemilik</h6>
                        <a href="<?= base_url('admin/user_detail/'.$trade->owner_id) ?>" 
                           class="text-decoration-none">
                            <?= $trade->owner_username ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Stiker -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Detail Stiker</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <h6>Stiker Diminta</h6>
                                <img src="<?= base_url('uploads/stickers/'.$trade->requested_sticker_image) ?>" 
                                     class="img-fluid mb-2" style="max-height: 200px;">
                                <p class="mb-0"><?= $trade->requested_sticker_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <h6>Stiker Ditawarkan</h6>
                                <img src="<?= base_url('uploads/stickers/'.$trade->offered_sticker_image) ?>" 
                                     class="img-fluid mb-2" style="max-height: 200px;">
                                <p class="mb-0"><?= $trade->offered_sticker_name ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Chat -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Chat</h5>
                    <?php if(empty($chat_messages)): ?>
                        <p class="text-muted text-center py-3">Belum ada chat</p>
                    <?php else: ?>
                        <div class="chat-messages" style="max-height: 400px; overflow-y: auto;">
                            <?php foreach($chat_messages as $message): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <span class="fw-bold"><?= $message->sender_username ?></span>
                                            <small class="text-muted ms-2">
                                                <?= date('d M Y H:i', strtotime($message->created_at)) ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <?= nl2br(htmlspecialchars($message->message)) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 