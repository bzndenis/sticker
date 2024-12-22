<?php $this->load->view('templates/header', ['title' => 'Edit Kategori']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Edit Kategori: <?= $category->name ?></h4>
                <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Upload Image Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Upload Gambar Stiker</h5>
                    <?= form_open_multipart('admin/categories/edit/'.$category->id, ['class' => 'mb-3']) ?>
                        <div class="mb-3">
                            <label class="form-label">Pilih Gambar</label>
                            <input type="file" name="image" class="form-control" required>
                            <small class="text-muted">Format: JPG/PNG, Max: 2MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Upload
                        </button>
                    <?= form_close() ?>

                    <?php if($stickers['sticker']->image_path): ?>
                        <div class="mt-3">
                            <img src="<?= base_url('uploads/stickers/'.$stickers['sticker']->image_path) ?>" 
                                 alt="Sticker" class="img-fluid" style="max-width: 200px;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sticker Quantities Form -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengaturan Jumlah Stiker</h5>
                    <?= form_open('admin/categories/edit/'.$category->id, ['class' => 'mb-3']) ?>
                        <div class="row g-3">
                            <?php for($i = 1; $i <= 9; $i++): ?>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" name="quantities[<?= $i ?>]" 
                                               class="form-control" id="quantity<?= $i ?>"
                                               value="<?= isset($stickers['quantities'][$i]) ? $stickers['quantities'][$i] : 0 ?>"
                                               min="0">
                                        <label for="quantity<?= $i ?>">Stiker #<?= $i ?></label>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 