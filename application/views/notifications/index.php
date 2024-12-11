<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notifikasi</h4>
                        <div class="notification-list">
                            <?php foreach($notifications as $notif): ?>
                            <div class="notification-item <?= $notif->is_read ? '' : 'unread' ?>" 
                                 data-id="<?= $notif->id ?>">
                                <div class="d-flex align-items-center p-3">
                                    <div class="mr-3">
                                        <img src="<?= base_url('assets/images/stickers/'.$notif->sticker_image) ?>" 
                                             style="width: 50px" alt="sticker">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1">
                                            <strong><?= $notif->sender_name ?></strong> 
                                            <?= $notif->message ?>
                                        </p>
                                        <small class="text-muted">
                                            <?= time_elapsed_string($notif->created_at) ?>
                                        </small>
                                    </div>
                                    <?php if(!$notif->is_read): ?>
                                    <button class="btn btn-outline-primary btn-sm mark-as-read">
                                        Tandai Dibaca
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.mark-as-read').click(function() {
        var $item = $(this).closest('.notification-item');
        var notifId = $item.data('id');
        
        $.ajax({
            url: '<?= base_url("notifications/mark_as_read") ?>',
            type: 'POST',
            data: { notification_id: notifId },
            success: function(response) {
                if(response.success) {
                    $item.removeClass('unread');
                    $(this).remove();
                }
            }
        });
    });
});
</script> 