@extends('admin.layouts.main')

@section('title', 'APBDes | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Kustomisasi tampilan pagination */
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

        /* Hide default arrow in select for cleaner look */
        select::-ms-expand {
            display: none;
        }
    </style>

    {{-- Main Container AlpineJS --}}
    <div x-data="{
        searchOpen: {{ request('q') || request('jenis') || request('tahun') ? 'true' : 'false' }},
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
    
        // Data Sementara untuk Edit
        itemData: {
            id: null,
            uraian: '',
            jenis: 'Pendapatan',
            tahun: new Date().getFullYear(),
            anggaran: 0,
            realisasi: 0
        },
        updateUrl: '',
        deleteUrl: '',
    
        // Logic Edit
        openEdit(item) {
            this.itemData = { ...item };
    
            // Normalisasi 'jenis' agar sesuai dengan value Option
            if (this.itemData.jenis) {
                this.itemData.jenis = this.itemData.jenis.charAt(0).toUpperCase() + this.itemData.jenis.slice(1).toLowerCase();
            }
    
            this.updateUrl = '{{ route('apbdes.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', item.id);
            this.editModalOpen = true;
        },
    
        // Logic Delete
        openDelete(id) {
            this.deleteUrl = '{{ route('apbdes.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            {{-- JUDUL --}}
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-8 h-8 text-emerald-600 dark:text-emerald-400">
                        <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                        <path fill-rule="evenodd"
                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                            clip-rule="evenodd" />
                        <path
                            d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                    </svg>
                    Data APBDes
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola data Anggaran Pendapatan dan Belanja Desa.
                </p>
            </div>

            {{-- TOOLBAR (Search & Filter) --}}
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('apbdes.index') }}" class="flex items-center gap-2">

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
                            :class="searchOpen ? 'w-48 opacity-100 px-2' : 'w-0 opacity-0 px-0'"
                            placeholder="Cari uraian..." style="outline: none;">
                    </div>

                    {{-- 2. Filter Dropdowns --}}
                    <div x-show="searchOpen" x-transition class="flex items-center gap-2" style="display: none;">

                        {{-- Filter Jenis --}}
                        <div class="relative">
                            <select name="jenis"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm cursor-pointer">
                                <option value="">Semua Jenis</option>
                                <option value="Pendapatan" {{ request('jenis') == 'Pendapatan' ? 'selected' : '' }}>
                                    Pendapatan</option>
                                <option value="Belanja" {{ request('jenis') == 'Belanja' ? 'selected' : '' }}>Belanja
                                </option>
                                <option value="Pembiayaan" {{ request('jenis') == 'Pembiayaan' ? 'selected' : '' }}>
                                    Pembiayaan</option>
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

                        {{-- Filter Tahun --}}
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
                            <a href="{{ route('apbdes.index') }}"
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
                @can('apbdes.create')
                    <button type="button" @click="createModalOpen = true"
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
                            <th class="px-6 py-4 w-12 text-center">#</th>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Uraian</th>
                            <th class="px-6 py-4 text-right">Anggaran</th>
                            <th class="px-6 py-4 text-right">Realisasi</th>
                            <th class="px-6 py-4 text-center">Capaian (%)</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $item->tahun }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Badge Logic Case-Insensitive --}}
                                    @php
                                        $jenisLower = strtolower($item->jenis);
                                        $badgeClass = match ($jenisLower) {
                                            'pendapatan'
                                                => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900/50 dark:text-green-300 dark:border-green-800',
                                            'belanja'
                                                => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/50 dark:text-red-300 dark:border-red-800',
                                            'pembiayaan'
                                                => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/50 dark:text-blue-300 dark:border-blue-800',
                                            default
                                                => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $badgeClass }}">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $item->uraian }}
                                </td>
                                <td class="px-6 py-4 text-right font-mono text-gray-600 dark:text-gray-400">
                                    Rp {{ number_format($item->anggaran, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-mono text-gray-600 dark:text-gray-400">
                                    Rp {{ number_format($item->realisasi, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $persen = $item->anggaran > 0 ? ($item->realisasi / $item->anggaran) * 100 : 0;
                                        $colorClass =
                                            $persen >= 90
                                                ? 'bg-green-500'
                                                : ($persen >= 50
                                                    ? 'bg-yellow-500'
                                                    : 'bg-red-500');
                                    @endphp
                                    <div class="flex items-center gap-2 justify-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                            <div class="{{ $colorClass }} h-1.5 rounded-full"
                                                style="width: {{ min($persen, 100) }}%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-medium text-gray-700 dark:text-gray-300 w-10 text-right">{{ number_format($persen, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        @can('apbdes.update')
                                            <button type="button" @click="openEdit({{ json_encode($item) }})"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-colors duration-200 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/50 cursor-pointer"
                                                title="Edit Data">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endcan

                                        @can('apbdes.delete')
                                            <button type="button" @click="openDelete({{ $item->id }})"
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
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                            </path>
                                        </svg>
                                        <p class="text-base font-medium">Belum ada data APBDes</p>
                                        <p class="text-sm mt-1">Coba sesuaikan filter atau tambah data baru.</p>
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

        {{-- MODAL CREATE --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="createModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">

                    <form action="{{ route('apbdes.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tambah Data APBDes
                            </h3>

                            <div class="space-y-4">
                                {{-- Tahun --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun
                                        Anggaran</label>
                                    <input type="number" name="tahun" value="{{ date('Y') }}"
                                        class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                        required>
                                </div>

                                {{-- Jenis --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis</label>
                                    <div class="relative">
                                        <select name="jenis"
                                            class="appearance-none block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-3 pr-10 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                            <option value="Pendapatan">Pendapatan</option>
                                            <option value="Belanja">Belanja</option>
                                            <option value="Pembiayaan">Pembiayaan</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Uraian --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian</label>
                                    <input type="text" name="uraian" placeholder="Contoh: Dana Desa"
                                        class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                        required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Anggaran --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anggaran
                                            (Rp)</label>
                                        {{-- STEP 0.01 ADDED --}}
                                        <input type="number" name="anggaran" min="0" step="0.01"
                                            placeholder="0"
                                            class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                            required>
                                    </div>
                                    {{-- Realisasi --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Realisasi
                                            (Rp)</label>
                                        {{-- STEP 0.01 ADDED --}}
                                        <input type="number" name="realisasi" min="0" step="0.01"
                                            placeholder="0"
                                            class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="createModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">

                    <form :action="updateUrl" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit Data APBDes
                            </h3>

                            <div class="space-y-4">
                                {{-- Tahun --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun
                                        Anggaran</label>
                                    <input type="number" name="tahun" x-model="itemData.tahun"
                                        class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        required>
                                </div>

                                {{-- Jenis --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis</label>
                                    <div class="relative">
                                        <select name="jenis" x-model="itemData.jenis"
                                            class="appearance-none block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-3 pr-10 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                            <option value="Pendapatan">Pendapatan</option>
                                            <option value="Belanja">Belanja</option>
                                            <option value="Pembiayaan">Pembiayaan</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Uraian --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian</label>
                                    <input type="text" name="uraian" x-model="itemData.uraian"
                                        class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Anggaran --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Anggaran
                                            (Rp)</label>
                                        {{-- STEP 0.01 ADDED --}}
                                        <input type="number" name="anggaran" x-model="itemData.anggaran" min="0"
                                            step="0.01"
                                            class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                            required>
                                    </div>
                                    {{-- Realisasi --}}
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Realisasi
                                            (Rp)</label>
                                        {{-- STEP 0.01 ADDED --}}
                                        <input type="number" name="realisasi" x-model="itemData.realisasi"
                                            min="0" step="0.01"
                                            class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2.5 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="editModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all">
                    <div class="p-6 text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-300" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Hapus Data APBDes?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Data yang dihapus tidak bisa dikembalikan.
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-center gap-3">
                        <button type="button" @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">Ya,
                                Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
