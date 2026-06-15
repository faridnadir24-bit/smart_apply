@extends('layouts.adminlte4.main')

@section('header', 'Dashboard Lowongan Kerja')

@section('content')

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('jobs.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari posisi, perusahaan..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="Full-time" {{ request('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="Part-time" {{ request('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="location" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Lokasi</option>
                @foreach(App\Models\JobListing::distinct()->pluck('location') as $loc)
                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Gaji Tertinggi</option>
                <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Gaji Terendah</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">🔍</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    {{-- Job Cards --}}
    <div class="row g-4">
        @forelse($jobs as $job)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0">{{ $job->title }}</h5>
                        <span class="badge {{ $job->type == 'Full-time' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $job->type }}
                        </span>
                    </div>
                    <p class="text-muted mb-1"><i class="bi bi-building me-1"></i> {{ $job->company }}</p>
                    <p class="text-muted mb-1"><i class="bi bi-geo-alt me-1"></i> {{ $job->location }}</p>
                    <p class="text-success mb-2"><i class="bi bi-cash me-1"></i> {{ $job->salary ?? 'Negosiasi' }}</p>
                    <p class="card-text text-secondary small">{{ Str::limit($job->description, 100) }}</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm w-100">
                        Lihat Detail & Lamar
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Tidak ada lowongan yang ditemukan.</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>

@endsection