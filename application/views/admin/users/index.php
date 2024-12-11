<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Daftar User</h4>
                            <div>
                                <button onclick="exportUsers()" class="btn btn-info mr-2">
                                    <i class="mdi mdi-file-excel"></i> Export Excel
                                </button>
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

                        <div class="table-responsive">
                            <table class="table table-hover" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Total Sticker</th>
                                        <th>Total Trade</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        <th>Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><?= $user->username ?></td>
                                        <td><?= $user->email ?></td>
                                        <td><?= $user->total_stickers ?></td>
                                        <td><?= $user->total_trades ?></td>
                                        <td>
                                            <?php if($user->is_banned): ?>
                                            <span class="badge badge-danger">Banned</span>
                                            <?php else: ?>
                                            <span class="badge badge-<?= $user->is_active ? 'success' : 'warning' ?>">
                                                <?= $user->is_active ? 'Aktif' : 'Nonaktif' ?>
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $user->is_admin ? 'primary' : 'info' ?>">
                                                <?= $user->is_admin ? 'Admin' : 'User' ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($user->created_at)) ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                        type="button" data-toggle="dropdown">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" 
                                                       href="<?= base_url('admin/users/view/'.$user->id) ?>">
                                                        <i class="mdi mdi-eye"></i> Detail
                                                    </a>
                                                    <a class="dropdown-item" 
                                                       href="<?= base_url('admin/users/edit/'.$user->id) ?>">
                                                        <i class="mdi mdi-pencil"></i> Edit
                                                    </a>
                                                    <?php if(!$user->is_banned): ?>
                                                    <a class="dropdown-item text-warning" href="javascript:void(0)"
                                                       onclick="showBanModal(<?= $user->id ?>)">
                                                        <i class="mdi mdi-block-helper"></i> Ban
                                                    </a>
                                                    <?php else: ?>
                                                    <a class="dropdown-item text-success" href="javascript:void(0)"
                                                       onclick="unbanUser(<?= $user->id ?>)">
                                                        <i class="mdi mdi-check-circle"></i> Unban
                                                    </a>
                                                    <?php endif; ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                       onclick="deleteUser(<?= $user->id ?>)">
                                                        <i class="mdi mdi-delete"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
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

<!-- Modal Ban User -->
<div class="modal fade" id="banModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ban User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="banForm">
                    <input type="hidden" name="user_id" id="banUserId">
                    <div class="form-group">
                        <label>Durasi Ban (hari)</label>
                        <input type="number" name="duration" class="form-control" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Alasan</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="banUser()">Ban User</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        "order": [[ 6, "desc" ]],
        "pageLength": 25
    });
});

function showBanModal(userId) {
    $('#banUserId').val(userId);
    $('#banModal').modal('show');
}

function banUser() {
    const userId = $('#banUserId').val();
    const duration = $('input[name="duration"]').val();
    const reason = $('textarea[name="reason"]').val();
    
    $.ajax({
        url: '<?= base_url("admin/users/ban/") ?>' + userId,
        type: 'POST',
        data: { duration: duration, reason: reason },
        success: function(response) {
            if(response.success) {
                $('#banModal').modal('hide');
                Swal.fire('Berhasil!', 'User telah dibanned', 'success')
                .then(() => location.reload());
            } else {
                Swal.fire('Gagal!', 'Gagal membanned user', 'error');
            }
        }
    });
}

function unbanUser(userId) {
    Swal.fire({
        title: 'Unban User?',
        text: 'User akan dapat mengakses sistem kembali',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Unban',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/users/unban/") ?>' + userId,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'User telah diunban', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Gagal unban user', 'error');
                    }
                }
            });
        }
    });
}

function deleteUser(userId) {
    Swal.fire({
        title: 'Hapus User?',
        text: 'User yang sudah dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/users/delete/") ?>' + userId,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'User telah dihapus', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                }
            });
        }
    });
}

function exportUsers() {
    window.location.href = '<?= base_url("admin/users/export_users") ?>';
}
</script> 