<?php $this->load->view('templates/header', ['title' => 'Kelola Kategori']); ?>
<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Kelola Kategori</h4>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Total Stiker</th>
                            <th>Total Kolektor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $category): ?>
                            <tr>
                                <td><?= $category->name ?></td>
                                <td><?= $category->total_stickers ?></td>
                                <td><?= $category->total_collectors ?></td>
                                <td>
                                    <a href="<?= base_url('admin/categories/edit/'.$category->id) ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?> 