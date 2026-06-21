<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Lowongan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
                ← Kembali ke Daftar Lowongan
            </a>

            <div class="bg-white rounded-xl shadow p-6 mt-2">

                <div class="flex justify-between items-start mb-3">
                    <h2 class="text-2xl font-bold">{{ $jobListing->title }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full {{ $jobListing->type == 'Full-time' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $jobListing->type }}
                    </span>
                </div>

                <p class="text-gray-500">🏢 {{ $jobListing->company }}</p>
                <p class="text-gray-500">📍 {{ $jobListing->location }}</p>
                <p class="text-green-600 font-semibold mt-1">💰 {{ $jobListing->salary ?? 'Negosiasi' }}</p>

                <hr class="my-4">

                <h4 class="font-bold text-lg mb-2">Deskripsi Pekerjaan</h4>
                <p class="text-gray-600">{{ $jobListing->description }}</p>

                <hr class="my-4">

                @auth
                    @if($hasApplied)
                        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                            ✅ Kamu sudah melamar pekerjaan ini!
                        </div>
                    @else
                        <h4 class="font-bold text-lg mb-3">📝 Kirim Lamaran</h4>
                        @if(session('error'))
                            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-3">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('jobs.apply', $jobListing->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block font-semibold mb-1">Cover Letter</label>
                                <textarea name="cover_letter" rows="5"
                                    class="w-full border rounded-lg px-4 py-2 @error('cover_letter') border-red-500 @enderror"
                                    placeholder="Tuliskan motivasi dan alasan kamu melamar posisi ini...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                🚀 Kirim Lamaran
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded-lg">
                        <a href="{{ route('login') }}" class="underline font-semibold">Login</a> terlebih dahulu untuk melamar.
                    </div>
                @endauth

                @auth
                 @if(auth()->user()->hasRole('user') || !auth()->user()->hasRole('admin'))
                        <a href="{{ route('cover-letters.from-job', $jobListing) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl inline-block mt-4">
                            ✨ Buat Surat Lamaran dengan AI
                        </a>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</x-app-layout>