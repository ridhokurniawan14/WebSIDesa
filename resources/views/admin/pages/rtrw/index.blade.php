@extends('admin.layouts.main')

@section('title', 'Data RT/RW | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Force hide default arrow in select for all browsers */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none;
        }
    </style>

    {{-- Main Container AlpineJS --}}
    <div x-data="{
        searchOpen: {{ request('q') ? 'true' : 'false' }},
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
        rtModalOpen: false,
    
        // Data RW yang sedang diedit/dilihat
        itemData: { id: null, dusun: '', nomor_rw: '', nama_ketua_rw: '' },
    
        // Data RT List (Master Detail)
        currentRwRts: [],
        currentRwId: null,
        currentRwName: '',
    
        // Data RT Baru (Untuk Bulk Insert)
        newRts: [],
    
        updateUrl: '',
        deleteUrl: '',
    
        // Logic Edit RW
        openEdit(item) {
            this.itemData = { ...item };
            this.updateUrl = '{{ route('admin.rtrw.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', item.id);
            this.editModalOpen = true;
        },
    
        // Logic Delete RW
        openDelete(id) {
            this.deleteUrl = '{{ route('admin.rtrw.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        },
    
        // Logic Open Modal RT
        openRtManager(item) {
            this.currentRwId = item.id;
            this.currentRwName = item.nomor_rw + ' (' + item.dusun + ')';
            this.currentRwRts = item.rts;
    
            // Reset form input dinamis
            this.newRts = [
                { nomor_rt: '', nama_ketua_rt: '' } // Mulai dengan 1 baris kosong
            ];
    
            this.rtModalOpen = true;
        },
    
        // Logic Tambah Baris RT
        addRtRow() {
            this.newRts.push({ nomor_rt: '', nama_ketua_rt: '' });
        },
    
        // Logic Hapus Baris RT (Inputan baru)
        removeRtRow(index) {
            this.newRts.splice(index, 1);
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                        <path
                            d="M11.25 4.533A9.707 9.707 0 006 3.75a9.753 9.753 0 00-3.255.555.75.75 0 00-.5.707v11.25c0 .312.162.614.435.816l6.75 4.908c.245.179.57.179.815 0l6.75-4.908a.99.99 0 00.435-.816V5.012a.75.75 0 00-.5-.707 9.753 9.753 0 00-3.255-.555 9.707 9.707 0 00-5.25.783z" />
                    </svg>
                    Data RT / RW
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola data struktur wilayah Dusun, RW, dan RT.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                {{-- SEARCH BAR --}}
                <form method="GET" action="{{ route('admin.rtrw.index') }}" class="flex items-center gap-2">
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border transition-colors duration-200"
                        :class="searchOpen ?
                            'border-indigo-300 dark:border-indigo-600 pr-2 ring-2 ring-indigo-100 dark:ring-indigo-900/30' :
                            'border-transparent'">

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
                            placeholder="Cari Dusun, RW, RT..." style="outline: none;">
                    </div>

                    {{-- Reset Filter Button if Search exists --}}
                    @if (request('q'))
                        <a href="{{ route('admin.rtrw.index') }}"
                            class="p-2 text-gray-500 hover:text-red-500 transition-colors" title="Reset Pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>

                {{-- Tombol Tambah RW --}}
                @can('rtrw.create')
                    <button type="button" @click="createModalOpen = true"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-sm transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah RW
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
                            <th class="px-6 py-4">Dusun</th>
                            <th class="px-6 py-4">Nomor RW</th>
                            <th class="px-6 py-4">Ketua RW / Detail Search</th>
                            <th class="px-6 py-4 text-center">Jml RT</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($data as $rw)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                        {{ $rw->dusun }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold">RW {{ $rw->nomor_rw }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    <div>{{ $rw->nama_ketua_rw ?? '-' }}</div>

                                    {{-- FITUR BARU: Menampilkan hasil pencarian RT langsung di tabel --}}
                                    @if (request('q'))
                                        @php
                                            $q = strtolower(request('q'));
                                            $matchingRts = $rw->rts->filter(function ($rt) use ($q) {
                                                return str_contains(strtolower($rt->nomor_rt), $q) ||
                                                    str_contains(strtolower($rt->nama_ketua_rt ?? ''), $q);
                                            });
                                        @endphp

                                        @if ($matchingRts->count() > 0)
                                            <div class="mt-2 flex flex-col gap-1">
                                                <span
                                                    class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Ditemukan
                                                    di:</span>
                                                @foreach ($matchingRts as $mRt)
                                                    <span
                                                        class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded w-fit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-3 h-3">
                                                            <path fill-rule="evenodd"
                                                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        RT {{ $mRt->nomor_rt }} ({{ $mRt->nama_ketua_rt ?? '-' }})
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Badge RT Button --}}
                                    <button @click="openRtManager({{ json_encode($rw) }})"
                                        class="inline-flex items-center justify-center px-3 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700 hover:bg-emerald-200 dark:bg-emerald-900/50 dark:text-emerald-400 dark:hover:bg-emerald-900 dark:border-emerald-800 border border-emerald-200 cursor-pointer transition-colors shadow-sm"
                                        title="Klik untuk Kelola RT">
                                        {{ $rw->rts->count() }} RT
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        {{-- Tombol Edit RW --}}
                                        @can('rtrw.update')
                                            <button type="button" @click="openEdit({{ json_encode($rw) }})"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/50 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endcan
                                        {{-- Tombol Hapus RW --}}
                                        @can('rtrw.delete')
                                            <button type="button" @click="openDelete({{ $rw->id }})"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/50 cursor-pointer">
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    @if (request('q'))
                                        Data tidak ditemukan untuk pencarian "{{ request('q') }}".
                                    @else
                                        Belum ada data RW.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION SUMMARY --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $data->firstItem() ?? 0 }}</span> -
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $data->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $data->total() }}</span> data
                </div>
                <div class="pagination-clean">{{ $data->links() }}</div>
            </div>
        </div>

        {{-- MODAL CREATE RW --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="createModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
                    <form action="{{ route('admin.rtrw.store') }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Data RW</h3>
                            <div class="space-y-4">
                                {{-- Dusun --}}
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dusun</label>
                                    <div class="relative">
                                        {{-- Class appearance-none ditambahkan untuk menghilangkan icon default --}}
                                        <select name="dusun"
                                            class="appearance-none w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-8">
                                            @foreach ($dusunOptions as $dsn)
                                                <option value="{{ $dsn }}">{{ $dsn }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                {{-- No RW --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                        RW</label>
                                    <input type="text" name="nomor_rw" placeholder="Contoh: 01"
                                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                        required>
                                </div>
                                {{-- Ketua RW --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                        Ketua RW</label>
                                    <input type="text" name="nama_ketua_rw" placeholder="Nama Lengkap"
                                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="createModalOpen = false"
                                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT RW --}}
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md overflow-hidden">
                    <form :action="updateUrl" method="POST">
                        @csrf @method('PUT')
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Edit Data RW</h3>
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dusun</label>
                                    <div class="relative">
                                        <select name="dusun" x-model="itemData.dusun"
                                            class="appearance-none w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-8">
                                            @foreach ($dusunOptions as $dsn)
                                                <option value="{{ $dsn }}">{{ $dsn }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                        RW</label>
                                    <input type="text" name="nomor_rw" x-model="itemData.nomor_rw"
                                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                        Ketua RW</label>
                                    <input type="text" name="nama_ketua_rw" x-model="itemData.nama_ketua_rw"
                                        class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2.5 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="editModalOpen = false"
                                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE RW --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm p-6 text-center overflow-hidden">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Hapus RW ini?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Data RW beserta <strong>SEMUA RT</strong> di
                        dalamnya akan dihapus.</p>
                    <div class="mt-6 flex justify-center gap-3">
                        <button @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">Ya,
                                Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL KHUSUS KELOLA RT (Master-Detail & Bulk Insert) --}}
        <div x-show="rtModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="rtModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="rtModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">

                    {{-- Header Modal RT --}}
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                            Kelola RT - RW <span x-text="currentRwName"></span>
                        </h3>
                        <button @click="rtModalOpen = false"
                            class="text-gray-400 cursor-pointer hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Content List RT (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto p-6 bg-white dark:bg-gray-800">

                        {{-- 1. DAFTAR RT YANG SUDAH ADA --}}
                        <div class="mb-8">
                            <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                Daftar RT Tersimpan</h4>
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                                        <tr>
                                            <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">
                                                No. RT</th>
                                            <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400">
                                                Ketua RT</th>
                                            <th class="px-4 py-2 text-right font-medium text-gray-500 dark:text-gray-400">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        <template x-for="rt in currentRwRts" :key="rt.id">
                                            <tr>
                                                <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">RT <span
                                                        x-text="rt.nomor_rt"></span></td>
                                                <td class="px-4 py-2 text-gray-600 dark:text-gray-400"
                                                    x-text="rt.nama_ketua_rt || '-'"></td>
                                                <td class="px-4 py-2 text-right">
                                                    @can('rtrw.delete')
                                                        <form
                                                            :action="'{{ route('admin.rt.destroy', 'ID_PALSU') }}'.replace(
                                                                'ID_PALSU', rt.id)"
                                                            method="POST" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20 cursor-pointer"
                                                                onclick="return confirm('Hapus RT ini?')" title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        </template>
                                        <tr x-show="currentRwRts.length === 0">
                                            <td colspan="3" class="px-4 py-3 text-center text-gray-500 italic text-xs">
                                                Belum ada RT tersimpan.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- 2. FORM TAMBAH RT (BULK INSERT) --}}
                        @can('rtrw.create')
                            <div
                                class="bg-indigo-50 dark:bg-indigo-900/20 p-5 rounded-lg border border-indigo-100 dark:border-indigo-800">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-300 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Tambah RT Baru
                                    </h4>
                                    <button type="button" @click="addRtRow()"
                                        class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 cursor-pointer flex items-center gap-1">
                                        + Tambah Baris
                                    </button>
                                </div>

                                <form action="{{ route('admin.rt.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rw_id" :value="currentRwId">

                                    <div class="space-y-3">
                                        <template x-for="(row, index) in newRts" :key="index">
                                            <div class="flex gap-3 items-start">
                                                <div class="w-24 shrink-0">
                                                    <input type="text" :name="'rts[' + index + '][nomor_rt]'"
                                                        x-model="row.nomor_rt" placeholder="No. RT"
                                                        class="w-full text-sm border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                                        required>
                                                </div>
                                                <div class="flex-1">
                                                    <input type="text" :name="'rts[' + index + '][nama_ketua_rt]'"
                                                        x-model="row.nama_ketua_rt" placeholder="Nama Ketua RT (Opsional)"
                                                        class="w-full text-sm border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                                </div>
                                                <button type="button" @click="removeRtRow(index)"
                                                    class="mt-2 text-red-500 hover:text-red-700 cursor-pointer"
                                                    title="Hapus Baris" x-show="newRts.length > 1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-indigo-200 dark:border-indigo-800">
                                        <button type="submit"
                                            class="w-full py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm cursor-pointer flex justify-center items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="w-4 h-4">
                                                <path
                                                    d="M3.375 3C2.339 3 1.5 3.839 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z" />
                                                <path fill-rule="evenodd"
                                                    d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Simpan Semua RT Baru
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
