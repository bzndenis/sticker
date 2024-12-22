<?php 
$data['title'] = 'Edit Koleksi';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <!-- Form Edit Koleksi -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Edit Koleksi</h4>
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

                    <?= form_open('admin/collections/edit/'.$collection->id) ?>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category->id ?>" 
                                            <?= set_select('category_id', $category->id, 
                                                         $category->id == $collection->category_id) ?>>
                                        <?= $category->name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Koleksi</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= set_value('name', $collection->name) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= set_value('description', $collection->description) ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <?php if(empty($stickers)): ?>
                                <button type="button" onclick="deleteCollection(<?= $collection->id ?>, '<?= $collection->name ?>')" 
                                        class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus Koleksi
                                </button>
                            <?php endif; ?>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Daftar Stiker -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Stiker dalam Koleksi</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStickerModal">
                            <i class="bi bi-plus-lg"></i> Tambah Stiker
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(empty($stickers)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-images text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">Belum ada stiker dalam koleksi ini</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach($stickers as $sticker): ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                                             class="card-img-top sticker-img" alt="<?= $sticker->name ?>">
                                        <div class="card-body">
                                            <h6 class="card-title mb-2"><?= $sticker->name ?></h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary">No. <?= $sticker->number ?></span>
                                                <button onclick="deleteSticker(<?= $sticker->id ?>, '<?= $sticker->name ?>')" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Stiker -->
<div class="modal fade" id="addStickerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stiker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/stickers/add/'.$collection->id) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Stiker</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Urut</label>
                        <input type="number" name="number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Stiker</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Stiker</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
function deleteCollection(id, name) {
    if(confirm(`Apakah Anda yakin ingin menghapus koleksi "${name}"?`)) {
        window.location.href = '<?= base_url('admin/collections/delete/') ?>' + id;
    }
}

function deleteSticker(id, name) {
    if(confirm(`Apakah Anda yakin ingin menghapus stiker "${name}"?`)) {
        window.location.href = '<?= base_url('admin/stickers/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 