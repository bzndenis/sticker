<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Pertukaran</h4>
                        
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#sent" role="tab">
                                    Permintaan Terkirim
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#received" role="tab">
                                    Permintaan Diterima
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="sent" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sticker</th>
                                                <th>Pemilik</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($sent_trades as $trade): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url('assets/images/stickers/'.$trade->sticker_image) ?>" 
                                                             class="mr-3" style="width: 40px" alt="sticker">
                                                        <span><?= $trade->sticker_name ?></span>
                                                    </div>
                                                </td>
                                                <td><?= $trade->owner_name ?></td>
                                                <td><?= time_elapsed_string($trade->created_at) ?></td>
                                                <td>
                                                    <span class="badge badge-<?= get_status_badge($trade->status) ?>">
                                                        <?= $trade->status ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('chat/trade/'.$trade->id) ?>" 
                                                       class="btn btn-outline-info btn-sm">
                                                        <i class="mdi mdi-message-text"></i> Chat
                                                    </a>
                                                    <?php if($trade->status == 'pending'): ?>
                                                    <button class="btn btn-outline-danger btn-sm" 
                                                            onclick="cancelTrade(<?= $trade->id ?>)">
                                                        <i class="mdi mdi-close"></i> Batal
                                                    </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="received" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sticker</th>
                                                <th>Pengirim</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($received_trades as $trade): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url('assets/images/stickers/'.$trade->sticker_image) ?>" 
                                                             class="mr-3" style="width: 40px" alt="sticker">
                                                        <span><?= $trade->sticker_name ?></span>
                                                    </div>
                                                </td>
                                                <td><?= $trade->sender_name ?></td>
                                                <td><?= time_elapsed_string($trade->created_at) ?></td>
                                                <td>
                                                    <span class="badge badge-<?= get_status_badge($trade->status) ?>">
                                                        <?= $trade->status ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('chat/trade/'.$trade->id) ?>" 
                                                       class="btn btn-outline-info btn-sm">
                                                        <i class="mdi mdi-message-text"></i> Chat
                                                    </a>
                                                    <?php if($trade->status == 'pending'): ?>
                                                    <button class="btn btn-outline-success btn-sm" 
                                                            onclick="acceptTrade(<?= $trade->id ?>)">
                                                        <i class="mdi mdi-check"></i> Terima
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" 
                                                            onclick="rejectTrade(<?= $trade->id ?>)">
                                                        <i class="mdi mdi-close"></i> Tolak
                                                    </button>
                                                    <?php endif; ?>
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
    </div>
</div>

<script>
function cancelTrade(tradeId) {
    Swal.fire({
        title: 'Batalkan Pertukaran?',
        text: 'Apakah Anda yakin ingin membatalkan permintaan pertukaran ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("trades/update_request_status") ?>',
                type: 'POST',
                data: {
                    request_id: tradeId,
                    status: 'cancelled'
                },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
}
</script> 