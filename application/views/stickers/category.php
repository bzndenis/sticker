<?php $this->load->view('templates/header', ['title' => 'Kelola Stiker - '.$category->name]); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Kelola Stiker: <?= $category->name ?></h4>
                <a href="<?= base_url('stickers/manage') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Upload Image Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Upload Gambar Kumpulan Stiker</h5>
                    <?= form_open_multipart('stickers/category/'.$category->id, ['class' => 'mb-3']) ?>
                        <div class="mb-3">
                            <label class="form-label">Pilih Gambar</label>
                            <input type="file" name="image" class="form-control" required>
                            <small class="text-muted">Format: JPG/PNG, Max: 2MB</small>
                        </div>
                        
                        <!-- Sticker Quantities -->
                        <h6 class="mb-3">Jumlah Stiker</h6>
                        <div class="row g-3 mb-3">
                            <?php for($i = 1; $i <= 9; $i++): ?>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" 
                                               name="quantities[<?= $i ?>]" 
                                               class="form-control" 
                                               id="quantity<?= $i ?>"
                                               value="<?= isset($stickers[$i-1]->user_sticker['quantity']) ? $stickers[$i-1]->user_sticker['quantity'] : 0 ?>"
                                               min="0">
                                        <label for="quantity<?= $i ?>">Stiker #<?= $i ?></label>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                    <?= form_close() ?>

                    <?php if(!empty($stickers[0]->user_sticker['image_path'])): ?>
                        <div class="mt-3">
                            <h6>Preview Gambar:</h6>
                            <img src="<?= base_url('uploads/stickers/'.$stickers[0]->user_sticker['image_path']) ?>" 
                                 alt="Sticker Collection" 
                                 class="img-fluid rounded">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informasi Kategori -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Kategori</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <strong>Total Stiker:</strong> 9
                    </p>
                    <p class="mb-0">
                        <strong>Stiker Dimiliki:</strong> 
                        <?= count(array_filter($stickers, function($s) { 
                            return $s->user_sticker !== null; 
                        })) ?> dari 9
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 