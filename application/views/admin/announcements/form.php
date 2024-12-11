<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?= isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?>
                        </h4>

                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" 
                                       value="<?= set_value('title', isset($announcement) ? $announcement->title : '') ?>" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Konten</label>
                                <textarea name="content" id="editor" class="form-control" rows="10" required><?= 
                                    set_value('content', isset($announcement) ? $announcement->content : '') 
                                ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tipe</label>
                                <select name="type" class="form-control" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="info" <?= set_select('type', 'info', 
                                        isset($announcement) && $announcement->type == 'info') ?>>Info</option>
                                    <option value="warning" <?= set_select('type', 'warning', 
                                        isset($announcement) && $announcement->type == 'warning') ?>>Warning</option>
                                    <option value="success" <?= set_select('type', 'success', 
                                        isset($announcement) && $announcement->type == 'success') ?>>Success</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="<?= set_value('start_date', 
                                           isset($announcement) ? date('Y-m-d', strtotime($announcement->start_date)) : '') ?>" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Berakhir (opsional)</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="<?= set_value('end_date', 
                                           isset($announcement) && $announcement->end_date ? 
                                           date('Y-m-d', strtotime($announcement->end_date)) : '') ?>">
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="isActive" name="is_active"
                                           <?= set_checkbox('is_active', '1', 
                                               isset($announcement) ? $announcement->is_active : true) ?>>
                                    <label class="custom-control-label" for="isActive">
                                        Aktif
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/announcements') ?>" class="btn btn-light">
                                Batal
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/plugins/ckeditor/ckeditor.js') ?>"></script>
<script>
CKEDITOR.replace('editor', {
    height: 300,
    removeButtons: 'Image'
});
</script> 