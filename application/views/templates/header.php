<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/owl-carousel-2/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/owl-carousel-2/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom_animasi.css') ?>">
</head>

<style>
    /* Navbar styles */
    .navbar {
        padding: 0;
        width: 100%;
        height: 70px;
        position: fixed;
        top: 0;
        z-index: 999;
        background: #191c24;
    }

    .navbar .navbar-menu-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 2rem;
        height: 100%;
    }

    /* Brand/Logo styles */
    .sidebar-brand-wrapper {
        width: 260px;
        height: 70px;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        background: #191c24;
    }

    .sidebar-brand-wrapper .brand-logo img {
        max-height: 28px;
        width: auto;
    }

    .sidebar-brand-wrapper .brand-logo-mini {
        display: none;
    }

    /* Navigation menu styles */
    .sidebar .nav {
        padding-top: 1rem;
    }

    .sidebar .nav .nav-item {
        padding: 0.25rem 1rem;
        width: 100%;
    }

    .sidebar .nav .nav-item .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #6c7293;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .sidebar .nav .nav-item .nav-link:hover,
    .sidebar .nav .nav-item.active .nav-link {
        color: #ffffff;
        background: #0f1015;
    }

    .sidebar .nav .nav-item .nav-link i {
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    /* Dropdown styles */
    .dropdown-menu {
        background: #191c24;
        border: none;
        border-radius: 0.25rem;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        color: #6c7293;
        padding: 0.5rem 1.5rem;
    }

    .dropdown-item:hover {
        color: #ffffff;
        background: #0f1015;
    }

    /* Responsive styles */
    @media (max-width: 991px) {
        .sidebar-brand-wrapper {
            width: 70px;
        }
        
        .sidebar-brand-wrapper .brand-logo {
            display: none;
        }
        
        .sidebar-brand-wrapper .brand-logo-mini {
            display: block;
        }
        
        .navbar .navbar-menu-wrapper {
            padding: 0 1rem;
        }
        
        .navbar-nav {
            margin: 0;
        }
        
        .nav-item {
            padding: 0.25rem 0.5rem;
        }
        
        .navbar-toggler {
            padding: 0.25rem;
            font-size: 1.2rem;
            border: none;
            color: #6c7293;
        }
        
        .navbar-profile-name {
            display: none;
        }
    }
</style>

<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="<?= base_url('dashboard') ?>">
                    <img src="<?= base_url('referensi/assets/images/logo.svg') ?>" alt="logo" />
                </a>
                <a class="sidebar-brand brand-logo-mini" href="<?= base_url('dashboard') ?>">
                    <img src="<?= base_url('referensi/assets/images/logo-mini.svg') ?>" alt="logo" />
                </a>
            </div>
            <ul class="nav">
                <!-- Menu Utama -->
                <li class="nav-item menu-items <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <i class="mdi mdi-view-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <!-- Menu Sticker -->
                <li class="nav-item menu-items <?= $this->uri->segment(1) == 'stickers' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('stickers') ?>">
                        <i class="mdi mdi-sticker-emoji menu-icon"></i>
                        <span class="menu-title">Katalog Sticker</span>
                    </a>
                </li>

                <!-- Menu Koleksi -->
                <li class="nav-item menu-items <?= $this->uri->segment(1) == 'collection' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('collection') ?>">
                        <i class="mdi mdi-folder-multiple-image menu-icon"></i>
                        <span class="menu-title">Koleksi Saya</span>
                    </a>
                </li>

                <!-- Menu Pertukaran -->
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#trades" aria-expanded="false">
                        <i class="mdi mdi-swap-horizontal menu-icon"></i>
                        <span class="menu-title">Pertukaran</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="trades">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('trades/requests') ?>">Permintaan Tukar</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('tradeable') ?>">Sticker Dapat Ditukar</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('trades/history') ?>">Riwayat Pertukaran</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Menu Profil -->
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#profile" aria-expanded="false">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">Profil</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="profile">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('profile') ?>">Profil Saya</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('profile/settings') ?>">Pengaturan Akun</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('profile/notifications') ?>">Pengaturan Notifikasi</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Menu Notifikasi -->
                <li class="nav-item menu-items <?= $this->uri->segment(1) == 'notifications' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('notifications') ?>">
                        <i class="mdi mdi-bell menu-icon"></i>
                        <span class="menu-title">Notifikasi</span>
                        <span class="badge badge-danger notification-count">0</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>">
                        <img src="<?= base_url('referensi/assets/images/logo-mini.svg') ?>" alt="logo" />
                    </a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <p class="mb-0 navbar-profile-name">
                                        <?= $this->session->userdata('name') ?>
                                    </p>
                                    <i class="mdi mdi-menu-down"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="<?= base_url('auth/logout') ?>">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Logout</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>