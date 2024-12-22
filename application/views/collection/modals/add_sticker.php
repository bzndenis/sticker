<!-- Add Sticker Modal Content -->
<div class="modal-header border-0">
    <h5 class="modal-title">Tambah Stiker Baru</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <?= form_open_multipart('collection/add', ['id' => 'addStickerForm']) ?>
        <div class="mb-3">
            <label class="form-label">Nama Stiker</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
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
            <label class="form-label">Jumlah</label>
            <input type="number" name="quantity" class="form-control" min="1" value="1" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Gambar Stiker</label>
            <div class="input-group">
                <input type="file" name="image" class="form-control" accept="image/*" required>
                <button class="btn btn-outline-light" type="button" onclick="previewImage()">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div id="imagePreview" class="mt-2 d-none">
                <img src="" class="img-fluid rounded">
            </div>
        </div>
        
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_tradeable" class="form-check-input" id="tradeableCheck">
                <label class="form-check-label" for="tradeableCheck">
                    Dapat Ditukar
                </label>
            </div>
        </div>
    <?= form_close() ?>
</div>
<div class="modal-footer border-0">
    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
    <button type="submit" form="addStickerForm" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Tambah
    </button>
</div> 