<?php $this->load->view('templates/header', ['title' => 'Upload Stiker']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Upload Stiker Baru</h4>
                <a href="<?= base_url('stickers/manage') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= form_open_multipart('stickers/upload', ['class' => 'mb-3']) ?>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Stiker</label>
                    <input type="number" name="number" class="form-control" 
                           min="1" max="9" required>
                    <small class="text-muted">Masukkan nomor stiker (1-9)</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Stiker</label>
                    <input type="file" name="image" class="form-control" required>
                    <small class="text-muted">Format: JPG/PNG, Max: 2MB</small>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_for_trade">
                        <label class="form-check-label">Dapat Ditukar</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-2"></i>Upload
                </button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 