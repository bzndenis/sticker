<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Koleksi - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('templates/navbar'); ?>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2>Hasil Pencarian</h2>
                <?php if($keyword): ?>
                    <p class="text-muted">
                        Menampilkan hasil untuk "<?= $keyword ?>"
                        <?= $selected_category ? ' dalam kategori "'.$categories[$selected_category].'"' : '' ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <form action="<?= base_url('collections/search') ?>" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" 
                               placeholder="Cari koleksi..." value="<?= $keyword ?>">
                        <select name="category" class="form-select" style="max-width: 150px;">
                            <option value="">Semua Kategori</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category->id ?>" 
                                    <?= $selected_category == $category->id ? 'selected' : '' ?>>
                                    <?= $category->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if(empty($collections)): ?>
            <div class="alert alert-info">
                Tidak ada koleksi yang ditemukan.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach($collections as $collection): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $collection->name ?></h5>
                                <p class="card-text">
                                    <?= substr($collection->description, 0, 100) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <?= $collection->total_stickers ?> stiker
                                    </small>
                                    <a href="<?= base_url('collections/view/'.$collection->id) ?>" 
                                       class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 