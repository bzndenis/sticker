<?php 
$data['title'] = 'Detail Pertukaran';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <!-- Header -->
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">Detail Pertukaran #<?= $trade->id ?></h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="<?= base_url('admin/trades') ?>">Pertukaran</a>
                                    </li>
                                    <li class="breadcrumb-item active">Detail</li>
                                </ol>
                            </nav>
                        </div>
                        <button onclick="deleteTrade(<?= $trade->id ?>)" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>

                <!-- Detail Pertukaran -->
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Stiker yang Diminta -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-center mb-3">Stiker yang Diminta</h6>
                                    <img src="<?= base_url('uploads/stickers/'.$trade->requested_sticker_image) ?>" 
                                         class="img-fluid mb-2 sticker-img mx-auto d-block" 
                                         alt="<?= $trade->requested_sticker_name ?>">
                                    <h5 class="text-center mb-1"><?= $trade->requested_sticker_name ?></h5>
                                    <p class="text-center text-muted mb-0">
                                        Pemilik: <?= $trade->owner_username ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stiker yang Ditawarkan -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-center mb-3">Stiker yang Ditawarkan</h6>
                                    <img src="<?= base_url('uploads/stickers/'.$trade->offered_sticker_image) ?>" 
                                         class="img-fluid mb-2 sticker-img mx-auto d-block" 
                                         alt="<?= $trade->offered_sticker_name ?>">
                                    <h5 class="text-center mb-1"><?= $trade->offered_sticker_name ?></h5>
                                    <p class="text-center text-muted mb-0">
                                        Pemohon: <?= $trade->requester_username ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pertukaran -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong>Status:</strong>
                                        <?php
                                        $status_class = [
                                            'pending' => 'warning',
                                            'accepted' => 'success',
                                            'rejected' => 'danger'
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $status_class[$trade->status] ?>">
                                            <?= ucfirst($trade->status) ?>
                                        </span>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Tanggal Permintaan:</strong>
                                        <?= date('d M Y H:i', strtotime($trade->created_at)) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <?php if($trade->status != 'pending'): ?>
                                        <p class="mb-1">
                                            <strong>Tanggal Update:</strong>
                                            <?= date('d M Y H:i', strtotime($trade->updated_at)) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Riwayat Chat</h5>
                        </div>
                        <div class="card-body chat-messages">
                            <?php if(empty($chat_messages)): ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-chat-dots text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Belum ada chat</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($chat_messages as $message): ?>
                                    <div class="d-flex mb-3 <?= $message->sender_id == $trade->requester_id ? 'justify-content-start' : 'justify-content-end' ?>">
                                        <div class="<?= $message->sender_id == $trade->requester_id ? 'bg-light' : 'bg-primary text-white' ?> 
                                                    rounded p-2" style="max-width: 70%;">
                                            <div class="small fw-bold mb-1">
                                                <?= $message->sender_username ?>
                                            </div>
                                            <?= nl2br(htmlspecialchars($message->message)) ?>
                                            <div class="small <?= $message->sender_id == $trade->requester_id ? 'text-muted' : 'text-white-50' ?> mt-1">
                                                <?= date('d M Y H:i', strtotime($message->created_at)) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteTrade(id) {
    if(confirm('Apakah Anda yakin ingin menghapus pertukaran ini?\nSemua chat dan notifikasi terkait akan ikut terhapus.')) {
        window.location.href = '<?= base_url('admin/trades/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 