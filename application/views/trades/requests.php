<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Permintaan Masuk</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Peminta</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($incoming_requests as $request): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('assets/images/stickers/'.$request->image) ?>" 
                                                 class="mr-2" alt="sticker">
                                            <?= $request->sticker_name ?>
                                        </td>
                                        <td><?= $request->requester_name ?></td>
                                        <td><?= $request->message ?></td>
                                        <td><?= date('d M Y H:i', strtotime($request->created_at)) ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" 
                                                    onclick="updateRequestStatus(<?= $request->id ?>, 'accepted')">
                                                Terima
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="updateRequestStatus(<?= $request->id ?>, 'rejected')">
                                                Tolak
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

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Permintaan Keluar</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Pemilik</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($outgoing_requests as $request): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('assets/images/stickers/'.$request->image) ?>" 
                                                 class="mr-2" alt="sticker">
                                            <?= $request->sticker_name ?>
                                        </td>
                                        <td><?= $request->owner_name ?></td>
                                        <td><?= $request->message ?></td>
                                        <td><?= date('d M Y H:i', strtotime($request->created_at)) ?></td>
                                        <td>
                                            <div class="badge badge-warning">Menunggu</div>
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

    <script>
    function updateRequestStatus(requestId, status) {
        $.ajax({
            url: '<?= base_url("trades/update_request_status") ?>',
            type: 'POST',
            data: {
                request_id: requestId,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire('Berhasil', 'Status permintaan berhasil diperbarui', 'success')
                        .then(() => location.reload());
                }
            }
        });
    }
    </script>
</div> 