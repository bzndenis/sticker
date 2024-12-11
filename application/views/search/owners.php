<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                 class="mr-3" style="width: 100px" alt="sticker">
                            <div>
                                <h4 class="card-title mb-1"><?= $sticker->name ?></h4>
                                <p class="text-muted">Kategori: <?= $sticker->category_name ?></p>
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
                                                Ajukan Pertukaran
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
function createTradeRequest(stickerId, ownerId) {
    Swal.fire({
        title: 'Ajukan Pertukaran',
        input: 'text',
        inputLabel: 'Pesan untuk pemilik sticker',
        inputPlaceholder: 'Masukkan pesan...',
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal'
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
                        Swal.fire('Berhasil', 'Permintaan pertukaran telah dikirim', 'success');
                    }
                }
            });
        }
    });
}
</script> 