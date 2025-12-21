@extends('admin.layouts.main')
@section('title', 'Kelola Karang Taruna | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi halus global */
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

        /* Custom scrollbar untuk textarea */
        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-track {
            background: transparent;
        }

        textarea::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .dark textarea::-webkit-scrollbar-thumb {
            background-color: #475569;
        }
    </style>

    {{-- PHP Logic: Prepare Data --}}
    @php
        // Helper Avatar
        function getAvatar($name)
        {
            return 'https://ui-avatars.com/api/?name=' . urlencode($name ?: 'X') . '&background=random&color=fff';
        }

        // 1. Pengurus
        $pengurusRaw = $karangTaruna?->pengurus ?? [];
        $pengurus = [];
        if (count($pengurusRaw) > 0) {
            foreach ($pengurusRaw as $item) {
                $path = $item['gambar'] ?? null;
                $pengurus[] = [
                    'jabatan' => $item['jabatan'] ?? '',
                    'nama' => $item['nama'] ?? '',
                    'gambar_old' => $path,
                    'preview' => $path ? asset('storage/' . $path) : getAvatar($item['nama'] ?? 'X'),
                ];
            }
        } else {
            $pengurus[] = ['jabatan' => '', 'nama' => '', 'gambar_old' => null, 'preview' => getAvatar('X')];
        }

        // 2. Galeri
        $galeriRaw = $karangTaruna?->galeri ?? [];
        $galeri = [];
        if (count($galeriRaw) > 0) {
            foreach ($galeriRaw as $item) {
                $path = $item['gambar'] ?? null;
                $galeri[] = [
                    'judul' => $item['judul'] ?? '',
                    'gambar_old' => $path,
                    'preview' => $path
                        ? asset('storage/' . $path)
                        : 'https://placehold.co/400x400/e2e8f0/475569?text=IMG',
                ];
            }
        } else {
            $galeri[] = [
                'judul' => '',
                'gambar_old' => null,
                'preview' => 'https://placehold.co/400x400/e2e8f0/475569?text=Upload',
            ];
        }

        // 3. Program & Misi & Kontak
        $programRaw = $karangTaruna?->program ?? [];
        $program = count($programRaw) > 0 ? $programRaw : [['judul' => '', 'deskripsi' => '', 'icon' => '']];
        $misiRaw = $karangTaruna?->misi ?? [];
        $misi = count($misiRaw) > 0 ? $misiRaw : [''];
        $kontak = $karangTaruna?->kontak ?? ['wa' => '', 'email' => '', 'instagram' => ''];
    @endphp

    <div class="w-full pb-12" x-data="{
        pengurus: {{ \Illuminate\Support\Js::from($pengurus) }},
        galeri: {{ \Illuminate\Support\Js::from($galeri) }},
        program: {{ \Illuminate\Support\Js::from($program) }},
        misi: {{ \Illuminate\Support\Js::from($misi) }},
    
        handleFilePreview(event, index, type) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imgId = 'preview-' + type + '-' + index;
                    const imgElement = document.getElementById(imgId);
                    if (imgElement) imgElement.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
    
        addItem(type) {
            if (type === 'pengurus') this.pengurus.push({ jabatan: '', nama: '', gambar_old: null, preview: 'https://ui-avatars.com/api/?name=X&background=random&color=fff' });
            if (type === 'galeri') this.galeri.push({ judul: '', gambar_old: null, preview: 'https://placehold.co/400x400/e2e8f0/475569?text=Upload' });
            if (type === 'program') this.program.push({ judul: '', deskripsi: '', icon: '' });
            if (type === 'misi') this.misi.push('');
        },
    
        removeItem(type, index) {
            if (this[type].length > 1) {
                this[type].splice(index, 1);
            } else {
                alert('Minimal data tidak boleh kosong!');
            }
        }
    }" x-cloak>

        {{-- HEADER --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-orange-500">
                    <span>Lembaga Desa</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">Karang Taruna</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-orange-600 rounded-lg text-white shadow-lg shadow-orange-200 dark:shadow-orange-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    {{ $karangTaruna ? 'Edit Profil Karang Taruna' : 'Buat Profil' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">Kelola visi misi, program kerja, dan struktur
                    organisasi.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-all shadow-sm cursor-pointer">
                    Reset
                </button>
                @can('karang-taruna.update')
                    <button form="kt-form" type="submit"
                        class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-orange-200 dark:shadow-orange-900/50 transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Data
                    </button>
                @endcan
            </div>
        </div>

        {{-- FORM START --}}
        <form id="kt-form" method="POST" autocomplete="off" enctype="multipart/form-data"
            action="{{ $karangTaruna ? route('karang-taruna.update', $karangTaruna->id) : route('karang-taruna.store') }}"
            class="space-y-8">
            @csrf
            @if ($karangTaruna)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- KOLOM KIRI (UTAMA) --}}
                <div class="xl:col-span-2 space-y-8">

                    {{-- 1. IDENTITAS & VISI --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-4">
                            <div class="w-1 h-6 bg-orange-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Identitas
                                & Visi</h3>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                                    Organisasi</label>
                                <input type="text" name="nama" value="{{ old('nama', $karangTaruna->nama ?? '') }}"
                                    class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                    placeholder="Contoh: Karang Taruna Bina Remaja">
                            </div>

                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Deskripsi
                                    Singkat</label>
                                <textarea name="deskripsi" rows="3"
                                    class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400">{{ old('deskripsi', $karangTaruna->deskripsi ?? '') }}</textarea>
                            </div>

                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Visi</label>
                                <textarea name="visi" rows="2"
                                    class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400">{{ old('visi', $karangTaruna->visi ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- 2. MISI (SIMPLE REPEATER) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div
                            class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Misi
                                    Organisasi</h3>
                            </div>

                            {{-- REVISI 4: Button + Misi dengan Text --}}
                            <button type="button" @click="addItem('misi')"
                                class="flex items-center gap-2 text-xs font-bold text-teal-600 bg-teal-50 border border-teal-200 px-4 py-2 rounded-lg hover:bg-teal-100 dark:text-teal-200 dark:bg-teal-900/50 dark:border-teal-700 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Misi
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(item, index) in misi" :key="index">
                                <div class="flex gap-3 group">
                                    <span class="flex items-center text-gray-400 text-xs font-mono w-6 justify-center"
                                        x-text="index+1+'.'"></span>
                                    {{-- REVISI 1: Padding input dilonggarkan (px-4 py-3) --}}
                                    <input type="text" name="misi[]" x-model="misi[index]"
                                        class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                        placeholder="Tuliskan misi...">
                                    <button type="button" @click="removeItem('misi', index)"
                                        class="text-gray-400 hover:text-red-500 p-2 cursor-pointer flex-shrink-0"><svg
                                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg></button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- 3. STRUKTUR PENGURUS --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div
                            class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Struktur Pengurus</h3>
                            </div>
                            <button type="button" @click="addItem('pengurus')"
                                class="text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 px-4 py-2 rounded-lg hover:bg-indigo-100 dark:text-indigo-200 dark:bg-indigo-900/50 dark:border-indigo-700 cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg> Tambah
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <template x-for="(item, index) in pengurus" :key="index">
                                <div
                                    class="relative bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700 group hover:border-indigo-300 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden border border-gray-300 dark:border-gray-600">
                                                <img :id="'preview-pengurus-' + index" :src="item.preview"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <label
                                                class="absolute -bottom-1 -right-1 cursor-pointer bg-white dark:bg-gray-700 text-gray-500 p-1.5 rounded-full border shadow-sm hover:text-indigo-600 hover:border-indigo-300">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <input type="file" :name="`pengurus[${index}][gambar_file]`"
                                                    class="hidden" accept="image/*"
                                                    @change="handleFilePreview($event, index, 'pengurus')">
                                                <input type="hidden" :name="`pengurus[${index}][gambar_old]`"
                                                    :value="item.gambar_old">
                                            </label>
                                        </div>
                                        <div class="flex-grow space-y-3 pt-1">
                                            {{-- REVISI 1: Input text pengurus juga diberi padding nyaman --}}
                                            <input type="text" :name="`pengurus[${index}][jabatan]`"
                                                x-model="item.jabatan"
                                                class="block w-full text-xs font-bold text-gray-900 bg-white border border-gray-200 rounded px-3 py-2 focus:ring-1 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600 placeholder-gray-400"
                                                placeholder="Jabatan">
                                            <input type="text" :name="`pengurus[${index}][nama]`" x-model="item.nama"
                                                class="block w-full text-sm text-gray-600 bg-white border border-gray-200 rounded px-3 py-2 focus:ring-1 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 placeholder-gray-400"
                                                placeholder="Nama Lengkap">
                                        </div>
                                        <button type="button" @click="removeItem('pengurus', index)"
                                            class="absolute top-2 right-2 text-gray-300 hover:text-red-500 cursor-pointer p-1"><svg
                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- 4. PROGRAM KERJA --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div
                            class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-sky-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Program Kerja</h3>
                            </div>
                            <button type="button" @click="addItem('program')"
                                class="text-xs font-bold text-sky-600 bg-sky-50 border border-sky-200 px-4 py-2 rounded-lg hover:bg-sky-100 dark:text-sky-200 dark:bg-sky-900/50 dark:border-sky-700 cursor-pointer flex items-center gap-2">
                                + Program
                            </button>
                        </div>
                        <div class="grid grid-cols-1 gap-6">
                            <template x-for="(item, index) in program" :key="index">
                                <div
                                    class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700 relative group">
                                    <div class="flex gap-4">
                                        <div class="w-16 pt-1">
                                            <input type="text" :name="`program[${index}][icon]`" x-model="item.icon"
                                                class="text-center w-full text-2xl bg-white border border-gray-200 rounded-lg py-3 focus:ring-1 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                placeholder="🚀" title="Icon/Emoji">
                                        </div>
                                        <div class="flex-grow space-y-3">
                                            {{-- REVISI 1: Padding text input program --}}
                                            <input type="text" :name="`program[${index}][judul]`" x-model="item.judul"
                                                class="block w-full text-sm font-bold text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-1 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                placeholder="Judul Program">
                                            <textarea :name="`program[${index}][deskripsi]`" x-model="item.deskripsi" rows="2"
                                                class="block w-full text-sm text-gray-600 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-1 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300"
                                                placeholder="Deskripsi kegiatan..."></textarea>
                                        </div>
                                        <button type="button" @click="removeItem('program', index)"
                                            class="text-gray-400 hover:text-red-500 self-start p-1 cursor-pointer"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg></button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (SIDEBAR) --}}
                <div class="space-y-8">
                    {{-- 5. KONTAK --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-5">
                        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-4">
                            <div class="w-1 h-6 bg-pink-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Kontak
                            </h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase">WhatsApp</label>
                                {{-- REVISI 2: Input HP dengan tanda + Statis --}}
                                <div class="flex mt-1">
                                    <span
                                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-100 border border-r-0 border-gray-200 rounded-l-lg dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600 font-bold select-none">+</span>
                                    <input type="number" name="kontak[wa]" value="{{ $kontak['wa'] ?? '' }}"
                                        class="rounded-none rounded-r-lg bg-gray-50 border border-gray-200 text-gray-900 focus:ring-pink-500 focus:border-pink-500 block flex-1 min-w-0 w-full text-sm px-4 py-3 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="6281xxx (Gunakan Kode Negara)">
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase">Email</label>
                                <input type="email" name="kontak[email]" value="{{ $kontak['email'] ?? '' }}"
                                    class="w-full mt-1 text-sm bg-gray-50 rounded-lg border-gray-200 px-4 py-3 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-pink-500"
                                    placeholder="email@contoh.com">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase">Instagram</label>
                                <input type="text" name="kontak[instagram]" value="{{ $kontak['instagram'] ?? '' }}"
                                    class="w-full mt-1 text-sm bg-gray-50 rounded-lg border-gray-200 px-4 py-3 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-pink-500"
                                    placeholder="@username">
                            </div>
                        </div>
                    </div>

                    {{-- 6. GALERI (REVISI 3: GRID KECIL) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div
                            class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-purple-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Galeri</h3>
                            </div>
                            <button type="button" @click="addItem('galeri')"
                                class="text-xs font-bold text-purple-600 bg-purple-50 px-3 py-1.5 rounded-lg cursor-pointer dark:bg-purple-900/30 dark:text-purple-300 hover:bg-purple-100">
                                + Foto
                            </button>
                        </div>

                        {{-- REVISI 3: Grid 2 Kolom untuk foto kecil --}}
                        <div class="grid grid-cols-2 gap-3">
                            <template x-for="(item, index) in galeri" :key="index">
                                <div
                                    class="group relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                    {{-- Preview Area Kecil --}}
                                    <div class="aspect-square w-full bg-gray-100 relative">
                                        <img :id="'preview-galeri-' + index" :src="item.preview"
                                            class="w-full h-full object-cover">

                                        {{-- Overlay Actions --}}
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                            <label
                                                class="cursor-pointer bg-white text-gray-800 p-1.5 rounded-full shadow hover:bg-gray-100"
                                                title="Ganti Foto">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <input type="file" :name="`galeri[${index}][gambar_file]`"
                                                    class="hidden" accept="image/*"
                                                    @change="handleFilePreview($event, index, 'galeri')">
                                            </label>
                                            <button type="button" @click="removeItem('galeri', index)"
                                                class="bg-red-500 text-white p-1.5 rounded-full shadow hover:bg-red-600 cursor-pointer"
                                                title="Hapus">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- Input Judul Simple --}}
                                    <div class="p-1.5">
                                        <input type="text" :name="`galeri[${index}][judul]`" x-model="item.judul"
                                            class="w-full text-[10px] text-center bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-purple-500 focus:ring-0 dark:text-gray-300 px-0 py-1"
                                            placeholder="Judul Foto...">
                                        <input type="hidden" :name="`galeri[${index}][gambar_old]`"
                                            :value="item.gambar_old">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
