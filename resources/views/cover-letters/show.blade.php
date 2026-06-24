@extends('layouts.adminlte4.main')

@section('header', 'Hasil Surat Lamaran AI')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    {{-- Kiri: Isi Surat --}}
    <div class="col-lg-8">

        {{-- Info Posisi --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>{{ $coverLetter->job_title }}
                    </h5>
                    <small class="opacity-75">{{ $coverLetter->company_name }}</small>
                </div>
                <span class="badge bg-white text-primary">AI Generated</span>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar3 me-2"></i>
                    Dibuat: {{ $coverLetter->created_at->format('d M Y, H:i') }}
                </p>
            </div>
        </div>

        {{-- Isi Surat --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">
                    <i class="bi bi-file-text me-2"></i>Isi Surat Lamaran
                </h6>
                <button onclick="copyText()" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-clipboard me-1"></i>Salin Teks
                </button>
            </div>
            <div class="card-body">
                <div id="coverLetterContent"
                    style="font-family: 'Times New Roman', serif; font-size: 13pt; line-height: 1.8; white-space: pre-line;">
                    {{ $coverLetter->content }}
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center">
            <form action="{{ route('cover-letters.destroy', $coverLetter) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i>Hapus Surat
                </button>
            </form>

            <div class="d-flex gap-2">
                <a href="{{ route('cover-letters.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-clock-history me-1"></i>Riwayat
                </a>
                <button onclick="printLetter()" class="btn btn-dark">
                    <i class="bi bi-printer me-1"></i>Print / PDF
                </button>
                <a href="{{ route('cover-letters.create') }}" class="btn btn-primary">
                    <i class="bi bi-stars me-1"></i>Buat Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Kanan: Info --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Informasi Surat
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted small">Posisi</td>
                        <td class="fw-semibold small">{{ $coverLetter->job_title }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Perusahaan</td>
                        <td class="fw-semibold small">{{ $coverLetter->company_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Dibuat</td>
                        <td class="fw-semibold small">{{ $coverLetter->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Generator</td>
                        <td><span class="badge bg-primary">GROQ AI</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightbulb me-2"></i>Tips Penggunaan
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Baca ulang dan sesuaikan isi surat
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Gunakan tombol Print untuk simpan PDF
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Salin teks untuk edit di Word/Google Docs
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        Buat surat baru untuk posisi berbeda
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    function copyText() {
        const el = document.getElementById('coverLetterContent');
        if (!el) return;

        const text = el.innerText;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Teks surat berhasil disalin!');
            }).catch(() => {
                fallbackCopy(text);
            });
            return;
        }

        fallbackCopy(text);
    }

    function fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        textArea.style.top = '-9999px';
        document.body.appendChild(textArea);

        textArea.focus();
        textArea.select();

        try {
            const ok = document.execCommand('copy');
            alert(ok ? 'Teks surat berhasil disalin!' : 'Gagal menyalin, coba select manual ya!');
        } catch (err) {
            alert('Gagal menyalin, coba select manual ya!');
        } finally {
            document.body.removeChild(textArea);
        }
    }


    function printLetter() {
        const content = document.getElementById('coverLetterContent').innerHTML;
        const win = window.open('', '_blank');
        win.document.write(`
            <html>
            <head>
                <title>Surat Lamaran - {{ $coverLetter->job_title }}</title>
                <style>
                    body {
                        font-family: 'Times New Roman', serif;
                        font-size: 12pt;
                        margin: 2cm;
                        line-height: 1.6;
                        color: #000;
                    }
                </style>
            </head>
            <body>${content}</body>
            </html>
        `);
        win.document.close();
        win.print();
    }
</script>
@endpush