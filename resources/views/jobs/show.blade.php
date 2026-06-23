@extends('layouts.adminlte4.main')

@section('header', 'Detail Lowongan')

@section('content')

    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mb-3">
        ← Kembali ke Daftar Lowongan
    </a>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start mb-3">
                <h2 class="fw-bold">{{ $jobListing->title }}</h2>
                <span class="badge {{ $jobListing->type == 'Full-time' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                    {{ $jobListing->type }}
                </span>
            </div>

            <p class="text-muted"><i class="bi bi-building me-2"></i>{{ $jobListing->company }}</p>
            <p class="text-muted"><i class="bi bi-geo-alt me-2"></i>{{ $jobListing->location }}</p>
            <p class="text-success fw-bold"><i class="bi bi-cash me-2"></i>{{ $jobListing->salary ?? 'Negosiasi' }}</p>

            <hr>

            <h5 class="fw-bold">Deskripsi Pekerjaan</h5>
            <p class="text-secondary">{{ $jobListing->description }}</p>

            <hr>

            @auth
                @if($hasApplied)
                    <div class="alert alert-success">
                        ✅ Kamu sudah melamar pekerjaan ini!
                        <a href="{{ route('applications.index') }}" class="alert-link">Lihat lamaran kamu</a>
                    </div>
                @else
                    <h5 class="fw-bold mb-3">📝 Kirim Lamaran</h5>
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form Input --}}
                    <div id="formInput">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover Letter <span class="text-danger">*</span></label>
                            <textarea id="coverLetterInput" class="form-control" rows="5"
                                placeholder="Tuliskan motivasi dan alasan kamu melamar posisi ini...">{{ old('cover_letter') }}</textarea>
                            <div id="coverLetterError" class="text-danger small mt-1" style="display:none">Cover letter minimal 20 karakter!</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Expected Salary (Gaji yang Diharapkan)</label>
                            <input type="text" id="expectedSalaryInput" class="form-control"
                                placeholder="Contoh: Rp 8.000.000 - Rp 10.000.000"
                                value="{{ old('expected_salary') }}">
                            <small class="text-muted">Opsional - kosongkan jika ingin negosiasi</small>
                        </div>
                        <button type="button" onclick="showConfirmation()" class="btn btn-primary px-4">
                            📋 Review Lamaran
                        </button>
                    </div>

                    {{-- Halaman Konfirmasi --}}
                    <div id="konfirmasiLamaran" style="display:none">
                        <div class="alert alert-info">
                            <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Ringkasan Lamaran Kamu</h6>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Posisi</div>
                                <div class="col-md-8">{{ $jobListing->title }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Perusahaan</div>
                                <div class="col-md-8">{{ $jobListing->company }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Lokasi</div>
                                <div class="col-md-8">{{ $jobListing->location }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Gaji Diharapkan</div>
                                <div class="col-md-8" id="konfirmasiSalary">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Cover Letter</div>
                                <div class="col-md-8">
                                    <div class="bg-white p-2 rounded border" id="konfirmasiCoverLetter"></div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            ⚠️ Pastikan semua informasi sudah benar sebelum mengirim lamaran!
                        </div>

                        <form method="POST" action="{{ route('jobs.apply', $jobListing->id) }}" id="formKirim">
                            @csrf
                            <input type="hidden" name="cover_letter" id="hiddenCoverLetter">
                            <input type="hidden" name="expected_salary" id="hiddenExpectedSalary">
                            <div class="d-flex gap-2">
                                <button type="button" onclick="backToForm()" class="btn btn-secondary">
                                    ← Edit Lamaran
                                </button>
                                <button type="submit" class="btn btn-success px-4">
                                    🚀 Kirim Lamaran Sekarang
                                </button>
                            </div>
                        </form>
                    </div>

@endif

                {{-- Tombol Generate Surat Lamaran AI --}}
                @if(auth()->user()->hasRole('user'))
                    <a href="{{ route('cover-letters.from-job', $jobListing) }}"
                        class="btn btn-info mt-3 d-inline-block">
                        ✨ Buat Surat Lamaran dengan AI
                    </a>
                @endif
            @else
                <div class="alert alert-warning">
                    <a href="{{ route('login') }}" class="alert-link fw-bold">Login</a> terlebih dahulu untuk melamar.
                </div>
            @endauth
        </div>
    </div>

@endsection

@push('js')
<script>
function showConfirmation() {
    const coverLetter = document.getElementById('coverLetterInput').value;
    const expectedSalary = document.getElementById('expectedSalaryInput').value;

    // Validasi
    if (coverLetter.length < 20) {
        document.getElementById('coverLetterError').style.display = 'block';
        return;
    }
    document.getElementById('coverLetterError').style.display = 'none';

    // Isi konfirmasi
    document.getElementById('konfirmasiCoverLetter').innerText = coverLetter;
    document.getElementById('konfirmasiSalary').innerText = expectedSalary || 'Negosiasi';

    // Isi hidden input
    document.getElementById('hiddenCoverLetter').value = coverLetter;
    document.getElementById('hiddenExpectedSalary').value = expectedSalary;

    // Tampilkan konfirmasi
    document.getElementById('formInput').style.display = 'none';
    document.getElementById('konfirmasiLamaran').style.display = 'block';
}

function backToForm() {
    document.getElementById('formInput').style.display = 'block';
    document.getElementById('konfirmasiLamaran').style.display = 'none';
}
</script>
@endpush