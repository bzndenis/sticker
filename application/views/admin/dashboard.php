<?php 
$data['title'] = 'Dashboard Admin';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Dashboard Admin</h2>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Kategori</h6>
                    <h2 class="mb-0"><?= $total_categories ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Stiker</h6>
                    <h2 class="mb-0"><?= $total_stickers ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Users</h6>
                    <h2 class="mb-0"><?= $total_users ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Pertukaran</h6>
                    <h2 class="mb-0"><?= $total_trades ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Manajemen Kategori -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Daftar Kategori</h5>
                        <button type="button" class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="bi bi-plus"></i> Tambah Kategori
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Total Stiker</th>
                                    <th>Progress Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($categories)): ?>
                                    <?php foreach($categories as $category): ?>
                                        <tr>
                                            <td><?= $category->name ?></td>
                                            <td>9</td>
                                            <td>
                                                <?php 
                                                $uploaded = isset($category->uploaded_count) ? 
                                                           $category->uploaded_count : 0;
                                                $progress = ($uploaded / 9) * 100;
                                                ?>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?= $progress ?>%"></div>
                                                </div>
                                                <small class="text-muted"><?= $uploaded ?>/9 terupload</small>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/categories/manage/'.$category->id) ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button onclick="deleteCategory(<?= $category->id ?>)" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Belum ada kategori</p>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/add_category') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteCategory(id) {
    if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        window.location.href = '<?= base_url('admin/categories/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 