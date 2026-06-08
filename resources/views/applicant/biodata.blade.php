<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Biodata Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FORM BIODATA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Data Diri
                    </h3>

                    <form method="POST" action="{{ route('applicant.biodata.update') }}">
                        @csrf

                        {{-- Nama (disabled, dari auth) --}}
                        <div class="mb-4">
                            <x-input-label value="Nama" />
                            <x-text-input
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ Auth::user()->name }}"
                                disabled />
                        </div>

                        {{-- Email (disabled, dari auth) --}}
                        <div class="mb-4">
                            <x-input-label value="Email" />
                            <x-text-input
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ Auth::user()->email }}"
                                disabled />
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-4">
                            <x-input-label for="phone" value="Nomor HP" />
                            <x-text-input
                                id="phone"
                                name="phone"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="08xxxxxxxxxx"
                                value="{{ $profile->phone ?? '' }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        {{-- Skills --}}
                        <div class="mb-4">
                            <x-input-label for="skills" value="Skills" />
                            <textarea
                                id="skills"
                                name="skills"
                                rows="3"
                                placeholder="Contoh: PHP, Laravel, JavaScript, MySQL"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ $profile->skills ?? '' }}</textarea>
                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                        </div>

                        {{-- Pengalaman --}}
                        <div class="mb-4">
                            <x-input-label for="experience" value="Pengalaman Kerja" />
                            <textarea
                                id="experience"
                                name="experience"
                                rows="4"
                                placeholder="Contoh: 2 tahun sebagai Backend Developer di PT. ABC"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ $profile->experience ?? '' }}</textarea>
                            <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                        </div>

                        <x-primary-button>
                            Simpan Biodata
                        </x-primary-button>
                    </form>
                </div>
            </div>

            {{-- FORM UPLOAD CV --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Upload CV <span class="text-sm text-gray-500">(PDF, maks. 2MB)</span>
                    </h3>

                    {{-- Tampilkan CV jika sudah ada --}}
                    @if($profile && $profile->cv_path)
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                            <p class="text-sm text-blue-700">
                                CV saat ini:
                                <a href="{{ Storage::url($profile->cv_path) }}"
                                   target="_blank"
                                   class="font-semibold underline">
                                    Lihat CV
                                </a>
                            </p>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                            <p class="text-sm text-yellow-700">Belum ada CV yang diupload.</p>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('applicant.upload-cv') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="cv" value="Pilih File CV (PDF)" />
                            <input
                                type="file"
                                id="cv"
                                name="cv"
                                accept=".pdf"
                                class="mt-1 block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-indigo-50 file:text-indigo-700
                                       hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                        </div>

                        <x-primary-button>
                            Upload CV
                        </x-primary-button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>