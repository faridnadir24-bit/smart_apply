@extends('layouts.adminlte4.main')

@section('header', 'Detail Pelamar')

@push('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeInUp 0.5s ease 0.1s both; }
    .anim-2 { animation: fadeInUp 0.5s ease 0.2s both; }

    .detail-card {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        background: rgba(255,255,255,0.95) !important;
        overflow: hidden;
    }
    .detail-card-header {
        background: linear-gradient(135deg, #1a4a7a, #2b6cb0);
        padding: 1.2rem 1.5rem;
    }
    .avatar-big {
        width: 70px; height: 70px;
        border-radius: 20px;
        background: linear-gradient(135deg, #3182ce, #63b3ed);
        color: white;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 2rem; font-weight: 800;
        box-shadow: 0 8px 25px rgba(43,108,176,0.4);
        flex-shrink: 0;
    }
    .info-row {
        display: flex; align-items: flex-start;
        gap: 1rem; padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f4f8;
        transition: background 0.2s;
    }
    .info-row:hover { background: #f8fbff; }
    .info-row:last-child { border-bottom: none; }
    .info-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: #ebf4ff;
        color: #2b6cb0;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .info-label { font-size: 0.75rem; color: #a0aec0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.9rem; color: #2d3748; font-weight: 500; }
</style>
@endpush

@section('content')

<div class="mb-3 anim-1">
    <a href="{{ route('admin.pelamar.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
    </a>
</div>

<div class="row g-3">
    {{-- Info Pelamar --}}
    <div class="col-lg-8 anim-1">
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-big">
                        {{ strtoupper(substr($pelamar->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="text-white fw-bold mb-1">{{ $pelamar->name }}</h5>
                        <p class="text-white opacity-75 mb-0 small">{{ $pelamar->email }}</p>
                        <span class="badge mt-1" style="background:rgba(255,255,255,0.2); color:white; border-radius:50px; font-size:0.7rem;">
                            <i class="bi bi-calendar3 me-1"></i>Bergabung {{ $pelamar->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-person-fill"></i></div>
                <div>
                    <p class="info-label mb-0">Nama Lengkap</p>
                    <p class="info-value mb-0">{{ $pelamar->name }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                <div>
                    <p class="info-label mb-0">Email</p>
                    <p class="info-value mb-0">{{ $pelamar->email }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                <div>
                    <p class="info-label mb-0">Nomor HP</p>
                    <p class="info-value mb-0">{{ $pelamar->applicantProfile?->phone ?? '-' }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="bi bi-tools"></i></div>
                <div>
                    <p class="info-label mb-0">Skills</p>
                    <p class="info-value mb-0">{{ $pelamar->applicantProfile?->skills ?? '-' }}</p>
                </div>
            </div>
            <div class="info-row">
                <div class="info-icon"><i class="bi bi-briefcase-fill"></i></div>
                <div>
                    <p class="info-label mb-0">Pengalaman Kerja</p>
                    <p class="info-value mb-0">{{ $pelamar->applicantProfile?->experience ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CV Card --}}
    <div class="col-lg-4 anim-2">
        <div class="detail-card">
            <div class="detail-card-header">
                <h6 class="mb-0 text-white fw-bold">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>CV Pelamar
                </h6>
            </div>
            <div class="p-4 text-center">
                @if($pelamar->applicantProfile?->cv_path)
                    <div style="width:70px; height:70px; background:#fff5f5; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:2rem; color:#e53e3e; margin: 0 auto 1rem;">
                        <i class="bi bi-file-pdf"></i>
                    </div>
                    <p class="fw-semibold text-success mb-1">CV Tersedia</p>
                    <p class="text-muted small mb-3">File CV sudah diupload</p>
                    <a href="{{ Storage::url($pelamar->applicantProfile->cv_path) }}"
                       target="_blank"
                       class="btn btn-primary w-100 mb-2" style="border-radius:10px;">
                        <i class="bi bi-eye me-1"></i>Lihat CV
                    </a>
                    <a href="{{ Storage::url($pelamar->applicantProfile->cv_path) }}"
                       download
                       class="btn btn-outline-primary w-100" style="border-radius:10px;">
                        <i class="bi bi-download me-1"></i>Download CV
                    </a>
                @else
                    <div style="width:70px; height:70px; background:#f7fafc; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:2rem; color:#a0aec0; margin: 0 auto 1rem;">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>
                    <p class="fw-semibold text-muted mb-1">Belum Ada CV</p>
                    <p class="text-muted small mb-0">Pelamar belum upload CV</p>
                @endif
            </div>
        </div>

        {{-- Kelengkapan Profil --}}
        <div class="detail-card mt-3">
            <div class="detail-card-header">
                <h6 class="mb-0 text-white fw-bold">
                    <i class="bi bi-clipboard-check-fill me-2"></i>Kelengkapan Profil
                </h6>
            </div>
            <div class="p-3">
                @php
                    $items = [
                        ['label' => 'Email', 'value' => $pelamar->email],
                        ['label' => 'Nomor HP', 'value' => $pelamar->applicantProfile?->phone],
                        ['label' => 'Skills', 'value' => $pelamar->applicantProfile?->skills],
                        ['label' => 'Pengalaman', 'value' => $pelamar->applicantProfile?->experience],
                        ['label' => 'CV', 'value' => $pelamar->applicantProfile?->cv_path],
                    ];
                    $filledCount = collect($items)->filter(fn($i) => !empty($i['value']))->count();
                    $pct = ($filledCount / count($items)) * 100;
                @endphp
                @foreach($items as $item)
                <div class="d-flex justify-content-between align-items-center py-2 px-2" style="border-bottom: 1px solid #f0f4f8;">
                    <span class="small text-muted">{{ $item['label'] }}</span>
                    @if(!empty($item['value']))
                        <span class="badge" style="background:#f0fff4; color:#276749; border-radius:50px; font-size:0.7rem;">✓ Ada</span>
                    @else
                        <span class="badge" style="background:#fff5f5; color:#9b2c2c; border-radius:50px; font-size:0.7rem;">✗ Kosong</span>
                    @endif
                </div>
                @endforeach
                <div class="mt-3 px-2">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">Progress</small>
                        <small class="fw-bold" style="color:#2b6cb0;">{{ $filledCount }}/{{ count($items) }}</small>
                    </div>
                    <div style="height:6px; border-radius:10px; background:#e2e8f0;">
                        <div style="height:100%; width:{{ $pct }}%; border-radius:10px; background:linear-gradient(90deg,#2b6cb0,#4299e1);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection