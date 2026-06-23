@extends('layouts.adminlte4.main')

@section('header', 'Riwayat Lamaran Saya')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($applications->isEmpty())
        <div class="alert alert-info text-center">
            Kamu belum melamar pekerjaan apapun.
            <a href="{{ route('jobs.index') }}" class="alert-link">Lihat lowongan tersedia</a>
        </div>
    @else
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Posisi</th>
                            <th>Perusahaan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Lamar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $index => $app)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $app->jobListing->title }}</td>
                            <td>{{ $app->jobListing->company }}</td>
                            <td>{{ $app->jobListing->location }}</td>
                            <td>
                                @if($app->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($app->status == 'reviewed')
                                    <span class="badge bg-info">Direview</span>
                                @elseif($app->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $app->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('applications.show', $app->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                @if($app->status == 'pending')
                                <form method="POST" action="{{ route('applications.destroy', $app->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin membatalkan lamaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Batal
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
            🔍 Cari Lowongan Lainnya
        </a>
    </div>

@endsection