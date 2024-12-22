<?php $this->load->view('templates/header', ['title' => 'Cari Stiker']); ?>

<div class="container my-4">
    <!-- Search Header -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= base_url('feed/search') ?>" method="GET" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" 
                               placeholder="Cari stiker..." value="<?= $this->input->get('keyword') ?>"
                               autofocus>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>" 
                                    <?= $this->input->get('category') == $category->id ? 'selected' : '' ?>>
                                <?= $category->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="relevance" <?= $this->input->get('sort') == 'relevance' ? 'selected' : '' ?>>
                            Relevansi
                        </option>
                        <option value="newest" <?= $this->input->get('sort') == 'newest' ? 'selected' : '' ?>>
                            Terbaru
                        </option>
                        <option value="name_asc" <?= $this->input->get('sort') == 'name_asc' ? 'selected' : '' ?>>
                            A-Z
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <?php if($this->input->get('keyword')): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Hasil Pencarian</h4>
                <p class="text-muted mb-0">
                    Ditemukan <?= count($stickers) ?> stiker untuk "<?= $this->input->get('keyword') ?>"
                </p>
            </div>
            <?php if(!empty($stickers)): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-light active" data-view="grid">
                        <i class="bi bi-grid"></i>
                    </button>
                    <button type="button" class="btn btn-outline-light" data-view="list">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <?php if(empty($stickers)): ?>
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted">Tidak Ada Hasil</h5>
                <p class="text-muted mb-4">
                    Coba kata kunci lain atau ubah filter pencarian
                </p>
                <a href="<?= base_url('feed') ?>" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Feed
                </a>
            </div>
        <?php else: ?>
            <!-- Grid View -->
            <div id="gridView" class="row g-4">
                <?php foreach($stickers as $sticker): ?>
                    <div class="col-md-3">
                        <div class="card h-100 floating">
                            <div class="position-relative">
                                <img src="<?= base_url('uploads/stickers/' . $sticker->image) ?>" 
                                     class="card-img-top" alt="<?= $sticker->name ?>"
                                     style="height: 180px; object-fit: cover;">
                                <?php if($sticker->is_tradeable): ?>
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                                        Dapat Ditukar
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title mb-1"><?= $sticker->name ?></h6>
                                <p class="card-text">
                                    <small class="text-muted"><?= $sticker->category_name ?></small>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Dimiliki oleh <?= $sticker->owner_name ?>
                                    </small>
                                    <?php if($sticker->is_tradeable): ?>
                                        <button class="btn btn-primary btn-sm" 
                                                onclick="initiateTradeRequest(<?= $sticker->id ?>)">
                                            <i class="bi bi-arrow-left-right me-1"></i>
                                            Tukar
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- List View (Hidden by default) -->
            <div id="listView" class="d-none">
                <?php foreach($stickers as $sticker): ?>
                    <div class="card mb-3 floating">
                        <div class="row g-0">
                            <div class="col-md-2">
                                <img src="<?= base_url('uploads/stickers/' . $sticker->image) ?>" 
                                     class="img-fluid rounded-start" alt="<?= $sticker->name ?>"
                                     style="height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title mb-1"><?= $sticker->name ?></h5>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    Kategori: <?= $sticker->category_name ?>
                                                </small>
                                            </p>
                                        </div>
                                        <?php if($sticker->is_tradeable): ?>
                                            <span class="badge bg-success">Dapat Ditukar</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Dimiliki oleh <?= $sticker->owner_name ?>
                                        </small>
                                    </p>
                                    <?php if($sticker->is_tradeable): ?>
                                        <button class="btn btn-primary btn-sm" 
                                                onclick="initiateTradeRequest(<?= $sticker->id ?>)">
                                            <i class="bi bi-arrow-left-right me-1"></i>
                                            Ajukan Pertukaran
                                        </button>
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
        <?php endif; ?>
    <?php else: ?>
        <!-- Search Suggestions -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Kategori Populer</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach($popular_categories as $category): ?>
                                <a href="<?= base_url('feed/search?category=' . $category->id) ?>" 
                                   class="btn btn-outline-light">
                                    <?= $category->name ?>
                                    <span class="badge bg-primary ms-2">
                                        <?= $category->sticker_count ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Pencarian Terpopuler</h5>
                        <div class="list-group list-group-flush">
                            <?php foreach($popular_searches as $search): ?>
                                <a href="<?= base_url('feed/search?keyword=' . urlencode($search->keyword)) ?>" 
                                   class="list-group-item list-group-item-action bg-transparent text-light">
                                    <i class="bi bi-search me-2"></i>
                                    <?= $search->keyword ?>
                                    <small class="text-muted ms-2">
                                        <?= $search->count ?> pencarian
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// View Toggle
document.querySelectorAll('[data-view]').forEach(button => {
    button.addEventListener('click', function() {
        const view = this.dataset.view;
        document.querySelectorAll('[data-view]').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        if(view === 'grid') {
            document.getElementById('gridView').classList.remove('d-none');
            document.getElementById('listView').classList.add('d-none');
        } else {
            document.getElementById('gridView').classList.add('d-none');
            document.getElementById('listView').classList.remove('d-none');
        }
    });
});

// Trade Request Functions
function initiateTradeRequest(stickerId) {
    // ... kode yang sudah ada ...
}
</script>

<?php $this->load->view('templates/footer'); ?> 