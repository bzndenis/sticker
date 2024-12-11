<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sticker <?= $category->name ?></h4>
                        <div class="row">
                            <?php foreach($stickers as $sticker): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img class="card-img-top" src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                         alt="<?= $sticker->name ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $sticker->name ?></h5>
                                        <p class="card-text">
                                            <span class="badge <?= $sticker->owned > 0 ? 'badge-success' : 'badge-info' ?>">
                                                <?= $sticker->owned > 0 ? 'Dimiliki: '.$sticker->owned : 'Belum Dimiliki' ?>
                                            </span>
                                        </p>
                                        <div class="btn-group w-100">
                                            <?php if($sticker->owned > 0): ?>
                                                <button class="btn btn-success btn-sm" onclick="updateSticker(<?= $sticker->id ?>)">
                                                    Tambah Jumlah
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-outline-primary btn-sm" onclick="searchOwners(<?= $sticker->id ?>)">
                                                    Cari Pemilik
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateSticker(stickerId) {
    // Ajax request untuk update kepemilikan sticker
    $.ajax({
        url: '<?= base_url("stickers/update_ownership") ?>',
        type: 'POST',
        data: {
            sticker_id: stickerId
        },
        success: function(response) {
            if(response.success) {
                Swal.fire('Berhasil', 'Status sticker berhasil diperbarui', 'success')
                    .then(() => location.reload());
            }
        }
    });
}

function searchSticker(stickerId) {
    // Redirect ke halaman pencarian pemilik sticker
    window.location.href = '<?= base_url("trades/search/") ?>' + stickerId;
}
</script> 