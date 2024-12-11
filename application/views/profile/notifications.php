<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pengaturan Notifikasi</h4>
                        
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
                        
                        <form method="post" action="<?= base_url('profile/notifications') ?>">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="tradeNotif" 
                                           name="trade_notification" <?= isset($settings->trade_notification) && $settings->trade_notification ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="tradeNotif">Notifikasi Pertukaran</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="chatNotif" 
                                           name="chat_notification" <?= isset($settings->chat_notification) && $settings->chat_notification ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="chatNotif">Notifikasi Chat</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="emailNotif" 
                                           name="email_notification" <?= isset($settings->email_notification) && $settings->email_notification ? 'checked' : '' ?>>
                                    <label class="custom-control-label" for="emailNotif">Notifikasi Email</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan Pengaturan
                            </button>
                            
                            <a href="<?= base_url('profile') ?>" class="btn btn-light">
                                <i class="mdi mdi-arrow-left"></i> Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tambahkan konfirmasi sebelum menonaktifkan notifikasi
$('.custom-control-input').change(function() {
    if (!$(this).prop('checked')) {
        const notifType = $(this).attr('id');
        const messages = {
            tradeNotif: 'pertukaran',
            chatNotif: 'chat',
            emailNotif: 'email'
        };
        
        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin menonaktifkan notifikasi ${messages[notifType]}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (!result.isConfirmed) {
                $(this).prop('checked', true);
            }
        });
    }
});
</script>