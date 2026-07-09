@extends('layouts.adminlte4.main')

@section('header', 'Dashboard saya')

@push('css')
<style>
    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(66,153,225,0.4); }
        70%  { transform: scale(1);    box-shadow: 0 0 0 10px rgba(66,153,225,0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(66,153,225,0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes countUp {
        from { opacity: 0; transform: scale(0.5); }
        to   { opacity: 1; transform: scale(1); }
    }

    /* ===== GREETING ===== */
    .greeting-banner {
        background: linear-gradient(135deg, #0f2d52 0%, #1a4a7a 40%, #2b6cb0 75%, #4299e1 100%);
        border-radius: 24px;
        padding: 2.2rem 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        animation: fadeInDown 0.7s ease both;
        box-shadow: 0 10px 40px rgba(43,108,176,0.3);
    }
    .greeting-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -40px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .greeting-banner::after {
        content: '';
        position: absolute;
        bottom: -80px; right: 15%;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .greeting-banner .decoration {
        position: absolute;
        top: 20px; right: 2rem;
        font-size: 5rem;
        opacity: 0.08;
        z-index: 0;
    }
    .greeting-name {
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        position: relative;
        z-index: 1;
    }
    .greeting-sub {
        font-size: 0.95rem;
        opacity: 0.8;
        position: relative;
        z-index: 1;
    }
    .greeting-badge {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        position: relative;
        z-index: 1;
    }

    /* ===== STAT CARDS ===== */
    .stat-card {
        background: white;
        border-radius: 20px !important;
        border: none !important;
        padding: 1.5rem !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        text-decoration: none !important;
        display: block;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 20px 20px 0 0;
        transition: height 0.3s ease;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg, #2b6cb0, #4299e1); }
    .stat-card.teal::before   { background: linear-gradient(90deg, #234e52, #38b2ac); }
    .stat-card.green::before  { background: linear-gradient(90deg, #276749, #48bb78); }
    .stat-card.orange::before { background: linear-gradient(90deg, #c05621, #ed8936); }
    .stat-card.red::before    { background: linear-gradient(90deg, #9b2c2c, #fc8181); }
    .stat-card:hover::before  { height: 5px; }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(59,130,246,0.15) !important;
    }
    .stat-card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .stat-card:hover .stat-card-icon { transform: rotate(-8deg) scale(1.15); }
    .stat-card-icon.blue   { background: #ebf4ff; color: #2b6cb0; }
    .stat-card-icon.teal   { background: #e6fffa; color: #234e52; }
    .stat-card-icon.green  { background: #f0fff4; color: #276749; }
    .stat-card-icon.orange { background: #fffaf0; color: #c05621; }
    .stat-card-icon.red    { background: #fff5f5; color: #9b2c2c; }
    .stat-num {
        font-size: 2rem; font-weight: 800;
        color: #1a365d; line-height: 1.1;
        animation: countUp 0.5s ease both;
    }
    .stat-title { font-weight: 700; color: #2d3748; font-size: 0.9rem; }
    .stat-desc  { color: #a0aec0; font-size: 0.78rem; }
    .mini-bar {
        height: 5px; border-radius: 10px;
        background: #edf2f7; margin: 0.6rem 0;
    }
    .mini-bar-fill {
        height: 100%; border-radius: 10px;
        transition: width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .stat-action {
        font-size: 0.8rem; font-weight: 700;
        display: inline-flex; align-items: center;
        gap: 0.3rem; transition: gap 0.2s;
        text-decoration: none;
    }
    .stat-action:hover { gap: 0.7rem; }

    /* ===== QUICK ACTIONS ===== */
    .section-label {
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
        color: #718096; margin-bottom: 0.75rem;
    }
    .qa-card {
        background: white;
        border-radius: 16px !important;
        border: none !important;
        padding: 1rem 1.25rem;
        box-shadow: 0 3px 15px rgba(59,130,246,0.06) !important;
        display: flex; align-items: center;
        gap: 1rem; text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        color: #2d3748;
    }
    .qa-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 30px rgba(59,130,246,0.12) !important;
        color: #1a365d;
    }
    .qa-icon {
        width: 46px; height: 46px;
        border-radius: 13px;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .qa-card:hover .qa-icon { transform: rotate(-8deg) scale(1.1); }

    /* ===== WELCOME CARD ===== */
    .info-card {
        background: white;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        overflow: hidden;
        animation: fadeInUp 0.6s ease 0.4s both;
    }
    .info-card-header {
        background: linear-gradient(135deg, #1a4a7a, #2b6cb0, #4299e1);
        padding: 1.1rem 1.5rem;
        color: white;
    }
    .step-row {
        display: flex; align-items: flex-start;
        gap: 1rem; padding: 0.9rem 1.5rem;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.25s ease;
    }
    .step-row:last-child { border-bottom: none; }
    .step-row:hover {
        background: linear-gradient(135deg, #f0f7ff, #e8f4fd);
        padding-left: 2rem;
    }
    .step-dot {
        width: 34px; height: 34px; flex-shrink: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, #2b6cb0, #4299e1);
        color: white; font-weight: 800;
        font-size: 0.85rem;
        display: flex; align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(43,108,176,0.3);
        transition: transform 0.3s ease;
    }
    .step-row:hover .step-dot { transform: scale(1.15); }

    /* ===== CHECKLIST ===== */
    .check-row {
        display: flex; justify-content: space-between;
        align-items: center; padding: 0.9rem 1.5rem;
        border-bottom: 1px solid #f7fafc;
        transition: all 0.25s ease;
    }
    .check-row:last-child { border-bottom: none; }
    .check-row:hover {
        background: linear-gradient(135deg, #f0f7ff, #e8f4fd);
        padding-left: 2rem;
    }
    .check-row .label {
        display: flex; align-items: center;
        gap: 0.6rem; font-size: 0.9rem;
        font-weight: 500; color: #4a5568;
    }
    .status-pill {
        border-radius: 50px !important;
        padding: 0.3rem 0.9rem !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
    }
    .progress-wrap {
        height: 8px; border-radius: 10px;
        background: #edf2f7; overflow: hidden;
    }
    .progress-fill {
        height: 100%; border-radius: 10px;
        background: linear-gradient(90deg, #2b6cb0, #4299e1);
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Animasi berurutan */
    .anim-1 { animation: fadeInUp 0.5s ease 0.1s both; }
    .anim-2 { animation: fadeInUp 0.5s ease 0.2s both; }
    .anim-3 { animation: fadeInUp 0.5s ease 0.3s both; }
    .anim-4 { animation: fadeInUp 0.5s ease 0.4s both; }
    .anim-5 { animation: fadeInUp 0.5s ease 0.5s both; }
    .anim-6 { animation: fadeInUp 0.5s ease 0.6s both; }
</style>
@endpush

@section('content')

@php
    $filled = collect([$profile?->phone, $profile?->skills, $profile?->experience, $profile?->cv_path])->filter()->count();
    $percent = ($filled / 4) * 100;
    $lamaranCount = App\Models\Application::where('user_id', Auth::id())->count();
@endphp

{{-- Greeting Banner --}}
<div class="greeting-banner mb-4">
    <div class="decoration"><i class="bi bi-briefcase-fill"></i></div>
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <p class="greeting-name mb-1">Halo, {{ Auth::user()->name }}! 👋</p>
            <p class="greeting-sub mb-3">Siap buat lamaran kerja yang lebih baik hari ini?</p>
            <div class="d-flex gap-2 flex-wrap">
                <span class="greeting-badge">
                    <i class="bi bi-circle-fill" style="font-size: 0.5rem; color: #68d391;"></i>
                    Active
                </span>
                <span class="greeting-badge">
                    <i class="bi bi-shield-check-fill"></i>
                    Pelamar
                </span>
                @if($percent == 100)
                <span class="greeting-badge">
                    <i class="bi bi-star-fill" style="color: #f6e05e;"></i>
                    Profil Lengkap
                </span>
                @endif
            </div>
        </div>
        <div class="text-end d-none d-md-block" style="z-index:1; position:relative;">
            <p class="mb-1 opacity-75 small">Kelengkapan Profil</p>
            <p class="fw-bold mb-1" style="font-size: 2rem;">{{ $percent }}%</p>
            <div style="width: 120px; height: 6px; background: rgba(255,255,255,0.2); border-radius: 10px;">
                <div style="width: {{ $percent }}%; height: 100%; background: white; border-radius: 10px; transition: width 1.5s ease;"></div>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-sm-6 anim-1">
        <a href="{{ route('applicant.biodata') }}" class="stat-card blue">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-card-icon blue"><i class="bi bi-person-fill"></i></div>
                <span class="badge rounded-pill" style="background:#ebf4ff; color:#2b6cb0; font-size:0.7rem;">Profil</span>
            </div>
            <p class="stat-title mb-0">Biodata</p>
            <p class="stat-desc mb-2">Kelengkapan profil kamu</p>
            <p class="stat-num">{{ $percent }}%</p>
            <div class="mini-bar">
                <div class="mini-bar-fill" style="width:{{ $percent }}%; background: linear-gradient(90deg,#2b6cb0,#4299e1);"></div>
            </div>
            <span class="stat-action" style="color:#2b6cb0;">Lihat Profil <i class="bi bi-arrow-right"></i></span>
        </a>
    </div>

    <div class="col-lg-3 col-sm-6 anim-2">
        <a href="{{ route('applications.index') }}" class="stat-card teal">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-card-icon teal"><i class="bi bi-file-earmark-text-fill"></i></div>
                <span class="badge rounded-pill" style="background:#e6fffa; color:#234e52; font-size:0.7rem;">Lamaran</span>
            </div>
            <p class="stat-title mb-0">Lamaran Aktif</p>
            <p class="stat-desc mb-2">Total lamaran dikirim</p>
            <p class="stat-num">{{ $lamaranCount }}</p>
            <div class="mini-bar">
                <div class="mini-bar-fill" style="width:{{ min($lamaranCount*20,100) }}%; background: linear-gradient(90deg,#234e52,#38b2ac);"></div>
            </div>
            <span class="stat-action" style="color:#234e52;">Lihat Semua <i class="bi bi-arrow-right"></i></span>
        </a>
    </div>

    <div class="col-lg-3 col-sm-6 anim-3">
        <a href="{{ route('applicant.biodata') }}" class="stat-card {{ $profile?->skills ? 'green' : 'orange' }}">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-card-icon {{ $profile?->skills ? 'green' : 'orange' }}"><i class="bi bi-tools"></i></div>
                <span class="badge rounded-pill" style="background:{{ $profile?->skills ? '#f0fff4; color:#276749' : '#fffaf0; color:#c05621' }}; font-size:0.7rem;">
                    {{ $profile?->skills ? 'Lengkap' : 'Perlu Diisi' }}
                </span>
            </div>
            <p class="stat-title mb-0">Skills</p>
            <p class="stat-desc mb-2">Keahlian yang kamu miliki</p>
            <p class="stat-num" style="font-size:1.4rem; color: {{ $profile?->skills ? '#276749' : '#c05621' }}">
                {{ $profile?->skills ? '✓ Terisi' : '— Kosong' }}
            </p>
            <div class="mini-bar">
                <div class="mini-bar-fill" style="width:{{ $profile?->skills ? '100' : '0' }}%; background: linear-gradient(90deg,#276749,#48bb78);"></div>
            </div>
            <span class="stat-action" style="color:{{ $profile?->skills ? '#276749' : '#c05621' }};">
                {{ $profile?->skills ? 'Edit Skills' : 'Tambah Skills' }} <i class="bi bi-arrow-right"></i>
            </span>
        </a>
    </div>

    <div class="col-lg-3 col-sm-6 anim-4">
        <a href="{{ route('applicant.biodata') }}" class="stat-card {{ $profile?->cv_path ? 'green' : 'red' }}">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="stat-card-icon {{ $profile?->cv_path ? 'green' : 'red' }}"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <span class="badge rounded-pill" style="background:{{ $profile?->cv_path ? '#f0fff4; color:#276749' : '#fff5f5; color:#9b2c2c' }}; font-size:0.7rem;">
                    {{ $profile?->cv_path ? 'Uploaded' : 'Belum Ada' }}
                </span>
            </div>
            <p class="stat-title mb-0">CV / Resume</p>
            <p class="stat-desc mb-2">File CV kamu</p>
            <p class="stat-num" style="font-size:1.4rem; color: {{ $profile?->cv_path ? '#276749' : '#9b2c2c' }}">
                {{ $profile?->cv_path ? '✓ Upload' : '✗ Belum' }}
            </p>
            <div class="mini-bar">
                <div class="mini-bar-fill" style="width:{{ $profile?->cv_path ? '100' : '0' }}%; background: {{ $profile?->cv_path ? 'linear-gradient(90deg,#276749,#48bb78)' : 'linear-gradient(90deg,#9b2c2c,#fc8181)' }};"></div>
            </div>
            <span class="stat-action" style="color:{{ $profile?->cv_path ? '#276749' : '#9b2c2c' }};">
                {{ $profile?->cv_path ? 'Lihat CV' : 'Upload Sekarang' }} <i class="bi bi-arrow-right"></i>
            </span>
        </a>
    </div>
</div>

{{-- Quick Actions --}}
<p class="section-label"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Aksi Cepat</p>
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-sm-6 anim-1">
        <a href="{{ route('applicant.biodata') }}" class="qa-card">
            <div class="qa-icon" style="background:#ebf4ff; color:#2b6cb0;">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div>
                <p class="fw-bold mb-0 small">Lengkapi Biodata</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Isi data diri kamu</p>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted small"></i>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6 anim-2">
        <a href="{{ route('jobs.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#e6fffa; color:#234e52;">
                <i class="bi bi-briefcase-fill"></i>
            </div>
            <div>
                <p class="fw-bold mb-0 small">Cari Lowongan</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Browse lowongan kerja</p>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted small"></i>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6 anim-3">
        <a href="{{ route('cover-letters.create') }}" class="qa-card">
            <div class="qa-icon" style="background:#faf5ff; color:#553c9a;">
                <i class="bi bi-stars"></i>
            </div>
            <div>
                <p class="fw-bold mb-0 small">Generate Surat AI</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Buat surat otomatis</p>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted small"></i>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6 anim-4">
        <a href="{{ route('applications.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#fff5f5; color:#9b2c2c;">
                <i class="bi bi-file-earmark-check-fill"></i>
            </div>
            <div>
                <p class="fw-bold mb-0 small">Lamaran Saya</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Cek status lamaran</p>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted small"></i>
        </a>
    </div>
</div>

{{-- Welcome & Checklist --}}
<div class="row g-3">
    <div class="col-lg-7 anim-5">
        <div class="info-card h-100">
            <div class="info-card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-house-fill me-2"></i>Selamat Datang di SmartApply!
                </h5>
            </div>
            <div class="p-4 pb-0">
                <p class="text-muted small">
                    SmartApply membantu kamu membuat surat lamaran kerja otomatis dan review kesesuaian skill berbasis AI.
                </p>
            </div>
            <div class="step-row">
                <div class="step-dot">1</div>
                <div>
                    <p class="fw-semibold mb-0 small">Lengkapi Biodata</p>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Isi nomor HP, skills, dan pengalaman kerja</p>
                </div>
            </div>
            <div class="step-row">
                <div class="step-dot">2</div>
                <div>
                    <p class="fw-semibold mb-0 small">Upload CV (PDF, maks. 2MB)</p>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Format PDF agar bisa dianalisis AI</p>
                </div>
            </div>
            <div class="step-row">
                <div class="step-dot">3</div>
                <div>
                    <p class="fw-semibold mb-0 small">Pilih Lowongan & Lamar</p>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Browse lowongan dan kirim lamaran kamu</p>
                </div>
            </div>
            <div class="step-row">
                <div class="step-dot">4</div>
                <div>
                    <p class="fw-semibold mb-0 small">Generate Surat Lamaran AI</p>
                    <p class="text-muted mb-0" style="font-size:0.78rem;">Buat surat lamaran otomatis dengan GROQ AI</p>
                </div>
            </div>
            <div class="p-4 d-flex gap-2 flex-wrap">
                <a href="{{ route('applicant.biodata') }}" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-person-lines-fill me-1"></i>Lengkapi Biodata
                </a>
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm px-3">
                    <i class="bi bi-briefcase me-1"></i>Lihat Lowongan
                </a>
                <a href="{{ route('cover-letters.create') }}" class="btn btn-outline-secondary btn-sm px-3">
                    <i class="bi bi-stars me-1"></i>Generate Surat
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-5 anim-6">
        <div class="info-card h-100">
            <div class="info-card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clipboard-check-fill me-2"></i>Kelengkapan Profil
                </h5>
            </div>

            <div class="check-row">
                <div class="label"><i class="bi bi-envelope-fill" style="color:#2b6cb0;"></i>Email</div>
                <span class="badge status-pill bg-success">✓ Lengkap</span>
            </div>
            <div class="check-row">
                <div class="label"><i class="bi bi-telephone-fill" style="color:#2b6cb0;"></i>Nomor HP</div>
                @if($profile?->phone)
                    <span class="badge status-pill bg-success">✓ Lengkap</span>
                @else
                    <span class="badge status-pill bg-warning text-dark">! Belum diisi</span>
                @endif
            </div>
            <div class="check-row">
                <div class="label"><i class="bi bi-tools" style="color:#2b6cb0;"></i>Skills</div>
                @if($profile?->skills)
                    <span class="badge status-pill bg-success">✓ Lengkap</span>
                @else
                    <span class="badge status-pill bg-warning text-dark">! Belum diisi</span>
                @endif
            </div>
            <div class="check-row">
                <div class="label"><i class="bi bi-briefcase-fill" style="color:#2b6cb0;"></i>Pengalaman</div>
                @if($profile?->experience)
                    <span class="badge status-pill bg-success">✓ Lengkap</span>
                @else
                    <span class="badge status-pill bg-warning text-dark">! Belum diisi</span>
                @endif
            </div>
            <div class="check-row">
                <div class="label"><i class="bi bi-file-earmark-pdf-fill" style="color:#2b6cb0;"></i>CV / Resume</div>
                @if($profile?->cv_path)
                    <span class="badge status-pill bg-success">✓ Uploaded</span>
                @else
                    <span class="badge status-pill bg-danger">✗ Belum</span>
                @endif
            </div>

            <div class="p-4">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted fw-semibold">Progress Profil</small>
                    <small class="fw-bold" style="color:#2b6cb0;">{{ $filled }}/4 &bull; {{ $percent }}%</small>
                </div>
                <div class="progress-wrap">
                    <div class="progress-fill" style="width:{{ $percent }}%;"></div>
                </div>
                <p class="text-center mt-3 mb-0 small">
                    @if($filled == 4)
                        <span class="text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i>Profil kamu sudah lengkap! 🎉
                        </span>
                    @else
                        <span class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>Lengkapi {{ 4 - $filled }} data lagi untuk profil sempurna
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
@endpush