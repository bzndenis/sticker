<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cari Sticker</h4>
                        
                        <form method="get" action="<?= base_url('search') ?>" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="keyword" class="form-control" 
                                               placeholder="Cari nama sticker..." 
                                               value="<?= $this->input->get('keyword') ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="category" class="form-control">
                                            <option value="">Semua Kategori</option>
                                            <?php foreach($categories as $cat): ?>
                                            <option value="<?= $cat->id ?>" 
                                                    <?= $this->input->get('category') == $cat->id ? 'selected' : '' ?>>
                                                <?= $cat->name ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="status" class="form-control">
                                            <option value="">Semua Status</option>
                                            <option value="owned" <?= $this->input->get('status') == 'owned' ? 'selected' : '' ?>>
                                                Dimiliki
                                            </option>
                                            <option value="needed" <?= $this->input->get('status') == 'needed' ? 'selected' : '' ?>>
                                                Belum Dimiliki
                                            </option>
                                            <option value="tradeable" <?= $this->input->get('status') == 'tradeable' ? 'selected' : '' ?>>
                                                Dapat Ditukar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="mdi mdi-magnify"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        <?php if(!empty($results)): ?>
                        <div class="row">
                            <?php foreach($results as $sticker): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img class="card-img-top" 
                                         src="<?= base_url('assets/images/stickers/'.$sticker->image) ?>" 
                                         alt="<?= $sticker->name ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $sticker->name ?></h5>
                                        <p class="card-text">
                                            <small class="text-muted"><?= $sticker->category_name ?></small>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge <?= $sticker->owned_quantity > 0 ? 'badge-success' : 'badge-secondary' ?>">
                                                <?= $sticker->owned_quantity > 0 ? 'Dimiliki: '.$sticker->owned_quantity : 'Belum Dimiliki' ?>
                                            </span>
                                            <?php if($sticker->owned_quantity > 1 && $sticker->is_tradeable): ?>
                                            <span class="badge badge-info">Dapat Ditukar</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3">
                                            <?php if($sticker->owned_quantity == 0): ?>
                                            <button class="btn btn-outline-primary btn-sm btn-block"
                                                    onclick="searchOwners(<?= $sticker->id ?>)">
                                                <i class="mdi mdi-account-search"></i> Cari Pemilik
                                            </button>
                                            <?php else: ?>
                                            <button class="btn btn-outline-info btn-sm btn-block"
                                                    onclick="searchNeeds(<?= $sticker->id ?>)">
                                                <i class="mdi mdi-account-multiple"></i> Cari yang Butuh
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php elseif($this->input->get()): ?>
                        <div class="alert alert-info">
                            Tidak ada sticker yang ditemukan.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function searchOwners(stickerId) {
    window.location.href = '<?= base_url("trades/search/") ?>' + stickerId;
}

function searchNeeds(stickerId) {
    window.location.href = '<?= base_url("trades/needs/") ?>' + stickerId;
}

// Implementasi pencarian real-time
let searchTimeout;
$('input[name="keyword"]').keyup(function() {
    clearTimeout(searchTimeout);
    const keyword = $(this).val();
    
    if(keyword.length >= 2) {
        searchTimeout = setTimeout(function() {
            $.ajax({
                url: '<?= base_url("search/ajax_search") ?>',
                type: 'GET',
                data: { keyword: keyword },
                success: function(response) {
                    // Implementasi suggestion box
                }
            });
        }, 500);
    }
});
</script> 