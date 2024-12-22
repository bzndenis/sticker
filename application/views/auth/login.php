<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sticker Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        #dice-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            backdrop-filter: blur(8px);
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: #fff;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-label {
            color: #fff;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .alert {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 8px;
            color: #fff;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div id="dice-container"></div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login</h3>
                        
                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('auth/login') ?>" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // Three.js setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('dice-container').appendChild(renderer.domElement);

        // Create dice geometry with rounded edges
        const geometry = new THREE.BoxGeometry(2, 2, 2, 2, 2, 2);
        const material = new THREE.MeshPhongMaterial({ 
            color: 0xffffff,
            transparent: true,
            opacity: 0.9,
            specular: 0x050505,
            shininess: 100
        });

        const dice = new THREE.Mesh(geometry, material);
        scene.add(dice);

        // Add lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);

        const pointLight = new THREE.PointLight(0xffffff, 1);
        pointLight.position.set(5, 5, 5);
        scene.add(pointLight);

        // Create dots for each face
        function createDot(x, y, z) {
            const dotGeometry = new THREE.SphereGeometry(0.1, 32, 32);
            const dotMaterial = new THREE.MeshPhongMaterial({ color: 0x000000 });
            const dot = new THREE.Mesh(dotGeometry, dotMaterial);
            dot.position.set(x, y, z);
            return dot;
        }

        // Face 1 (one dot) - Front face
        const face1 = new THREE.Group();
        face1.add(createDot(0, 0, 1.01));
        dice.add(face1);

        // Face 2 (two dots) - Right face
        const face2 = new THREE.Group();
        face2.add(createDot(1.01, 0.5, 0.5));
        face2.add(createDot(1.01, -0.5, -0.5));
        dice.add(face2);

        // Face 3 (three dots) - Top face
        const face3 = new THREE.Group();
        face3.add(createDot(0, 1.01, 0));
        face3.add(createDot(0.5, 1.01, 0.5));
        face3.add(createDot(-0.5, 1.01, -0.5));
        dice.add(face3);

        // Face 4 (four dots) - Left face
        const face4 = new THREE.Group();
        face4.add(createDot(-1.01, 0.5, 0.5));
        face4.add(createDot(-1.01, 0.5, -0.5));
        face4.add(createDot(-1.01, -0.5, 0.5));
        face4.add(createDot(-1.01, -0.5, -0.5));
        dice.add(face4);

        // Face 5 (five dots) - Back face
        const face5 = new THREE.Group();
        face5.add(createDot(0, 0, -1.01));
        face5.add(createDot(0.5, 0.5, -1.01));
        face5.add(createDot(-0.5, 0.5, -1.01));
        face5.add(createDot(0.5, -0.5, -1.01));
        face5.add(createDot(-0.5, -0.5, -1.01));
        dice.add(face5);

        // Face 6 (six dots) - Bottom face
        const face6 = new THREE.Group();
        face6.add(createDot(-0.5, -1.01, 0.5));
        face6.add(createDot(0.5, -1.01, 0.5));
        face6.add(createDot(-0.5, -1.01, 0));
        face6.add(createDot(0.5, -1.01, 0));
        face6.add(createDot(-0.5, -1.01, -0.5));
        face6.add(createDot(0.5, -1.01, -0.5));
        dice.add(face6);

        // Tambahkan ini untuk mengatur posisi awal dadu
        dice.rotation.x = Math.PI / 6;
        dice.rotation.y = Math.PI / 4;

        camera.position.z = 5;

        // Add smooth rotation animation
        let targetRotationX = 0;
        let targetRotationY = 0;
        let currentRotationX = 0;
        let currentRotationY = 0;

        function animate() {
            requestAnimationFrame(animate);

            // Smooth rotation
            currentRotationX += (targetRotationX - currentRotationX) * 0.05;
            currentRotationY += (targetRotationY - currentRotationY) * 0.05;

            dice.rotation.x = currentRotationX;
            dice.rotation.y = currentRotationY;

            // Increment target rotation for continuous movement
            targetRotationX += 0.01;
            targetRotationY += 0.01;

            renderer.render(scene, camera);
        }

        animate();

        // Add interactive rotation on mouse move
        document.addEventListener('mousemove', (event) => {
            const mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            const mouseY = (event.clientY / window.innerHeight) * 2 - 1;

            targetRotationX = mouseY * Math.PI;
            targetRotationY = mouseX * Math.PI;
        });

        // Responsive handling
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html> 