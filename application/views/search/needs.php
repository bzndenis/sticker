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
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($needs as $need): ?>
                                    <tr>
                                        <td><?= $need->username ?></td>
                                        <td><span class="badge badge-info">Membutuhkan</span></td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-sm" 
                                                    onclick="offerSticker(<?= $sticker->id ?>, <?= $need->id ?>)">
                                                <i class="mdi mdi-send"></i> Tawarkan Sticker
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
function offerSticker(stickerId, userId) {
    Swal.fire({
        title: 'Tawarkan Sticker',
        text: 'Apakah Anda ingin menawarkan sticker ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("trades/offer_sticker") ?>',
                type: 'POST',
                data: {
                    sticker_id: stickerId,
                    user_id: userId
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Berhasil', 'Tawaran sticker telah dikirim', 'success');
                    }
                }
            });
        }
    });
}
</script> 