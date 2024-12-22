<?php 
$data['title'] = 'Manajemen Kategori';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Kategori</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
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
            <?php if(ENVIRONMENT === 'development'): ?>
                <br>
                <small>Last Query: <?= $this->db->last_query() ?></small>
                <br>
                <small>DB Error: <?= print_r($this->db->error(), true) ?></small>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Total Stiker</th>
                            <th>Progress Upload</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $category): ?>
                            <tr>
                                <td><?= $category->name ?></td>
                                <td><?= $category->total_stickers ?>/9</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <?php $progress = ($category->total_stickers / 9) * 100; ?>
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?= $progress ?>%">
                                            <?= number_format($progress, 1) ?>%
                                        </div>
                                    </div>
                                </td>
                                <td><?= date('d M Y', strtotime($category->created_at)) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" 
                                            onclick="editCategory(<?= $category->id ?>, '<?= $category->name ?>')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" 
                                            onclick="deleteCategory(<?= $category->id ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/categories/add') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" required 
                               maxlength="100" placeholder="Masukkan nama kategori">
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

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/categories/edit') ?>" method="post">
                <input type="hidden" name="category_id" id="edit_category_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" id="edit_category_name" required>
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
function editCategory(id, name) {
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_category_name').value = name;
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
}

function deleteCategory(id) {
    if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        window.location.href = '<?= base_url('admin/categories/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 