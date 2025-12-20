@extends('admin.layouts.main')

@section('title', 'Permissions | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Kustomisasi tampilan pagination bawaan Laravel */
        .pagination-clean nav div[class*="justify-between"]>div:first-child {
            display: none;
        }

        /* Fallback jika struktur beda: sembunyikan tag p di dalam nav pagination */
        .pagination-clean nav p {
            display: none !important;
        }

        /* Pastikan tombol ada di kanan */
        .pagination-clean nav {
            display: flex;
            justify-content: flex-end;
        }
    </style>


    {{-- Main Container AlpineJS --}}
    <div x-data="{
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
    
        // Data Sementara
        permissionId: null,
        permissionName: '',
        updateUrl: '',
        deleteUrl: '',
    
        // Logic Edit
        openEdit(id, name) {
            this.permissionId = id;
            this.permissionName = name;
            this.updateUrl = '{{ route('permissions.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.editModalOpen = true;
        },
    
        // Logic Delete
        openDelete(id) {
            this.permissionId = id;
            this.deleteUrl = '{{ route('permissions.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                        <path fill-rule="evenodd"
                            d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.352-.272-2.636-.759-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                    Manage Permissions
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Atur hak akses role aplikasi di sini.
                </p>
            </div>

            <div class="flex items-center gap-3">
                {{-- SEARCH FORM --}}
                <form action="{{ route('permissions.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Cari permission..." value="{{ request('q') }}"
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

                @can('permissions.create')
                    {{-- BUTTON TAMBAH --}}
                    <button type="button" @click="createModalOpen = true"
                        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah
                    </button>
                @endcan
            </div>
        </div>

        {{-- TABLE CARD (Fixed: Removed min-h-[400px]) --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            {{-- Tabel Data --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 font-medium border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 w-16 text-center">#</th>
                            <th class="px-6 py-4">Nama Permission</th>
                            <th class="px-6 py-4">Guard</th>
                            <th class="px-6 py-4 text-right">
                                @can('permissions.update', 'permissions.delete')
                                    Aksi
                                @endcan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($permissions as $permission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    {{ $permissions->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $permission->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        {{ $permission->guard_name ?? 'web' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        @can('permissions.update')
                                            {{-- BUTTON EDIT --}}
                                            <button type="button"
                                                @click="openEdit({{ $permission->id }}, '{{ $permission->name }}')"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-colors duration-200 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 dark:hover:bg-blue-900/50 cursor-pointer"
                                                title="Edit Permission">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endcan

                                        @can('permissions.delete')
                                            {{-- BUTTON DELETE --}}
                                            <button type="button" @click="openDelete({{ $permission->id }})"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors duration-200 border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/50 cursor-pointer"
                                                title="Hapus Permission">
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
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data permission ditemukan.
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
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $permissions->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $permissions->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $permissions->total() }}</span>
                    data
                </div>

                <div class="pagination-clean">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL CREATE --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="createModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tambah Permission</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Permission</label>
                                <input type="text" name="name"
                                    class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                    placeholder="Contoh: users.create" required>
                                {{-- Added Helper Text --}}
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Gunakan format
                                    <code>resource.action</code> agar rapi.
                                </p>
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
                    <form :action="updateUrl" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Edit Permission</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Permission</label>
                                <input type="text" name="name" x-model="permissionName"
                                    class="block w-full text-sm border border-gray-400 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    required>
                                {{-- Added Helper Text --}}
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Gunakan format
                                    <code>resource.action</code> agar rapi.
                                </p>
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
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Hapus Permission?</h3>
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
