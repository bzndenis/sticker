<!-- Form Upload Stiker -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Stiker Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/stickers/add/'.$category->id) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Gambar</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <div class="form-text">
                            Format: JPG, PNG, GIF. Maksimal 2MB.
                        </div>
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