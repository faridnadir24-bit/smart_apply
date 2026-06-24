@extends('layouts.adminlte4.main')

@section('header', 'Surat Lamaran AI')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <p class="text-muted mb-0">Kelola surat lamaran yang dibuat dengan bantuan AI</p>
        <a href="{{ route('cover-letters.create') }}" class="btn btn-primary">
            <i class="bi bi-stars me-2"></i>Buat Surat Baru
        </a>
    </div>
</div>

@if($coverLetters->isEmpty())
    <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">
            <i class="bi bi-envelope-x text-muted" style="font-size: 64px;"></i>
            <h5 class="mt-3 text-muted">Belum ada surat lamaran</h5>
            <p class="text-muted small">Buat surat lamaran pertama kamu dengan bantuan AI!</p>
            <a href="{{ route('cover-letters.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-stars me-2"></i>Buat Surat Pertama
            </a>
        </div>
    </div>
@else
    <div class="row">
        @foreach($coverLetters as $letter)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-truncate" style="max-width: 200px;">
                        <i class="bi bi-file-earmark-text me-2"></i>{{ $letter->job_title }}
                    </span>
                    <span class="badge bg-white text-primary">AI</span>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <i class="bi bi-building text-primary me-2"></i>
                        <strong>{{ $letter->company_name }}</strong>
                    </p>
                    <p class="text-muted small mb-0">
                        <i class="bi bi-calendar3 me-2"></i>
                        {{ $letter->created_at->format('d M Y') }}
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex gap-2">
                    <a href="{{ route('cover-letters.show', $letter) }}"
                        class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="bi bi-eye me-1"></i>Lihat
                    </a>
                    <form action="{{ route('cover-letters.destroy', $letter) }}" method="POST"
                        onsubmit="return confirm('Hapus surat ini?')" class="flex-fill">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $coverLetters->links() }}
    </div>
@endif

@endsection

@push('js')
@endpush