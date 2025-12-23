@extends('admin.layouts.main')
@section('title', 'Pengaturan Beranda | Admin Panel')

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

        /* HILANGKAN SPINNER (PANAH) PADA INPUT NUMBER */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    {{-- PHP Logic: Prepare Data for AlpineJS --}}
    @php
        // 1. Prepare Banner
        $bannersRaw = $beranda?->banner_images ?? [];
        $banners = [];
        if (is_array($bannersRaw) && count($bannersRaw) > 0) {
            foreach ($bannersRaw as $path) {
                $banners[] = [
                    'gambar_old' => $path,
                    'preview' => asset('storage/' . $path),
                ];
            }
        } else {
            $banners[] = [
                'gambar_old' => null,
                'preview' => 'https://placehold.co/800x400/e2e8f0/475569?text=Upload+Banner',
            ];
        }

        // 2. Prepare Foto Kades (Default Avatar jika kosong)
        $fotoKades = $beranda?->foto_kepala_desa
            ? asset('storage/' . $beranda->foto_kepala_desa)
            : 'https://placehold.co/400x500/e2e8f0/475569?text=Foto+Kades';
    @endphp

    <div class="w-full pb-12" x-data="{
        banners: {{ \Illuminate\Support\Js::from($banners) }},
        kadesPreview: '{{ $fotoKades }}',
    
        // Preview Banner Slider
        handleFilePreview(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.banners[index].preview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    
        // Preview Foto Kades
        handleKadesPreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.kadesPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    
        addBanner() {
            this.banners.push({
                gambar_old: null,
                preview: 'https://placehold.co/800x400/e2e8f0/475569?text=New+Banner'
            });
        },
    
        removeBanner(index) {
            if (this.banners.length > 1) {
                this.banners.splice(index, 1);
            } else {
                alert('Minimal harus ada 1 banner!');
            }
        }
    }" x-cloak>

        {{-- HEADER --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Admin Panel</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">Halaman Depan</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    Pengaturan Beranda
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">Kelola banner, profil kepala desa, dan
                    statistik.</p>
            </div>

            <div class="flex items-center gap-3">
                @can('beranda.update')
                    <button form="beranda-form" type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                @endcan
            </div>
        </div>

        {{-- FORM START --}}
        <form id="beranda-form" method="POST" autocomplete="off" enctype="multipart/form-data"
            action="{{ $beranda ? route('admin.beranda.update', $beranda->id) : route('admin.beranda.store') }}"
            class="space-y-8">
            @csrf
            @if ($beranda)
                @method('PUT')
            @endif

            {{-- SECTION 1: BANNER SLIDER --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-6 bg-pink-500 rounded-full"></div>
                        <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                            Banner Slider (Minimal 1)</h3>
                    </div>
                    <button type="button" @click="addBanner()"
                        class="text-xs font-bold text-pink-600 bg-pink-50 border border-pink-200 px-4 py-2 rounded-lg hover:bg-pink-100 dark:text-pink-200 dark:bg-pink-900/50 dark:border-pink-700 cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg> Tambah Foto
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="(item, index) in banners" :key="index">
                        <div
                            class="relative group bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all">
                            {{-- Preview Image --}}
                            <div class="aspect-video w-full relative bg-gray-200">
                                <img :src="item.preview" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <label
                                        class="cursor-pointer bg-white text-gray-700 p-2 rounded-full hover:bg-gray-100 hover:text-indigo-600 shadow-lg transform hover:scale-110 transition-all"
                                        title="Ganti Foto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <input type="file" :name="`banner[${index}][gambar_file]`" class="hidden"
                                            accept="image/*" @change="handleFilePreview($event, index)">
                                    </label>
                                    <button type="button" @click="removeBanner(index)"
                                        class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-lg transform hover:scale-110 transition-all cursor-pointer"
                                        title="Hapus Banner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" :name="`banner[${index}][gambar_old]`" :value="item.gambar_old">
                            <div class="px-3 py-2 bg-white dark:bg-gray-800 text-center">
                                <span class="text-[10px] font-mono text-gray-400 uppercase tracking-widest"
                                    x-text="`Banner ` + (index + 1)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: INFO UMUM (Lebar 2/3) --}}
                <div class="xl:col-span-2 space-y-8">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-4">
                            <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Informasi
                                Umum</h3>
                        </div>

                        {{-- Layout Split: Kiri (Foto Kades), Kanan (Data Kades) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Foto Kepala Desa --}}
                            <div class="md:col-span-1">
                                <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Foto
                                    Kepala Desa</label>
                                <div
                                    class="relative group rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-500 transition-colors">
                                    <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-900">
                                        <img :src="kadesPreview" class="w-full h-full object-cover">
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-xs font-bold">Ubah Foto</span>
                                        <input type="file" name="foto_kepala_desa"
                                            class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*"
                                            @change="handleKadesPreview($event)">
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 text-center">Format: JPG/PNG, Max 2MB</p>
                            </div>

                            {{-- Data Text --}}
                            <div class="md:col-span-2 space-y-5">
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                                        Kepala Desa</label>
                                    <input type="text" name="nama_kepala_desa"
                                        value="{{ old('nama_kepala_desa', $beranda->nama_kepala_desa ?? '') }}"
                                        class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                        placeholder="Nama Lengkap beserta gelar">
                                </div>

                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Periode
                                        Menjabat</label>
                                    <input type="text" name="periode_jabatan"
                                        value="{{ old('periode_jabatan', $beranda->periode_jabatan ?? '2024-2029') }}"
                                        class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                        placeholder="Contoh: 2024-2029">
                                </div>

                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Deskripsi
                                        Desa (Singkat)</label>
                                    <textarea name="deskripsi" rows="3"
                                        class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400">{{ old('deskripsi', $beranda->deskripsi ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Sambutan Full Width --}}
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-5">
                            <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Sambutan
                                Kepala Desa</label>
                            <textarea name="sambutan_kades" rows="6"
                                class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400">{{ old('sambutan_kades', $beranda->sambutan_kades ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: STATISTIK (Lebar 1/3) --}}
                <div class="xl:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 pb-4 mb-6">
                            <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Data
                                Statistik</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $stats = [
                                    ['label' => 'Total Penduduk', 'name' => 'total_penduduk', 'icon' => '👥'],
                                    ['label' => 'Laki-Laki', 'name' => 'total_laki_laki', 'icon' => '👨'],
                                    ['label' => 'Perempuan', 'name' => 'total_perempuan', 'icon' => '👩'],
                                    ['label' => 'Jumlah KK', 'name' => 'jumlah_kk', 'icon' => '🏠'],
                                    ['label' => 'Usia Muda (0-17)', 'name' => 'usia_muda', 'icon' => '👶'],
                                    ['label' => 'Usia Dewasa (18-59)', 'name' => 'usia_dewasa', 'icon' => '🧑'],
                                    ['label' => 'Lansia (60+)', 'name' => 'usia_lansia', 'icon' => '👴'],
                                    ['label' => 'Jumlah RT', 'name' => 'jumlah_rt', 'icon' => '📍'],
                                    ['label' => 'Jumlah RW', 'name' => 'jumlah_rw', 'icon' => '🚩'],
                                    ['label' => 'Jumlah Dusun', 'name' => 'jumlah_dusun', 'icon' => '🏘️'],
                                    ['label' => 'Desa Adat', 'name' => 'desa_adat', 'icon' => '🏛️'],
                                    ['label' => 'Klg. Miskin', 'name' => 'keluarga_miskin', 'icon' => '📉'],
                                ];
                            @endphp

                            @foreach ($stats as $stat)
                                <div class="relative group">
                                    <label
                                        class="block mb-1 text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">
                                        {{ $stat['label'] }}
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-sm select-none">{{ $stat['icon'] }}</span>
                                        </div>
                                        <input type="number" name="{{ $stat['name'] }}"
                                            value="{{ old($stat['name'], $beranda->{$stat['name']} ?? 0) }}"
                                            class="block w-full pl-9 pr-3 py-2 text-sm font-mono font-bold text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:ring-1 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                            placeholder="0">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
