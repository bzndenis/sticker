<?php $this->load->view('templates/header', ['title' => 'Ketentuan Penggunaan']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Ketentuan Penggunaan</h4>

                    <!-- Ketentuan Umum -->
                    <div class="mb-4">
                        <h5 class="mb-3">1. Ketentuan Umum</h5>
                        <p>Dengan menggunakan platform Sticker Exchange, Anda menyetujui dan tunduk pada ketentuan penggunaan berikut:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check2-circle me-2 text-primary"></i>Platform ini ditujukan untuk pertukaran stiker digital secara legal</li>
                            <li class="mb-2"><i class="bi bi-check2-circle me-2 text-primary"></i>Pengguna wajib berusia minimal 13 tahun</li>
                            <li class="mb-2"><i class="bi bi-check2-circle me-2 text-primary"></i>Setiap akun harus menggunakan data yang valid dan akurat</li>
                        </ul>
                    </div>

                    <!-- Hak dan Kewajiban -->
                    <div class="mb-4">
                        <h5 class="mb-3">2. Hak dan Kewajiban Pengguna</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-2">Hak Pengguna:</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Mengakses fitur platform</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Melakukan pertukaran stiker</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Mendapatkan dukungan teknis</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">Kewajiban Pengguna:</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Menjaga keamanan akun</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Tidak melakukan spam</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right me-2 text-primary"></i>Menghormati pengguna lain</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Larangan -->
                    <div class="mb-4">
                        <h5 class="mb-3">3. Larangan</h5>
                        <div class="alert alert-danger">
                            <h6 class="alert-heading mb-2">Dilarang Keras:</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-x-circle me-2"></i>Menyebarkan konten ilegal atau berbahaya</li>
                                <li class="mb-2"><i class="bi bi-x-circle me-2"></i>Melakukan penipuan atau aktivitas ilegal</li>
                                <li class="mb-2"><i class="bi bi-x-circle me-2"></i>Menggunakan bot atau otomatisasi</li>
                                <!-- <li class="mb-2"><i class="bi bi-x-circle me-2"></i>Menjual atau membeli stiker dengan uang</li> -->
                            </ul>
                        </div>
                    </div>

                    <!-- Sanksi -->
                    <div class="mb-4">
                        <h5 class="mb-3">4. Sanksi Pelanggaran</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jenis Pelanggaran</th>
                                        <th>Sanksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pelanggaran Ringan</td>
                                        <td>Peringatan tertulis</td>
                                    </tr>
                                    <tr>
                                        <td>Pelanggaran Sedang</td>
                                        <td>Pembatasan akses sementara</td>
                                    </tr>
                                    <tr>
                                        <td>Pelanggaran Berat</td>
                                        <td>Penonaktifan akun permanen</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Perubahan Ketentuan -->
                    <div class="mb-4">
                        <h5 class="mb-3">5. Perubahan Ketentuan</h5>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Kami berhak mengubah ketentuan penggunaan sewaktu-waktu. Perubahan akan diinformasikan melalui email atau notifikasi platform.
                        </div>
                    </div>

                    <!-- Penutup -->
                    <div class="text-muted small">
                        <p class="mb-1">Terakhir diperbarui: <?= date('d F Y') ?></p>
                        <p class="mb-0">Hubungi kami jika ada pertanyaan tentang ketentuan penggunaan ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: var(--dark-gradient);
}

.table {
    color: rgba(255, 255, 255, 0.8);
}

.table th, .table td {
    border-color: rgba(255, 255, 255, 0.1);
}

.alert {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.2);
}

.alert-info {
    background: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.2);
}
</style>

<?php $this->load->view('templates/footer'); ?> 