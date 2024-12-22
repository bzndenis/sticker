<?php 
$data['title'] = 'Tambah Stiker - ' . $collection->name;
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-1">Tambah Stiker Baru</h4>
                            <h6 class="text-muted"><?= $collection->name ?></h6>
                        </div>
                        <a href="<?= base_url('admin/stickers/'.$collection->id) ?>" class="btn btn-secondary">Kembali</a>
                    </div>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open_multipart('admin/add_sticker/'.$collection->id, ['id' => 'addStickerForm']) ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Stiker</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Stiker</label>
                            <input type="text" name="number" class="form-control" required>
                            <small class="text-muted">
                                Nomor urut stiker dalam koleksi ini
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Stiker</label>
                            <div class="input-group">
                                <input type="file" name="sticker_image" class="form-control" 
                                       accept="image/*" required id="stickerImage">
                                <button type="button" class="btn btn-outline-secondary" 
                                        onclick="document.getElementById('stickerImage').value = ''">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div id="imagePreview" class="mt-2 text-center d-none">
                                <img src="" alt="Preview" style="max-height: 200px;" class="img-thumbnail">
                            </div>
                            <small class="text-muted d-block mt-1">
                                Format yang didukung: JPG, JPEG, PNG, GIF. Maksimal 2MB
                            </small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small>
                                    <i class="bi bi-info-circle"></i>
                                    Stiker <?= count($stickers) ?> dari <?= $collection->total_stickers ?> telah ditambahkan
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Stiker
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview gambar sebelum upload
document.getElementById('stickerImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.querySelector('img').src = e.target.result;
        preview.classList.remove('d-none');
    }

    if(file) {
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('d-none');
    }
});

// Validasi form sebelum submit
document.getElementById('addStickerForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('stickerImage');
    const file = fileInput.files[0];
    
    if(file && file.size > 2 * 1024 * 1024) { // 2MB
        e.preventDefault();
        alert('Ukuran file terlalu besar. Maksimal 2MB');
        return false;
    }
    
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if(file && !allowedTypes.includes(file.type)) {
        e.preventDefault();
        alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF');
        return false;
    }
});
</script>

<?php $this->load->view('templates/footer'); ?> 