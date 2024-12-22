<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('admin') ?>">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>" 
                       href="<?= base_url('admin/dashboard') ?>">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'categories' ? 'active' : '' ?>" 
                       href="<?= base_url('admin/categories') ?>">
                        <i class="bi bi-tags"></i> Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'users' ? 'active' : '' ?>" 
                       href="<?= base_url('admin/users') ?>">
                        <i class="bi bi-people"></i> Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'trades' ? 'active' : '' ?>" 
                       href="<?= base_url('admin/trades') ?>">
                        <i class="bi bi-arrow-left-right"></i> Pertukaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $this->uri->segment(2) == 'reports' ? 'active' : '' ?>" 
                       href="<?= base_url('admin/reports') ?>">
                        <i class="bi bi-graph-up"></i> Laporan
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Situs
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> 