@extends('admin.layouts.main')@section('title', 'Roles | Admin Panel')@section('content')<style>
        [x-cloak] {
            display: none !important;
        }

        /* Pagination Clean Styling */
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

        /* Custom Scrollbar for Modal Content */
        .modal-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .modal-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>

    <div x-data="{
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
    
        roleId: null,
        roleName: '',
        selectedPermissions: [],
        updateUrl: '',
        deleteUrl: '',
    
        // Logic Centang Semua (Global)
        toggleAll(checked) {
            const checkboxes = document.querySelectorAll('.perm-checkbox');
            if (checked) {
                const allIds = Array.from(checkboxes).map(el => parseInt(el.value));
                this.selectedPermissions = [...new Set([...this.selectedPermissions, ...allIds])];
            } else {
                this.selectedPermissions = [];
            }
        },
    
        // Logic Centang Per Grup Resource
        toggleGroup(groupSlug, checked) {
            const groupCheckboxes = document.querySelectorAll('.group-' + groupSlug);
            const ids = Array.from(groupCheckboxes).map(el => parseInt(el.value));
    
            if (checked) {
                this.selectedPermissions = [...new Set([...this.selectedPermissions, ...ids])];
            } else {
                this.selectedPermissions = this.selectedPermissions.filter(id => !ids.includes(id));
            }
        },
    
        openEdit(id, name, permissions) {
            this.roleId = id;
            this.roleName = name;
            // Pastikan permissions dalam bentuk array
            this.selectedPermissions = typeof permissions === 'string' ? JSON.parse(permissions) : permissions;
    
            // Gunakan template literal untuk menghindari masalah encoding
            let baseUrl = '{{ route('roles.update', '__ID__') }}';
            this.updateUrl = baseUrl.replace('__ID__', id);
    
            this.editModalOpen = true;
        },
    
        openDelete(id) {
            let baseUrl = '{{ route('roles.destroy', '__ID__') }}';
            this.deleteUrl = baseUrl.replace('__ID__', id);
            this.deleteModalOpen = true;
        }
    }" x-cloak>

        {{-- HEADER SECTION --}}
        <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600 dark:text-indigo-400"
                        viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.352-.272-2.636-.759-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                    Manage Roles
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Kelola grup hak akses pengguna sistem.</p>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('roles.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Cari role..." value="{{ request('q') }}"
                        class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-800 dark:text-white w-full md:w-64 transition shadow-sm"
                        autocomplete="off">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </form>

                @can('roles.create')
                    <button type="button" @click="createModalOpen = true"
                        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" />
                        </svg>
                        Tambah
                    </button>
                @endcan
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 w-16 text-center">
                                #</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Nama Role
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                                Permissions</th>
                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 text-right">
                                @can('roles.update', 'roles.delete')
                                    Aksi
                                @endcan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($roles as $role)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                                    {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $role->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($role->permissions as $perm)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                                                {{ $perm->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic text-xs">No permissions set</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @can('roles.update')
                                            <button type="button"
                                                @click="openEdit({{ $role->id }}, '{{ addslashes($role->name) }}', {{ $role->permissions->pluck('id')->toJson() }})"
                                                class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800 cursor-pointer shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('roles.delete')
                                            <button type="button" @click="openDelete({{ $role->id }})"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg border border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 cursor-pointer shadow-sm">
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
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">Data role
                                    tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-gray-800">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $roles->firstItem() ?? 0 }}</span> sampai
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $roles->lastItem() ?? 0 }}</span> dari
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $roles->total() }}</span> data
                </div>
                <div class="pagination-clean">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL TEMPLATES --}}
        <template x-teleport="body">
            <div>
                {{-- Modal Create --}}
                <div x-show="createModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4"
                    x-transition>
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="createModalOpen = false"></div>
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/50 shrink-0">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Tambah Role Baru</h3>
                            <button @click="createModalOpen = false"
                                class="text-gray-400 hover:text-gray-600 cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('roles.store') }}" method="POST" class="overflow-hidden flex flex-col">
                            @csrf
                            <div class="p-6 space-y-6 overflow-y-auto modal-scroll">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama
                                        Role</label>
                                    <input type="text" name="name" required placeholder="Contoh: Operator Desa"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 dark:text-white shadow-sm transition-all">
                                </div>
                                <div class="pt-2">
                                    <div
                                        class="flex items-center justify-between mb-4 bg-indigo-50/50 dark:bg-indigo-900/20 p-3 rounded-xl border border-indigo-100/50 dark:border-indigo-800/50">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <span
                                                class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider italic">Konfigurasi
                                                Hak Akses</span>
                                        </div>
                                        <label
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-800 rounded-lg cursor-pointer hover:shadow-sm border border-gray-200 dark:border-gray-700 transition">
                                            <input type="checkbox" @change="toggleAll($event.target.checked)"
                                                class="rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                            <span
                                                class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Pilih
                                                Semua</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($all_permissions as $group => $permissions)
                                            @php $groupSlug = Str::slug($group); @endphp
                                            <div
                                                class="border border-gray-200 dark:border-gray-700 rounded-2xl p-4 bg-white dark:bg-gray-900/40 shadow-sm flex flex-col group/card hover:border-indigo-300 transition-all duration-300">
                                                <div
                                                    class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3 mb-3">
                                                    <span
                                                        class="text-sm font-black text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $group }}</span>
                                                    <label
                                                        class="inline-flex items-center gap-1.5 cursor-pointer bg-gray-50 dark:bg-gray-800 px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 transition-colors">
                                                        <input type="checkbox"
                                                            @change="toggleGroup('{{ $groupSlug }}', $event.target.checked)"
                                                            class="rounded text-indigo-600 focus:ring-indigo-200 w-3.5 h-3.5 cursor-pointer">
                                                        <span
                                                            class="text-[10px] text-gray-500 font-bold uppercase">Grup</span>
                                                    </label>
                                                </div>
                                                <div class="grid grid-cols-1 gap-2.5">
                                                    @foreach ($permissions as $p)
                                                        <label class="flex items-center gap-3 cursor-pointer group/item">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $p->id }}" x-model="selectedPermissions"
                                                                class="perm-checkbox group-{{ $groupSlug }} rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer transition-all">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-gray-400 group-hover/item:text-indigo-600 transition-colors">{{ $p->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 shrink-0">
                                <button type="button" @click="createModalOpen = false"
                                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 cursor-pointer transition">Batal</button>
                                <button type="submit"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg transition cursor-pointer">Simpan
                                    Role</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Edit --}}
                <div x-show="editModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4"
                    x-transition>
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="editModalOpen = false"></div>
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-700/50 shrink-0">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Edit Role</h3>
                            <button @click="editModalOpen = false"
                                class="text-gray-400 hover:text-gray-600 cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form :action="updateUrl" method="POST" class="overflow-hidden flex flex-col">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-6 overflow-y-auto modal-scroll">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama
                                        Role</label>
                                    <input type="text" name="name" x-model="roleName" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 dark:text-white shadow-sm transition-all">
                                </div>
                                <div class="pt-2">
                                    <div
                                        class="flex items-center justify-between mb-4 bg-indigo-50/50 dark:bg-indigo-900/20 p-3 rounded-xl border border-indigo-100/50 dark:border-indigo-800/50">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span
                                                class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider italic">Izin
                                                Role</span>
                                        </div>
                                        <label
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-800 rounded-lg cursor-pointer hover:shadow-sm border border-gray-200 dark:border-gray-700 transition">
                                            <input type="checkbox" @change="toggleAll($event.target.checked)"
                                                class="rounded text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                            <span
                                                class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">Pilih
                                                Semua</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($all_permissions as $group => $permissions)
                                            @php $groupSlug = Str::slug($group); @endphp
                                            <div
                                                class="border border-gray-200 dark:border-gray-700 rounded-2xl p-4 bg-white dark:bg-gray-900/40 shadow-sm flex flex-col group/card hover:border-indigo-300 transition-all duration-300">
                                                <div
                                                    class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3 mb-3">
                                                    <span
                                                        class="text-sm font-black text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $group }}</span>
                                                    <label
                                                        class="inline-flex items-center gap-1.5 cursor-pointer bg-gray-50 dark:bg-gray-800 px-2.5 py-1 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 transition-colors">
                                                        <input type="checkbox"
                                                            @change="toggleGroup('{{ $groupSlug }}', $event.target.checked)"
                                                            class="rounded text-indigo-600 focus:ring-indigo-200 w-3.5 h-3.5 cursor-pointer">
                                                        <span
                                                            class="text-[10px] text-gray-500 font-bold uppercase">Grup</span>
                                                    </label>
                                                </div>
                                                <div class="grid grid-cols-1 gap-2.5">
                                                    @foreach ($permissions as $p)
                                                        <label class="flex items-center gap-3 cursor-pointer group/item">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $p->id }}" x-model="selectedPermissions"
                                                                class="perm-checkbox group-{{ $groupSlug }} rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer transition-all">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-gray-400 group-hover/item:text-indigo-600 transition-colors">{{ $p->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3 shrink-0">
                                <button type="button" @click="editModalOpen = false"
                                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 cursor-pointer transition">Batal</button>
                                <button type="submit"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg transition cursor-pointer">Perbarui
                                    Role</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Delete --}}
                <div x-show="deleteModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4"
                    x-transition>
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModalOpen = false"></div>
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-8 text-center border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-20 h-20 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-red-100 dark:border-red-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3
                            class="text-2xl font-black text-gray-800 dark:text-white mb-3 tracking-tight text-center w-full">
                            Hapus Role?</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">Anda akan menghapus role ini
                            secara permanen. Aksi ini tidak dapat dibatalkan.</p>
                        <div class="flex gap-4 justify-center">
                            <button @click="deleteModalOpen = false"
                                class="flex-1 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-2xl font-bold hover:bg-gray-200 transition cursor-pointer">Batal</button>
                            <form :action="deleteUrl" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full px-6 py-3 bg-red-600 text-white rounded-2xl font-bold hover:bg-red-700 transition cursor-pointer">Ya,
                                    Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection
