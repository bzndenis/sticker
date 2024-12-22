<?php 
$data['title'] = 'Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Koleksi Stiker</h2>
        <a href="<?= base_url('admin/collections/add') ?>" class="btn btn-primary">
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

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari koleksi..." value="<?= $search ?>">
                </div>
                <div class="col-md-5">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>" 
                                    <?= $selected_category == $category->id ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
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

    <!-- Daftar Koleksi -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Koleksi</th>
                            <th>Kategori</th>
                            <th>Total Stiker</th>
                            <th>Total Dimiliki</th>
                            <th>Total Ditukar</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($collections)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-collection text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Belum ada koleksi</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($collections as $collection): ?>
                                <tr>
                                    <td><?= $collection->name ?></td>
                                    <td><?= $collection->category_name ?></td>
                                    <td><?= $collection->total_stickers ?></td>
                                    <td><?= $collection->total_owned ?></td>
                                    <td><?= $collection->total_traded ?></td>
                                    <td><?= date('d M Y', strtotime($collection->created_at)) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/collections/edit/'.$collection->id) ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button onclick="deleteCollection(<?= $collection->id ?>, '<?= $collection->name ?>')" 
                                                    class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
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

<script>
function deleteCollection(id, name) {
    if(confirm(`Apakah Anda yakin ingin menghapus koleksi "${name}"?\nSemua stiker dalam koleksi ini akan ikut terhapus.`)) {
        window.location.href = '<?= base_url('admin/collections/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 