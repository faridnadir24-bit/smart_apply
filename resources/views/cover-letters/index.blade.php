{{-- resources/views/cover-letters/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📁 Riwayat Surat Lamaran
            </h2>
            <a href="{{ route('cover-letters.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                ✨ Buat Surat Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($coverLetters->isEmpty())
            <div class="bg-white rounded-2xl shadow p-12 text-center">
                <p class="text-5xl mb-4">📭</p>
                <p class="text-gray-500 text-lg">Belum ada surat lamaran yang dibuat.</p>
                <a href="{{ route('cover-letters.create') }}"
                    class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                    Buat Surat Pertama
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($coverLetters as $letter)
                    <div class="bg-white rounded-2xl shadow p-5 flex items-center justify-between hover:shadow-md transition">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $letter->job_title }}</p>
                            <p class="text-gray-500 text-sm">{{ $letter->company_name }}</p>
                            <p class="text-gray-400 text-xs mt-1">{{ $letter->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('cover-letters.show', $letter) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm border border-blue-300 hover:border-blue-500 px-3 py-1.5 rounded-lg transition">
                                Lihat
                            </a>
                            <form action="{{ route('cover-letters.destroy', $letter) }}" method="POST"
                                onsubmit="return confirm('Hapus surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 text-sm border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $coverLetters->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
