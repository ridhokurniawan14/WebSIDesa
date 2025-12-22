@extends('admin.layouts.main')
@section('title', 'Kelola Visi & Misi | Admin Panel')

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
        label {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    {{-- PHP Logic: Prepare Data for AlpineJS --}}
    @php
        // Ambil data Misi dari DB (sudah dicasting jadi array di Model)
        $misiDB = $visiMisi?->misi ?? [];

        // Jika kosong, siapkan array dengan 1 string kosong agar form muncul 1 baris
        $misiData = count($misiDB) > 0 ? $misiDB : [''];
    @endphp

    <div class="w-full pb-12" x-data="{
        // Data Visi Misi
        misi: {{ \Illuminate\Support\Js::from($misiData) }},
    
        // Tambah baris input Misi
        addItem() {
            this.misi.push('');
        },
    
        // Hapus baris input Misi
        removeItem(index) {
            if (this.misi.length > 1) {
                this.misi.splice(index, 1);
            } else {
                alert('Minimal satu Misi harus tersedia!');
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
                    <span class="text-gray-400">Visi Misi</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    {{ $visiMisi ? 'Edit Visi & Misi' : 'Buat Visi & Misi' }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Atur visi dan poin-poin misi instansi/desa di sini.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-all shadow-sm cursor-pointer">
                    Reset
                </button>

                {{-- Permission Check: Gunakan 'create' jika data kosong, 'update' jika ada --}}
                @can($visiMisi ? 'visi-misi.update' : 'visi-misi.create')
                    <button form="visimisi-form" type="submit"
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
        <form id="visimisi-form" method="POST" autocomplete="off"
            action="{{ $visiMisi ? route('admin.visiMisi.update', $visiMisi->id) : route('admin.visiMisi.store') }}"
            class="space-y-8">

            @csrf
            @if ($visiMisi)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: VISI (Besar) --}}
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-6">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Visi Utama
                            </h3>
                        </div>

                        <div class="p-6">
                            <label
                                class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Rumusan Visi
                            </label>
                            <textarea name="visi" rows="12"
                                class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors leading-relaxed"
                                placeholder="Tuliskan visi singkat, padat, dan jelas di sini..." required>{{ old('visi', $visiMisi->visi ?? '') }}</textarea>
                            <p class="mt-2 text-[10px] text-gray-400">
                                *Visi adalah cita-cita atau impian yang ingin dicapai di masa depan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: MISI (Repeater) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Poin-Poin Misi
                                </h3>
                            </div>

                            {{-- Tombol Tambah --}}
                            <button type="button" @click="addItem()"
                                class="text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-4 py-2 rounded-lg hover:bg-emerald-100 hover:text-emerald-800 dark:text-emerald-200 dark:bg-emerald-900/50 dark:border-emerald-700 dark:hover:bg-emerald-900 dark:hover:text-white transition-all cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Poin
                            </button>
                        </div>

                        <div class="p-6 space-y-4">
                            {{-- Looping Misi --}}
                            <template x-for="(item, index) in misi" :key="index">
                                <div class="flex items-start gap-3 group animate-fadeIn">
                                    {{-- Penomoran Otomatis --}}
                                    <span
                                        class="flex items-center justify-center w-8 h-[42px] text-gray-400 font-mono font-bold text-sm bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700 select-none"
                                        x-text="index + 1">
                                    </span>

                                    {{-- Input Misi --}}
                                    <div class="flex-grow">
                                        {{-- name="misi[]" agar dibaca array oleh Laravel --}}
                                        <input type="text" name="misi[]" x-model="misi[index]"
                                            class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 h-[42px]"
                                            placeholder="Tuliskan poin misi...">
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" @click="removeItem(index)"
                                        class="flex-shrink-0 h-[42px] w-[42px] flex items-center justify-center text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded-lg dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 dark:hover:border-red-900 transition-all cursor-pointer shadow-sm"
                                        title="Hapus baris ini">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            {{-- Empty State (Optional: jika mau handling extra, tapi logic removeItem sudah handle min 1) --}}
                            <p class="text-[11px] text-gray-400 pt-2 border-t border-gray-100 dark:border-gray-700">
                                *Misi adalah langkah-langkah nyata untuk mencapai Visi. Klik tombol "Tambah Poin" untuk
                                menambah baris baru.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
