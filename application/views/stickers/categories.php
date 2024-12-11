<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kategori Sticker GetRich</h4>
                        <div class="row">
                            <?php foreach($categories as $category): ?>
                            <div class="col-md-3 mb-4">
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="mdi <?= $category->icon ?> icon-lg"></i>
                                            <div class="ml-4">
                                                <h6 class="mb-0"><?= $category->name ?></h6>
                                                <small><?= $category->total_stickers ?>/9 sticker</small>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('stickers/list/'.$category->id) ?>" 
                                           class="btn btn-block btn-outline-primary mt-3">
                                            Lihat Sticker
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
