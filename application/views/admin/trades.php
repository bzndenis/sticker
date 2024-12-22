<?php 
$data['title'] = 'Manajemen Pertukaran';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <h2 class="mb-4">Manajemen Pertukaran</h2>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="mb-0"><?= $pending_count ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Diterima</h5>
                    <h2 class="mb-0"><?= count($completed_trades) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Ditolak</h5>
                    <h2 class="mb-0"><?= count($rejected_trades) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="tradeTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab">
                Pending <?php if($pending_count > 0): ?><span class="badge bg-primary"><?= $pending_count ?></span><?php endif; ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed" role="tab">
                Diterima
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rejected-tab" data-bs-toggle="tab" href="#rejected" role="tab">
                Ditolak
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="tradeTabContent">
        <!-- Pending Trades -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <?php if(empty($pending_trades)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-hourglass text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Tidak ada pertukaran yang pending</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Pemilik</th>
                                <th>Stiker Diminta</th>
                                <th>Stiker Ditawarkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pending_trades as $trade): ?>
                                <tr>
                                    <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                    <td><?= $trade->requester_username ?></td>
                                    <td><?= $trade->owner_username ?></td>
                                    <td><?= $trade->requested_sticker_name ?></td>
                                    <td><?= $trade->offered_sticker_name ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/trade_detail/'.$trade->id) ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Completed Trades -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            <?php if(empty($completed_trades)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-check-circle text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada pertukaran yang selesai</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Pemilik</th>
                                <th>Stiker Diminta</th>
                                <th>Stiker Ditawarkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($completed_trades as $trade): ?>
                                <tr>
                                    <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                    <td><?= $trade->requester_username ?></td>
                                    <td><?= $trade->owner_username ?></td>
                                    <td><?= $trade->requested_sticker_name ?></td>
                                    <td><?= $trade->offered_sticker_name ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/trade_detail/'.$trade->id) ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Rejected Trades -->
        <div class="tab-pane fade" id="rejected" role="tabpanel">
            <?php if(empty($rejected_trades)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-x-circle text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Tidak ada pertukaran yang ditolak</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Pemilik</th>
                                <th>Stiker Diminta</th>
                                <th>Stiker Ditawarkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rejected_trades as $trade): ?>
                                <tr>
                                    <td><?= date('d M Y H:i', strtotime($trade->created_at)) ?></td>
                                    <td><?= $trade->requester_username ?></td>
                                    <td><?= $trade->owner_username ?></td>
                                    <td><?= $trade->requested_sticker_name ?></td>
                                    <td><?= $trade->offered_sticker_name ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/trade_detail/'.$trade->id) ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 