@extends('admin.layouts.main')

@section('title', 'Pembangunan | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Pagination Styling */
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
        // Search State
        searchOpen: {{ request('q') || request('tahun') || request('status') ? 'true' : 'false' }},
    
        // Modal Logic
        deleteModalOpen: false,
        deleteUrl: '',
        photoModalOpen: false,
        currentPhotos: [],
        currentTitle: '',
        zoomOpen: false,
        zoomImage: '',
    
        openDelete(url) {
            this.deleteUrl = url;
            this.deleteModalOpen = true;
        },
    
        openPhotoModal(photos, title) {
            this.currentPhotos = photos;
            this.currentTitle = title;
            this.photoModalOpen = true;
        },
    
        openZoom(imgUrl) {
            this.zoomImage = imgUrl;
            this.zoomOpen = true;
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">

            {{-- JUDUL HALAMAN --}}
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-3">
                    <span
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Data Pembangunan
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Kelola dokumentasi dan realisasi pembangunan desa.
                </p>
            </div>

            {{-- TOOLBAR (Search & Filter) --}}
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('pembangunan.index') }}" class="flex items-center gap-2">

                    {{-- 1. Search Box (Expandable) --}}
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border transition-colors duration-200"
                        :class="searchOpen ? 'border-gray-300 dark:border-gray-600 pr-2' : 'border-transparent'">

                        <button type="button" @click="searchOpen = !searchOpen"
                            class="p-2 rounded-lg text-gray-500 hover:text-emerald-600 focus:outline-none transition-colors cursor-pointer"
                            :class="{ 'text-emerald-600': searchOpen }">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>

                        <input type="text" name="q" value="{{ request('q') }}"
                            class="bg-transparent border-none focus:ring-0 text-sm text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-300 ease-in-out"
                            :class="searchOpen ? 'w-48 opacity-100 px-2' : 'w-0 opacity-0 px-0'"
                            placeholder="Cari kegiatan..." style="outline: none;">
                    </div>

                    {{-- 2. Filter Dropdowns (Muncul saat searchOpen true) --}}
                    <div x-show="searchOpen" x-transition class="flex items-center gap-2" style="display: none;">

                        {{-- Filter Tahun --}}
                        <div class="relative">
                            <select name="tahun"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm cursor-pointer">
                                <option value="">Semua Tahun</option>
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

                        {{-- Filter Status --}}
                        <div class="relative">
                            <select name="status"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                </option>
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
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer shadow-sm transition-colors">
                            Filter
                        </button>

                        {{-- Tombol Reset --}}
                        @if (request()->hasAny(['q', 'tahun', 'status']))
                            <a href="{{ route('pembangunan.index') }}"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer shadow-sm transition-colors"
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
                @can('pembangunan.create')
                    <a href="{{ route('pembangunan.create') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors shadow-sm cursor-pointer shadow-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Data
                    </a>
                @endcan
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-medium border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 w-12 text-center">#</th>
                            <th class="px-6 py-4 text-center">Foto</th>
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4">Lokasi / Desa</th>
                            <th class="px-6 py-4">Anggaran & Tahun</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>

                                {{-- KOLOM FOTO: Button Lihat --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $photos = collect($item->foto)->map(function ($path) {
                                            return asset('storage/' . $path);
                                        });
                                    @endphp

                                    @if ($photos->count() > 0)
                                        <button @click="openPhotoModal({{ $photos }}, '{{ $item->judul }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition-colors cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Lihat ({{ $photos->count() }})
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No img</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $item->judul }}
                                    <div class="text-xs text-gray-500 mt-0.5 font-normal">{{ $item->volume }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $item->desa }}
                                    <div class="text-xs text-gray-400">{{ $item->lokasi }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-emerald-600 font-semibold tracking-tight">
                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">TA {{ $item->tahun }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border 
                                        {{ $item->status == 'Selesai' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                {{-- KOLOM AKSI --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        @can('pembangunan.update')
                                            <a href="{{ route('pembangunan.edit', $item->id) }}"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-colors duration-200 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/50 cursor-pointer"
                                                title="Edit Data">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('pembangunan.delete')
                                            <button type="button"
                                                @click="openDelete('{{ route('pembangunan.destroy', $item->id) }}')"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors duration-200 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/50 cursor-pointer"
                                                title="Hapus Data">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-base font-medium">Belum ada data pembangunan</p>
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
                        class="font-semibold text-gray-900 dark:text-white">{{ $data->firstItem() ?? 0 }}</span>
                    sampai <span class="font-semibold text-gray-900 dark:text-white">{{ $data->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-gray-900 dark:text-white">{{ $data->total() }}</span> data
                </div>
                <div class="pagination-clean">
                    {{ $data->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm p-6 text-center transform transition-all">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Data?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Data dan foto dokumentasi akan dihapus secara
                        permanen.</p>

                    <div class="mt-6 flex justify-center gap-3">
                        <button @click="deleteModalOpen = false"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/30 cursor-pointer">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL PHOTO GALLERY --}}
        <div x-show="photoModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" @click="photoModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden flex flex-col max-h-[85vh]">
                    {{-- Header Modal --}}
                    <div
                        class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="font-semibold text-gray-800 dark:text-white" x-text="currentTitle"></h3>
                        <button @click="photoModalOpen = false"
                            class="text-gray-400 hover:text-gray-500 cursor-pointer p-1 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Body: Grid Foto --}}
                    <div class="p-6 overflow-y-auto custom-scroll">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <template x-for="photo in currentPhotos" :key="photo">
                                <div class="relative group aspect-square rounded-xl overflow-hidden bg-gray-100 border border-gray-200 cursor-zoom-in"
                                    @click="openZoom(photo)">
                                    <img :src="photo"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity transform scale-75 group-hover:scale-100"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL ZOOM FULLSCREEN --}}
        <div x-show="zoomOpen" class="fixed inset-0 z-[60] overflow-hidden bg-black/95 flex items-center justify-center"
            style="display: none;">
            <button @click="zoomOpen = false"
                class="absolute top-4 right-4 text-white/70 hover:text-white cursor-pointer z-50 p-2 bg-black/20 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <img :src="zoomImage" class="max-w-full max-h-screen object-contain p-4 transition-transform"
                @click.away="zoomOpen = false">
        </div>

    </div>
@endsection
