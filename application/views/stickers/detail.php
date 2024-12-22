<?php $this->load->view('templates/header', ['title' => $sticker->name]); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Detail Stiker</h4>
                        <a href="<?= base_url('feed') ?>" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Sticker Image & Info -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="position-relative">
                                <img src="<?= base_url('uploads/stickers/' . $sticker->image) ?>" 
                                     class="img-fluid rounded" alt="<?= $sticker->name ?>"
                                     style="width: 100%; height: 300px; object-fit: contain;">
                                <?php if($sticker->is_tradeable): ?>
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                                        Dapat Ditukar
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3"><?= $sticker->name ?></h5>
                            
                            <div class="mb-3">
                                <span class="badge bg-primary">
                                    <?= $sticker->category_name ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Pemilik</small>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if($sticker->owner_avatar): ?>
                                        <img src="<?= base_url('uploads/avatars/' . $sticker->owner_avatar) ?>" 
                                             class="rounded-circle" alt="Owner"
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                             style="width: 32px; height: 32px;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span><?= $sticker->owner_name ?></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <small class="text-muted d-block mb-1">Jumlah</small>
                                <h6 class="mb-0"><?= $sticker->quantity ?> stiker</h6>
                            </div>

                            <?php if($sticker->owner_id != $this->session->userdata('user_id')): ?>
                                <?php if($sticker->is_tradeable): ?>
                                    <button class="btn btn-primary w-100" 
                                            onclick="initiateTradeRequest(<?= $sticker->id ?>)">
                                        <i class="bi bi-arrow-left-right me-2"></i>
                                        Ajukan Pertukaran
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="bi bi-lock me-2"></i>
                                        Tidak Dapat Ditukar
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" 
                                            onclick="toggleTradeStatus(<?= $sticker->id ?>)">
                                        <i class="bi bi-arrow-left-right me-2"></i>
                                        <?= $sticker->is_tradeable ? 'Batalkan Status Tukar' : 'Jadikan Dapat Ditukar' ?>
                                    </button>
                                    <button class="btn btn-outline-danger" 
                                            onclick="deleteSticker(<?= $sticker->id ?>)">
                                        <i class="bi bi-trash me-2"></i>
                                        Hapus Stiker
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Similar Stickers -->
                    <?php if(!empty($similar_stickers)): ?>
                        <hr class="my-4">
                        <h5 class="mb-3">Stiker Serupa</h5>
                        <div class="row g-3">
                            <?php foreach($similar_stickers as $similar): ?>
                                <div class="col-md-3">
                                    <div class="card h-100 floating">
                                        <img src="<?= base_url('uploads/stickers/' . $similar->image) ?>" 
                                             class="card-img-top" alt="<?= $similar->name ?>"
                                             style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1"><?= $similar->name ?></h6>
                                            <small class="text-muted d-block">
                                                <?= $similar->owner_name ?>
                                            </small>
                                            <?php if($similar->is_tradeable): ?>
                                                <button class="btn btn-primary btn-sm w-100 mt-2" 
                                                        onclick="initiateTradeRequest(<?= $similar->id ?>)">
                                                    <i class="bi bi-arrow-left-right"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trade Request Modal -->
<div class="modal fade" id="tradeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title">Ajukan Pertukaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tradeRequestForm">
                    <input type="hidden" id="requested_sticker_id" name="requested_sticker_id">
                    <div class="mb-3">
                        <label class="form-label">Pilih Stiker Untuk Ditukar</label>
                        <select class="form-select" name="offered_sticker_id" required>
                            <option value="">Pilih Stiker</option>
                            <?php foreach($my_stickers as $my_sticker): ?>
                                <option value="<?= $my_sticker->id ?>">
                                    <?= $my_sticker->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan (Opsional)</label>
                        <textarea class="form-control" name="message" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitTradeRequest()">
                    <i class="bi bi-send me-2"></i>Ajukan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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

function deleteSticker(id) {
    if(confirm('Apakah Anda yakin ingin menghapus stiker ini? Tindakan ini tidak dapat dibatalkan.')) {
        window.location.href = `<?= base_url('stickers/delete/') ?>${id}`;
    }
}
</script>

<?php $this->load->view('templates/footer'); ?> 