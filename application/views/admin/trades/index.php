<?php 
$data['title'] = 'Pertukaran';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pertukaran</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-download"></i> Export Data
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik Pertukaran -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h6 class="card-title">Total</h6>
                    <h2 class="mb-0"><?= $trade_stats->accepted + $trade_stats->rejected + $trade_stats->pending ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h6 class="card-title">Diterima</h6>
                    <h2 class="mb-0"><?= $trade_stats->accepted ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h6 class="card-title">Ditolak</h6>
                    <h2 class="mb-0"><?= $trade_stats->rejected ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h6 class="card-title">Pending</h6>
                    <h2 class="mb-0"><?= $trade_stats->pending ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-10">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $selected_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="completed" <?= $selected_status == 'completed' ? 'selected' : '' ?>>Diterima</option>
                        <option value="rejected" <?= $selected_status == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pertukaran -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Pemohon</th>
                            <th>Pemilik</th>
                            <th>Stiker Diminta</th>
                            <th>Stiker Ditawarkan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($trades)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-arrow-left-right text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Tidak ada pertukaran ditemukan</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($trades as $trade): ?>
                                <tr>
                                    <td>#<?= $trade->id ?></td>
                                    <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                    <td><?= $trade->requester_username ?></td>
                                    <td><?= $trade->owner_username ?></td>
                                    <td><?= $trade->requested_sticker_name ?></td>
                                    <td><?= $trade->offered_sticker_name ?></td>
                                    <td>
                                        <?php
                                        $status_class = [
                                            'pending' => 'warning',
                                            'accepted' => 'success',
                                            'rejected' => 'danger'
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $status_class[$trade->status] ?>">
                                            <?= ucfirst($trade->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/trades/view/'.$trade->id) ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button onclick="deleteTrade(<?= $trade->id ?>)" 
                                                    class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data Pertukaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('admin/trades/export') ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="<?= date('Y-m-d', strtotime('-1 month')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
function deleteTrade(id) {
    if(confirm('Apakah Anda yakin ingin menghapus pertukaran ini?\nSemua chat dan notifikasi terkait akan ikut terhapus.')) {
        window.location.href = '<?= base_url('admin/trades/delete/') ?>' + id;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 