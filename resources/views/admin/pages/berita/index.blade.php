@extends('admin.layouts.main')

@section('title', 'Berita & Artikel | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Trix Editor Styling */
        trix-toolbar .trix-button-group {
            background-color: #f3f4f6;
            border-radius: 0.5rem;
            margin-bottom: 10px;
            border: 1px solid #e5e7eb;
        }

        .dark trix-toolbar .trix-button-group {
            background-color: #374151;
            border-color: #4b5563;
        }

        .dark trix-toolbar .trix-button {
            border-bottom: none;
        }

        .dark trix-toolbar .trix-button--icon::before {
            filter: invert(1);
        }

        .dark trix-toolbar .trix-button.trix-active {
            background-color: #4b5563;
        }

        trix-editor {
            min-height: 200px;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: white;
            border-color: #9ca3af;
        }

        .dark trix-editor {
            background-color: #374151;
            color: white;
            border-color: #4b5563;
        }

        .trix-button--icon-attach {
            display: none !important;
        }

        /* Pagination Clean Style */
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
        imageModalOpen: false,
    
        // Data Sementara
        id: null,
        judul: '',
        tanggal: '',
        excerpt: '',
        content: '',
        currentImage: '',
        activeImageUrl: '',
        updateUrl: '',
        deleteUrl: '',
    
        // Helper
        photoPreview: null,
        isDragging: false,
    
        openCreate() {
            this.createModalOpen = true;
            this.id = null;
            this.judul = '';
            this.tanggal = new Date().toISOString().slice(0, 10);
            this.excerpt = '';
    
            // Reset Trix
            var element = document.querySelector('trix-editor[input=\'x-content-create\']');
            if (element) element.editor.loadHTML('');
    
            this.photoPreview = null;
            this.isDragging = false;
            if (document.getElementById('gambarCreate')) document.getElementById('gambarCreate').value = '';
        },
    
        openEdit(data) {
            this.id = data.id;
            this.judul = data.judul;
            this.tanggal = data.tanggal;
            this.excerpt = data.excerpt;
    
            // Load Trix
            var element = document.querySelector('trix-editor[input=\'x-content-edit\']');
            if (element) element.editor.loadHTML(data.content);
    
            this.currentImage = data.gambar_url;
            this.photoPreview = null;
            this.isDragging = false;
            if (document.getElementById('gambarEdit')) document.getElementById('gambarEdit').value = '';
    
            this.updateUrl = '{{ route('admin.berita.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', data.id);
            this.editModalOpen = true;
        },
    
        openDelete(id) {
            this.id = id;
            this.deleteUrl = '{{ route('admin.berita.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    Manajemen Berita
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola berita, artikel, dan informasi desa.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="{{ route('admin.berita.index') }}" method="GET" class="relative w-full md:w-64"
                    autocomplete="off">
                    <input type="text" name="q" placeholder="Cari judul..." value="{{ request('q') }}"
                        class="pl-10 pr-4 py-2.5 border border-gray-400 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 dark:text-white w-full transition shadow-sm hover:border-gray-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </form>

                @can('berita.create')
                    <button type="button" @click="openCreate()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-md transition-all transform hover:scale-105 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Berita
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
                            <th class="px-6 py-4 w-32">Thumbnail</th>
                            <th class="px-6 py-4">Judul & Tanggal</th>
                            @canany(['berita.update', 'berita.delete'])
                                <th class="px-6 py-4 text-right">Aksi</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($beritas as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $beritas->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative h-16 w-24 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 shadow-sm cursor-pointer group-hover:shadow-md transition-all"
                                        @click="openImageModal('{{ Storage::url($item->thumbnail) }}')">
                                        @if ($item->thumbnail)
                                            <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}"
                                                class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div
                                                class="h-full w-full flex items-center justify-center bg-gray-100 text-gray-400">
                                                No Img</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-1 line-clamp-1">
                                            {{ $item->title }}
                                        </span>
                                        <div class="text-xs text-gray-500 mb-2 line-clamp-1">{{ $item->excerpt }}</div>

                                        {{-- INFO TANGGAL & VIEWS --}}
                                        <div class="flex items-center gap-4 text-xs text-gray-400 dark:text-gray-500">
                                            {{-- Tanggal --}}
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-3.5 h-3.5 mr-1">
                                                    <path fill-rule="evenodd"
                                                        d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $item->date->isoFormat('D MMMM Y') }}
                                            </div>

                                            {{-- Views Counter --}}
                                            <div class="flex items-center text-gray-500 dark:text-gray-400"
                                                title="Total dilihat">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-3.5 h-3.5 mr-1">
                                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Dilihat {{ $item->views ?? 0 }} kali</span>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                                @canany(['berita.update', 'berita.delete'])
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            @can('berita.update')
                                                {{-- FIX: Menggunakan json_encode di dalam {{ }} agar escape quote aman --}}
                                                <button type="button"
                                                    @click="openEdit({
                                                        id: {{ $item->id }},
                                                        judul: {{ json_encode($item->title) }},
                                                        tanggal: '{{ $item->date->format('Y-m-d') }}',
                                                        excerpt: {{ json_encode($item->excerpt) }},
                                                        content: {{ json_encode($item->content) }},
                                                        gambar_url: '{{ $item->thumbnail ? Storage::url($item->thumbnail) : '' }}'
                                                    })"
                                                    class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                        class="w-4 h-4">
                                                        <path
                                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                                    </svg>
                                                </button>
                                            @endcan
                                            @can('berita.delete')
                                                <button type="button" @click="openDelete({{ $item->id }})"
                                                    class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 cursor-pointer">
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
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500">Belum ada berita.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $beritas->firstItem() ?? 0 }}</span> -
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $beritas->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $beritas->total() }}</span>
                </div>
                <div class="pagination-clean">{{ $beritas->links() }}</div>
            </div>
        </div>

        {{-- MODAL IMAGE PREVIEW --}}
        <div x-show="imageModalOpen" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm transition-opacity" @click="imageModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="imageModalOpen"
                    class="relative bg-transparent max-w-5xl w-full flex justify-center items-center">
                    <img :src="activeImageUrl"
                        class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain border-4 border-white/10">
                    <button @click="imageModalOpen = false"
                        class="absolute -top-12 right-0 md:-right-12 text-white/70 hover:text-white cursor-pointer p-2">
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
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">
                    {{-- Header Modal --}}
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Berita Baru</h3>
                        <button @click="createModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Body with Scroll --}}
                    <div class="flex-1 overflow-y-auto p-6">
                        <form id="createForm" action="{{ route('admin.berita.store') }}" method="POST"
                            enctype="multipart/form-data" autocomplete="off" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul
                                        Berita</label>
                                    <input type="text" name="title" x-model="judul" required
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                                    <input type="date" name="date" x-model="tanggal" required
                                        onclick="try{this.showPicker()}catch(e){}"
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2.5 cursor-pointer">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ringkasan
                                    (Excerpt)</label>
                                <textarea name="excerpt" x-model="excerpt" rows="2"
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2.5"
                                    placeholder="Teks singkat untuk preview..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Isi
                                    Berita</label>
                                <input id="x-content-create" type="hidden" name="content">
                                <trix-editor input="x-content-create" class="trix-content"></trix-editor>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Thumbnail</label>
                                <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                                    @drop.prevent="handleDrop($event, 'gambarCreate')"
                                    :class="{
                                        'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20': isDragging,
                                        'border-gray-400 dark:border-gray-600':
                                            !isDragging
                                    }"
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors relative cursor-pointer">

                                    <input id="gambarCreate" name="thumbnail" type="file"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required
                                        @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file)">

                                    <div class="space-y-1 text-center z-0" x-show="!photoPreview">
                                        <div class="flex justify-center text-indigo-500 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            <span class="font-medium text-indigo-600 dark:text-indigo-400">Klik untuk
                                                upload</span> atau drag ke sini
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP (Max 2MB)</p>
                                    </div>

                                    <div x-show="photoPreview" class="relative w-full h-40 z-20" style="display: none;">
                                        <img :src="photoPreview" class="w-full h-full object-cover rounded-md">
                                        <button type="button"
                                            @click.prevent="photoPreview = null; document.getElementById('gambarCreate').value = ''"
                                            class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 cursor-pointer shadow-lg z-30">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                        <button type="button" @click="createModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                        <button type="button" onclick="document.getElementById('createForm').submit()"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm cursor-pointer">Simpan
                            Berita</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col max-h-[90vh]">
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Berita</h3>
                        <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-500 cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6">
                        <form id="editForm" :action="updateUrl" method="POST" enctype="multipart/form-data"
                            autocomplete="off" class="space-y-5">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul
                                        Berita</label>
                                    <input type="text" name="title" x-model="judul" required
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2.5">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                                    <input type="date" name="date" x-model="tanggal" required
                                        onclick="try{this.showPicker()}catch(e){}"
                                        class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2.5 cursor-pointer">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ringkasan
                                    (Excerpt)</label>
                                <textarea name="excerpt" x-model="excerpt" rows="2"
                                    class="block w-full text-sm border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-4 py-2.5"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Isi
                                    Berita</label>
                                <input id="x-content-edit" type="hidden" name="content">
                                <trix-editor input="x-content-edit" class="trix-content"></trix-editor>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Update
                                    Thumbnail</label>
                                <div
                                    class="flex gap-4 items-start p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div
                                        class="w-24 h-24 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-500 relative">
                                        <template x-if="photoPreview"><img :src="photoPreview"
                                                class="w-full h-full object-cover"></template>
                                        <template x-if="!photoPreview"><img :src="currentImage"
                                                class="w-full h-full object-cover"></template>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" id="gambarEdit" name="thumbnail"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 cursor-pointer"
                                            @change="const file = $event.target.files[0]; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file)">
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak
                                            ingin mengubah foto saat ini.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div
                        class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
                        <button type="button" @click="editModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                        <button type="button" onclick="document.getElementById('editForm').submit()"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm cursor-pointer">Update
                            Berita</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Hapus Berita?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 px-2">Data berita dan foto akan dihapus
                            permanen.</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex justify-center gap-3 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 cursor-pointer">Batal</button>
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
