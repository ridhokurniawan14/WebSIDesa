@extends('admin.layouts.main')

@section('title', 'Produk Hukum | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .pagination-clean nav div[class*="justify-between"]>div:first-child {
            display: none;
        }

        .pagination-clean nav p {
            display: none !important;
        }

        .pagination-clean nav {
            display: flex;
            justify-content: flex-end;
        }
    </style>

    {{-- Main Container AlpineJS --}}
    <div x-data="{
        createModalOpen: {{ $errors->any() && old('_method') !== 'PUT' ? 'true' : 'false' }},
        editModalOpen: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
        deleteModalOpen: false,
        pdfModalOpen: false,
        searchOpen: false, // Tambahan untuk toggle search bar
    
        // Data Models
        id: null,
        judul: '',
        jenis: '',
        tahun: '',
        currentFile: '',
        activePdfUrl: '',
    
        // URLs
        updateUrl: '',
        deleteUrl: '',
    
        openCreate() {
            this.createModalOpen = true;
            this.id = null;
            this.judul = '';
            this.jenis = '';
            this.tahun = new Date().getFullYear();
            this.currentFile = '';
            if (document.getElementById('fileCreate')) document.getElementById('fileCreate').value = '';
        },
    
        openEdit(data) {
            this.id = data.id;
            this.judul = data.judul;
            this.jenis = data.jenis;
            this.tahun = data.tahun;
            this.currentFile = data.file_url;
    
            if (document.getElementById('fileEdit')) document.getElementById('fileEdit').value = '';
    
            this.updateUrl = '{{ route('admin.produk-hukum.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', data.id);
            this.editModalOpen = true;
        },
    
        openDelete(id) {
            this.id = id;
            this.deleteUrl = '{{ route('admin.produk-hukum.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        },
    
        openPdf(url) {
            this.activePdfUrl = url;
            this.pdfModalOpen = true;
        }
    }" x-cloak class="min-h-screen">

        {{-- HEADER SECTION (TOOLBAR BARU) --}}
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            {{-- Judul Halaman --}}
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                    Produk Hukum
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola Perdes, Perkades, SK, dan Surat Edaran.
                </p>
            </div>

            {{-- TOOLBAR (Search & Filter) --}}
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('admin.produk-hukum.index') }}" class="flex items-center gap-2">

                    {{-- 1. Search Box (Expandable) --}}
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border transition-colors duration-200"
                        :class="searchOpen ? 'border-gray-300 dark:border-gray-600 pr-2' : 'border-transparent'">

                        <button type="button" @click="searchOpen = !searchOpen"
                            class="p-2 rounded-lg text-gray-500 hover:text-indigo-600 focus:outline-none transition-colors cursor-pointer"
                            :class="{ 'text-indigo-600': searchOpen }">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>

                        <input type="text" name="q" value="{{ request('q') }}" x-ref="searchInput"
                            class="bg-transparent border-none focus:ring-0 text-sm text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-300 ease-in-out"
                            :class="searchOpen ? 'w-48 opacity-100 px-2' : 'w-0 opacity-0 px-0'" placeholder="Cari judul..."
                            style="outline: none;">
                    </div>

                    {{-- 2. Filter Dropdowns --}}
                    <div x-show="searchOpen" x-transition class="flex items-center gap-2" style="display: none;">

                        {{-- Filter Jenis --}}
                        <div class="relative">
                            <select name="jenis"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm cursor-pointer">
                                <option value="">Semua Jenis</option>
                                <option value="Peraturan Desa" {{ request('jenis') == 'Peraturan Desa' ? 'selected' : '' }}>
                                    Peraturan Desa</option>
                                <option value="Peraturan Kepala Desa"
                                    {{ request('jenis') == 'Peraturan Kepala Desa' ? 'selected' : '' }}>Peraturan Kades
                                </option>
                                <option value="Keputusan Kepala Desa"
                                    {{ request('jenis') == 'Keputusan Kepala Desa' ? 'selected' : '' }}>SK Kades</option>
                                <option value="Surat Edaran" {{ request('jenis') == 'Surat Edaran' ? 'selected' : '' }}>
                                    Surat Edaran</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        {{-- Filter Tahun (Dinamis dari DB) --}}
                        <div class="relative">
                            <select name="tahun"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm cursor-pointer">
                                <option value="">Semua Thn</option>
                                @foreach ($years as $y)
                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        {{-- Tombol Filter --}}
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer shadow-sm">
                            Filter
                        </button>

                        {{-- Tombol Reset --}}
                        @if (request()->hasAny(['q', 'jenis', 'tahun']))
                            <a href="{{ route('admin.produk-hukum.index') }}"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer shadow-sm"
                                title="Reset Filter">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Tombol Tambah --}}
                @can('produk-hukum.create')
                    <button type="button" @click="openCreate()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Data
                    </button>
                @endcan
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-medium border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 w-16 text-center">#</th>
                            <th class="px-6 py-4">Judul Dokumen</th>
                            <th class="px-6 py-4 w-48">Jenis & Tahun</th>
                            <th class="px-6 py-4 w-32 text-center">File</th>
                            @canany(['produk-hukum.update', 'produk-hukum.delete'])
                                <th class="px-6 py-4 text-right w-32">Aksi</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($produkHukum as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $produkHukum->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-base font-semibold text-gray-800 dark:text-gray-200 block">
                                        {{ $item->judul }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 w-fit">
                                            {{ $item->jenis }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 pl-1">
                                            Tahun: {{ $item->tahun }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Tombol Lihat PDF Modal --}}
                                    <button type="button" @click="openPdf('{{ Storage::url($item->file) }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-lg text-xs font-medium transition-colors cursor-pointer border border-red-200 dark:border-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Lihat
                                    </button>
                                </td>
                                @canany(['produk-hukum.update', 'produk-hukum.delete'])
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            @can('produk-hukum.update')
                                                <button type="button"
                                                    @click="openEdit({
                                                        id: {{ $item->id }},
                                                        judul: {{ json_encode($item->judul) }},
                                                        jenis: '{{ $item->jenis }}',
                                                        tahun: '{{ $item->tahun }}',
                                                        file_url: '{{ Storage::url($item->file) }}'
                                                    })"
                                                    class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path
                                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                                    </svg>
                                                </button>
                                            @endcan
                                            @can('produk-hukum.delete')
                                                <button type="button" @click="openDelete({{ $item->id }})"
                                                    class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.49 1.478l-.565 13.982A2.25 2.25 0 0117.082 23H6.918a2.25 2.25 0 01-2.241-2.323L4.112 6.695a48.85 48.85 0 01-3.413-.387.75.75 0 01-.3-1.486 49.33 49.33 0 0110.358-.557c.725-.03 1.45.01 2.164.12zM6.954 6.613l.542 13.437A.75.75 0 008.24 20.618l.102-14.28a47.456 47.456 0 01-1.388.275z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500">Belum ada data produk
                                    hukum.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span class="font-semibold">{{ $produkHukum->firstItem() ?? 0 }}</span> - <span
                        class="font-semibold">{{ $produkHukum->lastItem() ?? 0 }}</span> dari <span
                        class="font-semibold">{{ $produkHukum->total() }}</span>
                </div>
                <div class="pagination-clean">{{ $produkHukum->links() }}</div>
            </div>
        </div>

        {{-- MODAL PDF PREVIEW --}}
        <div x-show="pdfModalOpen" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="pdfModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="pdfModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden border border-gray-100 dark:border-gray-700">

                    {{-- Header PDF Modal --}}
                    <div
                        class="flex justify-between items-center px-4 py-3 bg-gray-100 dark:bg-gray-700 border-b dark:border-gray-600">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200">Preview Dokumen</h3>
                        {{-- HANYA TOMBOL CLOSE --}}
                        <button @click="pdfModalOpen = false"
                            class="text-gray-500 hover:text-red-600 p-1 rounded transition-colors" title="Tutup">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Body PDF Modal (Iframe) --}}
                    <div class="flex-1 bg-gray-200 dark:bg-gray-900 relative">
                        <iframe :src="activePdfUrl" class="w-full h-full border-none" title="PDF Preview"></iframe>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL CREATE & EDIT SAMA SEPERTI SEBELUMNYA --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="createModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col">
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Produk Hukum</h3>
                        <button @click="createModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <form id="createForm" action="{{ route('admin.produk-hukum.store') }}" method="POST"
                            enctype="multipart/form-data" autocomplete="off" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul
                                    Dokumen</label>
                                <input type="text" name="judul" x-model="judul" required
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis</label>
                                    <select name="jenis" x-model="jenis" required
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2.5">
                                        <option value="" disabled>Pilih Jenis</option>
                                        <option value="Peraturan Desa">Peraturan Desa</option>
                                        <option value="Peraturan Kepala Desa">Peraturan Kepala Desa</option>
                                        <option value="Keputusan Kepala Desa">Keputusan Kepala Desa</option>
                                        <option value="Surat Edaran">Surat Edaran</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                                    <input type="number" name="tahun" x-model="tahun" required min="2000"
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload
                                    PDF</label>
                                <input type="file" name="file" id="fileCreate" accept=".pdf" required
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer">
                                <p class="mt-1 text-xs text-gray-500">Maksimal 5MB (PDF only).</p>
                            </div>
                        </form>
                    </div>
                    <div
                        class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-gray-800">
                        <button type="button" @click="createModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                        <button type="button" onclick="document.getElementById('createForm').submit()"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm cursor-pointer">Simpan
                            Data</button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col">
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Produk Hukum</h3>
                        <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <form id="editForm" :action="updateUrl" method="POST" enctype="multipart/form-data"
                            autocomplete="off" class="space-y-5">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul
                                    Dokumen</label>
                                <input type="text" name="judul" x-model="judul" required
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis</label>
                                    <select name="jenis" x-model="jenis" required
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2.5">
                                        <option value="Peraturan Desa">Peraturan Desa</option>
                                        <option value="Peraturan Kepala Desa">Peraturan Kepala Desa</option>
                                        <option value="Keputusan Kepala Desa">Keputusan Kepala Desa</option>
                                        <option value="Surat Edaran">Surat Edaran</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                                    <input type="number" name="tahun" x-model="tahun" required min="2000"
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Update File
                                    PDF</label>
                                <div class="mb-2 text-sm text-blue-600" x-show="currentFile">
                                    <a :href="currentFile" target="_blank"
                                        class="hover:underline flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lihat File Saat Ini
                                    </a>
                                </div>
                                <input type="file" name="file" id="fileEdit" accept=".pdf"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer">
                                <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah file.</p>
                            </div>
                        </form>
                    </div>
                    <div
                        class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-gray-800">
                        <button type="button" @click="editModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                        <button type="button" onclick="document.getElementById('editForm').submit()"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm cursor-pointer">Update
                            Data</button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="deleteModalOpen"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-6 text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-6">
                            <svg class="h-8 w-8 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Hapus Data?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 px-2">Data produk hukum dan file PDF
                            terkait akan dihapus permanen.</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex justify-center gap-3 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-sm cursor-pointer">Ya,
                                Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
