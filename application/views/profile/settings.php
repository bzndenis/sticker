<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pengaturan Akun</h4>
                        
                        <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('profile/settings') ?>">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" 
                                       value="<?= set_value('username', $user->username) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= set_value('email', $user->email) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>WhatsApp (opsional)</label>
                                <input type="text" name="whatsapp" class="form-control" 
                                       value="<?= set_value('whatsapp', $user->whatsapp) ?>">
                                <small class="text-muted">Format: 08xxxxxxxxxx</small>
                            </div>

                            <div class="form-group">
                                <label>Username Telegram (opsional)</label>
                                <input type="text" name="telegram" class="form-control" 
                                       value="<?= set_value('telegram', $user->telegram) ?>">
                                <small class="text-muted">Format: @username</small>
                            </div>

                            <div class="form-group">
                                <label>Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 