<?php 
$data['title'] = 'Cari Stiker';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Cari Stiker</h2>
            <?php if($collection): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('trades/search') ?>">Semua Koleksi</a>
                        </li>
                        <li class="breadcrumb-item active"><?= $collection->name ?></li>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>
        <a href="<?= base_url('trades') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari stiker..." 
                           value="<?= $this->input->get('search') ?>">
                </div>
                <div class="col-md-4">
                    <select name="collection" class="form-select">
                        <option value="">Semua Koleksi</option>
                        <?php foreach($collections as $col): ?>
                            <option value="<?= $col->id ?>" 
                                    <?= $collection && $collection->id == $col->id ? 'selected' : '' ?>>
                                <?= $col->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Stiker -->
    <?php if(empty($available_stickers)): ?>
        <div class="text-center py-5">
            <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada stiker yang tersedia untuk ditukar</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($available_stickers as $sticker): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                             class="card-img-top sticker-img" alt="<?= $sticker->name ?>">
                        <div class="card-body">
                            <h6 class="card-title mb-1"><?= $sticker->name ?></h6>
                            <p class="text-muted small mb-2">
                                Koleksi: <?= $sticker->collection_name ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">
                                    Tersedia: <?= $sticker->quantity ?>
                                </span>
                                <button type="button" 
                                        onclick="showTradeModal(<?= $sticker->id ?>, '<?= $sticker->name ?>')"
                                        class="btn btn-sm btn-primary">
                                    <i class="bi bi-arrow-left-right"></i> Tukar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Tukar -->
<div class="modal fade" id="tradeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tukar Stiker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('trades/submit_request') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="requested_sticker_id" id="requested_sticker_id">
                    <input type="hidden" name="owner_id" id="owner_id">
                    
                    <p>Anda akan menukar dengan stiker: <strong id="requested_sticker_name"></strong></p>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih stiker yang akan ditawarkan:</label>
                        <select name="offered_sticker_id" class="form-select" required>
                            <option value="">Pilih Stiker</option>
                            <?php foreach($tradeable_stickers as $sticker): ?>
                                <option value="<?= $sticker->id ?>">
                                    <?= $sticker->name ?> (<?= $sticker->collection_name ?>)
                                    - Tersedia: <?= $sticker->quantity ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTradeModal(stickerId, stickerName) {
    document.getElementById('requested_sticker_id').value = stickerId;
    document.getElementById('requested_sticker_name').textContent = stickerName;
    new bootstrap.Modal(document.getElementById('tradeModal')).show();
}
</script>

<?php $this->load->view('templates/footer'); ?> 