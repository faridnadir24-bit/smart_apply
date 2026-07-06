<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SmartApply</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc7/dist/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.8); }
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Source Sans 3', -apple-system, sans-serif;
            background: #f0f4f8;
        }

        /* ===== LEFT PANEL ===== */
        .left-panel {
            width: 55%;
            background: linear-gradient(145deg, #0a2540 0%, #0f3460 35%, #1a5276 65%, #2980b9 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 3rem;
            position: relative; overflow: hidden;
        }
        .left-panel .circle-1 {
            position: absolute; top: -100px; right: -80px;
            width: 350px; height: 350px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .left-panel .circle-2 {
            position: absolute; bottom: -120px; left: -60px;
            width: 400px; height: 400px; border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .left-panel .circle-3 {
            position: absolute; top: 40%; right: 10%;
            width: 150px; height: 150px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .left-panel .dots {
            position: absolute; bottom: 2rem; right: 2rem;
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;
        }
        .left-panel .dots span {
            width: 5px; height: 5px; border-radius: 50%;
            background: rgba(255,255,255,0.15);
        }

        .brand-logo {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 3rem;
            animation: fadeInLeft 0.8s ease both;
            position: relative; z-index: 1;
        }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #2980b9, #5dade2);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: white;
            box-shadow: 0 8px 25px rgba(41,128,185,0.5);
        }
        .brand-text-wrap { line-height: 1.1; }
        .brand-name {
            font-size: 1.8rem; font-weight: 900;
            color: white; letter-spacing: -1px;
        }
        .brand-tagline {
            font-size: 0.75rem; color: rgba(255,255,255,0.55);
            font-weight: 500; letter-spacing: 1px; text-transform: uppercase;
        }

        .left-illustration {
            position: relative; z-index: 1; text-align: center;
            animation: fadeInLeft 0.8s ease 0.2s both;
        }
        .illus-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px; padding: 2rem;
            margin-bottom: 1.5rem;
            animation: float 4s ease-in-out infinite;
        }
        .illus-icon-big {
            font-size: 5rem; margin-bottom: 1rem;
            filter: drop-shadow(0 8px 20px rgba(41,128,185,0.4));
        }
        .illus-title {
            font-size: 1.4rem; font-weight: 800;
            color: white; margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }
        .illus-desc {
            font-size: 0.85rem; color: rgba(255,255,255,0.6);
            line-height: 1.6;
        }

        .feature-list {
            display: flex; flex-direction: column; gap: 0.75rem;
            position: relative; z-index: 1;
            animation: fadeInLeft 0.8s ease 0.4s both;
            width: 100%;
        }
        .feature-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            transition: background 0.2s;
        }
        .feature-item:hover { background: rgba(255,255,255,0.1); }
        .feature-dot {
            width: 8px; height: 8px; border-radius: 50%;
            flex-shrink: 0;
            animation: pulse-dot 2s ease infinite;
        }
        .feature-item p { color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 500; margin: 0; }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            width: 45%;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 3rem;
            background: white;
        }
        .login-box {
            width: 100%; max-width: 400px;
            animation: fadeInUp 0.7s ease 0.1s both;
        }
        .login-header { margin-bottom: 2rem; }
        .login-title {
            font-size: 1.8rem; font-weight: 900;
            color: #0a2540; letter-spacing: -0.5px;
            margin-bottom: 0.3rem;
        }
        .login-sub { color: #8fa3b1; font-size: 0.9rem; }

        .form-group { margin-bottom: 1.2rem; }
        .form-label-custom {
            font-size: 0.78rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #4a5568; margin-bottom: 0.5rem;
            display: block;
        }
        .form-input {
            width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 0.9rem; color: #2d3748;
            background: #fafbff;
            transition: all 0.25s ease;
            outline: none;
        }
        .form-input:focus {
            border-color: #2980b9;
            box-shadow: 0 0 0 4px rgba(41,128,185,0.1);
            background: white;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 0.9rem; top: 50%;
            transform: translateY(-50%);
            color: #8fa3b1; font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .input-wrap:focus-within .input-icon { color: #2980b9; }

        .form-check-row {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 1.5rem;
        }
        .form-check-label {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.85rem; color: #4a5568; cursor: pointer;
        }
        .form-check-label input[type="checkbox"] {
            width: 16px; height: 16px; cursor: pointer;
            accent-color: #2980b9;
        }
        .forgot-link {
            font-size: 0.82rem; color: #2980b9;
            text-decoration: none; font-weight: 600;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #1a5276; }

        .btn-login {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, #1a5276, #2980b9);
            color: white; border: none; border-radius: 12px;
            font-size: 0.95rem; font-weight: 700;
            cursor: pointer; letter-spacing: 0.3px;
            box-shadow: 0 5px 20px rgba(41,128,185,0.35);
            transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            box-shadow: 0 8px 30px rgba(41,128,185,0.45);
            transform: translateY(-2px);
        }
        .btn-login:active { transform: translateY(0); }

        .divider {
            text-align: center; margin: 1.5rem 0;
            position: relative; color: #cbd5e0; font-size: 0.82rem;
        }
        .divider::before, .divider::after {
            content: ''; position: absolute;
            top: 50%; width: 42%; height: 1px;
            background: #e2e8f0;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .register-link {
            text-align: center; font-size: 0.88rem; color: #8fa3b1;
        }
        .register-link a {
            color: #2980b9; font-weight: 700; text-decoration: none;
            transition: color 0.2s;
        }
        .register-link a:hover { color: #1a5276; }

        .alert-error {
            background: #fff5f5; border: 1px solid #fed7d7;
            border-radius: 12px; padding: 0.85rem 1rem;
            color: #c53030; font-size: 0.85rem;
            display: flex; align-items: center; gap: 0.5rem;
            margin-bottom: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
        <div class="dots">
            @for($i = 0; $i < 15; $i++)
                <span></span>
            @endfor
        </div>

        {{-- Brand --}}
        <div class="brand-logo">
            <div class="brand-icon"><i class="bi bi-send-fill"></i></div>
            <div class="brand-text-wrap">
                <div class="brand-name">SmartApply</div>
                <div class="brand-tagline">AI Job Assistant</div>
            </div>
        </div>

        {{-- Illustration --}}
        <div class="left-illustration">
            <div class="illus-card">
                <div class="illus-icon-big">🤖</div>
                <div class="illus-title">Generate Surat Lamaran</div>
                <div class="illus-desc">Buat surat lamaran profesional secara otomatis<br>dengan teknologi AI dalam hitungan detik</div>
            </div>

            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-dot" style="background:#2ecc71;"></div>
                    <p><i class="bi bi-person-lines-fill me-2" style="color:#5dade2;"></i>Biodata & CV pelamar terintegrasi</p>
                </div>
                <div class="feature-item">
                    <div class="feature-dot" style="background:#f39c12; animation-delay:0.5s;"></div>
                    <p><i class="bi bi-briefcase-fill me-2" style="color:#5dade2;"></i>Dashboard lowongan kerja terkini</p>
                </div>
                <div class="feature-item">
                    <div class="feature-dot" style="background:#9b59b6; animation-delay:1s;"></div>
                    <p><i class="bi bi-stars me-2" style="color:#5dade2;"></i>Generator surat lamaran berbasis AI</p>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="login-box">

            {{-- Header --}}
            <div class="login-header">
                <h1 class="login-title">Selamat Datang! 👋</h1>
                <p class="login-sub">Masuk ke akun SmartApply kamu</p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Session Status --}}
            @if (session('status'))
                <div style="background:#f0fff4; border:1px solid #c6f6d5; border-radius:12px; padding:0.85rem 1rem; color:#276749; font-size:0.85rem; margin-bottom:1.2rem;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label-custom">Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" name="email" class="form-input"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label-custom">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password" class="form-input"
                            placeholder="••••••••" required>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="form-check-row">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk ke SmartApply
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="register-link">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

            {{-- Demo Accounts --}}
            <div style="margin-top:2rem; padding:1rem; background:#f8fbff; border-radius:12px; border:1px solid #e2e8f0;">
                <p style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#8fa3b1; margin-bottom:0.75rem;">
                    <i class="bi bi-info-circle me-1"></i>Akun Demo
                </p>
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0.75rem; background:white; border-radius:8px; border:1px solid #e8f4fb;">
                        <div>
                            <p style="font-size:0.78rem; font-weight:700; color:#1a5276; margin:0;">Admin</p>
                            <p style="font-size:0.73rem; color:#8fa3b1; margin:0;">admin@smartapply.com</p>
                        </div>
                        <span style="font-size:0.7rem; background:#ebf4ff; color:#1a5276; padding:0.2rem 0.6rem; border-radius:50px; font-weight:700;">Admin</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0.75rem; background:white; border-radius:8px; border:1px solid #e8f8f5;">
                        <div>
                            <p style="font-size:0.78rem; font-weight:700; color:#0e6655; margin:0;">Pelamar</p>
                            <p style="font-size:0.73rem; color:#8fa3b1; margin:0;">pelamar@smartapply.com</p>
                        </div>
                        <span style="font-size:0.7rem; background:#e8f8f5; color:#0e6655; padding:0.2rem 0.6rem; border-radius:50px; font-weight:700;">User</span>
                    </div>
                    <p style="font-size:0.72rem; color:#8fa3b1; text-align:center; margin:0.25rem 0 0;">Password: <strong style="color:#4a5568;">password</strong></p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>