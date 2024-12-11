<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Daftar Sticker</h4>
                            <div>
                                <a href="<?= base_url('admin/stickers/bulk_upload') ?>" 
                                   class="btn btn-info mr-2">
                                    <i class="mdi mdi-file-excel"></i> Import Excel
                                </a>
                                <a href="<?= base_url('admin/stickers/add') ?>" 
                                   class="btn btn-primary">
                                    <i class="mdi mdi-plus"></i> Tambah Sticker
                                </a>
                            </div>
                        </div>

                        <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover" id="stickersTable">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Total Dimiliki</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($stickers as $sticker): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                                 alt="<?= $sticker->name ?>" style="width: 50px">
                                        </td>
                                        <td><?= $sticker->name ?></td>
                                        <td><?= $sticker->category_name ?></td>
                                        <td><?= $sticker->description ?></td>
                                        <td><?= $sticker->total_owned ?></td>
                                        <td><?= date('d M Y', strtotime($sticker->created_at)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/stickers/edit/'.$sticker->id) ?>" 
                                               class="btn btn-sm btn-outline-primary mr-2">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteSticker(<?= $sticker->id ?>)">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
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

<script>
$(document).ready(function() {
    $('#stickersTable').DataTable({
        "order": [[ 5, "desc" ]],
        "pageLength": 25
    });
});

function deleteSticker(stickerId) {
    Swal.fire({
        title: 'Hapus Sticker?',
        text: 'Sticker yang sudah dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/stickers/delete/") ?>' + stickerId,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'Sticker telah dihapus', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Gagal menghapus sticker', 'error');
                    }
                }
            });
        }
    });
}
</script> 