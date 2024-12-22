<?php $this->load->view('templates/header', ['title' => 'Kebijakan Privasi']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Kebijakan Privasi</h4>

                    <!-- Informasi yang Dikumpulkan -->
                    <div class="mb-4">
                        <h5 class="mb-3">1. Informasi yang Kami Kumpulkan</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="data-category p-3 rounded">
                                    <h6><i class="bi bi-person-badge me-2"></i>Data Profil</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">• Nama pengguna</li>
                                        <li class="mb-2">• Alamat email</li>
                                        <li class="mb-2">• Foto profil</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-category p-3 rounded">
                                    <h6><i class="bi bi-activity me-2"></i>Data Aktivitas</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">• Riwayat pertukaran</li>
                                        <li class="mb-2">• Koleksi stiker</li>
                                        <li class="mb-2">• Interaksi platform</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penggunaan Data -->
                    <div class="mb-4">
                        <h5 class="mb-3">2. Penggunaan Data</h5>
                        <div class="usage-list">
                            <div class="usage-item mb-3 p-3 rounded">
                                <h6><i class="bi bi-gear me-2"></i>Operasional Platform</h6>
                                <p class="mb-0 text-muted">Memproses pertukaran, mengelola akun, dan memberikan dukungan teknis</p>
                            </div>
                            <div class="usage-item mb-3 p-3 rounded">
                                <h6><i class="bi bi-graph-up me-2"></i>Pengembangan Layanan</h6>
                                <p class="mb-0 text-muted">Menganalisis tren, meningkatkan fitur, dan optimasi platform</p>
                            </div>
                            <div class="usage-item p-3 rounded">
                                <h6><i class="bi bi-shield-check me-2"></i>Keamanan</h6>
                                <p class="mb-0 text-muted">Mencegah penipuan dan melindungi pengguna platform</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keamanan Data -->
                    <div class="mb-4">
                        <h5 class="mb-3">3. Keamanan Data</h5>
                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-2">Komitmen Keamanan:</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-shield-lock me-2"></i>Enkripsi data sensitif</li>
                                <li class="mb-2"><i class="bi bi-shield-lock me-2"></i>Pemantauan keamanan 24/7</li>
                                <li class="mb-2"><i class="bi bi-shield-lock me-2"></i>Backup data berkala</li>
                                <li class="mb-2"><i class="bi bi-shield-lock me-2"></i>Akses terbatas untuk staf</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hak Pengguna -->
                    <div class="mb-4">
                        <h5 class="mb-3">4. Hak Pengguna</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="right-item p-3 rounded">
                                    <h6>Akses Data</h6>
                                    <p class="mb-0 small text-muted">Melihat data pribadi yang tersimpan</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="right-item p-3 rounded">
                                    <h6>Koreksi Data</h6>
                                    <p class="mb-0 small text-muted">Memperbarui data yang tidak akurat</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="right-item p-3 rounded">
                                    <h6>Hapus Data</h6>
                                    <p class="mb-0 small text-muted">Menghapus data dari platform</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="right-item p-3 rounded">
                                    <h6>Pembatasan</h6>
                                    <p class="mb-0 small text-muted">Membatasi penggunaan data</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penutup -->
                    <div class="text-muted small">
                        <p class="mb-1">Terakhir diperbarui: <?= date('d F Y') ?></p>
                        <p class="mb-0">Kontak privacy@stickerexchange.com untuk pertanyaan privasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.data-category, .usage-item, .right-item {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.data-category:hover, .usage-item:hover, .right-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.alert-info {
    background: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.2);
}
</style>

<?php $this->load->view('templates/footer'); ?> 