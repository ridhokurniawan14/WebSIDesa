@extends('admin.layouts.main')
@section('title', 'Kelola Data LPMD | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        input,
        textarea,
        button,
        select {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        /* Animasi Zoom */
        .zoom-enter {
            animation: zoomIn 0.2s ease-out forwards;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    {{-- LOGIC PHP: Menyiapkan Data --}}
    @php
        $bidangDB = $lpmd?->bidang ?? [];
        $programDB = $lpmd?->program ?? [];
        $dasarHukumDB = $lpmd?->dasar_hukum ?? [];
        $tugasFungsiDB = $lpmd?->tugas_fungsi ?? [];

        // Paksa minimal 1 baris kosong jika data null
        $bidang = count($bidangDB) > 0 ? $bidangDB : [['nama_bidang' => '', 'penanggung_jawab' => '']];
        $program = count($programDB) > 0 ? $programDB : [''];
        $dasarHukum = count($dasarHukumDB) > 0 ? $dasarHukumDB : [''];
        $tugasFungsi = count($tugasFungsiDB) > 0 ? $tugasFungsiDB : [''];

        $fotoUrl = $lpmd && $lpmd->struktur_gambar ? asset('storage/' . $lpmd->struktur_gambar) : null;
    @endphp

    {{-- Main Container --}}
    <div class="w-full pb-12" x-data="{
        // Logic Zoom
        zoomOpen: false,
    
        // Logic Gambar
        photoPreview: '{{ $fotoUrl }}',
    
        // Init Repeater
        bidang: {{ \Illuminate\Support\Js::from($bidang) }},
        program: {{ \Illuminate\Support\Js::from($program) }},
        dasarHukum: {{ \Illuminate\Support\Js::from($dasarHukum) }},
        tugasFungsi: {{ \Illuminate\Support\Js::from($tugasFungsi) }},
    
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    
        addItem(arrayName) {
            if (arrayName === 'bidang') {
                this[arrayName].push({ nama_bidang: '', penanggung_jawab: '' });
            } else {
                this[arrayName].push('');
            }
        },
    
        removeItem(arrayName, index) {
            if (this[arrayName].length > 1) {
                this[arrayName].splice(index, 1);
            } else {
                alert('Minimal satu data harus tersedia!');
            }
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-100 dark:border-gray-800 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Lembaga Desa</span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">LPMD</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    {{ $lpmd ? 'Edit Profil LPMD' : 'Buat Profil LPMD' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Kelola struktur organisasi, program kerja, dan tupoksi LPMD.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 cursor-pointer">
                    Reset
                </button>
                <button form="lpmd-form" type="submit"
                    class="px-7 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition-all focus:ring-4 focus:ring-indigo-100 active:scale-95 cursor-pointer">
                    {{ $lpmd ? 'Simpan Perubahan' : 'Simpan Data' }}
                </button>
            </div>
        </div>

        {{-- FORM START --}}
        <form id="lpmd-form" method="POST"
            action="{{ $lpmd ? route('admin.lpmd.update', $lpmd->id) : route('admin.lpmd.store') }}"
            enctype="multipart/form-data" class="space-y-8">

            @csrf
            @if ($lpmd)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI (2/3) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- CARD 1: PENGURUS INTI --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        {{-- Header Card --}}
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm shadow-blue-200"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">Pengurus
                                Inti</h3>
                        </div>

                        {{-- Body Card with GAP-6 (24px) --}}
                        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- Input Item: Ketua --}}
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-600 uppercase dark:text-gray-400">Ketua</label>
                                <input type="text" name="ketua" value="{{ old('ketua', $lpmd->ketua ?? '') }}"
                                    placeholder="Nama Ketua"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            {{-- Input Item: Sekretaris --}}
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-600 uppercase dark:text-gray-400">Sekretaris</label>
                                <input type="text" name="sekretaris"
                                    value="{{ old('sekretaris', $lpmd->sekretaris ?? '') }}" placeholder="Nama Sekretaris"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            {{-- Input Item: Bendahara --}}
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-600 uppercase dark:text-gray-400">Bendahara</label>
                                <input type="text" name="bendahara"
                                    value="{{ old('bendahara', $lpmd->bendahara ?? '') }}" placeholder="Nama Bendahara"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            {{-- Input Item: Deskripsi --}}
                            <div class="md:col-span-3">
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-600 uppercase dark:text-gray-400">Deskripsi
                                    Singkat</label>
                                <textarea name="deskripsi" rows="3" placeholder="Penjelasan singkat tentang LPMD..."
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('deskripsi', $lpmd->deskripsi ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: BIDANG (REPEATER) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-sm shadow-emerald-200"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">Bidang
                                    & Seksi</h3>
                            </div>
                            <button type="button" @click="addItem('bidang')"
                                class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3 py-1.5 rounded-lg hover:bg-emerald-200 transition-colors cursor-pointer shadow-sm">
                                + Tambah
                            </button>
                        </div>
                        <div class="p-8 space-y-6"> {{-- space-y-6 (24px) antar item repeater --}}
                            <template x-for="(item, index) in bidang" :key="index">
                                <div
                                    class="flex flex-col md:flex-row gap-6 items-end bg-slate-50 dark:bg-gray-900/50 p-5 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                                    <div class="w-full">
                                        <label
                                            class="block mb-3 text-[10px] font-bold text-gray-500 uppercase dark:text-gray-400">Nama
                                            Bidang</label>
                                        <input type="text" :name="`bidang[${index}][nama_bidang]`"
                                            x-model="item.nama_bidang" placeholder="Contoh: Bidang Keagamaan"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    </div>
                                    <div class="w-full">
                                        <label
                                            class="block mb-3 text-[10px] font-bold text-gray-500 uppercase dark:text-gray-400">Penanggung
                                            Jawab</label>
                                        <input type="text" :name="`bidang[${index}][penanggung_jawab]`"
                                            x-model="item.penanggung_jawab" placeholder="Nama PJ"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    </div>
                                    <button type="button" @click="removeItem('bidang', index)"
                                        class="p-2.5 bg-white dark:bg-gray-800 text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm transition-colors cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- CARD 3: PROGRAM & DASAR HUKUM --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Program --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-purple-500 rounded-full shadow-sm shadow-purple-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-xs uppercase tracking-widest">
                                        Program Kerja</h3>
                                </div>
                                <button type="button" @click="addItem('program')"
                                    class="text-purple-600 hover:bg-purple-100 p-1.5 rounded-lg transition-colors cursor-pointer"><svg
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg></button>
                            </div>
                            <div class="p-6 space-y-4">
                                <template x-for="(item, index) in program" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="program[]" x-model="program[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-2.5 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500"
                                            placeholder="Nama Program...">
                                        <button type="button" @click="removeItem('program', index)"
                                            class="text-gray-400 hover:text-red-500 cursor-pointer p-1"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        {{-- Dasar Hukum --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-orange-500 rounded-full shadow-sm shadow-orange-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-xs uppercase tracking-widest">
                                        Dasar Hukum</h3>
                                </div>
                                <button type="button" @click="addItem('dasarHukum')"
                                    class="text-orange-600 hover:bg-orange-100 p-1.5 rounded-lg transition-colors cursor-pointer"><svg
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg></button>
                            </div>
                            <div class="p-6 space-y-4">
                                <template x-for="(item, index) in dasarHukum" :key="index">
                                    <div class="flex gap-2">
                                        <input type="text" name="dasar_hukum[]" x-model="dasarHukum[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-2.5 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                                            placeholder="UU / Permendagri...">
                                        <button type="button" @click="removeItem('dasarHukum', index)"
                                            class="text-gray-400 hover:text-red-500 cursor-pointer p-1"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- CARD TUGAS FUNGSI --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-indigo-500 rounded-full shadow-sm shadow-indigo-200"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-xs uppercase tracking-widest">Tugas
                                    & Fungsi</h3>
                            </div>
                            <button type="button" @click="addItem('tugasFungsi')"
                                class="text-indigo-600 hover:bg-indigo-100 p-1.5 rounded-lg transition-colors cursor-pointer"><svg
                                    class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg></button>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Gap 6 antar kolom --}}
                            <template x-for="(item, index) in tugasFungsi" :key="index">
                                <div class="flex gap-2 items-center">
                                    <span class="text-gray-400 font-mono text-xs w-5" x-text="index+1+'.'"></span>
                                    <input type="text" name="tugas_fungsi[]" x-model="tugasFungsi[index]"
                                        class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                                        placeholder="Uraian tugas...">
                                    <button type="button" @click="removeItem('tugasFungsi', index)"
                                        class="text-gray-400 hover:text-red-500 cursor-pointer p-1"><svg class="w-4 h-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (1/3) --}}
                <div class="space-y-8">
                    {{-- UPLOAD STRUKTUR (DENGAN ZOOM) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1.5 h-6 bg-pink-500 rounded-full shadow-sm shadow-pink-200"></div>
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest">Struktur
                                Organisasi</h3>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-2xl bg-gray-50 dark:bg-gray-900/50 group/upload overflow-hidden relative">
                            {{-- Preview Image --}}
                            <div class="relative group/img mb-4 flex items-center justify-center min-h-[140px] w-full">
                                <template x-if="photoPreview && photoPreview !== ''">
                                    <div class="relative w-full">
                                        <img :src="photoPreview"
                                            class="h-40 w-full object-contain drop-shadow-sm cursor-zoom-in hover:scale-105 transition-transform duration-300"
                                            @click="zoomOpen = true" title="Klik untuk memperbesar">
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <span
                                                class="bg-black/50 text-white text-[10px] px-2 py-1 rounded-full opacity-0 group-hover/img:opacity-100 transition-opacity">Klik
                                                untuk Zoom</span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!photoPreview || photoPreview === ''">
                                    <div
                                        class="h-32 w-32 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <label class="w-full text-center">
                                <span
                                    class="block w-full py-2.5 px-4 bg-indigo-50 text-indigo-700 text-[11px] font-bold rounded-xl cursor-pointer hover:bg-indigo-100 transition-colors">PILIH
                                    GAMBAR</span>
                                <input type="file" name="struktur_gambar" class="hidden" accept="image/*"
                                    @change="handleFileChange">
                            </label>
                        </div>
                    </div>

                    {{-- TIPS PANEL --}}
                    <div
                        class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white shadow-xl shadow-indigo-200 dark:shadow-none relative overflow-hidden group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500/20 group-hover:scale-110 transition-transform"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <h4 class="text-sm font-bold uppercase tracking-widest mb-2">Tips Pengisian</h4>
                        <p class="text-xs text-indigo-100 leading-relaxed relative z-10 mb-2">
                            1. Gunakan tombol <strong>(+)</strong> untuk menambah baris jika lebih dari satu.
                        </p>
                        <p class="text-xs text-indigo-100 leading-relaxed relative z-10">
                            2. Format gambar yang disarankan adalah JPG/PNG dengan ukuran maks 2MB.
                        </p>
                    </div>
                </div>
            </div>
        </form>

        {{-- MODAL ZOOM (LIGHTBOX) --}}
        <div x-show="zoomOpen" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">

            {{-- Tombol Close --}}
            <button @click="zoomOpen = false"
                class="absolute top-5 right-5 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors cursor-pointer z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            {{-- Gambar Zoom --}}
            <div class="relative max-w-7xl max-h-screen p-4" @click.away="zoomOpen = false">
                <img :src="photoPreview"
                    class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl zoom-enter">
            </div>
        </div>

    </div>
@endsection
