<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Daftar Laporan</h4>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                        id="bulkActionButton" data-toggle="dropdown" disabled>
                                    Aksi Massal
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0)" 
                                       onclick="bulkAction('mark_read')">
                                        <i class="mdi mdi-eye"></i> Tandai Dibaca
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)" 
                                       onclick="bulkAction('delete')">
                                        <i class="mdi mdi-delete"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="reportsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" 
                                                       id="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Tipe</th>
                                        <th>Pelapor</th>
                                        <th>User Dilaporkan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($reports as $report): ?>
                                    <tr class="<?= $report->status == 'new' ? 'table-warning' : '' ?>">
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input report-checkbox" 
                                                       id="check<?= $report->id ?>" value="<?= $report->id ?>">
                                                <label class="custom-control-label" 
                                                       for="check<?= $report->id ?>"></label>
                                            </div>
                                        </td>
                                        <td>#<?= $report->id ?></td>
                                        <td>
                                            <span class="badge badge-<?= get_report_type_badge($report->type) ?>">
                                                <?= ucfirst($report->type) ?>
                                            </span>
                                        </td>
                                        <td><?= $report->reporter_username ?></td>
                                        <td><?= $report->reported_username ?></td>
                                        <td><?= date('d M Y H:i', strtotime($report->created_at)) ?></td>
                                        <td>
                                            <span class="badge badge-<?= get_report_status_badge($report->status) ?>">
                                                <?= ucfirst($report->status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/reports/view/'.$report->id) ?>" 
                                               class="btn btn-sm btn-outline-info mr-2">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteReport(<?= $report->id ?>)">
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
    $('#reportsTable').DataTable({
        "order": [[ 5, "desc" ]],
        "pageLength": 25
    });
    
    // Handle checkbox
    $('#checkAll').change(function() {
        $('.report-checkbox').prop('checked', $(this).prop('checked'));
        toggleBulkAction();
    });
    
    $('.report-checkbox').change(function() {
        toggleBulkAction();
    });
});

function toggleBulkAction() {
    const checkedCount = $('.report-checkbox:checked').length;
    $('#bulkActionButton').prop('disabled', checkedCount === 0);
}

function bulkAction(action) {
    const ids = $('.report-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
    
    if (ids.length === 0) return;
    
    let confirmMessage = '';
    switch(action) {
        case 'mark_read':
            confirmMessage = 'Tandai semua laporan terpilih sebagai dibaca?';
            break;
        case 'delete':
            confirmMessage = 'Hapus semua laporan terpilih?';
            break;
    }
    
    Swal.fire({
        title: 'Konfirmasi',
        text: confirmMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/reports/bulk_action") ?>',
                type: 'POST',
                data: { ids: ids, action: action },
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', response.message, 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                }
            });
        }
    });
}

function deleteReport(id) {
    Swal.fire({
        title: 'Hapus Laporan?',
        text: 'Laporan yang sudah dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("admin/reports/delete/") ?>' + id,
                type: 'POST',
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil!', 'Laporan telah dihapus', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Gagal menghapus laporan', 'error');
                    }
                }
            });
        }
    });
}
</script> 