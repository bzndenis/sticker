<?php $this->load->view('templates/header', ['title' => 'Rekomendasi Stiker']); ?>

<div class="container my-4">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Rekomendasi Stiker</h4>
                    <p class="text-muted mb-0">
                        Berdasarkan koleksi dan aktivitas Anda
                    </p>
                </div>
                <a href="<?= base_url('feed') ?>" class="btn btn-outline-light">
                    <i class="bi bi-grid me-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Match Score Categories -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success me-3">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Match Score</h6>
                            <h3 class="card-title mb-0"><?= number_format($match_score, 1) ?>%</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: <?= $match_score ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary me-3">
                            <i class="bi bi-collection"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Koleksi Serupa</h6>
                            <h3 class="card-title mb-0"><?= number_format($similar_collections) ?></h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-warning me-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Potensi Tukar</h6>
                            <h3 class="card-title mb-0"><?= number_format($potential_trades) ?></h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="scrolling-wrapper">
                <div class="nav nav-pills flex-nowrap" role="tablist">
                    <button class="nav-link active me-2" data-bs-toggle="pill" data-bs-target="#all">
                        Semua
                    </button>
                    <?php foreach($categories as $category): ?>
                        <button class="nav-link me-2" data-bs-toggle="pill" 
                                data-bs-target="#category-<?= $category->id ?>">
                            <i class="bi bi-<?= isset($category->icon) ? $category->icon : 'collection' ?> me-2"></i>
                            <?= $category->name ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations Grid -->
    <div class="tab-content">
        <!-- All Stickers -->
        <div class="tab-pane fade show active" id="all">
            <div class="row g-4">
                <?php foreach($recommendations as $sticker): ?>
                    <div class="col-md-3">
                        <div class="card h-100 floating">
                            <div class="position-relative">
                                <img src="<?= base_url('uploads/stickers/' . $sticker->image) ?>" 
                                     class="card-img-top" alt="<?= $sticker->name ?>"
                                     style="height: 180px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary">
                                        <?= $sticker->match_percentage ?>% Match
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title mb-1"><?= $sticker->name ?></h6>
                                <p class="card-text">
                                    <small class="text-muted"><?= $sticker->category_name ?></small>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <?php if($sticker->owner_avatar): ?>
                                            <img src="<?= base_url('uploads/avatars/' . $sticker->owner_avatar) ?>" 
                                                 class="rounded-circle me-2" alt="Owner"
                                                 style="width: 24px; height: 24px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                                 style="width: 24px; height: 24px;">
                                                <i class="bi bi-person-fill" style="font-size: 12px;"></i>
                                            </div>
                                        <?php endif; ?>
                                        <small class="text-muted"><?= $sticker->owner_name ?></small>
                                    </div>
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="initiateTradeRequest(<?= $sticker->id ?>)">
                                        <i class="bi bi-arrow-left-right me-1"></i>
                                        Tukar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Category Tabs -->
        <?php foreach($categories as $category): ?>
            <div class="tab-pane fade" id="category-<?= $category->id ?>">
                <div class="row g-4">
                    <?php 
                    $category_stickers = array_filter($recommendations, function($sticker) use ($category) {
                        return $sticker->category_id == $category->id;
                    });
                    ?>
                    <?php if(empty($category_stickers)): ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted">Tidak Ada Rekomendasi</h5>
                                <p class="text-muted mb-0">
                                    Belum ada rekomendasi stiker untuk kategori ini
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($category_stickers as $sticker): ?>
                            <!-- Card content sama seperti di atas -->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Trade Request Modal -->
<div class="modal fade" id="tradeModal" tabindex="-1">
    <!-- Modal content sama seperti di feed/index.php -->
</div>

<style>
.scrolling-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    &::-webkit-scrollbar {
        display: none;
    }
}

.nav-pills .nav-link {
    color: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
}

.nav-pills .nav-link.active {
    background: var(--primary-gradient);
    border-color: transparent;
}

.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.5rem;
    color: white;
}

.floating {
    transition: transform 0.3s ease;
}

.floating:hover {
    transform: translateY(-5px);
}
</style>

<script>
// Smooth scroll untuk tabs
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
        const target = e.target;
        const container = target.closest('.scrolling-wrapper');
        const scrollLeft = target.offsetLeft - (container.offsetWidth / 2) + (target.offsetWidth / 2);
        container.scrollTo({
            left: scrollLeft,
            behavior: 'smooth'
        });
    });
});

// Trade Request Functions
function initiateTradeRequest(stickerId) {
    document.getElementById('requested_sticker_id').value = stickerId;
    new bootstrap.Modal(document.getElementById('tradeModal')).show();
}

function submitTradeRequest() {
    const form = document.getElementById('tradeRequestForm');
    const formData = new FormData(form);

    fetch('<?= base_url('trades/request') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    });
}
</script>

<?php $this->load->view('templates/footer'); ?> 