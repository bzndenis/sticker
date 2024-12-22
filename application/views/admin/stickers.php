<?php 
$data['title'] = 'Manajemen Stiker - ' . $collection->name;
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Manajemen Stiker</h2>
            <h5 class="text-muted"><?= $collection->name ?></h5>
        </div>
        <div>
            <a href="<?= base_url('admin/collections') ?>" class="btn btn-secondary me-2">Kembali</a>
            <a href="<?= base_url('admin/add_sticker/'.$collection->id) ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Stiker
            </a>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Info Koleksi -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3 mb-md-0">
                        <small class="text-muted d-block">Total Stiker</small>
                        <h3 class="mb-0"><?= count($stickers) ?> / <?= $collection->total_stickers ?></h3>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?= (count($stickers) / $collection->total_stickers * 100) ?>%">
                            <?= number_format((count($stickers) / $collection->total_stickers * 100), 1) ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Stiker -->
    <?php if(empty($stickers)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-images text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada stiker dalam koleksi ini</p>
                <a href="<?= base_url('admin/add_sticker/'.$collection->id) ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Stiker Pertama
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($stickers as $sticker): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                             class="card-img-top" alt="<?= $sticker->name ?>"
                             style="height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h6 class="card-title"><?= $sticker->name ?></h6>
                            <p class="card-text text-muted">No. <?= $sticker->number ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-warning" 
                                        onclick="editSticker(<?= $sticker->id ?>)">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete(<?= $sticker->id ?>)">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Edit Stiker -->
<div class="modal fade" id="editStickerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Stiker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open_multipart('admin/edit_sticker', ['id' => 'editStickerForm']) ?>
                <input type="hidden" name="sticker_id" id="edit_sticker_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Stiker</label>
                        <input type="text" name="name" id="edit_sticker_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Stiker</label>
                        <input type="text" name="number" id="edit_sticker_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Stiker</label>
                        <input type="file" name="sticker_image" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Apakah Anda yakin ingin menghapus stiker ini?')) {
        window.location.href = '<?= base_url('admin/delete_sticker/') ?>' + id;
    }
}

function editSticker(id) {
    fetch('<?= base_url('admin/get_sticker/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_sticker_id').value = data.id;
            document.getElementById('edit_sticker_name').value = data.name;
            document.getElementById('edit_sticker_number').value = data.number;
            new bootstrap.Modal(document.getElementById('editStickerModal')).show();
        });
}
</script>

<?php $this->load->view('templates/footer'); ?> 