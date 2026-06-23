{{-- resources/views/cover-letters/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✍️ Generate Surat Lamaran dengan AI
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if ($errors->has('groq'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                ⚠️ {{ $errors->first('groq') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-300 text-red-600 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cover-letters.generate') }}" id="generateForm">
            @csrf

            {{-- ===== DATA DIRI ===== --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">📋 Data Diri Pelamar</h3>

                {{-- Nama & Email dari User (readonly, diambil otomatis di controller) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text"
                            value="{{ Auth::user()->name }}"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed"
                            disabled>
                        <p class="text-gray-400 text-xs mt-1">Diambil dari akun kamu</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <input type="text"
                            value="{{ Auth::user()->email }}"
                            class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed"
                            disabled>
                        <p class="text-gray-400 text-xs mt-1">Diambil dari akun kamu</p>
                    </div>
                </div>

                {{-- Nomor HP --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nomor HP</label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $profile->phone ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="08xxxxxxxxxx">
                    @if(!$profile?->phone)
                        <p class="text-amber-500 text-xs mt-1">⚠️ Belum diisi di biodata. Isi di sini atau <a href="{{ route('applicant.biodata') }}" class="underline">lengkapi biodata</a> dulu.</p>
                    @endif
                </div>

                {{-- Skills --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Keahlian / Skill</label>
                    <textarea name="skills" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="PHP, Laravel, MySQL, JavaScript, ...">{{ old('skills', $profile->skills ?? '') }}</textarea>
                    @if(!$profile?->skills)
                        <p class="text-amber-500 text-xs mt-1">⚠️ Belum diisi di biodata. Isi di sini atau <a href="{{ route('applicant.biodata') }}" class="underline">lengkapi biodata</a> dulu.</p>
                    @endif
                </div>

                {{-- Pengalaman --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Pengalaman Kerja</label>
                    <textarea name="experience" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Magang/kerja sebagai apa, di mana, berapa lama...">{{ old('experience', $profile->experience ?? '') }}</textarea>
                    @if(!$profile?->experience)
                        <p class="text-amber-500 text-xs mt-1">⚠️ Belum diisi di biodata. Isi di sini atau <a href="{{ route('applicant.biodata') }}" class="underline">lengkapi biodata</a> dulu.</p>
                    @endif
                </div>
            </div>

            {{-- ===== PILIH LOWONGAN ===== --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">💼 Informasi Posisi yang Dilamar</h3>

                @if(isset($jobListing))
                    {{-- Dari halaman detail lowongan --}}
                    <input type="hidden" name="job_listing_id" value="{{ $jobListing->id }}">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                        <p class="text-blue-800 font-semibold text-lg">{{ $jobListing->title }}</p>
                        <p class="text-blue-600 text-sm">{{ $jobListing->company }} · {{ $jobListing->location }} · {{ $jobListing->type }}</p>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit($jobListing->description, 200) }}</p>
                    </div>

                @elseif(isset($jobListings) && $jobListings->count() > 0)
                    {{-- Dropdown pilih lowongan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Pilih Lowongan yang Tersedia</label>
                        <select name="job_listing_id" id="jobSelect"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            onchange="toggleManualJob(this.value)">
                            <option value="">-- Isi Manual --</option>
                            @foreach($jobListings as $jl)
                                <option value="{{ $jl->id }}" {{ old('job_listing_id') == $jl->id ? 'selected' : '' }}>
                                    {{ $jl->title }} – {{ $jl->company }} ({{ $jl->location }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Form manual --}}
                <div id="manualJobForm" class="{{ isset($jobListing) ? 'hidden' : '' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                Posisi yang Dilamar <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title"
                                value="{{ old('job_title') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Frontend Developer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                Nama Perusahaan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="company_name"
                                value="{{ old('company_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="PT. XYZ Indonesia">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Lokasi</label>
                            <input type="text" name="job_location"
                                value="{{ old('job_location') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Jakarta, Remote, dll">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tipe Pekerjaan</label>
                            <input type="text" name="job_type"
                                value="{{ old('job_type') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Full-time, Part-time, Magang, dll">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi Pekerjaan</label>
                        <textarea name="job_description" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            placeholder="Salin deskripsi pekerjaan dari lowongan...">{{ old('job_description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('cover-letters.index') }}"
                    class="border border-gray-300 text-gray-600 hover:bg-gray-50 font-medium px-6 py-3 rounded-xl transition">
                    Riwayat Surat
                </a>
                <button type="submit" id="submitBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md transition duration-200 flex items-center gap-2 disabled:opacity-60">
                    <span id="btnText">✨ Generate Surat Lamaran</span>
                    <span id="btnLoading" class="hidden">⏳ Sedang Membuat Surat...</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleManualJob(jobId) {
            document.getElementById('manualJobForm').classList.toggle('hidden', !!jobId);
        }

        // Set state awal berdasarkan old value
        const sel = document.getElementById('jobSelect');
        if (sel) toggleManualJob(sel.value);

        document.getElementById('generateForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            document.getElementById('btnText').classList.add('hidden');
            document.getElementById('btnLoading').classList.remove('hidden');
        });
    </script>
</x-app-layout>
