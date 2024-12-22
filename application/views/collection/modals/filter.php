<!-- Filter Modal Content -->
<div class="modal-header border-0">
    <h5 class="modal-title">Filter Koleksi</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <form action="<?= base_url('collection') ?>" method="get" id="filterForm">
        <div class="mb-3">
            <label class="form-label">Kategori</label>
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
        
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="tradeable" <?= $this->input->get('status') == 'tradeable' ? 'selected' : '' ?>>
                    Dapat Ditukar
                </option>
                <option value="not_tradeable" <?= $this->input->get('status') == 'not_tradeable' ? 'selected' : '' ?>>
                    Tidak Dapat Ditukar
                </option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Urutkan</label>
            <select name="sort" class="form-select">
                <option value="newest" <?= $this->input->get('sort') == 'newest' ? 'selected' : '' ?>>
                    Terbaru
                </option>
                <option value="oldest" <?= $this->input->get('sort') == 'oldest' ? 'selected' : '' ?>>
                    Terlama
                </option>
                <option value="name_asc" <?= $this->input->get('sort') == 'name_asc' ? 'selected' : '' ?>>
                    Nama (A-Z)
                </option>
                <option value="name_desc" <?= $this->input->get('sort') == 'name_desc' ? 'selected' : '' ?>>
                    Nama (Z-A)
                </option>
            </select>
        </div>
    </form>
</div>
<div class="modal-footer border-0">
    <button type="button" class="btn btn-outline-light" onclick="resetFilter()">Reset</button>
    <button type="submit" form="filterForm" class="btn btn-primary">
        <i class="bi bi-funnel me-2"></i>Terapkan
    </button>
</div> 