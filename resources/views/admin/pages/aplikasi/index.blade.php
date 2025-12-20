@extends('admin.layouts.main')
@section('title', 'Setting Aplikasi | Admin Panel')

@section('content')
    {{-- Kontainer Full Width --}}
    <div class="w-full pb-12">
        {{-- HEADER SECTION --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-100 dark:border-gray-800 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Konfigurasi Sistem</span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Pengaturan Umum</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Identitas Aplikasi
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Kelola informasi publik, kontak, dan aset visual instansi Anda dalam satu tempat.
                </p>
            </div>

            @can('aplikasi.update')
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.location.reload()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 cursor-pointer">
                        Reset
                    </button>
                    <button form="main-form" type="submit"
                        class="px-7 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition-all focus:ring-4 focus:ring-indigo-100 active:scale-95 cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            @endcan
        </div>

        <form id="main-form" method="POST" enctype="multipart/form-data"
            action="{{ $aplikasi ? route('aplikasi.update', $aplikasi->id) : route('aplikasi.store') }}" class="space-y-8">
            @csrf
            @if ($aplikasi)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: FORM UTAMA --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Card 1: Informasi Dasar --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden group transition-all hover:shadow-md">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-indigo-600 rounded-full"></div>
                                <h3 class="font-bold text-gray-800 dark:text-white uppercase text-xs tracking-widest">Profil
                                    Desa & Instansi</h3>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama
                                        Desa</label>
                                    <input type="text" name="nama_desa" autocomplete="off"
                                        value="{{ old('nama_desa', $aplikasi->nama_desa ?? '') }}"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="Contoh: Desa Makmur Sejahtera">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Kabupaten</label>
                                    <input type="text" name="kabupaten" autocomplete="off"
                                        value="{{ old('kabupaten', $aplikasi->kabupaten ?? '') }}"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="Contoh: Kabupaten Bekasi">
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama
                                        Kantor Desa</label>
                                    <input type="text" name="nama_kantor" autocomplete="off"
                                        value="{{ old('nama_kantor', $aplikasi->nama_kantor ?? '') }}"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="Contoh: Kantor Kepala Desa Makmur Sejahtera">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Telepon</label>
                                    <input type="text" name="telepon" autocomplete="off"
                                        value="{{ old('telepon', $aplikasi->telepon ?? '') }}"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="Contoh: (021) 8899xxx atau 0812xxxx">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Email
                                        Resmi</label>
                                    <input type="email" name="email" value="{{ old('email', $aplikasi->email ?? '') }}"
                                        autocomplete="off"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="admin@desamakmur.go.id">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Alamat & Lokasi --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-red-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800 dark:text-white uppercase text-xs tracking-widest">Alamat
                                    & Lokasi Fisik</h3>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Alamat
                                    Lengkap</label>
                                <textarea name="alamat" rows="3"
                                    class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                    placeholder="Tuliskan alamat lengkap kantor desa, RT/RW, dan kode pos...">{{ old('alamat', $aplikasi->alamat ?? '') }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400 flex items-center gap-2">
                                    Google Maps (Embed Code)
                                    <span
                                        class="bg-indigo-100 text-indigo-600 text-[9px] px-2 py-0.5 rounded-full font-extrabold uppercase tracking-tighter">Opsional</span>
                                </label>
                                <textarea name="map" rows="3"
                                    class="block w-full text-[11px] font-mono border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all bg-gray-50 dark:bg-gray-900"
                                    placeholder="Tempelkan kode <iframe> dari fitur 'Sematkan Peta' di Google Maps...">{{ old('map', $aplikasi->map ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Media Sosial --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:shadow-md">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800 dark:text-white uppercase text-xs tracking-widest">Media
                                    Sosial & Chat</h3>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">WhatsApp
                                    (CS)</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 text-sm font-semibold">+</span>
                                    <input type="text" name="wa_cs" autocomplete="off"
                                        value="{{ old('wa_cs', $aplikasi->wa_cs ?? '') }}"
                                        class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-8 pr-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                        placeholder="Contoh: 62812345678">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Facebook
                                    Page</label>
                                <input type="text" name="facebook" autocomplete="off"
                                    value="{{ old('facebook', $aplikasi->facebook ?? '') }}"
                                    class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                    placeholder="Contoh: www.facebook.com/Kembiritan7">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Instagram</label>
                                <input type="text" name="instagram" autocomplete="off"
                                    value="{{ old('instagram', $aplikasi->instagram ?? '') }}"
                                    class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                    placeholder="Contoh: https://www.instagram.com/kembiritan7">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Youtube
                                    Channel</label>
                                <input type="text" name="youtube" autocomplete="off"
                                    value="{{ old('youtube', $aplikasi->youtube ?? '') }}"
                                    class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                    placeholder="Link channel youtube desa...">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: ASSET & INFO --}}
                <div class="space-y-8">

                    {{-- Logo Card dengan Preview Dinamis --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-all hover:shadow-md">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                            <h3 class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-widest">Logo
                                Instansi</h3>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-100 dark:border-gray-700 rounded-2xl bg-gray-50/30 dark:bg-gray-900/50 group/upload transition-all hover:border-indigo-300 overflow-hidden">

                            {{-- Area Preview --}}
                            <div id="logo-preview-container"
                                class="relative group/img mb-4 flex items-center justify-center min-h-[128px] w-full">
                                @if ($aplikasi && $aplikasi->logo)
                                    <img id="logo-preview-img" src="{{ asset('storage/' . $aplikasi->logo) }}"
                                        class="h-32 w-auto object-contain drop-shadow-md transition-transform group-hover/img:scale-105">
                                @else
                                    <div id="logo-placeholder"
                                        class="h-28 w-28 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-300 group-hover/upload:text-indigo-400 transition-colors">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    {{-- Hidden Image Tag untuk Preview Baru --}}
                                    <img id="logo-preview-img" src=""
                                        class="hidden h-32 w-auto object-contain drop-shadow-md transition-transform group-hover/img:scale-105">
                                @endif
                            </div>

                            <label class="w-full text-center">
                                <span
                                    class="block w-full py-2.5 px-4 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 text-[11px] font-bold rounded-xl cursor-pointer hover:bg-indigo-100 transition-colors">
                                    PILIH LOGO BARU
                                </span>
                                <input type="file" name="logo" id="logo-input" class="hidden" accept="image/*"
                                    onchange="previewLogo(event)">
                            </label>
                            <p class="mt-3 text-[10px] text-gray-400 text-center leading-relaxed italic">Disarankan format
                                PNG transparan.<br>Ukuran maksimal 2MB.</p>
                        </div>
                    </div>

                    {{-- Footer Info Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-all hover:shadow-md">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-6 bg-orange-400 rounded-full"></div>
                            <h3 class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-widest">Teks Kaki
                                (Footer)</h3>
                        </div>
                        <div class="space-y-3">
                            <textarea name="footer" rows="3"
                                class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                placeholder="Website resmi informasi pelayanan dan publikasi Desa Cipta Makmur. Melayani dengan integritas.">{{ old('footer', $aplikasi->footer ?? '') }}</textarea>
                            <div class="flex items-start gap-2 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[10px] text-blue-700 dark:text-blue-300 italic leading-snug">Teks ini akan
                                    muncul secara otomatis di bagian paling bawah website Anda.</p>
                            </div>
                        </div>
                    </div>
                    {{-- Jam Operasional Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 transition-all hover:shadow-md">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-6 bg-yellow-500 rounded-full"></div>
                            <h3 class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-widest">Jam
                                Operasional</h3>
                        </div>
                        <div class="space-y-3">
                            <textarea name="jam_operasional" rows="3"
                                class="block w-full text-sm border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                                placeholder="Contoh: Senin - Kamis: 08:00 - 15:30&#10;Jumat: 08:00 - 11:30&#10;Sabtu - Minggu: Tutup">{{ old('jam_operasional', $aplikasi->jam_operasional ?? '') }}</textarea>
                            <p class="text-[10px] text-gray-500 italic leading-snug">Gunakan baris baru (Enter) untuk
                                memisahkan jadwal antar hari agar rapi.</p>
                        </div>
                    </div>
                    {{-- Tips Panel --}}
                    <div
                        class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white shadow-xl shadow-indigo-200 dark:shadow-none relative overflow-hidden group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500/20 group-hover:scale-110 transition-transform"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <h4 class="text-sm font-bold uppercase tracking-widest mb-2">Tips</h4>
                        <p class="text-xs text-indigo-100 leading-relaxed relative z-10">
                            Pastikan Nomor WhatsApp menggunakan kode negara (Contoh: 62812...) agar link "Klik untuk Chat"
                            di website publik berfungsi dengan baik.
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- Script JavaScript untuk Live Preview --}}
    <script>
        function previewLogo(event) {
            const input = event.target;
            const previewImg = document.getElementById('logo-preview-img');
            const placeholder = document.getElementById('logo-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Update sumber gambar
                    previewImg.src = e.target.result;

                    // Tampilkan gambar preview
                    previewImg.classList.remove('hidden');

                    // Sembunyikan placeholder jika ada
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        /* Transisi Halus Global */
        input,
        textarea,
        button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Kustomisasi Scrollbar Textarea */
        textarea::-webkit-scrollbar {
            width: 4px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        /* Iframe Responsif */
        iframe {
            width: 100% !important;
            border-radius: 1rem;
            border: 1px solid #f3f4f6;
        }
    </style>
@endsection
