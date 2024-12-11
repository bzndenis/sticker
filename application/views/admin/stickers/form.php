<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?= isset($sticker) ? 'Edit Sticker' : 'Tambah Sticker' ?>
                        </h4>

                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Sticker</label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= set_value('name', isset($sticker) ? $sticker->name : '') ?>" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?= $category->id ?>" 
                                            <?= set_select('category_id', $category->id, 
                                                isset($sticker) && $sticker->category_id == $category->id) ?>>
                                        <?= $category->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4" required><?= 
                                    set_value('description', isset($sticker) ? $sticker->description : '') 
                                ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Gambar Sticker</label>
                                <?php if(isset($sticker) && $sticker->image): ?>
                                <div class="mb-3">
                                    <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                         alt="Current Image" style="max-width: 200px">
                                </div>
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control-file" 
                                       accept="image/*" <?= isset($sticker) ? '' : 'required' ?>>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal 2MB
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/stickers') ?>" class="btn btn-light">
                                Batal
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview gambar sebelum upload
$('input[name="image"]').change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('img[alt="Current Image"]').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script> 