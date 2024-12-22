<?php $this->load->view('templates/header', ['title' => 'Pengaturan']); ?>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush settings-menu">
                        <a href="#account" class="list-group-item active" data-bs-toggle="list">
                            <i class="bi bi-person me-3"></i>Akun
                        </a>
                        <a href="#notifications" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-bell me-3"></i>Notifikasi
                        </a>
                        <a href="#privacy" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-shield-lock me-3"></i>Privasi
                        </a>
                        <a href="#appearance" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-palette me-3"></i>Tampilan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-light btn-sm" onclick="clearCache()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Bersihkan Cache
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deactivateAccount()">
                            <i class="bi bi-exclamation-triangle me-2"></i>Nonaktifkan Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Account Settings -->
                <div class="tab-pane fade show active" id="account">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Pengaturan Akun</h5>
                            <?= form_open_multipart('settings/update_account', ['class' => 'settings-form']) ?>
                                <div class="row g-3">
                                    <div class="col-12 text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <?php if($user->avatar): ?>
                                                <img src="<?= base_url('uploads/avatars/' . $user->avatar) ?>" 
                                                     class="rounded-circle" alt="Avatar"
                                                     style="width: 100px; height: 100px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                                     style="width: 100px; height: 100px;">
                                                    <i class="bi bi-person-circle fs-1"></i>
                                                </div>
                                            <?php endif; ?>
                                            <label class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2"
                                                   style="cursor: pointer;">
                                                <i class="bi bi-camera text-white"></i>
                                                <input type="file" name="avatar" class="d-none" accept="image/*">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" 
                                               value="<?= $user->username ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="<?= $user->email ?>" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control" name="bio" rows="3"><?= $user->bio ?></textarea>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="mb-3">Ubah Password</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Pengaturan Notifikasi</h5>
                            <?= form_open('settings/update_notifications', ['class' => 'settings-form']) ?>
                                <div class="mb-4">
                                    <h6 class="mb-3">Email Notifikasi</h6>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="notify_trade" 
                                               id="notify_trade" <?= $settings->notify_trade ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="notify_trade">
                                            Permintaan pertukaran baru
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="notify_message" 
                                               id="notify_message" <?= $settings->notify_message ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="notify_message">
                                            Pesan baru
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="notify_news" 
                                               id="notify_news" <?= $settings->notify_news ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="notify_news">
                                            Berita dan update
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">Notifikasi Push</h6>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="push_enabled" 
                                               id="push_enabled" <?= $settings->push_enabled ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="push_enabled">
                                            Aktifkan notifikasi push
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Pengaturan
                                    </button>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="tab-pane fade" id="privacy">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Pengaturan Privasi</h5>
                            <?= form_open('settings/update_privacy', ['class' => 'settings-form']) ?>
                                <div class="mb-4">
                                    <h6 class="mb-3">Visibilitas Profil</h6>
                                    <select class="form-select" name="profile_visibility">
                                        <option value="public" <?= $settings->profile_visibility == 'public' ? 'selected' : '' ?>>
                                            Publik
                                        </option>
                                        <option value="friends" <?= $settings->profile_visibility == 'friends' ? 'selected' : '' ?>>
                                            Hanya Teman
                                        </option>
                                        <option value="private" <?= $settings->profile_visibility == 'private' ? 'selected' : '' ?>>
                                            Privat
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">Pengaturan Koleksi</h6>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="show_collection" 
                                               id="show_collection" <?= $settings->show_collection ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="show_collection">
                                            Tampilkan koleksi ke publik
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="show_trades" 
                                               id="show_trades" <?= $settings->show_trades ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="show_trades">
                                            Tampilkan riwayat pertukaran
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Pengaturan
                                    </button>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div class="tab-pane fade" id="appearance">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Pengaturan Tampilan</h5>
                            <?= form_open('settings/update_appearance', ['class' => 'settings-form']) ?>
                                <div class="mb-4">
                                    <h6 class="mb-3">Tema</h6>
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <div class="theme-option" data-theme="light">
                                                <div class="theme-preview bg-light"></div>
                                                <div class="form-check mt-2">
                                                    <input type="radio" class="form-check-input" name="theme" 
                                                           value="light" <?= $settings->theme == 'light' ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Terang</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="theme-option" data-theme="dark">
                                                <div class="theme-preview bg-dark"></div>
                                                <div class="form-check mt-2">
                                                    <input type="radio" class="form-check-input" name="theme" 
                                                           value="dark" <?= $settings->theme == 'dark' ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Gelap</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="theme-option" data-theme="auto">
                                                <div class="theme-preview bg-gradient"></div>
                                                <div class="form-check mt-2">
                                                    <input type="radio" class="form-check-input" name="theme" 
                                                           value="auto" <?= $settings->theme == 'auto' ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Otomatis</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-2"></i>Simpan Pengaturan
                                    </button>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-menu .list-group-item {
    background: transparent;
    border: none;
    color: #fff;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
}

.settings-menu .list-group-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.settings-menu .list-group-item.active {
    background: var(--primary-gradient);
}

.theme-preview {
    height: 100px;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.theme-option:hover .theme-preview {
    transform: translateY(-2px);
}

input[type="radio"]:checked ~ .theme-preview {
    border-color: var(--bs-primary);
}
</style>

<script>
function clearCache() {
    if(confirm('Apakah Anda yakin ingin membersihkan cache?')) {
        // Implementasi clear cache
    }
}

function deactivateAccount() {
    if(confirm('Apakah Anda yakin ingin menonaktifkan akun? Tindakan ini tidak dapat dibatalkan.')) {
        // Implementasi deactivate account
    }
}

// Preview avatar image before upload
document.querySelector('input[name="avatar"]')?.addEventListener('change', function(e) {
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