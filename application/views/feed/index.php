<div class="container mt-4">
    <h2>Rekomendasi Stiker untuk Anda</h2>
    
    <?php if(empty($stickers)): ?>
        <div class="alert alert-info">
            Tidak ada stiker yang tersedia untuk ditukar saat ini.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach($stickers as $sticker): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <?php if($sticker['image_path']): ?>
                            <img src="<?= base_url('uploads/stickers/' . $sticker['image_path']) ?>" class="card-img-top" alt="Sticker">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                No Image
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title">Stiker #<?= $sticker['sticker_number'] ?></h5>
                            <p class="card-text">
                                Kategori: <?= $sticker['category_name'] ?><br>
                                Pemilik: <?= $sticker['username'] ?><br>
                                Jumlah: <?= $sticker['quantity'] ?>
                            </p>
                            <a href="<?= base_url('trades/create/' . $sticker['id']) ?>" class="btn btn-primary">Ajukan Penukaran</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    <?= $pagination ?>
                </nav>
            </div>
        </div>
    <?php endif; ?>
</div>