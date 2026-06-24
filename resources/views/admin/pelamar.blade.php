@extends('layouts.adminlte4.main')

@section('header', 'Data Pelamar')

@push('css')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeInUp 0.5s ease 0.1s both; }

    .pelamar-table-card {
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 0 4px 25px rgba(59,130,246,0.07) !important;
        overflow: hidden;
        background: rgba(255,255,255,0.95) !important;
    }
    .pelamar-table-header {
        background: linear-gradient(135deg, #1a4a7a, #2b6cb0);
        padding: 1.2rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table thead th {
        background: #f8fbff !important;
        color: #4a5568 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 1rem 1.2rem !important;
        border-bottom: 2px solid #e2e8f0 !important;
    }
    .table tbody td {
        padding: 1rem 1.2rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f0f4f8 !important;
        font-size: 0.88rem !important;
    }
    .table tbody tr {
        transition: background 0.2s ease;
    }
    .table tbody tr:hover {
        background: linear-gradient(135deg, #f0f7ff, #e8f4fd) !important;
    }
    .avatar-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2b6cb0, #4299e1);
        color: white;
        display: flex; align-items: center;
        justify-content: center;
        font-weight: 700; font-size: 0.85rem;
        flex-shrink: 0;
    }
    .status-badge {
        border-radius: 50px !important;
        padding: 0.3rem 0.8rem !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
    }
</style>
@endpush

@section('content')

<div class="card pelamar-table-card anim-1">
    <div class="pelamar-table-header">
        <div class="d-flex align-items-center gap-3">
            <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; color:white;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <h5 class="mb-0 text-white fw-bold">Daftar Pelamar</h5>
                <small class="text-white opacity-75">Data semua pelamar SmartApply</small>
            </div>
        </div>
        <span class="badge" style="background:rgba(255,255,255,0.2); color:white; border-radius:50px; padding:0.4rem 1rem; font-size:0.8rem;">
            {{ $pelamars->count() }} pelamar
        </span>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelamar</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Skills</th>
                    <th>CV</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelamars as $i => $pelamar)
                <tr>
                    <td class="text-muted">{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-circle">
                                {{ strtoupper(substr($pelamar->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="fw-semibold mb-0">{{ $pelamar->name }}</p>
                                <p class="text-muted mb-0" style="font-size:0.75rem;">
                                    Bergabung {{ $pelamar->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">{{ $pelamar->email }}</td>
                    <td>
                        @if($pelamar->applicantProfile?->phone)
                            <span class="fw-semibold">{{ $pelamar->applicantProfile->phone }}</span>
                        @else
                            <span class="status-badge badge bg-secondary bg-opacity-10 text-secondary">Belum diisi</span>
                        @endif
                    </td>
                    <td>
                        @if($pelamar->applicantProfile?->skills)
                            <span class="status-badge badge" style="background:#f0fff4; color:#276749;">
                                <i class="bi bi-check-lg me-1"></i>Ada
                            </span>
                        @else
                            <span class="status-badge badge" style="background:#fffaf0; color:#c05621;">
                                Belum
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($pelamar->applicantProfile?->cv_path)
                            <a href="{{ Storage::url($pelamar->applicantProfile->cv_path) }}"
                               target="_blank"
                               class="status-badge badge text-decoration-none"
                               style="background:#ebf4ff; color:#2b6cb0;">
                                <i class="bi bi-file-pdf me-1"></i>Lihat CV
                            </a>
                        @else
                            <span class="status-badge badge" style="background:#fff5f5; color:#9b2c2c;">
                                Belum upload
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pelamar.show', $pelamar->id) }}"
                           class="btn btn-sm btn-primary" style="border-radius:8px;">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="opacity:0.4;">
                            <i class="bi bi-inbox" style="font-size:3rem; display:block; margin-bottom:0.5rem;"></i>
                            <p class="mb-0">Belum ada pelamar terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection