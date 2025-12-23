@extends('admin.layouts.main')
@section('title', 'Kelola Koperasi Desa | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi Global */
        input,
        textarea,
        button,
        select,
        div,
        span,
        img,
        label,
        a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    {{-- PHP PREPARE DATA --}}
    @php
        // Helper Avatar
        function getAvatar($name)
        {
            return 'https://ui-avatars.com/api/?name=' .
                urlencode($name ?: 'User') .
                '&background=random&color=fff&size=128&bold=true';
        }

        // 1. Data Pengurus
        $pengurusRaw = $koperasi?->struktur_pengurus ?? [];
        $pengurus = [];
        if (count($pengurusRaw) > 0) {
            foreach ($pengurusRaw as $p) {
                $path = $p['foto'] ?? null;
                $pengurus[] = [
                    'nama' => $p['nama'] ?? '',
                    'jabatan' => $p['jabatan'] ?? '',
                    'foto_old' => $path,
                    'preview' => $path ? asset('storage/' . $path) : getAvatar($p['nama'] ?? 'X'),
                ];
            }
        } else {
            $pengurus[] = ['nama' => '', 'jabatan' => '', 'foto_old' => null, 'preview' => getAvatar('X')];
        }

        // 2. Data Syarat
        $syaratRaw = $koperasi?->syarat_anggota ?? [];
        $syarat = count($syaratRaw) > 0 ? $syaratRaw : [''];
    @endphp

    <div class="w-full pb-20" x-data="{
        pengurus: {{ \Illuminate\Support\Js::from($pengurus) }},
        syarat: {{ \Illuminate\Support\Js::from($syarat) }},
    
        handleFilePreview(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.pengurus[index].preview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
    
        addPengurus() {
            this.pengurus.push({ nama: '', jabatan: '', foto_old: null, preview: 'https://ui-avatars.com/api/?name=New&background=e2e8f0&color=64748b' });
        },
    
        removePengurus(index) {
            if (this.pengurus.length > 1) {
                this.pengurus.splice(index, 1);
            } else {
                alert('Minimal data tidak boleh kosong!');
            }
        },
    
        addSyarat() {
            this.syarat.push('');
        },
    
        removeSyarat(index) {
            if (this.syarat.length > 1) {
                this.syarat.splice(index, 1);
            }
        }
    }" x-cloak>

        {{-- HEADER --}}
        <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                <div class="space-y-2">
                    <nav class="flex text-[10px] font-bold uppercase tracking-widest text-emerald-500">
                        <span>Lembaga Desa</span>
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-400">Ekonomi</span>
                    </nav>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-3">
                        <span
                            class="bg-emerald-100 text-emerald-600 p-2 rounded-xl dark:bg-emerald-900 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Koperasi Desa
                    </h1>
                    {{-- REVISI 1: Tambah Deskripsi/Keterangan --}}
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                        Kelola informasi lengkap Koperasi Desa, mulai dari profil utama, persyaratan menjadi anggota,
                        contact person layanan pelanggan, hingga struktur kepengurusan terbaru.
                    </p>
                </div>

                {{-- Action Button --}}
                <div class="flex items-center gap-3 pt-2">
                    @can('koperasi.update')
                        <button type="submit" form="koperasi-form"
                            class="cursor-pointer group inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-200 dark:shadow-emerald-900/20 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        {{-- FORM START --}}
        <form id="koperasi-form" method="POST" enctype="multipart/form-data"
            action="{{ $koperasi ? route('koperasi.update', $koperasi->id) : route('koperasi.store') }}" class="space-y-8">

            @csrf
            @if ($koperasi)
                @method('PUT')
            @endif

            {{-- SECTION 1: GRID ATAS (Profil & Syarat) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- KOLOM KIRI (LEBIH LEBAR): Profil Utama & Kontak --}}
                <div class="lg:col-span-7 space-y-8">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-800 dark:text-white uppercase tracking-wider text-sm">Identitas
                                Koperasi</h3>
                        </div>

                        <div class="space-y-6">
                            {{-- Nama --}}
                            <div>
                                <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                                    Koperasi</label>
                                <input type="text" name="nama_koperasi"
                                    value="{{ old('nama_koperasi', $koperasi->nama_koperasi ?? '') }}"
                                    class="block w-full text-sm font-semibold text-gray-900 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                    placeholder="Contoh: Koperasi Maju Jaya">
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Deskripsi
                                    / Profil Singkat</label>
                                <textarea name="deskripsi" rows="5"
                                    class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 resize-y">{{ old('deskripsi', $koperasi->deskripsi ?? '') }}</textarea>
                            </div>

                            {{-- Contact Person --}}
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Contact
                                    Person (CS)</label>
                                <div class="flex relative group">
                                    <span
                                        class="inline-flex items-center px-4 text-sm font-bold text-emerald-600 bg-emerald-50 border border-r-0 border-emerald-100 rounded-l-xl dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800">
                                        +
                                    </span>
                                    <input type="text" name="contact_person"
                                        value="{{ old('contact_person', $koperasi->contact_person ?? '') }}"
                                        class="rounded-r-xl bg-gray-50 border border-gray-200 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm px-4 py-3 dark:bg-gray-900 dark:border-gray-600 dark:text-white font-mono"
                                        placeholder="62812-xxxx-xxxx">
                                </div>
                                <p class="mt-2 text-[10px] text-gray-400">Nomor ini akan ditampilkan sebagai tombol
                                    WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (AGAK KECIL): Syarat Anggota --}}
                <div class="lg:col-span-5">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 h-full">
                        <div
                            class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800 dark:text-white uppercase tracking-wider text-sm">Syarat
                                    Anggota</h3>
                            </div>
                            <button type="button" @click="addSyarat()"
                                class="cursor-pointer text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 px-4 py-2 rounded-lg hover:bg-blue-100 dark:text-blue-200 dark:bg-blue-900/30 dark:border-blue-700 flex items-center gap-1 hover:shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah
                            </button>
                        </div>

                        <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(item, index) in syarat" :key="index">
                                <div class="flex items-center gap-2 group animate-fade-in-down">
                                    <span class="text-blue-300 font-bold text-sm w-6 text-right select-none"
                                        x-text="index + 1 + '.'"></span>
                                    <input type="text" name="syarat[]" x-model="syarat[index]"
                                        class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors"
                                        placeholder="Tulis persyaratan...">

                                    <button type="button" @click="removeSyarat(index)"
                                        class="cursor-pointer p-2 text-gray-300 hover:text-red-500 bg-transparent hover:bg-red-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: FULL WIDTH (REVISI 2: STRUKTUR JADI GRID DI BAWAH) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                <div class="flex justify-between items-center mb-8 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-purple-500 rounded-full"></div>
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white uppercase tracking-wider text-sm">Struktur
                                Kepengurusan</h3>
                            <p class="text-xs text-gray-400 mt-1">Tambahkan foto dan jabatan pengurus koperasi.</p>
                        </div>
                    </div>
                    <button type="button" @click="addPengurus()"
                        class="cursor-pointer text-xs font-bold text-white bg-purple-600 border border-purple-600 px-5 py-2.5 rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-200 dark:shadow-purple-900/20 flex items-center gap-2 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Personil
                    </button>
                </div>

                {{-- GRID DISPLAY --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template x-for="(item, index) in pengurus" :key="index">
                        <div
                            class="relative bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 group hover:border-purple-300 dark:hover:border-purple-500 hover:shadow-md transition-all duration-300">

                            {{-- Delete Button (Corner) --}}
                            <button type="button" @click="removePengurus(index)"
                                class="cursor-pointer absolute top-3 right-3 text-gray-400 hover:text-red-500 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg p-1.5 shadow-sm border border-gray-100 dark:border-gray-700 opacity-0 group-hover:opacity-100 transition-all z-10 transform scale-90 hover:scale-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="flex flex-col items-center">
                                {{-- Foto Avatar (Centering) --}}
                                <div class="relative group/img mb-5">
                                    <div
                                        class="w-28 h-28 rounded-full overflow-hidden border-4 border-white dark:border-gray-800 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
                                        <img :src="item.preview"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                    </div>

                                    {{-- Overlay Edit --}}
                                    <label
                                        class="cursor-pointer absolute inset-0 flex flex-col items-center justify-center bg-black/60 text-white rounded-full opacity-0 group-hover/img:opacity-100 transition-all duration-300 backdrop-blur-[2px]">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-[10px] font-bold uppercase tracking-wide">Ubah Foto</span>
                                        <input type="file" :name="`pengurus[${index}][foto_file]`" class="hidden"
                                            accept="image/*" @change="handleFilePreview($event, index)">
                                        <input type="hidden" :name="`pengurus[${index}][foto_old]`"
                                            :value="item.foto_old">
                                    </label>
                                </div>

                                {{-- Input Fields --}}
                                <div class="w-full space-y-3">
                                    <div class="relative">
                                        <input type="text" :name="`pengurus[${index}][nama]`" x-model="item.nama"
                                            class="block w-full text-center text-sm font-bold text-gray-800 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:ring-1 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-all"
                                            placeholder="Nama Lengkap">
                                    </div>

                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </span>
                                        </div>
                                        <input type="text" :name="`pengurus[${index}][jabatan]`" x-model="item.jabatan"
                                            class="block w-full pl-9 text-xs font-semibold text-gray-600 bg-transparent border-0 border-b-2 border-gray-200 focus:border-purple-500 focus:ring-0 px-2 py-2 dark:text-gray-400 placeholder-gray-400 transition-colors"
                                            placeholder="Jabatan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </form>
    </div>
@endsection
