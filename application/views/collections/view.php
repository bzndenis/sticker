<?php 
$data['title'] = $category->name;
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><?= $category->name ?></h2>
            <p class="text-muted mb-0">Total <?= $sticker ? $sticker->quantity : 0 ?> stiker</p>
        </div>
        
        <?php if(!$sticker || !$sticker->image_path): ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload"></i> Upload Gambar Stiker
            </button>
        <?php endif; ?>
    </div>

    <!-- Informasi Stiker -->
    <div class="card">
        <div class="card-body">
            <?php if($sticker && $sticker->image_path): ?>
                <div class="text-center mb-4">
                    <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                         class="img-fluid sticker-img mb-3" alt="Stiker Kategori">
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Total Stiker dalam Kategori</label>
                            <input type="number" class="form-control" 
                                   value="<?= $sticker->quantity ?>" 
                                   onchange="updateTotalQuantity(<?= $sticker->id ?>, this.value)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Stiker yang Dimiliki</label>
                            <input type="number" class="form-control" 
                                   value="<?= $sticker->owned_quantity ?>" 
                                   max="<?= $sticker->quantity ?>"
                                   onchange="updateOwnedQuantity(<?= $sticker->id ?>, this.value)">
                        </div>
                    </div>
                </div>

                <?php if($sticker->owned_quantity > 1): ?>
                    <div class="form-check mt-3">
                        <input type="checkbox" class="form-check-input trade-toggle" 
                               data-sticker-id="<?= $sticker->id ?>"
                               <?= $sticker->is_for_trade ? 'checked' : '' ?>>
                        <label class="form-check-label">Dapat Ditukar</label>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Belum ada gambar stiker</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Gambar Stiker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('stickers/upload/'.$category->id) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gambar Stiker</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Stiker dalam Kategori</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
function updateTotalQuantity(stickerId, quantity) {
    $.post('<?= base_url('stickers/update_quantity') ?>', {
        sticker_id: stickerId,
        total_quantity: quantity
    })
    .done(function(response) {
        if(response.success) {
            location.reload();
        } else {
            alert('Gagal mengubah jumlah stiker');
        }
    });
}

function updateOwnedQuantity(stickerId, quantity) {
    $.post('<?= base_url('stickers/update_owned_quantity') ?>', {
        sticker_id: stickerId,
        owned_quantity: quantity
    })
    .done(function(response) {
        if(response.success) {
            location.reload();
        } else {
            alert('Gagal mengubah jumlah stiker yang dimiliki');
        }
    });
}

// Existing trade toggle code...
</script>

<?php $this->load->view('templates/footer'); ?> 