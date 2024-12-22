<?php $this->load->view('templates/header', ['title' => 'Lisensi']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Lisensi Penggunaan</h4>

                    <!-- Ketentuan Lisensi -->
                    <div class="mb-4">
                        <h5 class="mb-3">1. Ketentuan Lisensi</h5>
                        <div class="alert alert-info">
                            <p class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Semua konten dan stiker di platform Sticker Exchange dilindungi hak cipta 
                                dan tunduk pada ketentuan lisensi berikut.
                            </p>
                        </div>
                    </div>

                    <!-- Hak Cipta -->
                    <div class="mb-4">
                        <h5 class="mb-3">2. Hak Cipta</h5>
                        <div class="license-section p-3 rounded">
                            <h6 class="mb-3">Kepemilikan Konten:</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bi bi-check2-circle me-2 text-primary"></i>
                                    Stiker original milik pembuat/artis
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check2-circle me-2 text-primary"></i>
                                    Platform memiliki hak distribusi
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check2-circle me-2 text-primary"></i>
                                    Pengguna memiliki hak penggunaan terbatas
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Penggunaan yang Diizinkan -->
                    <div class="mb-4">
                        <h5 class="mb-3">3. Penggunaan yang Diizinkan</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="allowed-usage p-3 rounded">
                                    <h6><i class="bi bi-check-lg me-2 text-success"></i>Diperbolehkan</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">• Penggunaan pribadi</li>
                                        <li class="mb-2">• Pertukaran dalam platform</li>
                                        <li class="mb-2">• Koleksi digital</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="prohibited-usage p-3 rounded">
                                    <h6><i class="bi bi-x-lg me-2 text-danger"></i>Dilarang</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">• Penggunaan komersial</li>
                                        <li class="mb-2">• Modifikasi stiker</li>
                                        <li class="mb-2">• Distribusi di luar platform</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lisensi Pihak Ketiga -->
                    <div class="mb-4">
                        <h5 class="mb-3">4. Lisensi Pihak Ketiga</h5>
                        <div class="third-party p-3 rounded">
                            <div class="mb-3">
                                <h6><i class="bi bi-code-square me-2"></i>Software</h6>
                                <ul class="list-unstyled small text-muted">
                                    <li>• Bootstrap (MIT License)</li>
                                    <li>• jQuery (MIT License)</li>
                                    <li>• CodeIgniter (MIT License)</li>
                                </ul>
                            </div>
                            <div>
                                <h6><i class="bi bi-images me-2"></i>Aset Visual</h6>
                                <ul class="list-unstyled small text-muted">
                                    <li>• Bootstrap Icons (MIT License)</li>
                                    <li>• Font Awesome Free (CC BY 4.0)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pelanggaran dan Sanksi -->
                    <div class="mb-4">
                        <h5 class="mb-3">5. Pelanggaran dan Sanksi</h5>
                        <div class="alert alert-warning">
                            <h6 class="alert-heading mb-2">Konsekuensi Pelanggaran:</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Penonaktifan akun
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Penghapusan konten
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Tindakan hukum jika diperlukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Penutup -->
                    <div class="text-muted small">
                        <p class="mb-1">Terakhir diperbarui: <?= date('d F Y') ?></p>
                        <p class="mb-0">Hubungi legal@stickerexchange.com untuk pertanyaan lisensi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.license-section, .allowed-usage, .prohibited-usage, .third-party {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.license-section:hover, .allowed-usage:hover, .prohibited-usage:hover, .third-party:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.alert-warning {
    background: rgba(255, 193, 7, 0.1);
    border-color: rgba(255, 193, 7, 0.2);
}

.text-success {
    color: #28a745 !important;
}

.text-danger {
    color: #dc3545 !important;
}
</style>

<?php $this->load->view('templates/footer'); ?> 