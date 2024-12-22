<?php $this->load->view('templates/header', ['title' => 'Kelola Stiker']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <!-- Categories Overview -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Kategori Stiker</h5>
            <div class="row g-4">
                <?php foreach($categories as $category): ?>
                    <div class="col-md-4">
                        <div class="card h-100 floating">
                            <div class="card-body">
                                <h6 class="card-title"><?= $category->name ?></h6>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar" style="width: <?= $category->progress ?>%"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <?= $category->owned ?>/<?= $category->total ?> Stiker
                                    </small>
                                    <a href="<?= base_url('stickers/category/'.$category->id) ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-upload me-2"></i>Upload
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Individual Stickers Management -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Stiker Saya</h5>
                <div>
                    <select class="form-select form-select-sm" id="categoryFilter">
                        <option value="">Semua Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>" 
                                    <?= $this->input->get('category') == $category->id ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                <?php if(empty($stickers)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-emoji-neutral text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">Belum Ada Stiker</h5>
                            <p class="text-muted">Upload stiker melalui menu kategori di atas</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach($stickers as $sticker): ?>
                        <div class="col-md-3">
                            <div class="card h-100 floating">
                                <div class="position-relative">
                                    <img src="<?= base_url('uploads/stickers/' . $sticker->image_path) ?>" 
                                         class="card-img-top" alt="Stiker #<?= $sticker->number ?>"
                                         style="height: 200px; object-fit: cover;">
                                    <span class="position-absolute bottom-0 start-0 m-2 badge bg-dark">
                                        x<?= $sticker->quantity ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title mb-1">Stiker #<?= $sticker->number ?></h6>
                                    <p class="card-text">
                                        <small class="text-muted"><?= $sticker->category_name ?></small>
                                    </p>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               onchange="toggleTradeStatus(<?= $sticker->id ?>, this.checked)"
                                               <?= $sticker->is_for_trade ? 'checked' : '' ?>>
                                        <label class="form-check-label">Dapat Ditukar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleTradeStatus(stickerId, status) {
    fetch('<?= base_url('stickers/toggle_trade') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `sticker_id=${stickerId}&status=${status ? 1 : 0}`
    })
    .then(response => response.json())
    .then(data => {
        if(!data.success) {
            alert('Gagal mengubah status stiker');
            location.reload();
        }
    });
}

document.getElementById('categoryFilter').addEventListener('change', function() {
    window.location.href = `<?= base_url('stickers/manage') ?>?category=${this.value}`;
});
</script>

<?php $this->load->view('templates/footer'); ?> 