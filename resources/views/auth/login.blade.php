<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Hill Holding</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Vite CSS --}}
    @vite([
        'resources/css/app.css',
        'resources/css/style.css'
    ])
</head>
<body class="bg-kc-dark d-flex align-items-center justify-content-center vh-100">

    {{-- Canvas pour animation particles --}}
    <canvas id="particle-canvas" class="position-absolute top-0 start-0 w-100 h-100"></canvas>

    <div class="login-card text-center shadow-lg position-relative">
        <h3 class="fw-bold mb-2">Hill Holding</h3>
        <p class="text-kc-light mb-4">Connexion à votre compte</p>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3 position-relative text-start">
                <label for="email" class="form-label text-kc-light">Email</label>
                <i class="bi bi-envelope-fill input-icon"></i>
                <input type="email" name="email" id="email" class="form-control input-glow" placeholder="email@exemple.com" required autofocus>
            </div>

            <div class="mb-3 position-relative text-start">
                <label for="password" class="form-label text-kc-light">Mot de passe</label>
                <i class="bi bi-lock-fill input-icon"></i>
                <input type="password" name="password" id="password" class="form-control input-glow" placeholder="••••••••" required>
            </div>

            <div class="mb-3 form-check text-start">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label text-kc-light" for="remember">Se souvenir de moi</label>
            </div>

            <button type="submit" class="btn btn-gold w-100 fw-bold shadow-sm">Se connecter</button>
        </form>
    </div>

    {{-- Script animation particles --}}
    <script>
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        let particlesArray;

        // Resize canvas
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Particle class
        class Particle {
            constructor(){
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 1;
                this.speedX = (Math.random() - 0.5) * 0.5;
                this.speedY = (Math.random() - 0.5) * 0.5;
                this.color = 'rgba(255, 215, 0, 0.7)'; // doré
            }
            update(){
                this.x += this.speedX;
                this.y += this.speedY;
                if(this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                if(this.y < 0 || this.y > canvas.height) this.speedY *= -1;
            }
            draw(){
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI*2);
                ctx.fill();
            }
        }

        // Initialize particles
        function init(){
            particlesArray = [];
            for(let i=0; i<80; i++){
                particlesArray.push(new Particle());
            }
        }

        function animate(){
            ctx.clearRect(0,0,canvas.width,canvas.height);
            particlesArray.forEach(p => { p.update(); p.draw(); });
            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>

</body>
</html>
