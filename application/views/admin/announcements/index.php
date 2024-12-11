<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Daftar Pengumuman</h4>
                            <a href="<?= base_url('admin/announcements/add') ?>" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Tambah Pengumuman
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

                        <div class="table-responsive">
                            <table class="table table-hover" id="announcementsTable">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tipe</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($announcements as $announcement): ?>
                                    <tr>
                                        <td><?= $announcement->title ?></td>
                                        <td>
                                            <span class="badge badge-<?= get_announcement_type_badge($announcement->type) ?>">
                                                <?= ucfirst($announcement->type) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($announcement->start_date)) ?></td>
                                        <td>
                                            <?= $announcement->end_date ? date('d M Y', strtotime($announcement->end_date)) : '-' ?>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="status<?= $announcement->id ?>"
                                                       <?= $announcement->is_active ? 'checked' : '' ?>
                                                       onchange="toggleStatus(<?= $announcement->id ?>)">
                                                <label class="custom-control-label" 
                                                       for="status<?= $announcement->id ?>"></label>
                                            </div>
                                        </td>
                                        <td><?= $announcement->created_by_username ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/announcements/edit/'.$announcement->id) ?>" 
                                               class="btn btn-sm btn-outline-primary mr-2">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteAnnouncement(<?= $announcement->id ?>)">
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
    $('#announcementsTable').DataTable({
        "order": [[ 2, "desc" ]],
        "pageLength": 25
    });
});

function toggleStatus(id) {
    const status = $('#status'+id).prop('checked') ? 1 : 0;
    
    $.ajax({
        url: '<?= base_url("admin/announcements/toggle_status/") ?>' + id,
        type: 'POST',
        data: { status: status },
        success: function(response) {
            if(response.success) {
                Toast.fire({
                    icon: 'success',
                    title: 'Status pengumuman berhasil diperbarui'
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal memperbarui status pengumuman'
                });
                // Kembalikan switch ke posisi semula
                $('#status'+id).prop('checked', !status);
            }
        }
    });
}

function deleteAnnouncement(id) {
    Swal.fire({
        title: 'Hapus Pengumuman?',
        text: 'Pengumuman yang sudah dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/announcements/delete/") ?>' + id,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'Pengumuman telah dihapus', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Gagal menghapus pengumuman', 'error');
                    }
                }
            });
        }
    });
}
</script> 