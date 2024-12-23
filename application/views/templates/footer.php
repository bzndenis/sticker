    </div> <!-- Tutup content-wrapper -->
    
    <!-- Footer -->
    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row g-4">
                <!-- Brand Section -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="brand-icon me-3">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h5 class="mb-0">Sticker Exchange</h5>
                    </div>
                    <p class="text-muted mb-4">
                        Platform pertukaran stiker digital yang mempertemukan kolektor 
                        untuk saling berbagi dan menukar koleksi mereka.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-discord"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="mb-3">Tautan Cepat</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li><a href="<?= base_url('feed') ?>">Feed</a></li>
                        <li><a href="<?= base_url('collection') ?>">Koleksi</a></li>
                        <li><a href="<?= base_url('trades') ?>">Pertukaran</a></li>
                    </ul>
                </div>

                <!-- Help & Support -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="mb-3">Bantuan</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?= base_url('help') ?>">FAQ</a></li>
                        <li><a href="<?= base_url('guide/getting-started') ?>">Panduan</a></li>
                        <li><a href="<?= base_url('help') ?>">Kontak</a></li>
                        <li><a href="<?= base_url('help') ?>">Laporkan Bug</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="mb-3">Legal</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?= base_url('legal/terms') ?>">Ketentuan</a></li>
                        <li><a href="<?= base_url('legal/privacy') ?>">Privasi</a></li>
                        <li><a href="<?= base_url('legal/cookies') ?>">Cookies</a></li>
                        <li><a href="<?= base_url('legal/license') ?>">Lisensi</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-2">
                    <h6 class="mb-3">Support</h6>
                    <p class="text-muted small mb-3">
                        Dukung pengembangan aplikasi ini melalui:
                    </p>
                    <div class="d-flex flex-column gap-2">
                        <a href="https://github.com/bzndenis/sticker" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-github me-2"></i>GitHub
                        </a>
                        <a href="https://saweria.co/bzndenis" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-heart-fill me-2"></i>Saweria
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            
            <!-- Copyright -->
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">
                        &copy; <?= date('Y') ?> Sticker Exchange. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-muted">
                        Made with <i class="bi bi-heart-fill text-danger"></i>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
    .footer {
        background: var(--dark-gradient);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .social-link {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--primary-gradient);
        color: #fff;
        transform: translateY(-2px);
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #fff;
        padding-left: 5px;
    }

    .newsletter-form .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
    }

    .newsletter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .newsletter-form .btn {
        padding: 0.375rem 0.75rem;
    }

    hr {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu {
        background: var(--dark-gradient);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .dropdown-item {
        color: rgba(255, 255, 255, 0.8);
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
    // Newsletter Form
    document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        
        // Implementasi subscribe newsletter
        console.log('Subscribe:', email);
        
        // Show success message
        alert('Terima kasih telah berlangganan newsletter kami!');
        this.reset();
    });
    </script>

</body>
</html> 