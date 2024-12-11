<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Detail Laporan #<?= $report->id ?></h4>
                            <span class="badge badge-<?= get_report_status_badge($report->status) ?>">
                                <?= ucfirst($report->status) ?>
                            </span>
                        </div>

                        <div class="report-content">
                            <div class="mb-4">
                                <h6>Tipe Laporan</h6>
                                <span class="badge badge-<?= get_report_type_badge($report->type) ?>">
                                    <?= ucfirst($report->type) ?>
                                </span>
                            </div>

                            <div class="mb-4">
                                <h6>Deskripsi</h6>
                                <p><?= nl2br($report->description) ?></p>
                            </div>

                            <?php if($report->evidence): ?>
                            <div class="mb-4">
                                <h6>Bukti</h6>
                                <img src="<?= base_url('assets/images/reports/'.$report->evidence) ?>" 
                                     class="img-fluid" style="max-width: 300px">
                            </div>
                            <?php endif; ?>

                            <?php if($report->status == 'processed'): ?>
                            <div class="alert alert-info">
                                <h6>Tanggapan Admin</h6>
                                <p class="mb-2"><?= nl2br($report->response) ?></p>
                                <small>
                                    Ditanggapi oleh: <?= $report->processor_username ?><br>
                                    Tanggal: <?= date('d M Y H:i', strtotime($report->processed_at)) ?>
                                </small>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if($report->status != 'processed'): ?>
                        <div class="mt-4">
                            <h5>Proses Laporan</h5>
                            <form id="processForm">
                                <div class="form-group">
                                    <label>Tanggapan</label>
                                    <textarea name="response" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Tindakan yang Diambil</label>
                                    <select name="action_taken" class="form-control" required>
                                        <option value="">Pilih Tindakan</option>
                                        <option value="warning">Peringatan</option>
                                        <option value="ban">Ban User</option>
                                        <option value="none">Tidak Ada Tindakan</option>
                                    </select>
                                </div>

                                <div id="banOptions" style="display: none;">
                                    <div class="form-group">
                                        <label>Durasi Ban (hari)</label>
                                        <input type="number" name="ban_duration" class="form-control" min="1">
                                    </div>
                                    <div class="form-group">
                                        <label>Alasan Ban</label>
                                        <textarea name="ban_reason" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-check"></i> Proses Laporan
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Pelapor</h5>
                        <p class="mb-1">
                            <strong>Username:</strong> 
                            <a href="<?= base_url('admin/users/view/'.$report->reporter_id) ?>">
                                <?= $report->reporter_username ?>
                            </a>
                        </p>
                        <p class="mb-1">
                            <strong>Email:</strong> <?= $report->reporter_email ?>
                        </p>
                        <p class="mb-0">
                            <strong>Tanggal Laporan:</strong><br>
                            <?= date('d M Y H:i', strtotime($report->created_at)) ?>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User yang Dilaporkan</h5>
                        <p class="mb-1">
                            <strong>Username:</strong> 
                            <a href="<?= base_url('admin/users/view/'.$report->reported_user_id) ?>">
                                <?= $report->reported_username ?>
                            </a>
                        </p>
                        <p class="mb-1">
                            <strong>Email:</strong> <?= $report->reported_user_email ?>
                        </p>
                        <p class="mb-0">
                            <strong>Status:</strong><br>
                            <?php if($report->reported_user_banned): ?>
                            <span class="badge badge-danger">Banned</span>
                            sampai <?= date('d M Y H:i', strtotime($report->reported_user_banned_until)) ?>
                            <?php else: ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('select[name="action_taken"]').change(function() {
        if ($(this).val() === 'ban') {
            $('#banOptions').slideDown();
            $('#banOptions input, #banOptions textarea').prop('required', true);
        } else {
            $('#banOptions').slideUp();
            $('#banOptions input, #banOptions textarea').prop('required', false);
        }
    });
    
    $('#processForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('ban_user', $('select[name="action_taken"]').val() === 'ban' ? 1 : 0);
        
        $.ajax({
            url: '<?= base_url("admin/reports/process/".$report->id) ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    Swal.fire('Berhasil!', 'Laporan telah diproses', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            }
        });
    });
});
</script> 