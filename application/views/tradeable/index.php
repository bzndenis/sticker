<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sticker Yang Dapat Ditukar</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sticker</th>
                                        <th>Kategori</th>
                                        <th>Jumlah Dimiliki</th>
                                        <th>Minimum Simpan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tradeable_stickers as $sticker): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                                     class="mr-3" style="width: 50px" alt="sticker">
                                                <span><?= $sticker->name ?></span>
                                            </div>
                                        </td>
                                        <td><?= $sticker->category_name ?></td>
                                        <td><?= $sticker->quantity ?></td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm min-quantity" 
                                                   value="<?= $sticker->min_quantity ?>" 
                                                   min="1" max="<?= $sticker->quantity ?>"
                                                   data-sticker-id="<?= $sticker->id ?>">
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input tradeable-status" 
                                                       id="tradeable_<?= $sticker->id ?>"
                                                       <?= $sticker->is_tradeable ? 'checked' : '' ?>
                                                       data-sticker-id="<?= $sticker->id ?>">
                                                <label class="custom-control-label" 
                                                       for="tradeable_<?= $sticker->id ?>">
                                                    <?= $sticker->is_tradeable ? 'Dapat Ditukar' : 'Tidak Dapat Ditukar' ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-info btn-sm view-requests"
                                                    data-sticker-id="<?= $sticker->id ?>">
                                                <i class="mdi mdi-eye"></i> Lihat Permintaan
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
$(document).ready(function() {
    // Update status dapat ditukar
    $('.tradeable-status').change(function() {
        var stickerId = $(this).data('sticker-id');
        var isTradeable = $(this).prop('checked') ? 1 : 0;
        
        $.ajax({
            url: '<?= base_url("tradeable/update_status") ?>',
            type: 'POST',
            data: {
                sticker_id: stickerId,
                is_tradeable: isTradeable
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire('Berhasil', 'Status sticker telah diperbarui', 'success');
                }
            }
        });
    });

    // Update minimum quantity
    $('.min-quantity').change(function() {
        var stickerId = $(this).data('sticker-id');
        var minQuantity = $(this).val();
        
        $.ajax({
            url: '<?= base_url("tradeable/set_minimum_quantity") ?>',
            type: 'POST',
            data: {
                sticker_id: stickerId,
                min_quantity: minQuantity
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire('Berhasil', 'Jumlah minimum simpan telah diperbarui', 'success');
                }
            }
        });
    });

    // Lihat permintaan pertukaran
    $('.view-requests').click(function() {
        var stickerId = $(this).data('sticker-id');
        window.location.href = '<?= base_url("trades/requests/") ?>' + stickerId;
    });
});
</script> 