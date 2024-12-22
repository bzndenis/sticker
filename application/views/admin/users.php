<?php 
$data['title'] = 'Manajemen Pengguna';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Pengguna</h2>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="bi bi-download"></i> Export Data
            </button>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?status=active">Aktif</a></li>
                    <li><a class="dropdown-item" href="?status=inactive">Tidak Aktif</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?">Semua</a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari username atau email..." 
                           value="<?= $this->input->get('search') ?>">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="username" <?= $this->input->get('sort') == 'username' ? 'selected' : '' ?>>
                            Username
                        </option>
                        <option value="created_at" <?= $this->input->get('sort') == 'created_at' ? 'selected' : '' ?>>
                            Tanggal Bergabung
                        </option>
                        <option value="last_login" <?= $this->input->get('sort') == 'last_login' ? 'selected' : '' ?>>
                            Login Terakhir
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna -->
    <div class="card">
        <div class="card-body">
            <?php if(empty($users)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Tidak ada pengguna yang ditemukan</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Bergabung</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('admin/user_detail/'.$user->id) ?>" 
                                           class="text-decoration-none">
                                            <?= $user->username ?>
                                        </a>
                                    </td>
                                    <td><?= $user->email ?></td>
                                    <td>
                                        <?php if($user->is_active): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($user->created_at)) ?></td>
                                    <td>
                                        <?= $user->last_login ? date('d M Y H:i', strtotime($user->last_login)) : '-' ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/user_detail/'.$user->id) ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if(!$user->is_admin): ?>
                                                <button onclick="toggleStatus(<?= $user->id ?>, <?= $user->is_active ?>)" 
                                                        class="btn btn-sm <?= $user->is_active ? 'btn-warning' : 'btn-success' ?>">
                                                    <i class="bi bi-<?= $user->is_active ? 'pause' : 'play' ?>"></i>
                                                </button>
                                                <button onclick="confirmDelete(<?= $user->id ?>)" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/export_users') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Format File</label>
                        <select name="format" class="form-select" required>
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data yang Diexport</label>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="username" class="form-check-input" checked>
                            <label class="form-check-label">Username</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="email" class="form-check-input" checked>
                            <label class="form-check-label">Email</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="created_at" class="form-check-input" checked>
                            <label class="form-check-label">Tanggal Bergabung</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="last_login" class="form-check-input" checked>
                            <label class="form-check-label">Login Terakhir</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-download"></i> Export
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        window.location.href = '<?= base_url('admin/delete_user/') ?>' + id;
    }
}

function toggleStatus(id, currentStatus) {
    const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
    if(confirm(`Apakah Anda yakin ingin ${action} pengguna ini?`)) {
        window.location.href = '<?= base_url('admin/toggle_user_status/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 