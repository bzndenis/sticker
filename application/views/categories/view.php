<?php $this->load->view('templates/header', ['title' => $category->name]); ?>

<div class="container my-4">
    <!-- Category Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="category-icon rounded-circle bg-primary p-3">
                            <i class="bi bi-<?= isset($category->icon) ? $category->icon : 'collection' ?> fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1"><?= $category->name ?></h4>
                            <p class="text-muted mb-0">
                                <?= isset($category->description) ? $category->description : 'Koleksi stiker ' . $category->name ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: <?= $completion_rate ?>%"
                             aria-valuenow="<?= $completion_rate ?>" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">Progress Koleksi</small>
                        <small class="text-muted"><?= $completion_rate ?>%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stickers Grid -->
    <div class="row g-4">
        <?php foreach($stickers as $sticker): ?>
            <div class="col-md-3">
                <div class="card h-100 floating">
                    <div class="position-relative">
                        <img src="<?= base_url('uploads/stickers/' . $sticker->image) ?>" 
                             class="card-img-top" alt="<?= $sticker->name ?>"
                             style="height: 180px; object-fit: cover;">
                        <?php if($sticker->is_owned): ?>
                            <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                Dimiliki
                            </span>
                        <?php endif; ?>
                        <?php if($sticker->is_tradeable): ?>
                            <span class="position-absolute top-0 end-0 m-2 badge bg-primary">
                                Dapat Ditukar
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title mb-2"><?= $sticker->name ?></h6>
                        <p class="card-text">
                            <small class="text-muted">
                                <?php if($sticker->is_owned): ?>
                                    Jumlah: <?= $sticker->quantity ?>
                                <?php else: ?>
                                    Belum Dimiliki
                                <?php endif; ?>
                            </small>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <?php if(!$sticker->is_owned): ?>
                                <a href="<?= base_url('feed/search?keyword=' . urlencode($sticker->name)) ?>" 
                                   class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-search me-1"></i>Cari
                                </a>
                            <?php else: ?>
                                <?php if($sticker->quantity > 1): ?>
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="toggleTradeStatus(<?= $sticker->id ?>)">
                                        <i class="bi bi-arrow-left-right me-1"></i>
                                        <?= $sticker->is_tradeable ? 'Batalkan Tukar' : 'Tukarkan' ?>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?= $this->pagination->create_links() ?>
    </div>
</div>

<script>
function toggleTradeStatus(id) {
    if(confirm('Apakah Anda yakin ingin mengubah status tukar stiker ini?')) {
        fetch(`<?= base_url('stickers/toggle_trade/') ?>${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 