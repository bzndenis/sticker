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

            <!-- After Trade Details -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Chat Pertukaran</h5>
                    
                    <!-- Chat Messages -->
                    <div class="chat-messages mb-4" id="chatMessages" style="max-height: 400px; overflow-y: auto; background: #f8f9fa; padding: 1rem; border-radius: 0.5rem;">
                        <?php if(empty($messages)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                                <p class="mt-2">Belum ada pesan</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($messages as $message): ?>
                                <div class="chat-message <?= $message->user_id == $this->session->userdata('user_id') ? 'sent' : 'received' ?> mb-3">
                                    <div class="message-bubble">
                                        <div class="message-sender mb-1">
                                            <?= $message->username ?>
                                        </div>
                                        <div class="message-content">
                                            <?= $message->message ?>
                                            <small class="message-time">
                                                <?= date('H:i', strtotime($message->created_at)) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Chat Input -->
                    <?php if($trade->status == 'pending'): ?>
                        <form id="chatForm" class="d-flex gap-2">
                            <input type="hidden" name="trade_id" value="<?= $trade->id ?>">
                            <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Chat dinonaktifkan karena pertukaran sudah selesai
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <style>
            .chat-messages {
                background: #f8f9fa;
                border-radius: 0.5rem;
                padding: 1rem;
            }

            .chat-message {
                display: flex;
                margin-bottom: 1rem;
            }

            .chat-message.sent {
                justify-content: flex-end;
            }

            .chat-message.received {
                justify-content: flex-start;
            }

            .message-bubble {
                max-width: 70%;
                padding: 0.75rem;
                border-radius: 1.25rem;
            }

            .chat-message.sent .message-bubble {
                background-color: #007bff;
                color: white;
                margin-left: auto;
                border-bottom-right-radius: 0.5rem;
            }

            .chat-message.received .message-bubble {
                background-color: white;
                color: #212529;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-right: auto;
                border-bottom-left-radius: 0.5rem;
            }

            .message-sender {
                font-size: 0.8rem;
                margin-bottom: 0.25rem;
            }

            .chat-message.sent .message-sender {
                color: rgba(255,255,255,0.9);
            }

            .chat-message.received .message-sender {
                color: #6c757d;
            }

            .message-content {
                font-size: 0.95rem;
                line-height: 1.4;
            }

            .message-time {
                font-size: 0.75rem;
                display: inline-block;
                margin-left: 0.5rem;
            }

            .chat-message.sent .message-time {
                color: rgba(255,255,255,0.8);
            }

            .chat-message.received .message-time {
                color: #6c757d;
            }

            #chatForm {
                margin-top: 1rem;
                display: flex;
                gap: 0.5rem;
            }

            #chatForm .form-control {
                border-radius: 2rem;
                padding: 0.75rem 1.25rem;
                border: 1px solid #2d3338;
                background: #2d3338;
                color: #fff;
            }

            #chatForm .form-control::placeholder {
                color: rgba(255,255,255,0.7);
            }

            #chatForm .form-control:focus {
                border-color: #007bff;
                background: #2d3338;
                color: #fff;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            }

            #chatForm .btn {
                border-radius: 50%;
                width: 42px;
                height: 42px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                background: #007bff;
                border: none;
            }

            #chatForm .btn:hover {
                background: #0056b3;
            }

            #chatForm .btn i {
                font-size: 1.2rem;
            }
            </style>

            <script>
            document.getElementById('chatForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const message = formData.get('message');
                
                if (!message.trim()) return;
                
                fetch('<?= base_url('trades/send_message') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        const now = new Date();
                        const time = now.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
                        
                        const messageHtml = `
                            <div class="chat-message sent mb-3">
                                <div class="message-bubble">
                                    <div class="message-sender">
                                        <?= $this->session->userdata('username') ?>
                                    </div>
                                    <div class="message-content">
                                        ${message}
                                        <small class="message-time">
                                            ${time}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        const chatMessages = document.getElementById('chatMessages');
                        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
                        
                        this.reset();
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    } else {
                        alert('Gagal mengirim pesan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim pesan');
                });
            });

            // Auto scroll to bottom on load
            window.addEventListener('load', function() {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
            </script>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 