<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — SmartApply</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc7/dist/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
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
            min-height: 100vh; display: flex;
            font-family: 'Source Sans 3', -apple-system, sans-serif;
            background: #f0f4f8;
        }

        /* LEFT PANEL */
        .left-panel {
            width: 45%;
            background: linear-gradient(145deg, #0a2540 0%, #0f3460 35%, #1a5276 65%, #2980b9 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 3rem; position: relative; overflow: hidden;
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
            margin-bottom: 3rem; position: relative; z-index: 1;
            animation: fadeInUp 0.8s ease both;
        }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #2980b9, #5dade2);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: white;
            box-shadow: 0 8px 25px rgba(41,128,185,0.5);
        }
        .brand-name { font-size: 1.8rem; font-weight: 900; color: white; letter-spacing: -1px; }
        .brand-tagline { font-size: 0.75rem; color: rgba(255,255,255,0.55); font-weight: 500; letter-spacing: 1px; text-transform: uppercase; }

        .illus-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px; padding: 2rem;
            text-align: center; margin-bottom: 1.5rem;
            position: relative; z-index: 1;
            animation: fadeInUp 0.8s ease 0.2s both;
            animation: float 4s ease-in-out infinite;
        }
        .illus-icon-big { font-size: 4.5rem; margin-bottom: 1rem; display: block; }
        .illus-title { font-size: 1.3rem; font-weight: 800; color: white; margin-bottom: 0.5rem; }
        .illus-desc { font-size: 0.83rem; color: rgba(255,255,255,0.6); line-height: 1.6; }

        .steps-list {
            display: flex; flex-direction: column; gap: 0.75rem;
            position: relative; z-index: 1; width: 100%;
            animation: fadeInUp 0.8s ease 0.4s both;
        }
        .step-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px; transition: background 0.2s;
        }
        .step-item:hover { background: rgba(255,255,255,0.1); }
        .step-num {
            width: 26px; height: 26px; border-radius: 50%;
            background: linear-gradient(135deg, #2980b9, #5dade2);
            color: white; font-weight: 800; font-size: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .step-item p { color: rgba(255,255,255,0.8); font-size: 0.83rem; font-weight: 500; margin: 0; }

        /* RIGHT PANEL */
        .right-panel {
            width: 55%; display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 3rem; background: white; overflow-y: auto;
        }
        .register-box {
            width: 100%; max-width: 440px;
            animation: fadeInUp 0.7s ease 0.1s both;
        }
        .register-header { margin-bottom: 1.8rem; }
        .register-title { font-size: 1.8rem; font-weight: 900; color: #0a2540; letter-spacing: -0.5px; margin-bottom: 0.3rem; }
        .register-sub { color: #8fa3b1; font-size: 0.88rem; }

        .form-group { margin-bottom: 1rem; }
        .form-label-custom {
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #4a5568; margin-bottom: 0.4rem; display: block;
        }
        .form-input {
            width: 100%; padding: 0.8rem 1rem 0.8rem 2.7rem;
            border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 0.88rem; color: #2d3748;
            background: #fafbff; transition: all 0.25s ease; outline: none;
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
            color: #8fa3b1; font-size: 0.95rem; pointer-events: none;
            transition: color 0.2s;
        }
        .input-wrap:focus-within .input-icon { color: #2980b9; }

        .btn-register {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, #1a5276, #2980b9);
            color: white; border: none; border-radius: 12px;
            font-size: 0.95rem; font-weight: 700; cursor: pointer;
            box-shadow: 0 5px 20px rgba(41,128,185,0.35);
            transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            margin-top: 1.2rem;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            box-shadow: 0 8px 30px rgba(41,128,185,0.45);
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center; font-size: 0.88rem;
            color: #8fa3b1; margin-top: 1.2rem;
        }
        .login-link a {
            color: #2980b9; font-weight: 700;
            text-decoration: none; transition: color 0.2s;
        }
        .login-link a:hover { color: #1a5276; }

        .alert-error {
            background: #fff5f5; border: 1px solid #fed7d7;
            border-radius: 12px; padding: 0.85rem 1rem;
            color: #c53030; font-size: 0.83rem;
            display: flex; align-items: flex-start; gap: 0.5rem;
            margin-bottom: 1.2rem;
        }

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
        <div class="dots">
            @for($i = 0; $i < 15; $i++)<span></span>@endfor
        </div>

        <div class="brand-logo">
            <div class="brand-icon"><i class="bi bi-send-fill"></i></div>
            <div>
                <div class="brand-name">SmartApply</div>
                <div class="brand-tagline">AI Job Assistant</div>
            </div>
        </div>

        <div class="illus-card">
            <span class="illus-icon-big">🚀</span>
            <div class="illus-title">Mulai Karir Impianmu</div>
            <div class="illus-desc">Daftar sekarang dan buat surat lamaran profesional dengan bantuan AI dalam hitungan detik</div>
        </div>

        <div class="steps-list">
            <div class="step-item">
                <div class="step-num">1</div>
                <p>Daftar & lengkapi biodata kamu</p>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <p>Upload CV format PDF (maks. 2MB)</p>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <p>Browse & lamar lowongan kerja</p>
            </div>
            <div class="step-item">
                <div class="step-num">4</div>
                <p>Generate surat lamaran otomatis dengan AI</p>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="register-box">

            <div class="register-header">
                <h1 class="register-title">Buat Akun Baru ✨</h1>
                <p class="register-sub">Bergabung dengan SmartApply dan mulai perjalanan karirmu</p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill mt-1"></i>
                    <ul style="margin:0; padding-left:0.5rem; list-style:none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label-custom">Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="name" class="form-input"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label-custom">Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" name="email" class="form-input"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label-custom">Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password" class="form-input"
                            placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label-custom">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-shield-lock-fill input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-input"
                            placeholder="Ulangi password kamu" required>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                    Daftar Sekarang
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

            {{-- Info --}}
            <div style="margin-top:1.5rem; padding:1rem; background:#f8fbff; border-radius:12px; border:1px solid #e2e8f0; text-align:center;">
                <p style="font-size:0.75rem; color:#8fa3b1; margin:0;">
                    <i class="bi bi-shield-check-fill me-1" style="color:#2980b9;"></i>
                    Data kamu aman & terlindungi. Gratis selamanya!
                </p>
            </div>

        </div>
    </div>

</body>
</html>