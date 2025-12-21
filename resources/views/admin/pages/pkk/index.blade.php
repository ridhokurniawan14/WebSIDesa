@extends('admin.layouts.main')
@section('title', 'Kelola Data PKK | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi halus */
        input,
        textarea,
        button,
        select,
        div,
        span,
        img,
        label {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    {{-- PHP Logic: Prepare Data (ROBUST WAY) --}}
    @php
        $pengurusRaw = $pkk?->pengurus ?? [];
        $pengurus = [];

        // LOGIC BARU: Siapkan semua data di server-side agar client-side (JS) ringan
        if (count($pengurusRaw) > 0) {
            foreach ($pengurusRaw as $item) {
                // Pastikan key ada, pakai fallback null/kosong
                $photoUrl = $item['photo_url'] ?? null;
                $nama = $item['nama'] ?? '';

                // Tentukan URL awal: jika ada di DB pakai storage, jika tidak pakai Avatar
                $initialPreview = $photoUrl
                    ? asset('storage/' . $photoUrl)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($nama ?: 'X') . '&background=random&color=fff';

                $pengurus[] = [
                    'jabatan' => $item['jabatan'] ?? '',
                    'nama' => $nama,
                    'photo_url' => $photoUrl, // Path relatif untuk hidden input
                    'initial_preview' => $initialPreview, // URL lengkap untuk tampilan awal img src
                ];
            }
        } else {
            // Default row kosong jika belum ada data
            $pengurus[] = [
                'jabatan' => '',
                'nama' => '',
                'photo_url' => null,
                'initial_preview' => 'https://ui-avatars.com/api/?name=X&background=random&color=fff',
            ];
        }

        $kegiatanDB = $pkk?->kegiatan ?? [];
        $kegiatan = count($kegiatanDB) > 0 ? $kegiatanDB : [''];

        $programDB = $pkk?->program_pokok ?? [];
        $programPokok = count($programDB) > 0 ? $programDB : [''];

        $ilustrasiUrl = $pkk && $pkk->gambar_ilustrasi ? asset('storage/' . $pkk->gambar_ilustrasi) : null;
    @endphp

    <div class="w-full pb-12" x-data="{
        zoomOpen: false,
        mainPhotoPreview: '{{ $ilustrasiUrl }}',
        // Data sudah matang dari PHP, Alpine tinggal pakai
        pengurus: {{ \Illuminate\Support\Js::from($pengurus) }},
        kegiatan: {{ \Illuminate\Support\Js::from($kegiatan) }},
        programPokok: {{ \Illuminate\Support\Js::from($programPokok) }},
    
        handleMainFile(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.mainPhotoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    
        // LOGIC PREVIEW FOTO PENGURUS (DIRECT DOM)
        handlePengurusFile(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Cari elemen gambar berdasarkan ID unik
                    const imgElement = document.getElementById('preview-' + index);
                    // Langsung ganti src-nya (bypass Alpine reactivity agar instan)
                    if (imgElement) {
                        imgElement.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        },
    
        addItem(type) {
            if (type === 'pengurus') {
                this.pengurus.push({
                    jabatan: '',
                    nama: '',
                    photo_url: null,
                    // Set default avatar untuk item baru
                    initial_preview: 'https://ui-avatars.com/api/?name=X&background=random&color=fff'
                });
            }
            if (type === 'kegiatan') this.kegiatan.push('');
            if (type === 'programPokok') this.programPokok.push('');
        },
    
        removeItem(type, index) {
            if (this[type].length > 1) {
                this[type].splice(index, 1);
            } else {
                alert('Minimal satu data harus tersedia!');
            }
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-pink-500">
                    <span>Lembaga Desa</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">PKK</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-pink-600 rounded-lg text-white shadow-lg shadow-pink-200 dark:shadow-pink-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    {{ $pkk ? 'Edit Profil PKK' : 'Buat Profil PKK' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Kelola data kepengurusan, kegiatan, dan program pokok PKK.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-all shadow-sm cursor-pointer">
                    Reset
                </button>

                @can('pkk.update')
                    <button form="pkk-form" type="submit"
                        class="px-6 py-2.5 bg-pink-600 hover:bg-pink-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-pink-200 dark:shadow-pink-900/50 transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Data
                    </button>
                @endcan
            </div>
        </div>

        {{-- FORM START (Autocomplete OFF) --}}
        <form id="pkk-form" method="POST" autocomplete="off"
            action="{{ $pkk ? route('admin.pkk.update', $pkk->id) : route('admin.pkk.store') }}"
            enctype="multipart/form-data" class="space-y-8">

            @csrf
            @if ($pkk)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI (DATA UTAMA) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- CARD 1: PROFIL KETUA --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-pink-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Profil
                                Ketua & Kontak</h3>
                        </div>

                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama
                                    Ketua PKK</label>
                                <input type="text" name="nama_ketua"
                                    value="{{ old('nama_ketua', $pkk->nama_ketua ?? '') }}"
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="Nama Lengkap Ketua">
                                <p class="mt-1 text-[10px] text-gray-400">Masukkan nama lengkap beserta gelar jika ada.</p>
                            </div>

                            {{-- Input Nomor HP dengan Prefix + --}}
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nomor
                                    HP / WA</label>
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center justify-center px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-r-0 border-gray-200 rounded-l-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 font-bold select-none h-[46px]">
                                        +
                                    </span>
                                    <input type="number" name="nomor_hp_wa"
                                        value="{{ old('nomor_hp_wa', $pkk->nomor_hp_wa ?? '') }}"
                                        class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-r-lg px-4 py-3 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors h-[46px]"
                                        placeholder="628123456789">
                                </div>
                                <p class="mt-1 text-[10px] text-gray-400">Gunakan format internasional (awali dengan 62).
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: PENGURUS INTI (REPEATER) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Struktur Pengurus</h3>
                            </div>
                            <button type="button" @click="addItem('pengurus')"
                                class="text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 px-4 py-2 rounded-lg hover:bg-indigo-100 hover:text-indigo-800 dark:text-indigo-200 dark:bg-indigo-900/50 dark:border-indigo-700 dark:hover:bg-indigo-900 dark:hover:text-white transition-all cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Personil
                            </button>
                        </div>

                        <div class="p-8 space-y-4">
                            <template x-for="(item, index) in pengurus" :key="index">
                                <div
                                    class="bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700 relative group transition-all hover:border-gray-300 dark:hover:border-gray-600">
                                    <div class="flex flex-col md:flex-row items-start gap-6">

                                        {{-- Foto Upload Circle --}}
                                        <div class="flex-shrink-0 relative mt-1">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden border-2 border-white dark:border-gray-600 shadow-sm relative group/img">

                                                {{-- 
                                                    LOGIC TAMPIL FOTO:
                                                    1. Beri ID unik: 'preview-' + index
                                                    2. Gunakan item.initial_preview yang sudah disiapkan PHP.
                                                    AlpineJS hanya me-render awal, selanjutnya handlePengurusFile yang ambil alih via DOM.
                                                --}}
                                                <img :id="'preview-' + index" :src="item.initial_preview"
                                                    class="w-full h-full object-cover transition-opacity duration-300">

                                                {{-- Overlay --}}
                                                <div
                                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <label
                                                class="absolute -bottom-1 -right-1 cursor-pointer bg-white dark:bg-gray-700 text-gray-600 dark:text-white p-1.5 rounded-full border border-gray-200 dark:border-gray-600 hover:bg-pink-500 hover:text-white dark:hover:bg-pink-600 hover:border-pink-500 transition-colors shadow-md z-10"
                                                title="Ganti Foto">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <input type="file" :name="`pengurus[${index}][photo_file]`"
                                                    class="hidden" accept="image/*"
                                                    @change="handlePengurusFile($event, index)">
                                                <input type="hidden" :name="`pengurus[${index}][photo_url_old]`"
                                                    :value="item.photo_url">
                                            </label>
                                        </div>

                                        {{-- Inputs --}}
                                        <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                                            <div>
                                                <label
                                                    class="block mb-1.5 text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Jabatan</label>
                                                <input type="text" :name="`pengurus[${index}][jabatan]`"
                                                    x-model="item.jabatan"
                                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white placeholder-gray-400 h-[42px]"
                                                    placeholder="Contoh: Sekretaris">
                                                <p
                                                    class="mt-1 text-[10px] text-gray-400 hidden group-hover:block transition-all">
                                                    Jabatan struktural PKK.</p>
                                            </div>
                                            <div>
                                                <label
                                                    class="block mb-1.5 text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                                                    Lengkap</label>
                                                <input type="text" :name="`pengurus[${index}][nama]`"
                                                    x-model="item.nama"
                                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white placeholder-gray-400 h-[42px]"
                                                    placeholder="Nama Personil">
                                                <p
                                                    class="mt-1 text-[10px] text-gray-400 hidden group-hover:block transition-all">
                                                    Nama lengkap personil.</p>
                                            </div>
                                        </div>

                                        {{-- Delete Button --}}
                                        <div class="flex-shrink-0">
                                            {{-- Dummy label agar tombol lurus --}}
                                            <label
                                                class="block mb-1.5 text-[10px] font-bold uppercase opacity-0 select-none">Hp</label>

                                            <button type="button" @click="removeItem('pengurus', index)"
                                                class="h-[42px] w-[42px] flex items-center justify-center text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded-lg dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 dark:hover:border-red-900 transition-all cursor-pointer shadow-sm"
                                                title="Hapus Personil">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- CARD 3: KEGIATAN & PROGRAM --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kegiatan --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full">
                            <div
                                class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-sm uppercase tracking-widest">
                                        Daftar Kegiatan</h3>
                                </div>
                                <button type="button" @click="addItem('kegiatan')"
                                    class="text-emerald-600 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg dark:text-emerald-400 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 transition-colors cursor-pointer"><svg
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg></button>
                            </div>
                            <div class="p-6 space-y-3">
                                <template x-for="(item, index) in kegiatan" :key="index">
                                    <div class="flex flex-col gap-1 group">
                                        <div class="flex gap-2">
                                            <input type="text" name="kegiatan[]" x-model="kegiatan[index]"
                                                class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                                placeholder="Nama Kegiatan...">
                                            <button type="button" @click="removeItem('kegiatan', index)"
                                                class="text-gray-400 hover:text-red-500 p-2 transition-colors cursor-pointer"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg></button>
                                        </div>
                                        <p class="text-[9px] text-gray-400 hidden group-hover:block transition-all ml-1">
                                            Nama kegiatan rutin/insidentil.</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Program Pokok --}}
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full">
                            <div
                                class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-1.5 h-8 bg-blue-500 rounded-full"></div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-sm uppercase tracking-widest">
                                        10 Program Pokok</h3>
                                </div>
                                <button type="button" @click="addItem('programPokok')"
                                    class="text-blue-600 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-colors cursor-pointer"><svg
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg></button>
                            </div>
                            <div class="p-6 space-y-3">
                                <template x-for="(item, index) in programPokok" :key="index">
                                    <div class="flex flex-col gap-1 group">
                                        <div class="flex gap-2">
                                            <span
                                                class="flex items-center text-gray-400 text-xs font-mono w-6 justify-center"
                                                x-text="index+1+'.'"></span>
                                            <input type="text" name="program_pokok[]" x-model="programPokok[index]"
                                                class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                                placeholder="Program Pokok...">
                                            <button type="button" @click="removeItem('programPokok', index)"
                                                class="text-gray-400 hover:text-red-500 p-2 transition-colors cursor-pointer"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg></button>
                                        </div>
                                        <p class="text-[9px] text-gray-400 hidden group-hover:block transition-all ml-8">
                                            Isi sesuai 10 Program Pokok PKK.</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (GAMBAR UTAMA) --}}
                <div class="space-y-8">
                    {{-- UPLOAD ILUSTRASI UTAMA --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-purple-500 rounded-full"></div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest">Ilustrasi
                                Kegiatan</h3>
                        </div>
                        <div class="p-8">
                            <div
                                class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-900 hover:border-purple-400 dark:hover:border-purple-500 transition-colors relative group/upload h-[300px]">
                                {{-- Preview Image --}}
                                <div class="relative w-full h-full flex items-center justify-center">
                                    <template x-if="mainPhotoPreview && mainPhotoPreview !== ''">
                                        <div class="relative w-full h-full">
                                            <img :src="mainPhotoPreview"
                                                class="w-full h-full object-contain cursor-zoom-in"
                                                @click="zoomOpen = true">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-0 group-hover/upload:opacity-100 transition-opacity">
                                                <span
                                                    class="bg-black/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm shadow-lg">Ganti
                                                    Gambar</span>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!mainPhotoPreview || mainPhotoPreview === ''">
                                        <div class="flex flex-col items-center text-gray-400 dark:text-gray-500">
                                            <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-full mb-3 shadow-inner">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span
                                                class="text-xs uppercase font-bold tracking-widest text-purple-500 dark:text-purple-400">Pilih
                                                Gambar</span>
                                            <span class="text-[10px] text-gray-400 mt-2">Max. 2MB (JPG/PNG)</span>
                                        </div>
                                    </template>
                                </div>
                                <input type="file" name="gambar_ilustrasi"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                                    @change="handleMainFile">
                            </div>
                            <p class="text-center text-[10px] text-gray-400 mt-3">Gambar ini akan tampil di halaman depan
                                website PKK.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- MODAL ZOOM (LIGHTBOX) --}}
        <div x-show="zoomOpen"
            class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
            <button @click="zoomOpen = false"
                class="absolute top-5 right-5 text-gray-400 hover:text-white bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors cursor-pointer z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="relative max-w-7xl max-h-screen" @click.away="zoomOpen = false">
                <img :src="mainPhotoPreview"
                    class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl zoom-enter">
            </div>
        </div>
    </div>
@endsection
