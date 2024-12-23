<?php $this->load->view('templates/header'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Buat Pertukaran Baru</h5>
        </div>
        <div class="card-body">
            <?php if(empty($owned_stickers)): ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">Tidak Ada Stiker untuk Ditukar</h5>
                    <p class="text-muted mb-4">
                        Anda harus memiliki stiker yang dapat ditukar terlebih dahulu
                    </p>
                    <a href="<?= base_url('collection') ?>" class="btn btn-primary">
                        Kelola Koleksi
                    </a>
                </div>
            <?php else: ?>
                <form action="<?= base_url('trades/store') ?>" method="POST">
                    <input type="hidden" name="requested_sticker_id" value="<?= $requested_sticker->id ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Stiker yang Diminta</label>
                        <div class="card">
                            <div class="card-body">
                                <h6>Stiker #<?= $requested_sticker->number ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Stiker untuk Ditukar</label>
                        <select name="offered_sticker_id" class="form-select" required>
                            <option value="">Pilih Stiker</option>
                            <?php foreach($owned_stickers as $sticker): ?>
                                <option value="<?= $sticker->sticker_id ?>">
                                    Stiker #<?= $sticker->sticker_number ?> 
                                    (Tersedia: <?= $sticker->quantity ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Ajukan Pertukaran
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 