<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit User</h4>

                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                        <?php endif; ?>

                        <form method="post">
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
                                <label>Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="isActive" name="is_active"
                                           <?= set_checkbox('is_active', '1', $user->is_active) ?>>
                                    <label class="custom-control-label" for="isActive">
                                        User Aktif
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="isAdmin" name="is_admin"
                                           <?= set_checkbox('is_admin', '1', $user->is_admin) ?>>
                                    <label class="custom-control-label" for="isAdmin">
                                        Hak Akses Admin
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-light">
                                Batal
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 