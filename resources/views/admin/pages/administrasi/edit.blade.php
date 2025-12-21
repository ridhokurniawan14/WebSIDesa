@extends('admin.layouts.main')

@section('title', 'Edit Layanan | Admin Panel')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-3">
                    <span
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                        {{-- Icon Edit Document --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                            <path
                                d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                    </span>
                    Edit Layanan Administrasi
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Perbarui informasi, prosedur, dan persyaratan layanan.
                </p>
            </div>
            <a href="{{ route('admin.administrasi.index') }}"
                class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors shadow-sm cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

        <form action="{{ route('admin.administrasi.update', $administrasi->id) }}" method="POST" class="p-8"
            autocomplete="off">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">

                {{-- KOLOM KIRI: Identitas Layanan --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-indigo-600">#1</span> Identitas Layanan
                        </h3>
                    </div>

                    {{-- Nama Layanan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama
                            Layanan</label>
                        <input type="text" name="nama" value="{{ old('nama', $administrasi->nama) }}" required
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 shadow-sm transition-all hover:border-indigo-400">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <div class="relative">
                            <select name="kategori" required
                                class="w-full appearance-none rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 shadow-sm cursor-pointer hover:border-indigo-400">
                                <option value="" disabled>Pilih Kategori Layanan</option>
                                <option value="kependudukan"
                                    {{ old('kategori', $administrasi->kategori) == 'kependudukan' ? 'selected' : '' }}>
                                    Administrasi Kependudukan</option>
                                <option value="surat-keterangan"
                                    {{ old('kategori', $administrasi->kategori) == 'surat-keterangan' ? 'selected' : '' }}>
                                    Surat Keterangan</option>
                                <option value="lainnya"
                                    {{ old('kategori', $administrasi->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi
                            Singkat</label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 p-4 shadow-sm hover:border-indigo-400 transition-all resize-none">{{ old('deskripsi', $administrasi->deskripsi) }}</textarea>
                    </div>
                </div>

                {{-- KOLOM KANAN: Detail Teknis (Repeater) --}}
                {{-- Kita inject data lama via parameter fungsi repeaterLogic --}}
                <div class="space-y-8" x-data="repeaterLogic(
                    {{ json_encode(old('syarat', $administrasi->syarat ?? [''])) }},
                    {{ json_encode(old('prosedur', $administrasi->prosedur ?? [''])) }}
                )">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-indigo-600">#2</span> Detail Persyaratan & Prosedur
                        </h3>
                    </div>

                    {{-- 1. REPEATER PERSYARATAN --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">Daftar
                                    Persyaratan</label>
                                <p class="text-xs text-gray-500 mt-1">Dokumen yang wajib dibawa pemohon.</p>
                            </div>

                            {{-- BUTTON TAMBAH (PILL) --}}
                            <button type="button" @click="addSyarat()"
                                class="group flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 group-hover:rotate-90" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Syarat
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(syarat, index) in syaratList" :key="index">
                                <div class="flex items-center gap-3 group">
                                    {{-- Bullet Point Stylish --}}
                                    <div
                                        class="w-2 h-2 rounded-full bg-indigo-400 group-hover:bg-indigo-600 transition-colors">
                                    </div>

                                    <div class="relative flex-1">
                                        <input type="text" name="syarat[]" x-model="syaratList[index]"
                                            placeholder="Contoh: Fotokopi KK"
                                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 shadow-sm text-sm">
                                    </div>

                                    <button type="button" @click="removeSyarat(index)"
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all cursor-pointer opacity-0 group-hover:opacity-100"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <div x-show="syaratList.length === 0" @click="addSyarat()"
                                class="flex flex-col items-center justify-center py-6 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors group">
                                <span class="text-sm font-medium text-gray-500 group-hover:text-indigo-600">Belum ada
                                    persyaratan</span>
                                <span class="text-xs text-gray-400">Klik untuk menambahkan</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. REPEATER PROSEDUR --}}
                    <div
                        class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">Alur /
                                    Prosedur</label>
                                <p class="text-xs text-gray-500 mt-1">Langkah-langkah yang harus dilalui.</p>
                            </div>

                            {{-- BUTTON TAMBAH (PILL - EMERALD) --}}
                            <button type="button" @click="addProsedur()"
                                class="group flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 group-hover:rotate-90" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Langkah
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(langkah, index) in prosedurList" :key="index">
                                <div class="flex gap-4 items-start group">

                                    {{-- NUMBERING LINGKARAN (STEP BADGE) --}}
                                    <div class="flex-shrink-0 relative z-10">
                                        <div
                                            class="flex items-center justify-center w-8 h-8 rounded-full bg-white border-2 border-emerald-200 text-emerald-600 font-bold text-sm shadow-sm group-hover:border-emerald-500 group-hover:text-emerald-700 transition-colors">
                                            <span x-text="index + 1"></span>
                                        </div>
                                    </div>

                                    <div class="flex-1">
                                        <textarea name="prosedur[]" rows="2" x-model="prosedurList[index]"
                                            placeholder="Jelaskan langkah ini secara detail..."
                                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 p-3 shadow-sm text-sm resize-none"></textarea>
                                    </div>

                                    <button type="button" @click="removeProsedur(index)"
                                        class="p-2 mt-1 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all cursor-pointer opacity-0 group-hover:opacity-100"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <div x-show="prosedurList.length === 0" @click="addProsedur()"
                                class="flex flex-col items-center justify-center py-6 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/50 transition-colors group">
                                <span class="text-sm font-medium text-gray-500 group-hover:text-emerald-600">Belum ada
                                    langkah prosedur</span>
                                <span class="text-xs text-gray-400">Klik untuk menambahkan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div
                class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.administrasi.index') }}"
                    class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition cursor-pointer">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition shadow-lg shadow-indigo-500/20 cursor-pointer flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Perbarui Layanan
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPTS ALPINEJS (Menerima Data Lama) --}}
    <script>
        function repeaterLogic(initialSyarat, initialProsedur) {
            return {
                syaratList: initialSyarat || [''],
                prosedurList: initialProsedur || [''],

                addSyarat() {
                    this.syaratList.push('');
                },
                removeSyarat(index) {
                    this.syaratList.splice(index, 1);
                },

                addProsedur() {
                    this.prosedurList.push('');
                },
                removeProsedur(index) {
                    this.prosedurList.splice(index, 1);
                }
            }
        }
    </script>
@endsection
