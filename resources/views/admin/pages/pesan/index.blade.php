@extends('admin.layouts.main')

@section('title', 'Pesan | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
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
        detailModalOpen: false,
        deleteModalOpen: false,
        deleteAllModalOpen: false,
    
        // Data untuk Modal Detail
        detail: {
            name: '',
            email: '',
            phone: '',
            subject: '',
            message: '',
            date: ''
        },
    
        // Data untuk Delete Single
        deleteUrl: '',
    
        // Logic Buka Modal Detail
        openDetail(name, email, phone, subject, message, date) {
            this.detail = { name, email, phone, subject, message, date };
            this.detailModalOpen = true;
        },
    
        // Logic Buka Modal Delete Single
        openDelete(url) {
            this.deleteUrl = url;
            this.deleteModalOpen = true;
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    {{-- Icon Amplop --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path
                            d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>
                    Pesan Masuk
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Daftar pesan dari pengunjung website (Form Kontak).
                </p>
            </div>

            <div class="flex items-center gap-3">
                {{-- SEARCH FORM --}}
                <form action="{{ route('pesan.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Cari pengirim/subject..." value="{{ request('q') }}"
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 dark:text-white w-full md:w-64 transition shadow-sm"
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

                @can('pesan.delete')
                    {{-- BUTTON DELETE ALL (Trigger Modal) --}}
                    <button type="button" @click="deleteAllModalOpen = true"
                        class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                clip-rule="evenodd" />
                        </svg>
                        Hapus Semua
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
                            <th class="px-6 py-4">Nama & Kontak</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Pesan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($pesans as $pesan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $loop->iteration + $pesans->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-semibold text-gray-800 dark:text-gray-200">{{ ucwords($pesan->nama_lengkap) }}</span>
                                        <span class="text-xs text-gray-500">{{ $pesan->email }}</span>
                                        <span class="text-xs text-gray-400">{{ $pesan->nomor_hp }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $pesan->subject }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ Str::limit($pesan->isi_pesan, 40) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        {{-- BUTTON DETAIL (Mata) --}}
                                        <button type="button"
                                            @click="openDetail(
                                                '{{ addslashes($pesan->nama_lengkap) }}', 
                                                '{{ addslashes($pesan->email) }}', 
                                                '{{ addslashes($pesan->nomor_hp) }}', 
                                                '{{ addslashes($pesan->subject) }}', 
                                                {{ json_encode($pesan->isi_pesan) }},
                                                '{{ $pesan->created_at->format('d M Y, H:i') }}'
                                            )"
                                            class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-colors duration-200 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/50 cursor-pointer"
                                            title="Lihat Detail Pesan">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>

                                        @can('pesan.delete')
                                            {{-- BUTTON DELETE (Tong Sampah) --}}
                                            <button type="button"
                                                @click="openDelete('{{ route('pesan.destroy', $pesan->id) }}')"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors duration-200 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/50 cursor-pointer"
                                                title="Hapus Pesan">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p>Tidak ada pesan masuk saat ini.</p>
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
                    Menampilkan
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pesans->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pesans->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $pesans->total() }}</span>
                    pesan
                </div>

                <div class="pagination-clean">
                    {{ $pesans->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL --}}
        <div x-show="detailModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="detailModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="detailModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">

                    <div class="flex justify-between items-center p-6 border-b dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pesan</h3>
                        <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Pengirim</label>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="detail.name"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Tanggal</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.date"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Email</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.email"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">No HP</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.phone || '-'"></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase">Subject</label>
                            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400" x-text="detail.subject">
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-2">Isi Pesan</label>
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed"
                                x-text="detail.message">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end">
                        <button type="button" @click="detailModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer shadow-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE SINGLE --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false">
            </div>
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
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Hapus Pesan Ini?</h3>
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
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">
                                Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE ALL (NEW) --}}
        <div x-show="deleteAllModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteAllModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="deleteAllModalOpen" x-transition:enter="transition ease-out duration-300"
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
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus SEMUA Pesan?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Tindakan ini akan <strong>menghapus seluruh data pesan</strong> secara permanen. Anda yakin?
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-center gap-3">
                        <button type="button" @click="deleteAllModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            Batal
                        </button>
                        <form action="{{ route('pesan.destroyAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">
                                Ya, Hapus Semua
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
