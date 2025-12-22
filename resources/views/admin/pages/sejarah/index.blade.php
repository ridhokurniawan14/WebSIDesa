@extends('admin.layouts.main')
@section('title', 'Kelola Sejarah Desa | Admin Panel')

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
        // Data Timeline default
        $timelineDB = $sejarah?->timeline ?? [];
        $defaultTimeline = [['judul' => '', 'ket' => '']];
        $timelineData = count($timelineDB) > 0 ? $timelineDB : $defaultTimeline;

        // Foto default
        $fotoUrl = $sejarah?->foto ? asset('storage/' . $sejarah->foto) : null;
    @endphp

    <div class="w-full pb-12" x-data="{
        timeline: {{ \Illuminate\Support\Js::from($timelineData) }},
        photoPreview: '{{ $fotoUrl }}',
    
        updatePreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; }
                reader.readAsDataURL(file);
            }
        },
    
        addItem() {
            this.timeline.push({ judul: '', ket: '' });
        },
    
        removeItem(index) {
            if (this.timeline.length > 1) {
                this.timeline.splice(index, 1);
            } else {
                alert('Minimal satu timeline harus tersedia!');
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
                    <span class="text-gray-400">Sejarah</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    {{ $sejarah ? 'Edit Sejarah Desa' : 'Input Sejarah Desa' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Kelola foto sejarah, cerita asal-usul, dan timeline peristiwa penting.
                </p>
            </div>

            <div class="flex items-center gap-3">
                @can($sejarah ? 'sejarah.update' : 'sejarah.create')
                    <button form="sejarah-form" type="submit"
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
        <form id="sejarah-form" method="POST" enctype="multipart/form-data"
            action="{{ $sejarah ? route('admin.sejarah.update', $sejarah->id) : route('admin.sejarah.store') }}">
            @csrf
            @if ($sejarah)
                @method('PUT')
            @endif

            {{-- GRID LAYOUT --}}
            {{-- KUNCI PERBAIKAN: items-start agar kolom kanan tidak turun/centered, tapi rata atas --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KOLOM KIRI (KONTEN UTAMA) --}}
                <div class="lg:col-span-2 space-y-8 order-2 lg:order-1">

                    {{-- 1. Asal Usul --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-blue-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Asal Usul Desa
                            </h3>
                        </div>
                        <div class="p-6">
                            <textarea name="asal_usul" rows="10"
                                class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors leading-relaxed"
                                placeholder="Ceritakan sejarah lengkap asal usul desa di sini..." required>{{ old('asal_usul', $sejarah->asal_usul ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- 2. Timeline (Repeater) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-8 bg-amber-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Timeline Peristiwa
                                </h3>
                            </div>
                            <button type="button" @click="addItem()"
                                class="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200 px-4 py-2 rounded-lg hover:bg-amber-100 hover:text-amber-800 dark:text-amber-200 dark:bg-amber-900/50 dark:border-amber-700 dark:hover:bg-amber-900 dark:hover:text-white transition-all cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Event
                            </button>
                        </div>

                        <div class="p-6 space-y-4">
                            <template x-for="(item, index) in timeline" :key="index">
                                <div
                                    class="relative bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700 animate-fadeIn group">
                                    <button type="button" @click="removeItem(index)"
                                        class="absolute top-3 right-3 text-gray-300 hover:text-red-500 dark:text-gray-600 dark:hover:text-red-400 transition-colors"
                                        title="Hapus Event">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                        <div class="md:col-span-1 flex items-center justify-center">
                                            <span class="text-xl font-bold text-gray-200 dark:text-gray-700 select-none"
                                                x-text="'#'+(index+1)"></span>
                                        </div>
                                        <div class="md:col-span-11 grid grid-cols-1 gap-4">
                                            <div>
                                                <label
                                                    class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Judul /
                                                    Tahun</label>
                                                <input type="text" :name="'timeline[' + index + '][judul]'"
                                                    x-model="item.judul"
                                                    class="block w-full text-sm font-bold text-gray-900 bg-white border border-gray-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white placeholder-gray-400"
                                                    placeholder="Cth: 1998 - Pemekaran Desa">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Keterangan
                                                    Singkat</label>
                                                <textarea :name="'timeline[' + index + '][ket]'" x-model="item.ket" rows="2"
                                                    class="block w-full text-sm text-gray-600 bg-white border border-gray-200 rounded-lg px-3 py-2 focus:ring-1 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 placeholder-gray-400 resize-none"
                                                    placeholder="Deskripsi kejadian..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (SIDEBAR) --}}
                {{-- PERBAIKAN: Hapus sticky, dan biarkan dia flow normal --}}
                <div class="lg:col-span-1 order-1 lg:order-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Foto Sejarah
                            </h3>
                        </div>

                        <div class="p-6 flex flex-col items-center">
                            <div
                                class="relative w-full aspect-video bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 flex justify-center items-center group hover:border-indigo-400 transition-colors">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center p-4">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada foto</p>
                                    </div>
                                </template>

                                <label for="foto"
                                    class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer z-10">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Ganti Foto</span>
                                </label>
                                <input type="file" id="foto" name="foto" class="hidden" accept="image/*"
                                    @change="updatePreview($event)">
                            </div>
                            <p class="mt-4 text-[10px] text-gray-400 text-center">
                                Format: JPG/PNG, Max 2MB.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
