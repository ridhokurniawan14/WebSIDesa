@extends('admin.layouts.main')
@section('title', 'Kelola Data Posyandu | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi Input yang Smooth */
        input,
        textarea,
        button,
        select {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Animasi Zoom Gambar */
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
        $prepArray = fn($val) => is_array($val) && count($val) > 0 ? $val : [''];
        $prepKontak = fn($val) => is_array($val) && count($val) > 0
            ? $val
            : [['nama' => '', 'jabatan' => '', 'telepon' => '']];

        $tujuan = $prepArray($posyandu?->tujuan);
        $layanan = $prepArray($posyandu?->layanan);
        $sasaran = $prepArray($posyandu?->sasaran);
        $program = $prepArray($posyandu?->program);
        $kader = $prepArray($posyandu?->nama_kader);
        $kontak = $prepKontak($posyandu?->kontak);

        $fotoUrl = $posyandu && $posyandu->gambar_struktur ? asset('storage/' . $posyandu->gambar_struktur) : null;
    @endphp

    <div class="w-full pb-12" x-data="{
        zoomOpen: false,
        photoPreview: '{{ $fotoUrl }}',
    
        // Init Data
        tujuan: {{ \Illuminate\Support\Js::from($tujuan) }},
        layanan: {{ \Illuminate\Support\Js::from($layanan) }},
        sasaran: {{ \Illuminate\Support\Js::from($sasaran) }},
        program: {{ \Illuminate\Support\Js::from($program) }},
        kader: {{ \Illuminate\Support\Js::from($kader) }},
        kontak: {{ \Illuminate\Support\Js::from($kontak) }},
    
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    
        addItem(arrayName) {
            if (arrayName === 'kontak') {
                this[arrayName].push({ nama: '', jabatan: '', telepon: '' });
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

        {{-- SECTION: HEADER HALAMAN --}}
        <div class="mb-10 border-b border-gray-100 dark:border-gray-800 pb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
                <div>
                    <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                        <span>Lembaga Desa</span> <span class="mx-2 text-gray-300">/</span> <span
                            class="text-gray-400">Posyandu</span>
                    </nav>
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="p-2 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        {{ $posyandu ? 'Edit Profil Posyandu' : 'Buat Profil Posyandu' }}
                    </h1>
                    <p class="mt-3 text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-2xl">
                        Kelola data profil Pos Pelayanan Terpadu (Posyandu), termasuk struktur kepengurusan, jadwal
                        kegiatan, program kerja, dan layanan kesehatan masyarakat.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3">
                    <button type="button" onclick="window.location.reload()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 cursor-pointer">
                        Reset
                    </button>
                    <button form="posyandu-form" type="submit"
                        class="px-7 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition-all active:scale-95 cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        {{ $posyandu ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- FORM START --}}
        <form id="posyandu-form" method="POST"
            action="{{ $posyandu ? route('admin.posyandu.update', $posyandu->id) : route('admin.posyandu.store') }}"
            enctype="multipart/form-data" class="space-y-8">

            @csrf
            @if ($posyandu)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI (2/3) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- CARD 1: INFORMASI UMUM --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        {{-- Header Card --}}
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-blue-600 rounded-full shadow-sm shadow-blue-200"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">Informasi
                                Dasar</h3>
                        </div>
                        {{-- Body Card --}}
                        <div class="p-8 space-y-6">
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Deskripsi
                                    / Profil Singkat</label>
                                <textarea name="deskripsi" rows="4"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                    placeholder="Jelaskan secara singkat tentang Posyandu di desa ini...">{{ old('deskripsi', $posyandu->deskripsi ?? '') }}</textarea>
                            </div>
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Jadwal
                                    Kegiatan Rutin</label>
                                <input type="text" name="jadwal" value="{{ old('jadwal', $posyandu->jadwal ?? '') }}"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                    placeholder="Contoh: Setiap tanggal 10 setiap bulan di Balai Desa">
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: PENGURUS INTI --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-pink-500 rounded-full shadow-sm shadow-pink-200"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">Struktur
                                Kepengurusan</h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block mb-3 text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Ketua
                                    Posyandu</label>
                                <input type="text" name="nama_ketua"
                                    value="{{ old('nama_ketua', $posyandu->nama_ketua ?? '') }}"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500"
                                    placeholder="Nama Ketua">
                            </div>
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Sekretaris</label>
                                <input type="text" name="nama_sekretaris"
                                    value="{{ old('nama_sekretaris', $posyandu->nama_sekretaris ?? '') }}"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500"
                                    placeholder="Nama Sekretaris">
                            </div>
                            <div>
                                <label
                                    class="block mb-3 text-xs font-bold text-gray-500 uppercase dark:text-gray-400">Bendahara</label>
                                <input type="text" name="nama_bendahara"
                                    value="{{ old('nama_bendahara', $posyandu->nama_bendahara ?? '') }}"
                                    class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-pink-500/20 focus:border-pink-500"
                                    placeholder="Nama Bendahara">
                            </div>
                        </div>
                    </div>

                    {{-- CARD 3: GRID LAYANAN & SASARAN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- LAYANAN --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-sm shadow-emerald-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                        Layanan</h3>
                                </div>
                                <button type="button" @click="addItem('layanan')"
                                    class="text-emerald-600 hover:bg-emerald-100 p-1.5 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-4 flex-1">
                                <template x-for="(item, index) in layanan" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="text" name="layanan[]" x-model="layanan[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                            placeholder="Contoh: Imunisasi">
                                        <button type="button" @click="removeItem('layanan', index)"
                                            class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- SASARAN --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-orange-500 rounded-full shadow-sm shadow-orange-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                        Sasaran</h3>
                                </div>
                                <button type="button" @click="addItem('sasaran')"
                                    class="text-orange-600 hover:bg-orange-100 p-1.5 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-4 flex-1">
                                <template x-for="(item, index) in sasaran" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="text" name="sasaran[]" x-model="sasaran[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                                            placeholder="Contoh: Balita">
                                        <button type="button" @click="removeItem('sasaran', index)"
                                            class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 4: GRID TUJUAN & PROGRAM --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- TUJUAN --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-purple-500 rounded-full shadow-sm shadow-purple-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                        Tujuan</h3>
                                </div>
                                <button type="button" @click="addItem('tujuan')"
                                    class="text-purple-600 hover:bg-purple-100 p-1.5 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-4 flex-1">
                                <template x-for="(item, index) in tujuan" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="text" name="tujuan[]" x-model="tujuan[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500"
                                            placeholder="Tujuan Posyandu...">
                                        <button type="button" @click="removeItem('tujuan', index)"
                                            class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- PROGRAM KERJA --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                            <div
                                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-1.5 h-6 bg-indigo-500 rounded-full shadow-sm shadow-indigo-200"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                        Program Kerja</h3>
                                </div>
                                <button type="button" @click="addItem('program')"
                                    class="text-indigo-600 hover:bg-indigo-100 p-1.5 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-4 flex-1">
                                <template x-for="(item, index) in program" :key="index">
                                    <div class="flex gap-2 group">
                                        <input type="text" name="program[]" x-model="program[index]"
                                            class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-xl dark:bg-gray-700 dark:border-gray-600 px-4 py-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500"
                                            placeholder="Nama Program...">
                                        <button type="button" @click="removeItem('program', index)"
                                            class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 5: KADER --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-teal-500 rounded-full shadow-sm shadow-teal-200"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                    Daftar Kader</h3>
                            </div>
                            <button type="button" @click="addItem('kader')"
                                class="text-xs font-bold text-teal-700 bg-teal-100 px-3 py-1.5 rounded-lg hover:bg-teal-200 transition-colors cursor-pointer shadow-sm">
                                + Tambah Kader
                            </button>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="(item, index) in kader" :key="index">
                                <div
                                    class="flex gap-3 items-center bg-gray-50 dark:bg-gray-900/50 p-2 rounded-xl border border-transparent hover:border-teal-200 dark:hover:border-teal-900 transition-colors">
                                    <span x-text="index+1+'.'" class="text-gray-400 font-bold text-sm pl-2"></span>
                                    <input type="text" name="nama_kader[]" x-model="kader[index]"
                                        class="block w-full text-sm text-gray-900 dark:text-white border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 bg-white dark:bg-gray-800"
                                        placeholder="Nama Kader...">
                                    <button type="button" @click="removeItem('kader', index)"
                                        class="text-gray-400 hover:text-red-500 p-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN (1/3) --}}
                <div class="space-y-8">

                    {{-- UPLOAD STRUKTUR --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1.5 h-6 bg-yellow-500 rounded-full shadow-sm shadow-yellow-200"></div>
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest">Bagan
                                Struktur</h3>
                        </div>
                        <div
                            class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-2xl p-6 flex flex-col items-center bg-gray-50 dark:bg-gray-900/50">
                            <div class="mb-6 w-full flex justify-center min-h-[150px] items-center">
                                <template x-if="photoPreview">
                                    <div class="relative group">
                                        <img :src="photoPreview"
                                            class="max-h-48 object-contain cursor-zoom-in drop-shadow-sm rounded-lg"
                                            @click="zoomOpen = true">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span
                                                class="bg-black/60 text-white text-[10px] px-2 py-1 rounded-full">Zoom</span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="flex flex-col items-center text-gray-300">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs">Belum ada gambar</span>
                                    </div>
                                </template>
                            </div>
                            <label class="w-full text-center">
                                <span
                                    class="block w-full py-3 px-4 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-xl cursor-pointer hover:bg-indigo-100 transition-colors uppercase tracking-wider border border-indigo-100">
                                    Pilih File Gambar
                                </span>
                                <input type="file" name="gambar_struktur" class="hidden" accept="image/*"
                                    @change="handleFileChange">
                            </label>
                            <p class="text-[10px] text-gray-400 mt-3 text-center">Format: JPG/PNG, Maks. 2MB</p>
                        </div>
                    </div>

                    {{-- KONTAK PERSON --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-rose-500 rounded-full shadow-sm shadow-rose-200"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-xs tracking-widest">
                                    Kontak Person</h3>
                            </div>
                            <button type="button" @click="addItem('kontak')"
                                class="text-rose-600 hover:bg-rose-100 p-1.5 rounded-lg transition-colors cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <template x-for="(item, index) in kontak" :key="index">
                                <div
                                    class="bg-white dark:bg-gray-900 p-4 rounded-xl relative border border-gray-200 dark:border-gray-600 shadow-sm group">
                                    <button type="button" @click="removeItem('kontak', index)"
                                        class="absolute top-2 right-2 text-gray-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <div class="space-y-4 mt-2">
                                        <div>
                                            <label class="text-[10px] uppercase text-gray-400 font-bold mb-2 block">Nama
                                                Lengkap</label>
                                            <input type="text" :name="`kontak[${index}][nama]`" x-model="item.nama"
                                                class="block w-full text-xs text-gray-900 dark:text-white border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2.5 focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                                placeholder="Nama..">
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label
                                                    class="text-[10px] uppercase text-gray-400 font-bold mb-2 block">Jabatan</label>
                                                <input type="text" :name="`kontak[${index}][jabatan]`"
                                                    x-model="item.jabatan"
                                                    class="block w-full text-xs text-gray-900 dark:text-white border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2.5 focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                                    placeholder="Jabatan..">
                                            </div>
                                            <div>
                                                <label
                                                    class="text-[10px] uppercase text-gray-400 font-bold mb-2 block">WhatsApp</label>
                                                <input type="text" :name="`kontak[${index}][telepon]`"
                                                    x-model="item.telepon"
                                                    class="block w-full text-xs text-gray-900 dark:text-white border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2.5 focus:ring-1 focus:ring-rose-500 focus:border-rose-500"
                                                    placeholder="08xx..">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        {{-- MODAL ZOOM (LIGHTBOX) --}}
        <div x-show="zoomOpen" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 backdrop-blur-sm"
            style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <button @click="zoomOpen = false"
                class="absolute top-5 right-5 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors cursor-pointer z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="relative max-w-7xl max-h-screen p-4" @click.away="zoomOpen = false">
                <img :src="photoPreview"
                    class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl zoom-enter">
            </div>
        </div>

    </div>
@endsection
