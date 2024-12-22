<?php 
$data['title'] = 'Chat';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <h2 class="mb-4">Chat Pertukaran</h2>

    <?php if(empty($trades)): ?>
        <div class="text-center py-5">
            <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada chat pertukaran</p>
            <a href="<?= base_url('trades') ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left-right"></i> Mulai Pertukaran
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-4">
                <!-- Daftar Chat -->
                <div class="card">
                    <div class="list-group list-group-flush">
                        <?php foreach($trades as $trade): ?>
                            <a href="<?= base_url('chat/trade/'.$trade->id) ?>" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span><?= $trade->requested_sticker_name ?></span>
                                            <i class="bi bi-arrow-left-right"></i>
                                            <span><?= $trade->offered_sticker_name ?></span>
                                        </div>
                                        <small class="text-muted d-block">
                                            dengan <?= $trade->requester_id == $this->session->userdata('user_id') ? 
                                                      $trade->owner_username : 
                                                      $trade->requester_username ?>
                                        </small>
                                        <?php if($trade->last_message): ?>
                                            <small class="text-truncate d-block" style="max-width: 200px;">
                                                <?= $trade->last_message ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($trade->unread_count > 0): ?>
                                        <span class="badge bg-danger rounded-pill">
                                            <?= $trade->unread_count ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Area Chat -->
                <div class="card h-100">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-chat-text text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Pilih chat untuk melihat percakapan</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $this->load->view('templates/footer'); ?> 