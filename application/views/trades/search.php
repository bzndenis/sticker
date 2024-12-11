<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pemilik Sticker <?= $sticker->name ?></h4>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                     class="img-fluid" alt="sticker">
                            </div>
                            <div class="col-md-9">
                                <h5><?= $sticker->name ?></h5>
                                <p><?= $sticker->description ?></p>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Jumlah Dimiliki</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($owners as $owner): ?>
                                    <tr>
                                        <td><?= $owner->username ?></td>
                                        <td><?= $owner->quantity ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                    onclick="createTradeRequest(<?= $sticker->id ?>, <?= $owner->id ?>)">
                                                <i class="mdi mdi-swap-horizontal"></i> Ajukan Tukar
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

    <script>
    function createTradeRequest(stickerId, ownerId) {
        Swal.fire({
            title: 'Ajukan Pertukaran',
            input: 'text',
            inputLabel: 'Pesan untuk pemilik',
            inputPlaceholder: 'Masukkan pesan...',
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Pesan tidak boleh kosong!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("trades/create_request") ?>',
                    type: 'POST',
                    data: {
                        sticker_id: stickerId,
                        owner_id: ownerId,
                        message: result.value
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Berhasil', 'Permintaan tukar berhasil dikirim', 'success')
                                .then(() => window.location.href = '<?= base_url("trades/requests") ?>');
                        }
                    }
                });
            }
        });
    }
    </script>
</div> 