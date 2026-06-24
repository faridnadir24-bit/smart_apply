@extends('layouts.adminlte4.main')

@section('header', 'Biodata Pelamar')

@push('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeInUp 0.5s ease 0.1s both; }
    .anim-2 { animation: fadeInUp 0.5s ease 0.2s both; }
    .anim-3 { animation: fadeInUp 0.5s ease 0.3s both; }

    .biodata-card {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        background: rgba(255,255,255,0.95) !important;
        overflow: hidden;
    }
    .biodata-card-header {
        background: linear-gradient(135deg, #1a4a7a, #2b6cb0);
        padding: 1.1rem 1.5rem;
    }
    .biodata-form-group {
        margin-bottom: 1.2rem;
    }
    .biodata-form-group label {
        font-weight: 700 !important;
        font-size: 0.82rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        color: #4a5568 !important;
        margin-bottom: 0.4rem !important;
    }
    .biodata-input {
        border-radius: 12px !important;
        border: 2px solid #e2e8f0 !important;
        padding: 0.7rem 1rem !important;
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
        background: #fafbff !important;
    }
    .biodata-input:focus {
        border-color: #4299e1 !important;
        box-shadow: 0 0 0 3px rgba(66,153,225,0.12) !important;
        background: white !important;
    }
    .biodata-input:disabled {
        background: #f7fafc !important;
        color: #a0aec0 !important;
        border-color: #e2e8f0 !important;
    }
    .input-icon-wrap {
        position: relative;
    }
    .input-icon-wrap .input-icon {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #4299e1; font-size: 0.9rem;
        pointer-events: none;
    }
    .input-icon-wrap .biodata-input {
        padding-left: 2.4rem !important;
    }
    .input-icon-wrap-ta .input-icon {
        top: 14px; transform: none;
    }
    .input-icon-wrap-ta .biodata-input {
        padding-left: 2.4rem !important;
    }
    .btn-save {
        border-radius: 12px !important;
        padding: 0.7rem 2rem !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        background: linear-gradient(135deg, #2b6cb0, #4299e1) !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(43,108,176,0.3) !important;
        transition: all 0.3s ease !important;
    }
    .btn-save:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(43,108,176,0.4) !important;
    }
    .btn-upload {
        border-radius: 12px !important;
        padding: 0.7rem 2rem !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        background: linear-gradient(135deg, #276749, #48bb78) !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(39,103,73,0.3) !important;
        transition: all 0.3s ease !important;
        width: 100%;
    }
    .btn-upload:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(39,103,73,0.4) !important;
    }
    .tips-item {
        display: flex; gap: 0.75rem;
        align-items: flex-start;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f0f4f8;
        font-size: 0.85rem;
    }
    .tips-item:last-child { border-bottom: none; }
    .tips-dot {
        width: 22px; height: 22px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f0fff4, #c6f6d5);
        color: #276749;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert"
        style="border-radius:14px; border:none;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3">

    {{-- FORM BIODATA --}}
    <div class="col-lg-7 anim-1">
        <div class="biodata-card mb-3">
            <div class="biodata-card-header">
                <h5 class="mb-0 text-white fw-bold">
                    <i class="bi bi-person-fill me-2"></i>Data Diri
                </h5>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('applicant.biodata.update') }}">
                    @csrf

                    <div class="biodata-form-group">
                        <label>Nama Lengkap</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" class="form-control biodata-input"
                                value="{{ Auth::user()->name }}" disabled>
                        </div>
                    </div>

                    <div class="biodata-form-group">
                        <label>Email</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="text" class="form-control biodata-input"
                                value="{{ Auth::user()->email }}" disabled>
                        </div>
                    </div>

                    <div class="biodata-form-group">
                        <label>Nomor HP</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-telephone input-icon"></i>
                            <input type="text" name="phone"
                                class="form-control biodata-input @error('phone') is-invalid @enderror"
                                placeholder="08xxxxxxxxxx"
                                value="{{ $profile->phone ?? '' }}">
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="biodata-form-group">
                        <label>Skills</label>
                        <div class="input-icon-wrap input-icon-wrap-ta" style="position:relative;">
                            <i class="bi bi-tools input-icon" style="position:absolute; left:12px; top:14px; color:#4299e1;"></i>
                            <textarea name="skills" rows="3"
                                class="form-control biodata-input @error('skills') is-invalid @enderror"
                                style="padding-left: 2.4rem !important;"
                                placeholder="Contoh: PHP, Laravel, JavaScript, MySQL">{{ $profile->skills ?? '' }}</textarea>
                        </div>
                        <div class="form-text">Pisahkan setiap skill dengan koma</div>
                        @error('skills')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="biodata-form-group mb-4">
                        <label>Pengalaman Kerja</label>
                        <div style="position:relative;">
                            <i class="bi bi-briefcase" style="position:absolute; left:12px; top:14px; color:#4299e1; z-index:1;"></i>
                            <textarea name="experience" rows="4"
                                class="form-control biodata-input @error('experience') is-invalid @enderror"
                                style="padding-left: 2.4rem !important;"
                                placeholder="Contoh: 2 tahun sebagai Backend Developer di PT. ABC">{{ $profile->experience ?? '' }}</textarea>
                        </div>
                        @error('experience')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-save w-100">
                        <i class="bi bi-save me-2"></i>Simpan Biodata
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SIDEBAR KANAN --}}
    <div class="col-lg-5">

        {{-- Upload CV --}}
        <div class="biodata-card mb-3 anim-2">
            <div class="biodata-card-header">
                <h5 class="mb-0 text-white fw-bold">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                    Upload CV <small class="opacity-75" style="font-size:0.7rem; font-weight:400;">PDF · maks 2MB</small>
                </h5>
            </div>
            <div class="p-4">
                @if($profile && $profile->cv_path)
                    <div class="d-flex align-items-center gap-3 p-3 mb-3"
                        style="background:#f0fff4; border-radius:14px; border:1px solid #c6f6d5;">
                        <div style="width:44px; height:44px; background:#c6f6d5; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#276749; flex-shrink:0;">
                            <i class="bi bi-file-check-fill"></i>
                        </div>
                        <div>
                            <p class="fw-semibold text-success mb-0 small">CV sudah terupload ✓</p>
                            <a href="{{ Storage::url($profile->cv_path) }}" target="_blank"
                                class="text-primary small fw-semibold text-decoration-none">
                                <i class="bi bi-eye me-1"></i>Lihat CV
                            </a>
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-3 p-3 mb-3"
                        style="background:#fffaf0; border-radius:14px; border:1px solid #feebc8;">
                        <div style="width:44px; height:44px; background:#feebc8; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; color:#c05621; flex-shrink:0;">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <p class="fw-semibold text-warning mb-0 small">Belum ada CV</p>
                            <p class="text-muted mb-0 small">Upload CV kamu sekarang</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('applicant.upload-cv') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="biodata-form-group mb-3">
                        <label>Pilih File CV</label>
                        <input type="file" name="cv" accept=".pdf"
                            class="form-control biodata-input @error('cv') is-invalid @enderror"
                            style="padding: 0.6rem 1rem !important;">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>Format: PDF | Maks: 2MB
                        </div>
                        @error('cv')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn text-white btn-upload">
                        <i class="bi bi-upload me-2"></i>Upload CV
                    </button>
                </form>
            </div>
        </div>

        {{-- Tips --}}
        <div class="biodata-card anim-3">
            <div class="biodata-card-header">
                <h6 class="mb-0 text-white fw-bold">
                    <i class="bi bi-lightbulb-fill me-2"></i>Tips Pengisian
                </h6>
            </div>
            <div class="p-3">
                <div class="tips-item">
                    <div class="tips-dot"><i class="bi bi-check-lg"></i></div>
                    <span class="text-muted">Isi skills selengkap mungkin agar AI bisa menganalisis dengan akurat</span>
                </div>
                <div class="tips-item">
                    <div class="tips-dot"><i class="bi bi-check-lg"></i></div>
                    <span class="text-muted">Pengalaman kerja ditulis secara kronologis</span>
                </div>
                <div class="tips-item">
                    <div class="tips-dot"><i class="bi bi-check-lg"></i></div>
                    <span class="text-muted">CV harus format PDF dan maksimal 2MB</span>
                </div>
                <div class="tips-item">
                    <div class="tips-dot"><i class="bi bi-check-lg"></i></div>
                    <span class="text-muted">Data yang lengkap menghasilkan surat lamaran yang lebih baik</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('js')
@endpush