<?php $this->load->view('templates/header', ['title' => 'Notifikasi']); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Notifikasi</h5>
                    <?php if(!empty($notifications)): ?>
                    <div>
                        <button class="btn btn-sm btn-secondary" id="markAllRead">
                            <i class="fas fa-check-double"></i> Tandai Sudah Dibaca
                        </button>
                        <button class="btn btn-sm btn-danger" id="deleteAll">
                            <i class="fas fa-trash"></i> Hapus Semua
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if(empty($notifications)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-bell text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">Tidak Ada Notifikasi</h5>
                            <p class="text-muted mb-0">Anda akan menerima notifikasi untuk aktivitas penting</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach($notifications as $notification): ?>
                                <div class="list-group-item <?= $notification->is_read ? '' : 'list-group-item-primary' ?>">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($notification->title) ?></h6>
                                        <small class="text-muted"><?= time_elapsed_string($notification->created_at) ?></small>
                                    </div>
                                    <p class="mb-1"><?= htmlspecialchars($notification->message) ?></p>
                                    <?php if($notification->reference_type && $notification->reference_id): ?>
                                        <a href="<?= site_url($notification->reference_type . '/view/' . $notification->reference_id) ?>" 
                                           class="btn btn-sm btn-primary mt-2">
                                            Lihat Detail
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#markAllRead').click(function() {
        $.ajax({
            url: '<?= site_url('notifications/mark_all_read') ?>',
            type: 'POST',
            success: function(response) {
                if(response.status === 'success') {
                    location.reload();
                }
            }
        });
    });

    $('#deleteAll').click(function() {
        if(confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')) {
            $.ajax({
                url: '<?= site_url('notifications/delete_all') ?>',
                type: 'POST',
                success: function(response) {
                    if(response.status === 'success') {
                        location.reload();
                    }
                }
            });
        }
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 