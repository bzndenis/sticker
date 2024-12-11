<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Detail Pertukaran</h4>
                            <span class="badge badge-<?= get_status_badge($trade->status) ?>">
                                <?= $trade->status ?>
                            </span>
                        </div>
                        
                        <div class="row">
                            <!-- Detail Sticker -->
                            <div class="col-md-6">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('assets/images/stickers/'.$trade->sticker_image) ?>" 
                                                 class="mr-3" style="width: 80px" alt="sticker">
                                            <div>
                                                <h5 class="mb-1"><?= $trade->sticker_name ?></h5>
                                                <p class="mb-0">Kategori: <?= $trade->category_name ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Detail Pertukaran -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi Pertukaran</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <strong>Peminta:</strong> <?= $trade->requester_name ?>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Pemilik:</strong> <?= $trade->owner_name ?>
                                            </li>
                                            <li class="mb-2">
                                                <strong>Tanggal Request:</strong> 
                                                <?= date('d M Y H:i', strtotime($trade->created_at)) ?>
                                            </li>
                                            <?php if($trade->status != 'pending'): ?>
                                            <li class="mb-2">
                                                <strong>Tanggal Update:</strong>
                                                <?= date('d M Y H:i', strtotime($trade->updated_at)) ?>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                        
                                        <?php if($trade->status == 'pending' && $is_owner): ?>
                                        <div class="mt-4">
                                            <button class="btn btn-success mr-2" 
                                                    onclick="updateTradeStatus(<?= $trade->id ?>, 'accepted')">
                                                <i class="mdi mdi-check"></i> Terima
                                            </button>
                                            <button class="btn btn-danger" 
                                                    onclick="updateTradeStatus(<?= $trade->id ?>, 'rejected')">
                                                <i class="mdi mdi-close"></i> Tolak
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chat Section -->
                        <div class="mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Diskusi</h6>
                                    <div class="chat-container" id="chatContainer">
                                        <?php foreach($messages as $msg): ?>
                                        <div class="chat-message <?= $msg->user_id == $user_id ? 'sent' : 'received' ?>">
                                            <div class="message-content">
                                                <div class="message-text"><?= $msg->message ?></div>
                                                <small class="text-muted">
                                                    <?= $msg->sender_name ?> - 
                                                    <?= time_elapsed_string($msg->created_at) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php if($trade->status == 'pending' || $trade->status == 'accepted'): ?>
                                    <div class="chat-input mt-3">
                                        <form id="chatForm" class="d-flex">
                                            <input type="text" class="form-control mr-2" 
                                                   id="messageInput" placeholder="Ketik pesan...">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-send"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const chatContainer = $('#chatContainer');
    chatContainer.scrollTop(chatContainer[0].scrollHeight);
    
    $('#chatForm').submit(function(e) {
        e.preventDefault();
        const message = $('#messageInput').val();
        
        if (message.trim() !== '') {
            $.ajax({
                url: '<?= base_url("chat/send_message") ?>',
                type: 'POST',
                data: {
                    trade_id: <?= $trade->id ?>,
                    message: message
                },
                success: function(response) {
                    if(response.success) {
                        $('#messageInput').val('');
                        appendMessage(response.message);
                    }
                }
            });
        }
    });
});

function updateTradeStatus(tradeId, status) {
    const confirmMessages = {
        accepted: 'Apakah Anda yakin ingin menerima pertukaran ini?',
        rejected: 'Apakah Anda yakin ingin menolak pertukaran ini?'
    };
    
    Swal.fire({
        title: 'Konfirmasi',
        text: confirmMessages[status],
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("trades/update_request_status") ?>',
                type: 'POST',
                data: { request_id: tradeId, status: status },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
}
</script> 