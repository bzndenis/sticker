<?php $this->load->view('templates/header', ['title' => $guide->title]); ?>

<div class="container my-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card mb-4 sidebar-card">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom">
                        <h5 class="mb-0">Panduan Pengguna</h5>
                    </div>
                    <div class="guide-menu p-2">
                        <?php foreach($guides as $g): ?>
                            <a href="<?= base_url('guide/' . $g->slug) ?>" 
                               class="menu-item <?= ($g->id === $guide->id) ? 'active' : '' ?>">
                                <div class="d-flex align-items-center">
                                    <?php if($g->slug === 'getting-started'): ?>
                                        <i class="bi bi-rocket-takeoff"></i>
                                    <?php elseif($g->slug === 'trading-guide'): ?>
                                        <i class="bi bi-arrow-left-right"></i>
                                    <?php elseif($g->slug === 'collection-tips'): ?>
                                        <i class="bi bi-collection"></i>
                                    <?php else: ?>
                                        <i class="bi bi-book"></i>
                                    <?php endif; ?>
                                    <span><?= $g->title ?></span>
                                </div>
                                <?php if($g->id === $guide->id): ?>
                                    <div class="active-indicator"></div>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card quick-actions">
                <div class="card-body">
                    <h6 class="mb-3">Bantuan Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('help#faq') ?>" class="action-btn">
                            <i class="bi bi-question-circle"></i>
                            <div>
                                <span class="title">FAQ</span>
                                <small class="desc">Pertanyaan umum</small>
                            </div>
                        </a>
                        <a href="<?= base_url('help#contact') ?>" class="action-btn">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <span class="title">Kontak</span>
                                <small class="desc">Hubungi tim support</small>
                            </div>
                        </a>
                        <button onclick="openLiveChat()" class="action-btn">
                            <i class="bi bi-chat-dots"></i>
                            <div>
                                <span class="title">Live Chat</span>
                                <small class="desc">Bantuan langsung</small>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="card content-card">
                <div class="card-body">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('help') ?>">
                                    <i class="bi bi-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('help#guide') ?>">Panduan</a>
                            </li>
                            <li class="breadcrumb-item active"><?= $guide->title ?></li>
                        </ol>
                    </nav>

                    <!-- Progress Bar -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="guide-content">
                        <h1 class="guide-title"><?= $guide->title ?></h1>
                        <div class="guide-meta">
                            <span class="badge bg-primary">
                                <i class="bi bi-clock"></i> <?= ceil(str_word_count($guide->content) / 200) ?> menit baca
                            </span>
                            <span class="badge bg-secondary">
                                <i class="bi bi-calendar"></i> Update: <?= date('d M Y', strtotime($guide->updated_at)) ?>
                            </span>
                        </div>

                        <!-- Table of Contents -->
                        <div class="toc-container">
                            <div class="toc-header">
                                <i class="bi bi-list-ul me-2"></i>Daftar Isi
                            </div>
                            <div class="toc-content" id="tableOfContents">
                                <!-- Diisi oleh JavaScript -->
                            </div>
                        </div>

                        <div class="guide-body">
                            <?= $guide->content ?>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="guide-navigation">
                        <div class="row g-4">
                            <?php if(isset($prev_guide)): ?>
                            <div class="col-md-6">
                                <a href="<?= base_url('guide/' . $prev_guide->slug) ?>" class="nav-card prev">
                                    <div class="icon">
                                        <i class="bi bi-arrow-left"></i>
                                    </div>
                                    <div class="content">
                                        <small>Sebelumnya</small>
                                        <h6><?= $prev_guide->title ?></h6>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>

                            <?php if(isset($next_guide)): ?>
                            <div class="col-md-6">
                                <a href="<?= base_url('guide/' . $next_guide->slug) ?>" class="nav-card next">
                                    <div class="content">
                                        <small>Selanjutnya</small>
                                        <h6><?= $next_guide->title ?></h6>
                                    </div>
                                    <div class="icon">
                                        <i class="bi bi-arrow-right"></i>
                                    </div>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Feedback -->
                    <div class="guide-feedback">
                        <div class="feedback-card">
                            <div class="feedback-content">
                                <h5>Apakah panduan ini membantu?</h5>
                                <p class="text-muted">Bantu kami meningkatkan kualitas panduan</p>
                                <div class="feedback-actions">
                                    <button onclick="submitFeedback('helpful')" class="btn-feedback positive">
                                        <i class="bi bi-emoji-smile"></i>
                                        <span>Membantu</span>
                                    </button>
                                    <button onclick="submitFeedback('not_helpful')" class="btn-feedback negative">
                                        <i class="bi bi-emoji-frown"></i>
                                        <span>Kurang Membantu</span>
                                    </button>
                                </div>
                            </div>
                            <div class="feedback-illustration">
                                <i class="bi bi-chat-square-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Sidebar Styles */
.sidebar-card {
    position: sticky;
    top: 20px;
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    background: var(--dark-gradient);
}

.guide-menu {
    max-height: calc(100vh - 300px);
    overflow-y: auto;
}

.menu-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    border-radius: 8px;
    margin: 4px 8px;
    transition: all 0.3s ease;
}

.menu-item i {
    font-size: 1.2rem;
    margin-right: 12px;
    opacity: 0.7;
}

.menu-item:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

.menu-item.active {
    background: var(--primary-gradient);
    color: #fff;
}

.active-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #fff;
}

/* Quick Actions */
.quick-actions {
    border: none;
    background: var(--dark-gradient);
}

.action-btn {
    display: flex;
    align-items: center;
    padding: 12px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
    background: transparent;
    width: 100%;
    text-align: left;
}

.action-btn i {
    font-size: 1.5rem;
    margin-right: 12px;
}

.action-btn .title {
    display: block;
    font-weight: 500;
}

.action-btn .desc {
    display: block;
    opacity: 0.7;
}

.action-btn:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
    transform: translateY(-2px);
}

/* Content Styles */
.content-card {
    border: none;
    background: var(--dark-gradient);
}

.progress-container {
    position: sticky;
    top: 0;
    z-index: 100;
    padding: 10px 0;
    background: var(--dark-gradient);
}

.progress {
    height: 4px;
    background: rgba(255,255,255,0.1);
}

.guide-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.guide-meta {
    margin-bottom: 2rem;
}

.guide-meta .badge {
    padding: 8px 16px;
    font-weight: 500;
    margin-right: 8px;
}

.guide-meta i {
    margin-right: 6px;
}

/* Table of Contents */
.toc-container {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    margin: 2rem 0;
    padding: 1.5rem;
}

.toc-header {
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-primary);
}

.toc-content a {
    display: block;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    padding: 6px 0;
    padding-left: 20px;
    border-left: 2px solid rgba(255,255,255,0.1);
    margin: 4px 0;
    transition: all 0.3s ease;
}

.toc-content a:hover {
    color: #fff;
    border-left-color: var(--bs-primary);
}

.toc-content a.active {
    color: var(--bs-primary);
    border-left-color: var(--bs-primary);
}

/* Navigation Cards */
.nav-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    text-decoration: none;
    color: #fff;
    transition: all 0.3s ease;
}

.nav-card:hover {
    background: rgba(255,255,255,0.1);
    color: #fff;
    transform: translateY(-2px);
}

.nav-card .icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-gradient);
    border-radius: 10px;
    font-size: 1.2rem;
}

.nav-card .content {
    flex: 1;
    padding: 0 1rem;
}

.nav-card small {
    display: block;
    opacity: 0.7;
    margin-bottom: 4px;
}

.nav-card h6 {
    margin: 0;
    font-weight: 600;
}

/* Feedback Section */
.guide-feedback {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.feedback-card {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 2rem;
}

.feedback-content {
    flex: 1;
}

.feedback-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-feedback {
    display: flex;
    align-items: center;
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    color: #fff;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.1);
}

.btn-feedback i {
    margin-right: 8px;
    font-size: 1.2rem;
}

.btn-feedback.positive:hover {
    background: var(--bs-success);
}

.btn-feedback.negative:hover {
    background: var(--bs-danger);
}

.feedback-illustration {
    font-size: 4rem;
    margin-left: 2rem;
    opacity: 0.2;
}

/* Content Typography */
.guide-body {
    font-size: 1.1rem;
    line-height: 1.8;
}

.guide-body h2 {
    font-size: 1.8rem;
    margin-top: 3rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.guide-body h3 {
    font-size: 1.4rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--bs-primary);
}

.guide-body p {
    margin-bottom: 1.5rem;
}

.guide-body ul, .guide-body ol {
    margin-bottom: 1.5rem;
    padding-left: 1.2rem;
}

.guide-body li {
    margin-bottom: 0.5rem;
}

.guide-body code {
    background: rgba(255,255,255,0.1);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Fira Code', monospace;
}

.guide-body pre {
    background: rgba(0,0,0,0.2);
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 2rem 0;
}

.guide-body img {
    max-width: 100%;
    border-radius: 12px;
    margin: 2rem 0;
}

.guide-body blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
}
</style>

<script>
// Progress bar
window.addEventListener('scroll', function() {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.querySelector('.progress-bar').style.width = scrolled + '%';
});

// Generate Table of Contents
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.guide-body');
    const toc = document.getElementById('tableOfContents');
    const headings = content.querySelectorAll('h2, h3');
    
    headings.forEach((heading, index) => {
        const id = `section-${index}`;
        heading.id = id;
        
        const link = document.createElement('a');
        link.href = `#${id}`;
        link.textContent = heading.textContent;
        link.style.paddingLeft = heading.tagName === 'H3' ? '40px' : '20px';
        
        toc.appendChild(link);
    });
});

// Highlight current section in TOC
window.addEventListener('scroll', function() {
    const headings = document.querySelectorAll('.guide-body h2, .guide-body h3');
    const tocLinks = document.querySelectorAll('.toc-content a');
    
    let current = '';
    
    headings.forEach(heading => {
        const top = heading.getBoundingClientRect().top;
        
        if (top < 100) {
            current = heading.id;
        }
    });
    
    tocLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});

function submitFeedback(type) {
    const feedbackCard = document.querySelector('.feedback-card');
    const message = type === 'helpful' ? 
        'Terima kasih atas feedback positif Anda!' : 
        'Terima kasih atas feedback Anda. Kami akan terus meningkatkan kualitas panduan kami.';
    
    feedbackCard.innerHTML = `
        <div class="text-center w-100">
            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
            <h5 class="mt-3">${message}</h5>
        </div>
    `;
}

function openLiveChat() {
    alert('Fitur live chat akan segera hadir!');
}
</script>

<?php $this->load->view('templates/footer'); ?> 