<?php $this->load->view('templates/header', ['title' => 'Edit Profil']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Profil</h4>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?= form_open_multipart('profile/edit') ?>
                        <div class="text-center mb-4">
                            <img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>" 
                                 class="rounded-circle profile-image mb-3" 
                                 alt="Profile Image"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Ubah Foto Profil</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                <small class="text-muted">Max 2MB (JPG, JPEG, PNG, GIF)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= set_value('username', $user->username) ?>" required>
                            <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= set_value('email', $user->email) ?>" required>
                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('profile') ?>" class="btn btn-light">Batal</a>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 