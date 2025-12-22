@extends('admin.layouts.main')
@section('title', 'Kelola Perangkat Desa | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .form-input-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    @php
        // Data Staff Default (Jika DB kosong)
        $dbStaff = $perangkat?->data_perangkat ?? [];

        // Transform data DB agar path foto bisa dibaca asset() jika disimpan lokal
        // atau dibiarkan jika link eksternal (placeholder)
        $mappedStaff = array_map(function ($item) {
            $foto = $item['foto'] ?? null;
            // Cek jika foto adalah path storage (tidak ada http)
            $url = $foto && !str_contains($foto, 'http') ? asset('storage/' . $foto) : $foto;

            return [
                'nama' => $item['nama'] ?? '',
                'jabatan' => $item['jabatan'] ?? '',
                'foto_url' => $url, // Untuk preview
                'foto_path' => $foto, // Untuk value hidden input (path asli DB)
            ];
        }, $dbStaff);

        $defaultStaff = [
            [
                'nama' => '',
                'jabatan' => '',
                'foto_url' => 'https://via.placeholder.com/150?text=No+Image',
                'foto_path' => null,
            ],
        ];

        $staffData = count($mappedStaff) > 0 ? $mappedStaff : $defaultStaff;

        // Foto Struktur Utama
        $strukturUrl = $perangkat?->foto_struktur_organisasi
            ? asset('storage/' . $perangkat->foto_struktur_organisasi)
            : null;
    @endphp

    <div class="w-full pb-12" x-data="{
        staffList: {{ \Illuminate\Support\Js::from($staffData) }},
        strukturPreview: '{{ $strukturUrl }}',
    
        // Preview Foto Struktur Utama
        updateStrukturPreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.strukturPreview = e.target.result; }
                reader.readAsDataURL(file);
            }
        },
    
        // Preview Foto Staff (Per Item)
        updateItemPreview(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Update property foto_url di object array specific
                    this.staffList[index].foto_url = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
    
        addStaff() {
            this.staffList.push({ nama: '', jabatan: '', foto_url: 'https://via.placeholder.com/150?text=Upload', foto_path: '' });
        },
    
        removeStaff(index) {
            if (this.staffList.length > 1) {
                this.staffList.splice(index, 1);
            } else {
                alert('Minimal satu perangkat desa harus tersedia!');
            }
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Profil</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">Pemerintahan</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    {{ $perangkat ? 'Edit Perangkat Desa' : 'Input Perangkat Desa' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Kelola struktur organisasi dan data staff perangkat desa.
                </p>
            </div>

            <div class="flex items-center gap-3">
                @can('perangkat.create')
                    {{-- atau perangkat.update --}}
                    <button form="perangkat-form" type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Perubahan
                    </button>
                @endcan
            </div>
        </div>

        {{-- FORM START --}}
        <form id="perangkat-form" method="POST" enctype="multipart/form-data"
            action="{{ $perangkat ? route('admin.perangkat.update', $perangkat->id) : route('admin.perangkat.store') }}">
            @csrf
            @if ($perangkat)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KOLOM KIRI: REPEATER STAFF --}}
                <div class="lg:col-span-2 space-y-6 order-2 lg:order-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                        {{-- Repeater Header --}}
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-8 bg-blue-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Daftar Staff / Pegawai
                                </h3>
                            </div>
                            <button type="button" @click="addStaff()"
                                class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 px-4 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-800 dark:text-blue-200 dark:bg-blue-900/50 dark:border-blue-700 transition-all cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Staff
                            </button>
                        </div>

                        {{-- Repeater Body --}}
                        <div class="p-6 space-y-4">
                            <template x-for="(item, index) in staffList" :key="index">
                                <div
                                    class="relative bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 animate-fadeIn group hover:shadow-md transition-all duration-300">

                                    {{-- TOMBOL CLOSE --}}
                                    <button type="button" @click="removeStaff(index)"
                                        class="absolute -top-2 -right-2 w-8 h-8 flex items-center justify-center bg-white dark:bg-gray-800 text-gray-400 border border-gray-200 dark:border-gray-600 rounded-full shadow-sm hover:bg-red-50 hover:text-red-600 hover:border-red-200 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-all z-20 transform hover:scale-110"
                                        title="Hapus Staff">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <div class="flex flex-col sm:flex-row gap-5">
                                        {{-- FOTO STAFF --}}
                                        <div class="flex-shrink-0">
                                            <div
                                                class="relative w-24 h-32 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600 group-hover:border-blue-400 transition-colors shadow-sm bg-gray-200 dark:bg-gray-800 flex items-center justify-center">

                                                {{-- KONDISI 1: ADA FOTO --}}
                                                <template
                                                    x-if="item.foto_url && item.foto_url.length > 10 && !item.foto_url.includes('via.placeholder')">
                                                    <img :src="item.foto_url" class="w-full h-full object-cover">
                                                </template>

                                                {{-- KONDISI 2: DEFAULT (NO IMAGE) --}}
                                                <template
                                                    x-if="!item.foto_url || item.foto_url.length <= 10 || item.foto_url.includes('via.placeholder')">
                                                    <div
                                                        class="text-gray-400 dark:text-gray-500 flex flex-col items-center justify-center w-full h-full p-4">
                                                        <svg class="w-10 h-10 mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span
                                                            class="text-[9px] font-bold uppercase tracking-wider opacity-60">No
                                                            Image</span>
                                                    </div>
                                                </template>

                                                {{-- PERBAIKAN DISINI: INPUT FILE DI DALAM LABEL --}}
                                                <label
                                                    class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 transition-opacity cursor-pointer backdrop-blur-[1px] z-10">
                                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-widest">Ganti</span>

                                                    {{-- Input sekarang menjadi anak dari label --}}
                                                    <input type="file" class="hidden" accept="image/*"
                                                        :name="'staff[' + index + '][foto_new]'"
                                                        @change="updateItemPreview($event, index)">
                                                </label>

                                                <input type="hidden" :name="'staff[' + index + '][foto_old]'"
                                                    :value="item.foto_path">
                                            </div>
                                        </div>

                                        {{-- Input Data Text --}}
                                        <div class="flex-grow grid grid-cols-1 gap-4 content-center">
                                            <div>
                                                <label
                                                    class="block text-[10px] uppercase font-bold text-gray-400 mb-1 ml-1">Nama
                                                    Lengkap</label>
                                                <input type="text" :name="'staff[' + index + '][nama]'"
                                                    x-model="item.nama"
                                                    class="block w-full text-sm font-bold text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white transition-all shadow-sm"
                                                    placeholder="Nama Staff..." required>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[10px] uppercase font-bold text-gray-400 mb-1 ml-1">Jabatan</label>
                                                <input type="text" :name="'staff[' + index + '][jabatan]'"
                                                    x-model="item.jabatan"
                                                    class="block w-full text-sm text-gray-600 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 transition-all shadow-sm"
                                                    placeholder="Jabatan (mis: Kaur Umum)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: SIDEBAR (FOTO STRUKTUR) --}}
                <div class="lg:col-span-1 order-1 lg:order-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Bagan Struktur
                            </h3>
                        </div>

                        <div class="p-6 flex flex-col items-center">
                            {{-- Preview Area --}}
                            <div
                                class="relative w-full aspect-[3/4] md:aspect-video bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 flex justify-center items-center group hover:border-indigo-400 transition-colors">
                                <template x-if="strukturPreview">
                                    <img :src="strukturPreview"
                                        class="w-full h-full object-contain bg-white dark:bg-black">
                                </template>
                                <template x-if="!strukturPreview">
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-500">Upload Bagan Organisasi</p>
                                    </div>
                                </template>

                                <label for="foto_struktur"
                                    class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer z-10">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Pilih Gambar</span>
                                </label>
                                <input type="file" id="foto_struktur" name="foto_struktur" class="hidden"
                                    accept="image/*" @change="updateStrukturPreview($event)">
                            </div>
                            <p class="mt-4 text-[10px] text-gray-400 text-center">Format: JPG/PNG, Max 2MB.</p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
