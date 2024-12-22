<?php $this->load->view('templates/header', ['title' => 'Permintaan Pertukaran']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-1">Permintaan Pertukaran</h4>
                            <span class="badge bg-<?= $trade->status_class ?> px-3 py-2">
                                <?= $trade->status_text ?>
                            </span>
                        </div>
                        <a href="<?= base_url('trades') ?>" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Trade Items -->
                    <div class="row g-4 mb-4">
                        <!-- Requested Sticker -->
                        <div class="col-md-6">
                            <div class="card bg-dark h-100">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Stiker yang Diminta</small>
                                    <div class="text-center mb-3">
                                        <img src="<?= base_url('uploads/stickers/' . $trade->requested_sticker_image) ?>" 
                                             class="img-fluid rounded" alt="<?= $trade->requested_sticker_name ?>"
                                             style="max-height: 150px;">
                                    </div>
                                    <h5 class="card-title mb-2"><?= $trade->requested_sticker_name ?></h5>
                                    <div class="d-flex align-items-center">
                                        <?php if($trade->owner_avatar): ?>
                                            <img src="<?= base_url('uploads/avatars/' . $trade->owner_avatar) ?>" 
                                                 class="rounded-circle me-2" alt="Owner"
                                                 style="width: 24px; height: 24px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                                 style="width: 24px; height: 24px;">
                                                <i class="bi bi-person-fill" style="font-size: 12px;"></i>
                                            </div>
                                        <?php endif; ?>
                                        <small class="text-muted">Milik <?= $trade->owner_name ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Offered Sticker -->
                        <div class="col-md-6">
                            <div class="card bg-dark h-100">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2">Stiker yang Ditawarkan</small>
                                    <div class="text-center mb-3">
                                        <img src="<?= base_url('uploads/stickers/' . $trade->offered_sticker_image) ?>" 
                                             class="img-fluid rounded" alt="<?= $trade->offered_sticker_name ?>"
                                             style="max-height: 150px;">
                                    </div>
                                    <h5 class="card-title mb-2"><?= $trade->offered_sticker_name ?></h5>
                                    <div class="d-flex align-items-center">
                                        <?php if($trade->requester_avatar): ?>
                                            <img src="<?= base_url('uploads/avatars/' . $trade->requester_avatar) ?>" 
                                                 class="rounded-circle me-2" alt="Requester"
                                                 style="width: 24px; height: 24px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                                 style="width: 24px; height: 24px;">
                                                <i class="bi bi-person-fill" style="font-size: 12px;"></i>
                                            </div>
                                        <?php endif; ?>
                                        <small class="text-muted">Milik <?= $trade->requester_name ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Section -->
                    <div class="card bg-dark mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Diskusi Pertukaran</h5>
                            <div class="chat-container bg-darker rounded p-3" style="height: 300px; overflow-y: auto;">
                                <div id="messages" class="messages">
                                    <?php foreach($messages as $message): ?>
                                        <div class="message mb-3 <?= $message->user_id == $this->session->userdata('user_id') ? 'text-end' : '' ?>">
                                            <div class="message-content d-inline-block p-3 rounded 
                                                <?= $message->user_id == $this->session->userdata('user_id') ? 
                                                    'bg-primary text-white' : 'bg-secondary' ?>"
                                                 style="max-width: 75%;">
                                                <?= $message->message ?>
                                                <div class="message-info mt-1">
                                                    <small class="text-muted">
                                                        <?= $message->username ?> • <?= time_elapsed_string($message->created_at) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <?php if($trade->status == 'pending'): ?>
                                <form id="chatForm" class="mt-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ketik pesan..." 
                                               id="messageInput" required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Trade Actions -->
                    <?php if($trade->status == 'pending' && $trade->receiver_id == $this->session->userdata('user_id')): ?>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-success" onclick="acceptTrade()">
                                <i class="bi bi-check-lg me-2"></i>Terima Pertukaran
                            </button>
                            <button class="btn btn-danger" onclick="rejectTrade()">
                                <i class="bi bi-x-lg me-2"></i>Tolak Pertukaran
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-darker {
    background: rgba(0, 0, 0, 0.2);
}

.message-content {
    word-break: break-word;
}

.chat-container {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

.chat-container::-webkit-scrollbar {
    width: 6px;
}

.chat-container::-webkit-scrollbar-track {
    background: transparent;
}

.chat-container::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}
</style>

<script>
const messagesContainer = document.getElementById('messages');
const chatForm = document.getElementById('chatForm');
const messageInput = document.getElementById('messageInput');

// Scroll to bottom on load
function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}
scrollToBottom();

// Send message
chatForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (!message) return;

    fetch('<?= base_url('chat/send/' . $trade->id) ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            location.reload(); // Temporary solution - should use WebSocket in production
        }
    });
});

// Trade actions
function acceptTrade() {
    if(confirm('Apakah Anda yakin ingin menerima pertukaran ini?')) {
        window.location.href = '<?= base_url('trades/accept/' . $trade->id) ?>';
    }
}

function rejectTrade() {
    if(confirm('Apakah Anda yakin ingin menolak pertukaran ini?')) {
        window.location.href = '<?= base_url('trades/reject/' . $trade->id) ?>';
    }
}

// Auto refresh chat (should use WebSocket in production)
setInterval(() => {
    fetch('<?= base_url('chat/get_messages/' . $trade->id) ?>')
        .then(response => response.json())
        .then(data => {
            if (data.messages) {
                location.reload();
            }
        });
}, 5000);
</script>

<?php $this->load->view('templates/footer'); ?> 