<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Daftar Kategori</h4>
                            <a href="<?= base_url('admin/categories/add') ?>" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Tambah Kategori
                            </a>
                        </div>

                        <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <div class="row">
                            <?php foreach($categories as $category): ?>
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <?php if($category->icon): ?>
                                            <img src="<?= base_url('assets/images/categories/'.$category->icon) ?>" 
                                                 alt="<?= $category->name ?>" class="mr-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                            <div class="mr-3 bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="mdi mdi-folder-outline" style="font-size: 24px;"></i>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <h5 class="mb-1"><?= $category->name ?></h5>
                                                <small class="text-muted">
                                                    <?= $category->total_stickers ?> sticker
                                                </small>
                                            </div>
                                        </div>
                                        
                                        <p class="text-muted mb-3" style="height: 40px; overflow: hidden;">
                                            <?= $category->description ?>
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted">
                                                    Dibuat: <?= date('d M Y', strtotime($category->created_at)) ?>
                                                </small>
                                            </div>
                                            <div>
                                                <a href="<?= base_url('admin/categories/edit/'.$category->id) ?>" 
                                                   class="btn btn-sm btn-outline-primary mr-2">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger"
                                                        onclick="deleteCategory(<?= $category->id ?>)">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteCategory(categoryId) {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: 'Kategori yang sudah dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/categories/delete/") ?>' + categoryId,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'Kategori telah dihapus', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', response.message || 'Gagal menghapus kategori', 'error');
                    }
                }
            });
        }
    });
}
</script> 