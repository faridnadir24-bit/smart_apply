{{-- resources/views/cover-letters/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📄 Hasil Surat Lamaran
            </h2>
            <a href="{{ route('cover-letters.index') }}"
                class="text-sm text-blue-600 hover:underline">← Riwayat Surat</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Info Posisi --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6 flex justify-between items-center">
            <div>
                <p class="font-semibold text-blue-900 text-lg">{{ $coverLetter->job_title }}</p>
                <p class="text-blue-600 text-sm">{{ $coverLetter->company_name }}</p>
                <p class="text-gray-400 text-xs mt-1">Dibuat: {{ $coverLetter->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex gap-2">
                {{-- Tombol copy --}}
                <button onclick="copyText()"
                    class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                    📋 Salin
                </button>
                {{-- Tombol buat ulang --}}
                <a href="{{ route('cover-letters.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    ✨ Buat Baru
                </a>
            </div>
        </div>

        {{-- Isi Surat --}}
        <div class="bg-white rounded-2xl shadow p-8">
            <div id="coverLetterContent"
                class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-line font-serif text-base">
                {{ $coverLetter->content }}
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-between mt-6">
            <form action="{{ route('cover-letters.destroy', $coverLetter) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-500 hover:text-red-700 text-sm border border-red-300 hover:border-red-500 px-4 py-2 rounded-lg transition">
                    🗑️ Hapus Surat
                </button>
            </form>

            <button onclick="printLetter()"
                class="bg-gray-700 hover:bg-gray-900 text-white text-sm font-medium px-6 py-2 rounded-lg transition">
                🖨️ Print / Simpan PDF
            </button>
        </div>
    </div>

    <script>
        function copyText() {
            const text = document.getElementById('coverLetterContent').innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert('Teks surat berhasil disalin!');
            });
        }

        function printLetter() {
            const content = document.getElementById('coverLetterContent').innerHTML;
            const win = window.open('', '_blank');
            win.document.write(`
                <html>
                <head>
                    <title>Surat Lamaran</title>
                    <style>
                        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 2cm; line-height: 1.6; color: #000; }
                    </style>
                </head>
                <body>${content}</body>
                </html>
            `);
            win.document.close();
            win.print();
        }
    </script>
</x-app-layout>
