@extends('layouts.adminlte4.main')

@section('header', 'Detail Lamaran')

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Detail Lamaran</h5>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Posisi</div>
                    <div class="col-md-8">{{ $application->jobListing->title }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Perusahaan</div>
                    <div class="col-md-8">{{ $application->jobListing->company }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Lokasi</div>
                    <div class="col-md-8">{{ $application->jobListing->location }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Tipe</div>
                    <div class="col-md-8">
                        <span class="badge {{ $application->jobListing->type == 'Full-time' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $application->jobListing->type }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Gaji Ditawarkan</div>
                    <div class="col-md-8">{{ $application->jobListing->salary ?? 'Negosiasi' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Gaji Diharapkan</div>
                    <div class="col-md-8">
                        @if($application->expected_salary)
                            <span class="text-success fw-bold">{{ $application->expected_salary }}</span>
                        @else
                            <span class="text-muted fst-italic">Negosiasi</span>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Status Lamaran</div>
                    <div class="col-md-8">
                        @if($application->status == 'pending')
                            <span class="badge bg-warning text-dark">⏳ Pending</span>
                        @elseif($application->status == 'reviewed')
                            <span class="badge bg-info">👀 Direview</span>
                        @elseif($application->status == 'accepted')
                            <span class="badge bg-success">✅ Diterima</span>
                        @else
                            <span class="badge bg-danger">❌ Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-muted">Tanggal Lamar</div>
                    <div class="col-md-8">{{ $application->created_at->format('d M Y, H:i') }}</div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="fw-bold text-muted mb-2">Cover Letter</div>
                    <div class="bg-light p-3 rounded">{{ $application->cover_letter }}</div>
                </div>

            </div>
            <div class="card-footer bg-transparent d-flex gap-2">
                <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
                @if($application->status == 'pending')
                <form method="POST" action="{{ route('applications.destroy', $application->id) }}"
                    onsubmit="return confirm('Yakin ingin membatalkan lamaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Batalkan Lamaran
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">📋 Info Lowongan</h6>
            </div>
            <div class="card-body">
                <p class="text-secondary small">{{ $application->jobListing->description }}</p>
                <a href="{{ route('jobs.show', $application->jobListing->id) }}" class="btn btn-outline-primary btn-sm w-100">
                    Lihat Lowongan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection