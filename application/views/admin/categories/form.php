<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?= isset($category) ? 'Edit Kategori' : 'Tambah Kategori' ?>
                        </h4>

                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= set_value('name', isset($category) ? $category->name : '') ?>" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4" required><?= 
                                    set_value('description', isset($category) ? $category->description : '') 
                                ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Icon Kategori</label>
                                <?php if(isset($category) && $category->icon): ?>
                                <div class="mb-3">
                                    <img src="<?= base_url('assets/images/categories/'.$category->icon) ?>" 
                                         alt="Current Icon" class="img-thumbnail" style="height: 100px;">
                                </div>
                                <?php endif; ?>
                                <input type="file" name="icon" class="file-upload-default" accept="image/*">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled 
                                           placeholder="Upload Icon">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">
                                            Upload
                                        </button>
                                    </span>
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                    <?php if(isset($category) && $category->icon): ?>
                                    <br>Kosongkan jika tidak ingin mengubah icon.
                                    <?php endif; ?>
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/categories') ?>" class="btn btn-light">
                                Batal
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <?php if(isset($category)): ?>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Kategori</h4>
                        
                        <div class="mt-4">
                            <p class="mb-2">
                                <strong>Total Sticker:</strong><br>
                                <?= $category->total_stickers ?> sticker
                            </p>
                            <p class="mb-2">
                                <strong>Dibuat Pada:</strong><br>
                                <?= date('d M Y H:i', strtotime($category->created_at)) ?>
                            </p>
                            <?php if($category->updated_at): ?>
                            <p class="mb-0">
                                <strong>Terakhir Diperbarui:</strong><br>
                                <?= date('d M Y H:i', strtotime($category->updated_at)) ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <?php if($category->total_stickers > 0): ?>
                        <div class="alert alert-info mt-4">
                            <i class="mdi mdi-information-outline mr-2"></i>
                            Kategori ini memiliki <?= $category->total_stickers ?> sticker aktif.
                            Perubahan pada kategori akan mempengaruhi sticker-sticker tersebut.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/file-upload.js') ?>"></script>
<script>
$(document).ready(function() {
    // Preview gambar yang akan diupload
    $('input[name="icon"]').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if($('.img-thumbnail').length) {
                    $('.img-thumbnail').attr('src', e.target.result);
                } else {
                    $('<div class="mb-3"><img src="' + e.target.result + 
                      '" class="img-thumbnail" style="height: 100px;"></div>')
                        .insertBefore('.input-group');
                }
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script> 