@extends('admin.layouts.main')
@section('title', 'User Management | Admin Panel')
@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Kustomisasi tampilan pagination bawaan Laravel */
        .pagination-clean nav div[class*=&quot;
        justify-between&quot;
        ]&gt;

        div:first-child {
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
    {{-- Main Container AlpineJS --}}<div x-data="{
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
        showPassword: false,
        {{-- State untuk toggle mata password --}} // Data State
        userId: null,
        userName: '',
        userEmail: '',
        updateUrl: '',
        deleteUrl: '',
    
        // Logic Edit
        openEdit(user, roles) {
            this.userId = user.id;
            this.userName = user.name;
            this.userEmail = user.email;
            this.showPassword = false;
            {{-- Reset state mata saat buka modal --}}
            this.updateUrl = '{{ route('user.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', user.id);
    
            // Set Selected Roles
            let select = document.getElementById('edit_roles');
            Array.from(select.options).forEach(option => {
                option.selected = roles.includes(parseInt(option.value));
            });
    
            this.editModalOpen = true;
        },
    
        // Logic Delete
        openDelete(id, name) {
            this.userId = id;
            this.userName = name;
            this.deleteUrl = '{{ route('user.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', id);
            this.deleteModalOpen = true;
        },
    
        // Reset Create
        openCreate() {
            this.showPassword = false;
            this.createModalOpen = true;
        }
    }" x-cloak>{{-- HEADER SECTION --}}
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-8 h-8 text-indigo-600 dark:text-indigo-400">
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                            clip-rule="evenodd" />
                    </svg>
                    User Management
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Kelola data pengguna dan peranan (role) mereka di sistem.
                </p>
            </div>

            <div class="flex items-center gap-3">
                {{-- SEARCH FORM --}}
                <form action="{{ route('user.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Cari nama atau email..." value="{{ request('q') }}"
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

                @can('user.create')
                    {{-- BUTTON TAMBAH USER --}}
                    <button type="button" @click="openCreate()"
                        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah User
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
                            <th class="px-6 py-4">Informasi User</th>
                            <th class="px-6 py-4">Roles</th>
                            <th class="px-6 py-4 text-right px-10">
                                @can('user.update', 'user.delete')
                                    Aksi
                                @endcan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right px-10">
                                    <div class="flex justify-end items-center gap-2">
                                        @can('user.update')
                                            <button type="button"
                                                @click="openEdit({{ $user }}, {{ $user->roles->pluck('id') }})"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 cursor-pointer"
                                                title="Edit User">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('user.delete')
                                            <button type="button"
                                                @click="openDelete({{ $user->id }}, '{{ $user->name }}')"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 cursor-pointer"
                                                title="Hapus User">
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
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">Data user tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $users->firstItem() ?? 0 }}</span> sampai
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $users->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span> data
                </div>
                <div class="pagination-clean">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL CREATE --}}
        <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="createModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="createModalOpen" x-transition:enter="transition ease-out duration-300 opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transition-all">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-4 text-left">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tambah User Baru</h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Lengkap</label>
                                <input type="text" name="name" required autocomplete="off"
                                    placeholder="Contoh: John Doe"
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Gunakan nama lengkap sesuai kartu identitas.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat
                                    Email</label>
                                <input type="email" name="email" required autocomplete="off"
                                    placeholder="john.doe@example.com"
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Pastikan email aktif untuk keperluan notifikasi.</p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" required
                                        autocomplete="new-password" placeholder="••••••••"
                                        class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-3 pr-10 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all">
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-500 focus:outline-none transition-colors">
                                        <template x-if="!showPassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </template>
                                        <template x-if="showPassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Gunakan minimal 6 karakter kombinasi huruf dan angka.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih
                                    Role</label>
                                <select name="roles[]" required
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                    <option value="" disabled selected>Pilih hak akses user...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Role menentukan fitur apa saja yang bisa diakses
                                    user.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="createModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition-all cursor-pointer">Simpan
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="editModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="editModalOpen" x-transition:enter="transition ease-out duration-300 opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transition-all">
                    <form :action="updateUrl" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-4 text-left">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Edit User</h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Lengkap</label>
                                <input type="text" name="name" x-model="userName" required autocomplete="off"
                                    placeholder="Nama Lengkap User"
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                <input type="email" name="email" x-model="userEmail" required autocomplete="off"
                                    placeholder="Email Aktif"
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password
                                    Baru</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        autocomplete="new-password" placeholder="••••••••"
                                        class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white pl-3 pr-10 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-500 focus:outline-none transition-colors">
                                        <template x-if="!showPassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </template>
                                        <template x-if="showPassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-amber-600">Catatan: Kosongkan password jika tidak ingin diubah.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Update
                                    Role</label>
                                <select name="roles[]" id="edit_roles" required
                                    class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" @click="editModalOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition-all cursor-pointer">Update
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="deleteModalOpen = false"></div>
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-300 opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-sm overflow-hidden transition-all">
                    <div class="p-6">
                        <div
                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/40 mb-4 text-red-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white italic">Hapus User <span
                                class="font-bold not-italic" x-text="userName"></span>?</h3>
                        <p class="text-sm text-gray-500 mt-2">Data yang sudah dihapus tidak dapat dipulihkan kembali dari
                            database.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-center gap-3">
                        <button type="button" @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition-all cursor-pointer">Ya,
                                Hapus Permanen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>@endsection
