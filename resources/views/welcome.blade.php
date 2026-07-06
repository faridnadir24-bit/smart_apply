<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartApply — AI Job Assistant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-15px); }
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, sans-serif;
            background: linear-gradient(135deg, #0a2540 0%, #0f3460 40%, #1a5276 70%, #2980b9 100%);
            min-height: 100vh; color: white;
        }

        /* Navbar */
        .navbar {
            display: flex; justify-content: space-between;
            align-items: center; padding: 1.5rem 4rem;
            position: relative; z-index: 10;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
        }
        .nav-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #2980b9, #5dade2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: white;
            box-shadow: 0 5px 15px rgba(41,128,185,0.5);
        }
        .nav-name { font-size: 1.3rem; font-weight: 900; color: white; letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 1rem; align-items: center; }
        .btn-nav-login {
            padding: 0.5rem 1.2rem;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 8px; color: white;
            text-decoration: none; font-size: 0.88rem;
            font-weight: 600; transition: all 0.2s;
            background: rgba(255,255,255,0.08);
        }
        .btn-nav-login:hover { background: rgba(255,255,255,0.15); color: white; }
        .btn-nav-register {
            padding: 0.5rem 1.2rem;
            background: white; border-radius: 8px;
            color: #1a5276; text-decoration: none;
            font-size: 0.88rem; font-weight: 700;
            transition: all 0.2s;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }
        .btn-nav-register:hover { background: #ebf4ff; color: #1a5276; transform: translateY(-1px); }

        /* Hero */
        .hero {
            text-align: center; padding: 5rem 2rem 4rem;
            position: relative;
            animation: fadeInUp 0.8s ease both;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px; padding: 0.4rem 1.2rem;
            font-size: 0.8rem; font-weight: 600;
            margin-bottom: 1.5rem; letter-spacing: 0.5px;
        }
        .hero-title {
            font-size: 3.5rem; font-weight: 900;
            line-height: 1.1; letter-spacing: -2px;
            margin-bottom: 1.2rem;
        }
        .hero-title span {
            background: linear-gradient(90deg, #5dade2, #aed6f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-sub {
            font-size: 1.1rem; color: rgba(255,255,255,0.7);
            max-width: 550px; margin: 0 auto 2.5rem;
            line-height: 1.7;
        }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 0.85rem 2rem;
            background: white; color: #1a5276;
            border-radius: 12px; text-decoration: none;
            font-weight: 800; font-size: 0.95rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(0,0,0,0.25); color: #1a5276; }
        .btn-hero-secondary {
            padding: 0.85rem 2rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.25);
            color: white; border-radius: 12px;
            text-decoration: none; font-weight: 700;
            font-size: 0.95rem; transition: all 0.3s ease;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.18); color: white; transform: translateY(-3px); }

        /* Features */
        .features {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem; max-width: 900px;
            margin: 4rem auto 0; padding: 0 2rem;
            animation: fadeInUp 0.8s ease 0.3s both;
        }
        .feature-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 1.8rem;
            text-align: center; transition: all 0.3s ease;
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.12);
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .feature-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
        .feature-desc { font-size: 0.83rem; color: rgba(255,255,255,0.6); line-height: 1.6; }

        /* Float emoji */
        .float-emoji {
            font-size: 5rem; margin-bottom: 1rem;
            display: block;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 25px rgba(41,128,185,0.3));
        }

        /* Footer */
        .footer {
            text-align: center; padding: 3rem 2rem;
            color: rgba(255,255,255,0.4); font-size: 0.82rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .navbar { padding: 1.2rem 1.5rem; }
            .hero-title { font-size: 2.2rem; }
            .features { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar">
        <a href="/" class="nav-brand">
            <div class="nav-icon"><i class="bi bi-send-fill"></i></div>
            <span class="nav-name">SmartApply</span>
        </a>
        <div class="nav-links">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav-register">Daftar Gratis</a>
            @endif
        </div>
    </nav>

    {{-- Hero --}}
    <div class="hero">
        <span class="float-emoji">🤖</span>
        <div class="hero-badge">
            <span style="width:7px; height:7px; border-radius:50%; background:#2ecc71; display:inline-block;"></span>
            Didukung GROQ AI — Gratis!
        </div>
        <h1 class="hero-title">
            Buat Surat Lamaran<br>
            <span>Lebih Cerdas</span> dengan AI
        </h1>
        <p class="hero-sub">
            SmartApply membantu pelamar kerja membuat surat lamaran profesional secara otomatis, disesuaikan dengan posisi dan keahlian mereka.
        </p>
        <div class="hero-btns">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="bi bi-rocket-takeoff-fill"></i>
                Mulai Sekarang — Gratis
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="bi bi-box-arrow-in-right"></i>
                Sudah punya akun? Masuk
            </a>
        </div>
    </div>

    {{-- Features --}}
    <div class="features">
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(41,128,185,0.2); color:#5dade2;">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <p class="feature-title">Profil Pelamar</p>
            <p class="feature-desc">Isi biodata, skills, pengalaman kerja, dan upload CV sekali untuk digunakan berulang kali.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(46,204,113,0.2); color:#58d68d;">
                <i class="bi bi-briefcase-fill"></i>
            </div>
            <p class="feature-title">Lowongan Kerja</p>
            <p class="feature-desc">Browse berbagai lowongan kerja dan lamar langsung dari platform SmartApply.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(155,89,182,0.2); color:#c39bd3;">
                <i class="bi bi-stars"></i>
            </div>
            <p class="feature-title">Generator AI</p>
            <p class="feature-desc">Generate surat lamaran otomatis yang dipersonalisasi dengan teknologi GROQ AI.</p>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Copyright &copy; {{ date('Y') }} SmartApply. All rights reserved.</p>
        <p style="margin-top:0.3rem;">Dibuat dengan ❤️ menggunakan Laravel 11 + GROQ AI</p>
    </div>

</body>
</html>