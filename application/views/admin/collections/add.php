<?php 
$data['title'] = 'Tambah Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Tambah Koleksi</h4>
                        <a href="<?= base_url('admin/collections') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/collections/add') ?>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category->id ?>" 
                                            <?= set_select('category_id', $category->id) ?>>
                                        <?= $category->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">
                                Pilih kategori untuk koleksi stiker ini
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Koleksi</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= set_value('name') ?>" required>
                            <small class="text-muted">
                                Nama koleksi harus unik dan belum digunakan
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= set_value('description') ?></textarea>
                            <small class="text-muted">
                                Berikan deskripsi singkat tentang koleksi ini
                            </small>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Setelah membuat koleksi, Anda dapat menambahkan stiker ke dalamnya melalui halaman edit koleksi.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Koleksi
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 