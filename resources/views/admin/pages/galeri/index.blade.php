@extends('admin.layouts.main')

@section('title', 'Galeri Foto | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Styling Pagination Custom */
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
        editModalOpen: false,
        deleteModalOpen: false,
        imageModalOpen: false,
    
        // Data Sementara
        id: null,
        judul: '',
        tanggal: '',
        currentImage: '',
        activeImageUrl: '',
        updateUrl: '',
        deleteUrl: '',
    
        // Helper untuk preview gambar upload
        photoPreview: null,
        isDragging: false,
    
        openCreate() {
            this.createModalOpen = true;
            this.id = null;
            this.judul = '';
            this.tanggal = new Date().toISOString().slice(0, 10);
            this.photoPreview = null;
            this.isDragging = false;
            if (document.getElementById('gambarCreate')) document.getElementById('gambarCreate').value = '';
        },
    
        openEdit(data) {
            this.id = data.id;
            this.judul = data.judul;
            this.tanggal = data.tanggal;
            this.currentImage = data.gambar_url;
            this.photoPreview = null;
            this.isDragging = false;
    
            this.updateUrl = '{{ route('admin.galeri.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', data.id);
            this.editModalOpen = true;
        },
    
        openDelete(id) {
            this.id = id;
            this.deleteUrl = '{{ route('admin.galeri.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        },
    
        openImageModal(url) {
            this.activeImageUrl = url;
            this.imageModalOpen = true;
        },
    
        handleDrop(event, inputId) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const input = document.getElementById(inputId);
                    input.files = files;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.photoPreview = e.target.result };
                    reader.readAsDataURL(file);
                }
            }
        }
    }" x-cloak class="min-h-screen">

        {{-- HEADER SECTION --}}
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                            <path fill-rule="evenodd"
                                d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    Manajemen Galeri
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola dokumentasi kegiatan dan foto-foto galeri.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                {{-- SEARCH FORM --}}
                <form action="{{ route('admin.galeri.index') }}" method="GET" class="relative w-full md:w-64"
                    autocomplete="off">
                    <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}"
                        class="pl-10 pr-4 py-2.5 border border-gray-400 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 dark:text-white w-full transition shadow-sm hover:border-gray-500"
                        autocomplete="off">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </form>

                @can('galeri.create')
                    <button type="button" @click="openCreate()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md transition-all transform hover:scale-105 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Upload Foto
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
                            <th class="px-6 py-4 w-32">Preview</th>
                            <th class="px-6 py-4">Judul & Tanggal</th>
                            @canany(['galeri.update', 'galeri.delete'])
                                <th class="px-6 py-4 text-right">Aksi</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($galeris as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $galeris->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative h-16 w-24 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 shadow-sm cursor-pointer group-hover:shadow-md transition-all"
                                        @click="openImageModal('{{ Storage::url($item->gambar) }}')"
                                        title="Klik untuk memperbesar">
                                        <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}"
                                            class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                        <div
                                            class="absolute inset-0 bg-black/20 hidden group-hover:flex items-center justify-center transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="w-5 h-5 text-white drop-shadow-md">
                                                <path fill-rule="evenodd"
                                                    d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-1">
                                            {{ $item->judul }}
                                        </span>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-3.5 h-3.5 mr-1">
                                                <path fill-rule="evenodd"
                                                    d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}
                                        </div>
                                    </div>
                                </td>

                                @canany(['galeri.update', 'galeri.delete'])
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            @can('galeri.update')
                                                <button type="button"
                                                    @click="openEdit({
                                                        id: {{ $item->id }},
                                                        judul: '{{ addslashes($item->judul) }}',
                                                        tanggal: '{{ $item->tanggal }}',
                                                        gambar_url: '{{ Storage::url($item->gambar) }}'
                                                    })"
                                                    class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-colors border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 cursor-pointer"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                        class="w-4 h-4">
                                                        <path
                                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                                    </svg>
                                                </button>
                                            @endcan

                                            @can('galeri.delete')
                                                <button type="button" @click="openDelete({{ $item->id }})"
                                                    class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 cursor-pointer"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                        class="w-4 h-4">
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
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 text-base">Belum ada galeri foto yang ditambahkan.</p>
                                        @can('galeri.create')
                                            <button @click="openCreate()"
                                                class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium cursor-pointer">Tambah
                                                Foto Baru</button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer / Pagination --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $galeris->firstItem() ?? 0 }}</span> -
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $galeris->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $galeris->total() }}</span>
                </div>
                <div class="pagination-clean">
                    {{ $galeris->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL IMAGE PREVIEW (LIGHTBOX) --}}
        <div x-show="imageModalOpen" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm transition-opacity" @click="imageModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="imageModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-transparent max-w-5xl w-full flex justify-center items-center outline-none">
                    <img :src="activeImageUrl"
                        class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain border-4 border-white/10"
                        alt="Preview">
                    <button @click="imageModalOpen = false"
                        class="absolute -top-12 right-0 md:-right-12 text-white/70 hover:text-white transition-colors cursor-pointer p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL CREATE --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="createModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700">

                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Galeri Baru</h3>
                        <button @click="createModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul
                                    Galeri</label>
                                <input type="text" name="judul" x-model="judul" required
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2.5"
                                    placeholder="Contoh: Kegiatan Workshop Desa">
                                @error('judul')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                    Kegiatan</label>
                                <input type="date" name="tanggal" x-model="tanggal" required
                                    onclick="try{this.showPicker()}catch(e){}"
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm px-4 py-2.5 cursor-pointer">
                                @error('tanggal')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input Gambar with Drag & Drop --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload
                                    Foto</label>
                                <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                                    @drop.prevent="handleDrop($event, 'gambarCreate')"
                                    :class="{
                                        'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20': isDragging,
                                        'border-gray-400 dark:border-gray-600':
                                            !isDragging
                                    }"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors relative">

                                    <div class="space-y-1 text-center" x-show="!photoPreview">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                            <label for="gambarCreate"
                                                class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload file</span>
                                                <input id="gambarCreate" name="gambar" type="file" class="sr-only"
                                                    required
                                                    @change="const file = $event.target.files[0]; 
                                                                const reader = new FileReader(); 
                                                                reader.onload = (e) => { photoPreview = e.target.result }; 
                                                                reader.readAsDataURL(file)">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP up to 2MB</p>
                                    </div>

                                    <div x-show="photoPreview" class="relative w-full h-48">
                                        <img :src="photoPreview" class="w-full h-full object-cover rounded-md">
                                        <button type="button"
                                            @click="photoPreview = null; document.getElementById('gambarCreate').value = ''"
                                            class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 focus:outline-none cursor-pointer">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @error('gambar')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="createModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm cursor-pointer">Simpan
                                Galeri</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700">

                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Galeri</h3>
                        <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form :action="updateUrl" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul
                                    Galeri</label>
                                <input type="text" name="judul" x-model="judul" required
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2.5">
                                @error('judul')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                    Kegiatan</label>
                                <input type="date" name="tanggal" x-model="tanggal" required
                                    onclick="try{this.showPicker()}catch(e){}"
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-2.5 cursor-pointer">
                                @error('tanggal')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gambar Edit Logic --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update
                                    Foto</label>
                                <div class="flex gap-4 items-start">
                                    <div
                                        class="w-32 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                        <template x-if="photoPreview">
                                            <img :src="photoPreview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!photoPreview">
                                            <img :src="currentImage" class="w-full h-full object-cover">
                                        </template>
                                    </div>

                                    <div class="flex-1">
                                        <input type="file" id="gambarEdit" name="gambar"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 cursor-pointer"
                                            @change="const file = $event.target.files[0]; 
                                                     const reader = new FileReader(); 
                                                     reader.onload = (e) => { photoPreview = e.target.result }; 
                                                     reader.readAsDataURL(file)">
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin
                                            mengubah foto.</p>
                                        @error('gambar')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="editModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm cursor-pointer">Update
                                Galeri</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Hapus Galeri?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 px-2">
                            Data dan file foto akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-center gap-3">
                        <button type="button" @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
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
