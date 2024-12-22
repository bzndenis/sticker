<?php 
$data['title'] = 'Tambah Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Tambah Koleksi Baru</h4>
                        <a href="<?= base_url('admin/collections') ?>" class="btn btn-secondary">Kembali</a>
                    </div>

                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/add_collection') ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Koleksi</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= set_value('name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category->id ?>" 
                                            <?= set_value('category_id') == $category->id ? 'selected' : '' ?>>
                                        <?= $category->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mt-2">
                                <a href="<?= base_url('admin/categories') ?>" class="text-decoration-none">
                                    <i class="bi bi-plus-circle"></i> Tambah Kategori Baru
                                </a>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Stiker</label>
                            <input type="number" name="total_stickers" class="form-control" 
                                   value="<?= set_value('total_stickers') ?>" required>
                            <small class="text-muted">
                                Masukkan jumlah total stiker dalam koleksi ini
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"><?= set_value('description') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Koleksi
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 