<?php 
$data['title'] = 'Laporan';
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/admin_navbar'); ?>

<div class="container my-4">
    <h2 class="mb-4">Laporan</h2>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Laporan Pertukaran -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Laporan Pertukaran</h5>
                    <p class="text-muted">Lihat statistik pertukaran berdasarkan periode</p>
                    
                    <form action="<?= base_url('admin/generate_trade_report') ?>" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Periode</label>
                            <select name="period" class="form-select" required>
                                <option value="daily">Harian</option>
                                <option value="weekly">Mingguan</option>
                                <option value="monthly">Bulanan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text"></i> Generate Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Laporan Pengguna -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Laporan Pengguna</h5>
                    <p class="text-muted">Lihat statistik pengguna dan aktivitas</p>
                    
                    <form action="<?= base_url('admin/generate_user_report') ?>" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Tipe Laporan</label>
                            <select name="type" class="form-select" required>
                                <option value="new_users">Pengguna Baru</option>
                                <option value="active_users">Pengguna Aktif</option>
                                <option value="collection_progress">Progress Koleksi</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Periode</label>
                            <select name="period" class="form-select" required>
                                <option value="daily">Harian</option>
                                <option value="weekly">Mingguan</option>
                                <option value="monthly">Bulanan</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-file-earmark-text"></i> Generate Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Umum -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistik Umum</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <h6>Total Pengguna</h6>
                                <h3><?= $total_users ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <h6>Total Koleksi</h6>
                                <h3><?= $total_collections ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <h6>Total Stiker</h6>
                                <h3><?= $total_stickers ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <h6>Total Pertukaran</h6>
                                <h3><?= $total_trades ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validasi tanggal
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const startDate = form.querySelector('input[name="start_date"]');
        const endDate = form.querySelector('input[name="end_date"]');
        
        if(startDate && endDate) {
            if(new Date(startDate.value) > new Date(endDate.value)) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
            }
        }
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 