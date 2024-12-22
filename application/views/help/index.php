<?php $this->load->view('templates/header', ['title' => 'Bantuan']); ?>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush help-menu">
                        <a href="#faq" class="list-group-item active" data-bs-toggle="list">
                            <i class="bi bi-question-circle me-3"></i>FAQ
                        </a>
                        <a href="#guide" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-book me-3"></i>Panduan
                        </a>
                        <a href="#contact" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-envelope me-3"></i>Kontak
                        </a>
                        <a href="#report" class="list-group-item" data-bs-toggle="list">
                            <i class="bi bi-bug me-3"></i>Laporkan Bug
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Bantuan Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('guide/getting-started') ?>" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-play-circle me-2"></i>Panduan Memulai
                        </a>
                        <button class="btn btn-primary btn-sm" onclick="openLiveChat()">
                            <i class="bi bi-chat-dots me-2"></i>Live Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- FAQ Section -->
                <div class="tab-pane fade show active" id="faq">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Pertanyaan yang Sering Diajukan</h4>
                            
                            <div class="accordion" id="faqAccordion">
                                <!-- Umum -->
                                <div class="accordion-item bg-dark">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                            Bagaimana cara memulai pertukaran stiker?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Untuk memulai pertukaran stiker:</p>
                                            <ol>
                                                <li>Masuk ke halaman Feed atau Koleksi</li>
                                                <li>Pilih stiker yang ingin ditukar</li>
                                                <li>Klik tombol "Ajukan Pertukaran"</li>
                                                <li>Pilih stiker yang ingin ditawarkan</li>
                                                <li>Tunggu konfirmasi dari pemilik stiker</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <!-- Koleksi -->
                                <div class="accordion-item bg-dark">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            Bagaimana cara mengelola koleksi stiker?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Anda dapat mengelola koleksi stiker melalui:</p>
                                            <ul>
                                                <li>Menu "Koleksi" di navbar</li>
                                                <li>Mengatur status tukar setiap stiker</li>
                                                <li>Menambah atau menghapus stiker</li>
                                                <li>Mengatur visibilitas koleksi</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guide Section -->
                <div class="tab-pane fade" id="guide">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Panduan Pengguna</h4>
                            
                            <div class="row g-4">
                                <!-- Getting Started -->
                                <div class="col-md-6">
                                    <div class="card h-100 bg-dark">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="guide-icon me-3">
                                                    <i class="bi bi-rocket-takeoff"></i>
                                                </div>
                                                <h5 class="card-title mb-0">Memulai</h5>
                                            </div>
                                            <p class="card-text text-muted">
                                                Panduan lengkap untuk memulai menggunakan platform Sticker Exchange
                                            </p>
                                            <a href="<?= base_url('guide/getting-started') ?>" class="btn btn-outline-light btn-sm">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trading Guide -->
                                <div class="col-md-6">
                                    <div class="card h-100 bg-dark">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="guide-icon me-3">
                                                    <i class="bi bi-arrow-left-right"></i>
                                                </div>
                                                <h5 class="card-title mb-0">Pertukaran</h5>
                                            </div>
                                            <p class="card-text text-muted">
                                                Cara melakukan pertukaran stiker dengan pengguna lain
                                            </p>
                                            <a href="<?= base_url('guide/trading') ?>" class="btn btn-outline-light btn-sm">
                                                Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="tab-pane fade" id="contact">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Hubungi Kami</h4>
                            
                            <?= form_open('help/contact', ['class' => 'contact-form']) ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Subjek</label>
                                        <input type="text" class="form-control" name="subject" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Pesan</label>
                                        <textarea class="form-control" name="message" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-2"></i>Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>

                <!-- Report Bug Section -->
                <div class="tab-pane fade" id="report">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Laporkan Bug</h4>
                            
                            <?= form_open_multipart('help/report_bug', ['class' => 'bug-report-form']) ?>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Judul Bug</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Halaman/Fitur</label>
                                        <input type="text" class="form-control" name="page" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tingkat Keseriusan</label>
                                        <select class="form-select" name="severity" required>
                                            <option value="low">Rendah</option>
                                            <option value="medium">Sedang</option>
                                            <option value="high">Tinggi</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Deskripsi Bug</label>
                                        <textarea class="form-control" name="description" rows="5" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Screenshot (opsional)</label>
                                        <input type="file" class="form-control" name="screenshot" accept="image/*">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-bug me-2"></i>Kirim Laporan
                                        </button>
                                    </div>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.help-menu .list-group-item {
    background: transparent;
    border: none;
    color: #fff;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
}

.help-menu .list-group-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.help-menu .list-group-item.active {
    background: var(--primary-gradient);
}

.guide-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-gradient);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.accordion-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 0.5rem;
}

.accordion-button {
    background: transparent;
    color: #fff;
}

.accordion-button:not(.collapsed) {
    background: var(--primary-gradient);
    color: #fff;
}

.accordion-button::after {
    filter: invert(1);
}

.form-control, .form-select {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-control:focus, .form-select:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: var(--bs-primary);
    color: #fff;
}
</style>

<script>
function openLiveChat() {
    // Implementasi live chat
    alert('Fitur live chat akan segera hadir!');
}

// Smooth scroll untuk menu
document.querySelectorAll('.help-menu .list-group-item').forEach(item => {
    item.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(item.getAttribute('href'));
        target.scrollIntoView({ behavior: 'smooth' });
    });
});
</script>

<?php $this->load->view('templates/footer'); ?> 