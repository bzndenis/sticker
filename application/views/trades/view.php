<?php $this->load->view('templates/header', ['title' => 'Detail Pertukaran']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Detail Pertukaran</h4>
                <a href="<?= base_url('trades') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Trade Status -->
            <div class="alert alert-<?= $trade->status == 'pending' ? 'warning' : 
                                    ($trade->status == 'accepted' ? 'success' : 'danger') ?>">
                Status: <?= ucfirst($trade->status) ?>
            </div>

            <!-- Trade Details -->
            <div class="row g-4">
                <!-- Requester's Sticker -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stiker yang Ditawarkan</h5>
                            <p class="text-muted">Oleh: <?= $trade->requester_username ?></p>
                            <img src="<?= base_url('uploads/stickers/'.$trade->offered_image) ?>" 
                                 class="img-fluid rounded mb-3" alt="Sticker">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Stiker #<?= $trade->offered_number ?></h6>
                                    <small class="text-muted"><?= $trade->offered_category ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Owner's Sticker -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stiker yang Diminta</h5>
                            <p class="text-muted">Oleh: <?= $trade->owner_username ?></p>
                            <img src="<?= base_url('uploads/stickers/'.$trade->requested_image) ?>" 
                                 class="img-fluid rounded mb-3" alt="Sticker">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Stiker #<?= $trade->requested_number ?></h6>
                                    <small class="text-muted"><?= $trade->requested_category ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <?php if($trade->status == 'pending' && $trade->owner_id == $this->session->userdata('user_id')): ?>
                <div class="mt-4">
                    <a href="<?= base_url('trades/accept/'.$trade->id) ?>" 
                       class="btn btn-success me-2"
                       onclick="return confirm('Yakin ingin menerima pertukaran ini?')">
                        <i class="bi bi-check-lg me-2"></i>Terima
                    </a>
                    <a href="<?= base_url('trades/reject/'.$trade->id) ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin menolak pertukaran ini?')">
                        <i class="bi bi-x-lg me-2"></i>Tolak
                    </a>
                </div>
            <?php endif; ?>

            <!-- Chat Section -->
            <div class="card mt-4">
                <div class="card-body p-0">
                    <!-- Chat Header -->
                    <div class="chat-header p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="chat-contact-info">
                                <h5 class="mb-0">Diskusi Pertukaran</h5>
                                <small class="text-muted">
                                    <?= $trade->status == 'pending' ? 'Sedang dalam negosiasi' : 
                                       ($trade->status == 'accepted' ? 'Pertukaran selesai' : 'Pertukaran dibatalkan') ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="chat-container p-3" style="height: 400px; overflow-y: auto; background: #0f1419;">
                        <div id="chatMessages" class="messages">
                            <!-- Chat messages akan dimuat di sini -->
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <form id="chatForm" class="chat-input-form p-3 border-top">
                        <div class="input-group">
                            <input type="text" id="messageInput" name="message" 
                                class="form-control bg-dark text-white border-0" 
                                placeholder="Ketik pesan..." required>
                            <input type="hidden" name="trade_id" value="<?= $trade->id ?>">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan jQuery sebelum script chat -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    const chatForm = $('#chatForm');
    const messageInput = $('#messageInput');
    const chatMessages = $('#chatMessages');

    function addMessage(msg) {
        const messageHtml = `
            <div class="chat-message ${msg.is_mine ? 'sent' : 'received'}">
                <div class="message-bubble">
                    ${msg.message}
                    <div class="message-meta">
                        <small class="message-time">${msg.created_at}</small>
                        ${msg.is_mine ? getMessageStatus(msg) : ''}
                    </div>
                </div>
            </div>`;
        chatMessages.append(messageHtml);
        scrollToBottom();
    }

    function getMessageStatus(msg) {
        if (msg.is_read) {
            return '<span class="message-status status-read"><i class="bi bi-check2-all"></i></span>';
        } else if (msg.is_delivered) {
            return '<span class="message-status status-delivered"><i class="bi bi-check2-all"></i></span>';
        }
        return '<span class="message-status status-sent"><i class="bi bi-check2"></i></span>';
    }

    function loadMessages() {
        $.ajax({
            url: '<?= base_url("chat/get_messages/".$trade->id) ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    chatMessages.empty();
                    if (response.messages && response.messages.length > 0) {
                        response.messages.forEach(addMessage);
                    }
                } else {
                    console.error('Error:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', error);
            }
        });
    }

    function scrollToBottom() {
        const container = $('.chat-container');
        container.scrollTop(container[0].scrollHeight);
    }

    chatForm.on('submit', function(e) {
        e.preventDefault();
        const message = messageInput.val().trim();
        if (!message) return;

        $.ajax({
            url: '<?= base_url("chat/send") ?>',
            method: 'POST',
            dataType: 'json',
            data: {
                trade_id: <?= $trade->id ?>,
                message: message
            },
            success: function(response) {
                if (response.success) {
                    messageInput.val('');
                    addMessage(response.message);
                } else {
                    alert(response.message || 'Gagal mengirim pesan');
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax error:', error);
                alert('Terjadi kesalahan saat mengirim pesan');
            }
        });
    });

    // Load pesan awal dan setup polling
    loadMessages();
    setInterval(loadMessages, 3000);
});
</script>

<style>
.chat-header {
    background: #1f2937;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.chat-message {
    margin-bottom: 1rem;
}

.chat-message.sent {
    text-align: right;
}

.chat-message.received {
    text-align: left;
}

.message-bubble {
    display: inline-block;
    max-width: 70%;
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    position: relative;
    word-wrap: break-word;
}

.chat-message.sent .message-bubble {
    background-color: #005c4b;
    border-top-right-radius: 0.25rem;
    margin-left: auto;
}

.chat-message.received .message-bubble {
    background-color: #1f2937;
    border-top-left-radius: 0.25rem;
}

.message-status {
    display: inline-block;
    margin-left: 4px;
    font-size: 0.8em;
}

.message-status i {
    font-size: 1em;
}

.status-sent {
    color: #8696a0;
}

.status-delivered {
    color: #8696a0;
}

.status-read {
    color: #53bdeb;
}

.chat-input-form {
    background: #1f2937;
}

.chat-input-form .form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

.message-time {
    font-size: 0.75rem;
    margin-top: 0.25rem;
    opacity: 0.7;
}

.message-meta {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.25rem;
}
</style>

<?php $this->load->view('templates/footer'); ?> 