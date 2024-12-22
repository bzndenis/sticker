<?php $this->load->view('templates/header', ['title' => 'Kategori Stiker']); ?>

<div class="container my-4">
    <!-- Header Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">Kategori Stiker</h4>
                    <p class="text-muted mb-0">
                        Jelajahi koleksi stiker berdasarkan kategori
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchCategory" 
                               placeholder="Cari kategori...">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row g-4" id="categoriesContainer">
        <?php foreach($categories as $category): ?>
            <div class="col-md-4 category-item">
                <div class="card h-100 floating">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="category-icon rounded-circle bg-primary p-3">
                                <i class="bi bi-<?= isset($category->icon) ? $category->icon : 'collection' ?> fs-4"></i>
                            </div>
                            <span class="badge bg-primary">
                                <?= number_format($category->sticker_count) ?> Stiker
                            </span>
                        </div>
                        
                        <h5 class="card-title mb-2"><?= $category->name ?></h5>
                        <p class="card-text text-muted mb-4">
                            <?= isset($category->description) ? $category->description : 'Koleksi stiker ' . $category->name ?>
                        </p>

                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?= $category->completion_rate ?>%"
                                 aria-valuenow="<?= $category->completion_rate ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <?= $category->completion_rate ?>% Selesai
                            </small>
                            <a href="<?= base_url('categories/view/' . $category->id) ?>" 
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-right me-1"></i>
                                Lihat Koleksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <?php if(empty($categories)): ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-grid-3x3-gap text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted">Belum Ada Kategori</h5>
            <p class="text-muted mb-4">
                Kategori akan ditambahkan oleh admin
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- Category Detail Modal -->
<div class="modal fade" id="categoryDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title">Detail Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="category-icon rounded-circle bg-primary p-4 d-inline-block mb-3">
                        <i class="bi bi-collection fs-1"></i>
                    </div>
                    <h4 class="modal-category-name mb-2"></h4>
                    <p class="text-muted modal-category-description"></p>
                </div>

                <div class="row text-center g-3 mb-4">
                    <div class="col-4">
                        <div class="p-3 rounded bg-dark">
                            <h4 class="modal-sticker-count mb-1"></h4>
                            <small class="text-muted">Total Stiker</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded bg-dark">
                            <h4 class="modal-owned-count mb-1"></h4>
                            <small class="text-muted">Dimiliki</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded bg-dark">
                            <h4 class="modal-completion-rate mb-1"></h4>
                            <small class="text-muted">Selesai</small>
                        </div>
                    </div>
                </div>

                <div class="progress mb-4" style="height: 8px;">
                    <div class="progress-bar" role="progressbar"></div>
                </div>

                <div class="d-grid">
                    <a href="" class="btn btn-primary view-collection-btn">
                        <i class="bi bi-grid me-2"></i>Lihat Koleksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.category-item {
    transition: transform 0.3s ease;
}

.category-item:hover {
    transform: translateY(-5px);
}

#searchCategory {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
</style>

<script>
// Live search categories
document.getElementById('searchCategory').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const categories = document.querySelectorAll('.category-item');
    
    categories.forEach(category => {
        const title = category.querySelector('.card-title').textContent.toLowerCase();
        const description = category.querySelector('.card-text').textContent.toLowerCase();
        
        if(title.includes(searchTerm) || description.includes(searchTerm)) {
            category.style.display = '';
        } else {
            category.style.display = 'none';
        }
    });
});

// Show category detail modal
function showCategoryDetail(categoryId) {
    fetch(`<?= base_url('categories/get_detail/') ?>${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const modal = document.getElementById('categoryDetailModal');
            modal.querySelector('.modal-category-name').textContent = data.name;
            modal.querySelector('.modal-category-description').textContent = data.description;
            modal.querySelector('.modal-sticker-count').textContent = data.sticker_count;
            modal.querySelector('.modal-owned-count').textContent = data.owned_count;
            modal.querySelector('.modal-completion-rate').textContent = `${data.completion_rate}%`;
            modal.querySelector('.progress-bar').style.width = `${data.completion_rate}%`;
            modal.querySelector('.view-collection-btn').href = 
                `<?= base_url('categories/view/') ?>${categoryId}`;
            
            new bootstrap.Modal(modal).show();
        });
}
</script>

<?php $this->load->view('templates/footer'); ?> 