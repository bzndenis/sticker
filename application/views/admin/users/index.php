<?php 
$data['title'] = 'Pengguna';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pengguna</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-download"></i> Export Data
        </button>
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

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('admin/users/search') ?>" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" 
                           placeholder="Cari username/email..." 
                           value="<?= isset($keyword) ? $keyword : '' ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" <?= isset($status) && $status == 'active' ? 'selected' : '' ?>>
                            Aktif
                        </option>
                        <option value="inactive" <?= isset($status) && $status == 'inactive' ? 'selected' : '' ?>>
                            Tidak Aktif
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="">Urut Berdasarkan</option>
                        <option value="username" <?= isset($sort) && $sort == 'username' ? 'selected' : '' ?>>
                            Username
                        </option>
                        <option value="created_at" <?= isset($sort) && $sort == 'created_at' ? 'selected' : '' ?>>
                            Tanggal Daftar
                        </option>
                        <option value="last_login" <?= isset($sort) && $sort == 'last_login' ? 'selected' : '' ?>>
                            Login Terakhir
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Login Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-people text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Tidak ada pengguna ditemukan</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td>
                                        <?php if($user->is_admin): ?>
                                            <span class="badge bg-primary">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-<?= $user->is_active ? 'success' : 'danger' ?>">
                                                <?= $user->is_active ? 'Aktif' : 'Tidak Aktif' ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y H:i', strtotime($user->created_at)) ?></td>
                                    <td><?= $user->last_login ? date('d M Y H:i', strtotime($user->last_login)) : '-' ?></td>
                                    <td>
                                        <?php if(!$user->is_admin): ?>
                                            <div class="btn-group">
                                                <button onclick="toggleStatus(<?= $user->id ?>, '<?= $user->username ?>', <?= $user->is_active ?>)" 
                                                        class="btn btn-sm btn-<?= $user->is_active ? 'warning' : 'success' ?>">
                                                    <i class="bi bi-<?= $user->is_active ? 'x-lg' : 'check-lg' ?>"></i>
                                                </button>
                                                <button onclick="deleteUser(<?= $user->id ?>, '<?= $user->username ?>')" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
            <?= form_open('admin/users/export') ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Format File</label>
                        <select name="format" class="form-select" required>
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Kolom</label>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="username" class="form-check-input" checked>
                            <label class="form-check-label">Username</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="email" class="form-check-input" checked>
                            <label class="form-check-label">Email</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="is_active" class="form-check-input" checked>
                            <label class="form-check-label">Status</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="created_at" class="form-check-input" checked>
                            <label class="form-check-label">Tanggal Daftar</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="last_login" class="form-check-input" checked>
                            <label class="form-check-label">Login Terakhir</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
function toggleStatus(id, username, currentStatus) {
    const action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
    if(confirm(`Apakah Anda yakin ingin ${action} pengguna "${username}"?`)) {
        window.location.href = '<?= base_url('admin/users/toggle_status/') ?>' + id;
    }
}

function deleteUser(id, username) {
    if(confirm(`Apakah Anda yakin ingin menghapus pengguna "${username}"?\nSemua data terkait pengguna ini akan ikut terhapus.`)) {
        window.location.href = '<?= base_url('admin/users/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 