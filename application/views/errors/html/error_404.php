<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --dark-gradient: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        body {
            background: var(--dark-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .error-page {
            position: relative;
            z-index: 1;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 700;
            line-height: 1;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
        }

        .error-text {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .sticker-lost {
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            position: relative;
            overflow: hidden;
        }

        .sticker-lost i {
            font-size: 5rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .sticker-lost::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.5;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: move 3s linear infinite;
            border-radius: 50%;
        }

        @keyframes move {
            0% {
                transform: translateY(100vh) scale(0);
            }
            100% {
                transform: translateY(-10vh) scale(1);
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <?php for($i = 0; $i < 10; $i++): ?>
            <span style="
                left: <?= rand(0, 100) ?>%;
                width: <?= rand(10, 30) ?>px;
                height: <?= rand(10, 30) ?>px;
                animation-delay: <?= $i * 0.3 ?>s;
                animation-duration: <?= rand(3, 6) ?>s;
            "></span>
        <?php endfor; ?>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center error-page">
                <div class="sticker-lost floating">
                    <i class="bi bi-emoji-dizzy"></i>
                </div>
                <h1 class="error-code">404</h1>
                <p class="error-text">Oops! Halaman yang Anda cari tidak ditemukan</p>
                <p class="text-muted mb-4">
                    Sepertinya stiker ini terselip di tempat lain. 
                    Mari kembali ke halaman utama!
                </p>
                <a href="/" class="btn btn-primary">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        // Add random movement to background elements
        document.querySelectorAll('.bg-animation span').forEach(element => {
            element.style.left = `${Math.random() * 100}%`;
            element.style.animationDelay = `${Math.random() * 2}s`;
            element.style.animationDuration = `${3 + Math.random() * 3}s`;
        });
    </script>
</body>
</html>