@extends('layouts.adminlte4.main')

@section('header', 'Dashboard Admin')

@push('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeInUp 0.5s ease 0.1s both; }
    .anim-2 { animation: fadeInUp 0.5s ease 0.2s both; }
    .anim-3 { animation: fadeInUp 0.5s ease 0.3s both; }
    .anim-4 { animation: fadeInUp 0.5s ease 0.4s both; }
    .anim-5 { animation: fadeInUp 0.5s ease 0.5s both; }

    .admin-greeting {
        background: linear-gradient(135deg, #0f2d52 0%, #1a4a7a 50%, #2b6cb0 100%);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(43,108,176,0.3);
    }
    .admin-greeting::before {
        content: '';
        position: absolute;
        top: -60px; right: -40px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .admin-greeting::after {
        content: '';
        position: absolute;
        bottom: -80px; right: 15%;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .admin-stat-card {
        background: white;
        border-radius: 20px !important;
        border: none !important;
        padding: 1.5rem !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }
    .admin-stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }
    .admin-stat-card.blue::before   { background: linear-gradient(90deg, #2b6cb0, #4299e1); }
    .admin-stat-card.green::before  { background: linear-gradient(90deg, #276749, #48bb78); }
    .admin-stat-card.orange::before { background: linear-gradient(90deg, #c05621, #ed8936); }
    .admin-stat-card.red::before    { background: linear-gradient(90deg, #9b2c2c, #fc8181); }
    .admin-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(59,130,246,0.15) !important;
    }
    .admin-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .admin-stat-card:hover .admin-icon { transform: rotate(-8deg) scale(1.15); }
    .admin-icon.blue   { background: #ebf4ff; color: #2b6cb0; }
    .admin-icon.green  { background: #f0fff4; color: #276749; }
    .admin-icon.orange { background: #fffaf0; color: #c05621; }
    .admin-icon.red    { background: #fff5f5; color: #9b2c2c; }
    .stat-big-num {
        font-size: 2.5rem; font-weight: 800;
        color: #1a365d; line-height: 1;
    }
</style>
@endpush

@section('content')

{{-- Greeting --}}
<div class="admin-greeting mb-4 anim-1">
    <div style="position:relative; z-index:1;">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                <p class="mb-0 opacity-75">Pantau data pelamar SmartApply dari sini</p>
            </div>
            <div class="text-end">
                <p class="mb-0 opacity-75 small">Total Pelamar</p>
                <p class="fw-bold mb-0" style="font-size: 2.5rem; line-height:1;">{{ $totalPelamar }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-sm-6 anim-1">
        <div class="admin-stat-card blue">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="admin-icon blue"><i class="bi bi-people-fill"></i></div>
                <span class="badge rounded-pill" style="background:#ebf4ff; color:#2b6cb0; font-size:0.7rem;">Total</span>
            </div>
            <p class="text-muted small mb-1 fw-semibold">Total Pelamar</p>
            <p class="stat-big-num">{{ $totalPelamar }}</p>
            <p class="text-muted small mt-1 mb-0">Terdaftar di SmartApply</p>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 anim-2">
        <div class="admin-stat-card green">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="admin-icon green"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <span class="badge rounded-pill" style="background:#f0fff4; color:#276749; font-size:0.7rem;">CV</span>
            </div>
            <p class="text-muted small mb-1 fw-semibold">Sudah Upload CV</p>
            <p class="stat-big-num" style="color:#276749;">{{ $sudahUploadCv }}</p>
            <p class="text-muted small mt-1 mb-0">dari {{ $totalPelamar }} pelamar</p>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 anim-3">
        <div class="admin-stat-card orange">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="admin-icon orange"><i class="bi bi-tools"></i></div>
                <span class="badge rounded-pill" style="background:#fffaf0; color:#c05621; font-size:0.7rem;">Skills</span>
            </div>
            <p class="text-muted small mb-1 fw-semibold">Sudah Isi Skills</p>
            <p class="stat-big-num" style="color:#c05621;">{{ $sudahIsiSkills }}</p>
            <p class="text-muted small mt-1 mb-0">dari {{ $totalPelamar }} pelamar</p>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 anim-4">
        <div class="admin-stat-card red">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="admin-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <span class="badge rounded-pill" style="background:#fff5f5; color:#9b2c2c; font-size:0.7rem;">Belum</span>
            </div>
            <p class="text-muted small mb-1 fw-semibold">Belum Upload CV</p>
            <p class="stat-big-num" style="color:#9b2c2c;">{{ $totalPelamar - $sudahUploadCv }}</p>
            <p class="text-muted small mt-1 mb-0">perlu follow up</p>
        </div>
    </div>
</div>

{{-- Welcome Info --}}
<div class="row anim-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 20px !important; background: rgba(255,255,255,0.92) !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:48px; height:48px; background: linear-gradient(135deg,#ebf4ff,#bee3f8); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#2b6cb0; flex-shrink:0;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-1 text-primary">Panel Admin SmartApply</p>
                        <p class="text-muted small mb-0">
                            Gunakan menu <strong>Data Pelamar</strong> untuk melihat daftar lengkap pelamar, biodata, dan CV mereka.
                            Klik tombol <strong>Detail</strong> untuk melihat profil lengkap pelamar.
                        </p>
                    </div>
                    <a href="{{ route('admin.pelamar.index') }}" class="btn btn-primary ms-auto flex-shrink-0">
                        <i class="bi bi-people-fill me-1"></i>Lihat Pelamar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection