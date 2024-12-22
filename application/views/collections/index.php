<?php 
$data['title'] = 'Koleksi Stiker';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Koleksi Stiker</h2>
        <a href="<?= base_url('feed') ?>" class="btn btn-primary">
            <i class="bi bi-collection"></i> Lihat Feed Stiker
        </a>
    </div>

    <!-- Daftar Kategori -->
    <div class="row g-4">
        <?php foreach($collections as $category): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?= $category->name ?></h5>
                        
                        <!-- Progress -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small>Progress</small>
                                <small><?= $category->owned ?>/<?= $category->total ?> Stiker</small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?= $category->progress ?>%">
                                    <?= number_format($category->progress, 1) ?>%
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <a href="<?= base_url('collections/manage/'.$category->id) ?>" 
                               class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Kelola Stiker
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 