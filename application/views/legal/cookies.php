<?php $this->load->view('templates/header', ['title' => 'Kebijakan Cookies']); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Kebijakan Cookies</h4>

                    <!-- Penjelasan Cookies -->
                    <div class="mb-4">
                        <h5 class="mb-3">1. Apa itu Cookies?</h5>
                        <div class="alert alert-info">
                            <p class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Cookies adalah file kecil yang disimpan di perangkat Anda saat mengunjungi website. 
                                File ini membantu kami memberikan pengalaman yang lebih baik saat Anda menggunakan platform.
                            </p>
                        </div>
                    </div>

                    <!-- Jenis Cookies -->
                    <div class="mb-4">
                        <h5 class="mb-3">2. Jenis Cookies yang Kami Gunakan</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="cookie-type p-3 rounded">
                                    <h6><i class="bi bi-shield-check me-2"></i>Cookies Esensial</h6>
                                    <p class="small text-muted mb-0">Diperlukan agar website dapat berfungsi dengan baik</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="cookie-type p-3 rounded">
                                    <h6><i class="bi bi-person-check me-2"></i>Cookies Preferensi</h6>
                                    <p class="small text-muted mb-0">Mengingat pilihan dan pengaturan Anda</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="cookie-type p-3 rounded">
                                    <h6><i class="bi bi-graph-up me-2"></i>Cookies Analitik</h6>
                                    <p class="small text-muted mb-0">Membantu kami memahami penggunaan website</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="cookie-type p-3 rounded">
                                    <h6><i class="bi bi-megaphone me-2"></i>Cookies Marketing</h6>
                                    <p class="small text-muted mb-0">Menampilkan konten yang relevan dengan Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Cookies -->
                    <!-- <div class="mb-4">
                        <h5 class="mb-3">3. Mengatur Cookies</h5>
                        <div class="settings-container p-4 rounded">
                            <div class="cookie-settings mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="essentialCookies" checked disabled>
                                    <label class="form-check-label" for="essentialCookies">Cookies Esensial (Wajib)</label>
                                </div>
                            </div>
                            <div class="cookie-settings mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="preferenceCookies">
                                    <label class="form-check-label" for="preferenceCookies">Cookies Preferensi</label>
                                </div>
                            </div>
                            <div class="cookie-settings mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="analyticsCookies">
                                    <label class="form-check-label" for="analyticsCookies">Cookies Analitik</label>
                                </div>
                            </div>
                            <div class="cookie-settings">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="marketingCookies">
                                    <label class="form-check-label" for="marketingCookies">Cookies Marketing</label>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button class="btn btn-primary" onclick="saveCookiePreferences()">
                                    Simpan Preferensi
                                </button>
                            </div>
                        </div>
                    </div> -->

                    <!-- Browser Settings -->
                    <!-- <div class="mb-4">
                        <h5 class="mb-3">4. Pengaturan Browser</h5>
                        <p class="text-muted mb-3">
                            Anda juga dapat mengatur cookies melalui browser Anda:
                        </p>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="browser-item text-center p-3 rounded">
                                    <i class="bi bi-chrome fs-3 mb-2"></i>
                                    <p class="mb-0 small">Chrome</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="browser-item text-center p-3 rounded">
                                    <i class="bi bi-firefox fs-3 mb-2"></i>
                                    <p class="mb-0 small">Firefox</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="browser-item text-center p-3 rounded">
                                    <i class="bi bi-safari fs-3 mb-2"></i>
                                    <p class="mb-0 small">Safari</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="browser-item text-center p-3 rounded">
                                    <i class="bi bi-edge fs-3 mb-2"></i>
                                    <p class="mb-0 small">Edge</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Penutup -->
                    <div class="text-muted small">
                        <p class="mb-1">Terakhir diperbarui: <?= date('d F Y') ?></p>
                        <p class="mb-0">Hubungi kami jika ada pertanyaan tentang penggunaan cookies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cookie-type, .browser-item {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.cookie-type:hover, .browser-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.settings-container {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.form-check-input {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
}

.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}
</style>

<script>
function saveCookiePreferences() {
    // Implementasi penyimpanan preferensi cookies
    const preferences = {
        essential: true, // Selalu true
        preference: document.getElementById('preferenceCookies').checked,
        analytics: document.getElementById('analyticsCookies').checked,
        marketing: document.getElementById('marketingCookies').checked
    };
    
    // Simpan ke localStorage
    localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
    
    // Tampilkan notifikasi
    alert('Preferensi cookies berhasil disimpan!');
}

// Load saved preferences
document.addEventListener('DOMContentLoaded', function() {
    const saved = localStorage.getItem('cookiePreferences');
    if (saved) {
        const preferences = JSON.parse(saved);
        document.getElementById('preferenceCookies').checked = preferences.preference;
        document.getElementById('analyticsCookies').checked = preferences.analytics;
        document.getElementById('marketingCookies').checked = preferences.marketing;
    }
});
</script>

<?php $this->load->view('templates/footer'); ?> 