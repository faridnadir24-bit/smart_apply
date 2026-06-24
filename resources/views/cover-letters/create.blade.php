@extends('layouts.adminlte4.main')

@section('header', 'Generate Surat Lamaran AI')

@section('content')

@if ($errors->has('groq'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('groq') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('cover-letters.generate') }}" id="generateForm">
    @csrf
    <div class="row">

        {{-- KIRI: Data Diri + Posisi --}}
        <div class="col-lg-8">

            {{-- Data Diri --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-fill me-2"></i>Data Diri Pelamar
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ Auth::user()->name }}" disabled>
                            <div class="form-text">Diambil dari akun kamu</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ Auth::user()->email }}" disabled>
                            <div class="form-text">Diambil dari akun kamu</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor HP</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $profile->phone ?? '') }}"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        @if(!$profile?->phone)
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum diisi di biodata.
                                <a href="{{ route('applicant.biodata') }}">Lengkapi biodata</a> dulu.
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keahlian / Skill</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tools"></i></span>
                            <textarea name="skills" class="form-control" rows="2"
                                placeholder="PHP, Laravel, MySQL, JavaScript...">{{ old('skills', $profile->skills ?? '') }}</textarea>
                        </div>
                        @if(!$profile?->skills)
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum diisi di biodata.
                                <a href="{{ route('applicant.biodata') }}">Lengkapi biodata</a> dulu.
                            </div>
                        @endif
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">Pengalaman Kerja</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                            <textarea name="experience" class="form-control" rows="3"
                                placeholder="Magang/kerja sebagai apa, di mana, berapa lama...">{{ old('experience', $profile->experience ?? '') }}</textarea>
                        </div>
                        @if(!$profile?->experience)
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum diisi di biodata.
                                <a href="{{ route('applicant.biodata') }}">Lengkapi biodata</a> dulu.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Informasi Posisi --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-briefcase-fill me-2"></i>Informasi Posisi yang Dilamar
                    </h5>
                </div>
                <div class="card-body">

                    @if(isset($jobListing))
                        <input type="hidden" name="job_listing_id" value="{{ $jobListing->id }}">
                        <div class="alert alert-info mb-3">
                            <p class="fw-bold fs-5 mb-1">{{ $jobListing->title }}</p>
                            <p class="mb-1 text-muted">
                                <i class="bi bi-building me-1"></i>{{ $jobListing->company }}
                                &nbsp;·&nbsp;
                                <i class="bi bi-geo-alt me-1"></i>{{ $jobListing->location }}
                                &nbsp;·&nbsp;
                                <i class="bi bi-clock me-1"></i>{{ $jobListing->type }}
                            </p>
                            <p class="mb-0 text-muted small">{{ Str::limit($jobListing->description, 200) }}</p>
                        </div>

                    @elseif(isset($jobListings) && $jobListings->count() > 0)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Lowongan yang Tersedia</label>
                            <select name="job_listing_id" id="jobSelect" class="form-select"
                                onchange="toggleManualJob(this.value)">
                                <option value="">-- Isi Manual --</option>
                                @foreach($jobListings as $jl)
                                    <option value="{{ $jl->id }}" {{ old('job_listing_id') == $jl->id ? 'selected' : '' }}>
                                        {{ $jl->title }} – {{ $jl->company }} ({{ $jl->location }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div id="manualJobForm" class="{{ isset($jobListing) ? 'd-none' : '' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Posisi yang Dilamar <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="job_title" class="form-control"
                                    value="{{ old('job_title') }}"
                                    placeholder="Frontend Developer">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Nama Perusahaan <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ old('company_name') }}"
                                    placeholder="PT. XYZ Indonesia">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Lokasi</label>
                                <input type="text" name="job_location" class="form-control"
                                    value="{{ old('job_location') }}"
                                    placeholder="Jakarta, Remote, dll">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tipe Pekerjaan</label>
                                <input type="text" name="job_type" class="form-control"
                                    value="{{ old('job_type') }}"
                                    placeholder="Full-time, Part-time, Magang">
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                            <textarea name="job_description" class="form-control" rows="3"
                                placeholder="Salin deskripsi pekerjaan dari lowongan...">{{ old('job_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('cover-letters.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-clock-history me-1"></i>Riwayat Surat
                </a>
                <button type="submit" id="submitBtn" class="btn btn-primary px-5">
                    <span id="btnText">
                        <i class="bi bi-stars me-2"></i>Generate Surat Lamaran
                    </span>
                    <span id="btnLoading" class="d-none">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Sedang Membuat Surat...
                    </span>
                </button>
            </div>

        </div>

        {{-- KANAN: Tips --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-lightbulb-fill me-2"></i>Tips Generate Surat
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Isi skills selengkap mungkin
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Tulis pengalaman secara kronologis
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Sertakan deskripsi pekerjaan untuk hasil terbaik
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Proses generate membutuhkan 10-30 detik
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Surat bisa diedit setelah digenerate
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Status Biodata --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-clipboard-check me-2"></i>Status Biodata
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center small">
                            <span><i class="bi bi-telephone text-primary me-2"></i>Nomor HP</span>
                            @if($profile?->phone)
                                <span class="badge bg-success">✓ Ada</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center small">
                            <span><i class="bi bi-tools text-primary me-2"></i>Skills</span>
                            @if($profile?->skills)
                                <span class="badge bg-success">✓ Ada</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center small">
                            <span><i class="bi bi-briefcase text-primary me-2"></i>Pengalaman</span>
                            @if($profile?->experience)
                                <span class="badge bg-success">✓ Ada</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@push('js')
<script>
    function toggleManualJob(jobId) {
        const form = document.getElementById('manualJobForm');
        if (jobId) {
            form.classList.add('d-none');
        } else {
            form.classList.remove('d-none');
        }
    }

    const sel = document.getElementById('jobSelect');
    if (sel) toggleManualJob(sel.value);

    document.getElementById('generateForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('btnText').classList.add('d-none');
        document.getElementById('btnLoading').classList.remove('d-none');
    });
</script>
@endpush