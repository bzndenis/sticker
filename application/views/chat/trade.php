<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="card-title mb-1">Chat dengan <?= $other_user ?></h4>
                                <p class="text-muted">
                                    Sticker: <?= $trade->sticker_name ?> 
                                    (<?= $trade->status ?>)
                                </p>
                            </div>
                            <div>
                                <img src="<?= base_url('assets/images/stickers/'.$trade->sticker_image) ?>" 
                                     style="width: 60px" alt="sticker">
                            </div>
                        </div>

                        <div class="chat-container" style="height: 400px; overflow-y: auto;">
                            <div class="chat-messages">
                                <?php foreach($messages as $msg): ?>
                                <div class="chat-message <?= $msg->user_id == $this->session->userdata('user_id') ? 'sent' : 'received' ?> mb-3">
                                    <div class="message-content">
                                        <div class="message-text">
                                            <?= htmlspecialchars($msg->message) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= $msg->sender_name ?> - 
                                            <?= time_elapsed_string($msg->created_at) ?>
                                        </small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="chat-input mt-3">
                            <form id="chat-form" class="d-flex">
                                <input type="text" class="form-control mr-2" 
                                       id="message-input" placeholder="Ketik pesan...">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-message {
    margin-bottom: 15px;
}

.chat-message.sent {
    text-align: right;
}

.chat-message.sent .message-content {
    background: #007bff;
    color: white;
    border-radius: 15px 15px 0 15px;
    padding: 10px 15px;
    display: inline-block;
    max-width: 70%;
}

.chat-message.received .message-content {
    background: #e9ecef;
    border-radius: 15px 15px 15px 0;
    padding: 10px 15px;
    display: inline-block;
    max-width: 70%;
}

.message-text {
    margin-bottom: 5px;
}
</style>

<script>
$(document).ready(function() {
    var chatContainer = $('.chat-container');
    var lastMessageId = $('.chat-message').last().data('id') || 0;
    
    // Scroll ke bawah
    chatContainer.scrollTop(chatContainer[0].scrollHeight);
    
    // Kirim pesan
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var message = $('#message-input').val();
        
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
                        $('#message-input').val('');
                        getNewMessages();
                    }
                }
            });
        }
    });
    
    // Polling untuk pesan baru
    function getNewMessages() {
        $.ajax({
            url: '<?= base_url("chat/get_new_messages") ?>',
            type: 'GET',
            data: {
                trade_id: <?= $trade->id ?>,
                last_id: lastMessageId
            },
            success: function(response) {
                if(response.messages.length > 0) {
                    response.messages.forEach(function(msg) {
                        var messageHtml = createMessageHtml(msg);
                        $('.chat-messages').append(messageHtml);
                        lastMessageId = msg.id;
                    });
                    chatContainer.scrollTop(chatContainer[0].scrollHeight);
                }
            }
        });
    }
    
    function createMessageHtml(msg) {
        var isOwn = msg.user_id == <?= $this->session->userdata('user_id') ?>;
        return `
            <div class="chat-message ${isOwn ? 'sent' : 'received'} mb-3" data-id="${msg.id}">
                <div class="message-content">
                    <div class="message-text">
                        ${msg.message}
                    </div>
                    <small class="text-muted">
                        ${msg.sender_name} - baru saja
                    </small>
                </div>
            </div>
        `;
    }
    
    // Polling setiap 5 detik
    setInterval(getNewMessages, 5000);
});
</script> 