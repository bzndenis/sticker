<?php 
$data['title'] = 'Manajemen Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Koleksi</h2>
        <a href="<?= base_url('admin/add_collection') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Koleksi
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

    <!-- Filter Kategori -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET">
                <div class="col-md-4">
                    <label class="form-label">Filter Kategori</label>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>" 
                                    <?= $this->input->get('category') == $category->id ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" 
                           value="<?= $this->input->get('search') ?>" 
                           placeholder="Cari koleksi...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Koleksi -->
    <div class="card">
        <div class="card-body">
            <?php if(empty($collections)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-collection text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Tidak ada koleksi yang ditemukan</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Koleksi</th>
                                <th>Kategori</th>
                                <th>Total Stiker</th>
                                <th>Total Dimiliki</th>
                                <th>Total Ditukar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($collections as $collection): ?>
                                <tr>
                                    <td><?= $collection->name ?></td>
                                    <td><?= $collection->category_name ?></td>
                                    <td><?= $collection->total_stickers ?></td>
                                    <td><?= $collection->total_owned ?></td>
                                    <td><?= $collection->total_traded ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/stickers/'.$collection->id) ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-images"></i> Stiker
                                            </a>
                                            <a href="<?= base_url('admin/edit_collection/'.$collection->id) ?>" 
                                               class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <button onclick="confirmDelete(<?= $collection->id ?>)" 
                                                    class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
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

<script>
function confirmDelete(id) {
    if(confirm('Apakah Anda yakin ingin menghapus koleksi ini? Semua stiker dalam koleksi ini juga akan dihapus.')) {
        window.location.href = '<?= base_url('admin/delete_collection/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 