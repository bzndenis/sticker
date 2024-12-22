<?php 
$data['title'] = 'Edit Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Edit Koleksi</h4>
                        <a href="<?= base_url('admin/collections') ?>" class="btn btn-secondary">Kembali</a>
                    </div>

                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/edit_collection/'.$collection->id) ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Koleksi</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= set_value('name', $collection->name) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category->id ?>" 
                                            <?= set_value('category_id', $collection->category_id) == $category->id ? 'selected' : '' ?>>
                                        <?= $category->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Stiker</label>
                            <input type="number" name="total_stickers" class="form-control" 
                                   value="<?= set_value('total_stickers', $collection->total_stickers) ?>" required>
                            <small class="text-muted">
                                Jumlah stiker saat ini: <?= $collection->total_stickers ?>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4"><?= set_value('description', $collection->description) ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/stickers/'.$collection->id) ?>" 
                               class="btn btn-info">
                                <i class="bi bi-images"></i> Kelola Stiker
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 