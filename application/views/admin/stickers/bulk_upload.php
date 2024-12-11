<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Import Sticker dari Excel</h4>

                        <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h5>Petunjuk Import:</h5>
                                    <ol>
                                        <li>Download template Excel terlebih dahulu</li>
                                        <li>Isi data sesuai format yang ada di template</li>
                                        <li>Pastikan kategori sudah ada di sistem</li>
                                        <li>Upload file Excel yang sudah diisi</li>
                                    </ol>
                                </div>

                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>File Excel</label>
                                        <input type="file" name="excel_file" class="form-control-file" 
                                               accept=".xlsx, .xls" required>
                                        <small class="form-text text-muted">
                                            Format: XLS, XLSX. Maksimal 2MB
                                        </small>
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-primary">
                                        <i class="mdi mdi-upload"></i> Upload dan Import
                                    </button>
                                    <a href="<?= base_url('assets/templates/sticker_import_template.xlsx') ?>" 
                                       class="btn btn-info">
                                        <i class="mdi mdi-download"></i> Download Template
                                    </a>
                                    <a href="<?= base_url('admin/stickers') ?>" class="btn btn-light">
                                        Kembali
                                    </a>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Daftar ID Kategori</h5>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama Kategori</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($categories as $category): ?>
                                                    <tr>
                                                        <td><?= $category->id ?></td>
                                                        <td><?= $category->name ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validasi ukuran file sebelum upload
$('input[name="excel_file"]').change(function() {
    if (this.files[0].size > 2097152) { // 2MB in bytes
        Swal.fire({
            title: 'Error!',
            text: 'Ukuran file terlalu besar. Maksimal 2MB',
            icon: 'error'
        });
        $(this).val('');
    }
});
</script> 