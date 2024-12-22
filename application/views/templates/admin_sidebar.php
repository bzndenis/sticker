<div class="sidebar">
    <a href="<?= base_url('admin/dashboard') ?>" class="sidebar-brand">
        <i class="bi bi-shield-lock"></i>
        Admin Panel
    </a>
    
    <ul class="sidebar-menu">
        <li class="menu-header">Menu Utama</li>
        <li class="menu-item">
            <a href="<?= base_url('admin/dashboard') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2"></i>
                Dashboard
            </a>
        </li>
        
        <li class="menu-header">Manajemen</li>
        <li class="menu-item">
            <a href="<?= base_url('admin/users') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'users' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                Pengguna
            </a>
        </li>
        <li class="menu-item">
            <a href="<?= base_url('admin/stickers') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'stickers' ? 'active' : '' ?>">
                <i class="bi bi-collection"></i>
                Stiker
            </a>
        </li>
        <li class="menu-item">
            <a href="<?= base_url('admin/trades') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'trades' ? 'active' : '' ?>">
                <i class="bi bi-arrow-left-right"></i>
                Pertukaran
            </a>
        </li>
        
        <li class="menu-header">Laporan</li>
        <li class="menu-item">
            <a href="<?= base_url('admin/reports') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'reports' ? 'active' : '' ?>">
                <i class="bi bi-graph-up"></i>
                Statistik
            </a>
        </li>
        
        <li class="menu-header">Pengaturan</li>
        <li class="menu-item">
            <a href="<?= base_url('admin/settings') ?>" 
               class="menu-link <?= $this->uri->segment(2) == 'settings' ? 'active' : '' ?>">
                <i class="bi bi-gear"></i>
                Pengaturan
            </a>
        </li>
        <li class="menu-item">
            <a href="<?= base_url() ?>" class="menu-link">
                <i class="bi bi-box-arrow-up-right"></i>
                Lihat Situs
            </a>
        </li>
        <li class="menu-item">
            <a href="<?= base_url('auth/logout') ?>" class="menu-link text-danger">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>
    </ul>
</div> 