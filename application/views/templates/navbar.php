<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
            <div class="brand-icon me-2">
                <i class="bi bi-collection"></i>
            </div>
            Sticker Exchange
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>" 
                       href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'feed' ? 'active' : '' ?>" 
                       href="<?= base_url('feed') ?>">
                        <i class="bi bi-grid me-1"></i>Feed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'collection' ? 'active' : '' ?>" 
                       href="<?= base_url('collection') ?>">
                        <i class="bi bi-collection me-1"></i>Koleksi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(1) == 'trades' ? 'active' : '' ?>" 
                       href="<?= base_url('trades') ?>">
                        <i class="bi bi-arrow-left-right me-1"></i>Pertukaran
                    </a>
                </li>
            </ul>

            <?php if($this->session->userdata('logged_in')): ?>
                <ul class="navbar-nav">
                    <!-- Notifications -->
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative" href="<?= base_url('notifications') ?>">
                            <i class="bi bi-bell"></i>
                            <?php $unread_count = $this->notification_model->get_unread_notifications_count($this->session->userdata('user_id')); ?>
                            <?php if($unread_count > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $unread_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           data-bs-toggle="dropdown">
                            <?php if($this->session->userdata('avatar')): ?>
                                <img src="<?= base_url('uploads/avatars/' . $this->session->userdata('avatar')) ?>" 
                                     class="rounded-circle me-2" alt="Avatar"
                                     style="width: 32px; height: 32px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                     style="width: 32px; height: 32px;">
                                    <i class="bi bi-person"></i>
                                </div>
                            <?php endif; ?>
                            <span class="d-none d-lg-inline">
                                <?= $this->session->userdata('username') ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                                    <i class="bi bi-person me-2"></i>Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('stickers/manage') ?>">
                                    <i class="bi bi-grid-3x3 me-2"></i>Atur Stiker
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('stickers/upload') ?>">
                                    <i class="bi bi-upload me-2"></i>Upload Stiker
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('settings') ?>">
                                    <i class="bi bi-gear me-2"></i>Pengaturan
                                </a>
                            </li>
                            <?php if($this->session->userdata('is_admin')): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>">
                                        <i class="bi bi-speedometer2 me-2"></i>Admin Panel
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php if($this->session->userdata('is_admin')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/categories') ?>">
                                        <i class="bi bi-grid me-2"></i>Kelola Kategori
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/users') ?>">
                                        <i class="bi bi-people me-2"></i>Kelola User
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/trades') ?>">
                                        <i class="bi bi-arrow-left-right me-2"></i>Kelola Pertukaran
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                        <i class="bi bi-sliders me-2"></i>Pengaturan
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php else: ?>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                    <a href="<?= base_url('auth/register') ?>" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Register
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
.navbar {
    background: var(--dark-gradient);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-icon {
    width: 32px;
    height: 32px;
    background: var(--primary-gradient);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-link {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
    background: var(--primary-gradient);
}

.dropdown-menu {
    background: var(--dark-gradient);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.dropdown-item {
    color: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.dropdown-divider {
    border-color: rgba(255, 255, 255, 0.1);
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        background: var(--dark-gradient);
        padding: 1rem;
        border-radius: 12px;
        margin-top: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
}
</style>

<script>
// Tambahkan class active pada dropdown jika halaman aktif ada di dalamnya
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.dropdown-item').forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.closest('.nav-item.dropdown').querySelector('.nav-link').classList.add('active');
        }
    });
});
</script> 