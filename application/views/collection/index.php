<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Koleksi Sticker Saya</h4>
                        <div class="table-responsive">
                            <table class="table table-hover sticker-table">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($collection as $sticker): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                                 class="mr-2" alt="sticker">
                                            <?= $sticker->name ?>
                                        </td>
                                        <td><?= $sticker->category_name ?></td>
                                        <td>
                                            <div class="input-group" style="width: 130px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-sm btn-outline-secondary" 
                                                            onclick="updateQuantity(<?= $sticker->sticker_id ?>, -1)">
                                                        <i class="mdi mdi-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="number" class="form-control text-center" 
                                                       value="<?= $sticker->quantity ?>" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm btn-outline-secondary" 
                                                            onclick="updateQuantity(<?= $sticker->sticker_id ?>, 1)">
                                                        <i class="mdi mdi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-info btn-sm" 
                                                    onclick="searchTradeRequests(<?= $sticker->sticker_id ?>)">
                                                <i class="mdi mdi-swap-horizontal"></i> Cari yang Butuh
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
    function updateQuantity(stickerId, change) {
        const input = event.target.closest('.input-group').querySelector('input');
        const newQuantity = parseInt(input.value) + change;
        
        if (newQuantity < 0) return;
        
        $.ajax({
            url: '<?= base_url("collection/update_quantity") ?>',
            type: 'POST',
            data: {
                sticker_id: stickerId,
                quantity: newQuantity
            },
            success: function(response) {
                if(response.success) {
                    input.value = newQuantity;
                    if(newQuantity === 0) {
                        location.reload();
                    }
                }
            }
        });
    }

    function searchTradeRequests(stickerId) {
        window.location.href = '<?= base_url("trades/search_requests/") ?>' + stickerId;
    }
    </script>
</div> 