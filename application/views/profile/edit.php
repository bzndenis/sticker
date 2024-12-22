<?php $this->load->view('templates/header', ['title' => 'Edit Profil']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Edit Profil</h4>
                        <a href="<?= base_url('profile') ?>" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>

                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open_multipart('profile/update', ['class' => 'profile-form']) ?>
                        <!-- Avatar Upload -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <?php if($user->avatar): ?>
                                    <img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>" 
                                         class="rounded-circle" alt="Avatar"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                                         style="width: 120px; height: 120px;">
                                        <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <label class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 cursor-pointer"
                                       style="cursor: pointer;">
                                    <i class="bi bi-camera text-white"></i>
                                    <input type="file" name="avatar" class="d-none" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" 
                                           value="<?= set_value('username', $user->username) ?>" required>
                                    <small class="text-muted">
                                        Username akan digunakan untuk login
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= set_value('email', $user->email) ?>" required>
                                    <small class="text-muted">
                                        Email akan digunakan untuk notifikasi
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Change Password -->
                        <h5 class="mb-3">Ubah Password</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">
                                        Kosongkan jika tidak ingin mengubah password
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview avatar image before upload
document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('.rounded-circle');
            img.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php $this->load->view('templates/footer'); ?> 