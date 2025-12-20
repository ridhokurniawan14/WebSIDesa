@extends('admin.layouts.main')

@section('title', 'Log Activity | Admin Panel')

@section('content')
    <!-- CSS Pagination & Select Clean -->
    <style>
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

        select::-ms-expand {
            display: none;
        }
    </style>

    <!-- Main Container dengan Alpine JS -->
    <div x-data="{
        searchOpen: {{ request('q') || request('method') ? 'true' : 'false' }},
        deleteModalOpen: false,
        detailModalOpen: false,
        detailData: {},
        openDetail(data) {
            this.detailData = data;
            this.detailModalOpen = true;
        }
    }">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-7 h-7 text-blue-600 dark:text-blue-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    Log Activity
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                    Pantau aktivitas user dan keamanan sistem secara real-time.
                </p>
            </div>

            <!-- Toolbar -->
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('admin.logactivity') }}" class="flex items-center gap-2">
                    <!-- Search & Filter -->
                    <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border transition-colors duration-200"
                        :class="searchOpen ? 'border-gray-300 dark:border-gray-600 pr-2' : 'border-transparent'">
                        <button type="button" @click="searchOpen = !searchOpen"
                            class="p-2 rounded-lg text-gray-500 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer"
                            :class="{ 'text-blue-600': searchOpen }">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                        <input type="text" name="q" value="{{ request('q') }}" x-ref="searchInput"
                            class="bg-transparent border-none focus:ring-0 text-sm text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-300 ease-in-out"
                            :class="searchOpen ? 'w-48 opacity-100 px-2' : 'w-0 opacity-0 px-0'"
                            placeholder="Search logs..." style="outline: none;">
                    </div>

                    <div x-show="searchOpen" x-transition class="flex items-center gap-2" style="display: none;">
                        <div class="relative">
                            <select name="method"
                                class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm cursor-pointer">
                                <option value="">All Method</option>
                                @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $m)
                                    <option value="{{ $m }}" @selected(request('method') === $m)>{{ $m }}
                                    </option>
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
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">Filter</button>
                        @if (request()->hasAny(['q', 'method']))
                            <a href="{{ route('admin.logactivity') }}"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>

                <button @click="deleteModalOpen = true"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 focus:outline-none dark:bg-gray-800 dark:text-red-400 dark:border-red-900 dark:hover:bg-gray-700 transition-colors shadow-sm cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Sisakan 10
                </button>
            </div>
        </div>

        <!-- Table Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">User / Actor</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Action & Subject</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Method</th>
                            <th scope="col" class="px-6 py-4 font-semibold">IP Address</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($logs as $log)
                            <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                                <!-- User -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold text-xs uppercase">
                                            {{ substr($log->causer->name ?? 'Sy', 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $log->causer->name ?? 'System' }}
                                            </div>
                                            <!-- Menampilkan email jika role tidak tersedia di model User standard -->
                                            <div class="text-xs text-gray-500">
                                                {{ $log->causer->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Action & Changes -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-start gap-1">
                                        <!-- Subject Type -->
                                        <span class="text-gray-900 dark:text-gray-100 font-medium">
                                            {{ class_basename($log->subject_type ?? 'General') }}
                                        </span>

                                        <!-- Description -->
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $log->description }}
                                        </span>

                                        <!-- Logic Tombol Detail FIX: Menggunakan json_encode + JSON_HEX_APOS agar aman dari error kutip -->
                                        @if (isset($log->properties['changes']) && !empty($log->properties['changes']))
                                            <button @click='openDetail({!! json_encode($log->properties['changes'], JSON_HEX_APOS) !!})'
                                                class="mt-1 inline-flex items-center gap-1 text-[10px] font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-3 h-3">
                                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Lihat Perubahan
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <!-- Method -->
                                <td class="px-6 py-4">
                                    @php
                                        $methodName = $log->properties['method'] ?? 'GET';
                                        $methodColor = match (strtoupper($methodName)) {
                                            'POST'
                                                => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'PUT',
                                            'PATCH'
                                                => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'DELETE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded text-xs font-medium {{ $methodColor }}">
                                        {{ $methodName }}
                                    </span>
                                </td>

                                <!-- IP -->
                                <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-400">
                                    {{ $log->properties['ip'] ?? '127.0.0.1' }}
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-200">
                                        {{ $log->created_at->diffForHumans() }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada aktivitas log
                                    yang terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan <span class="font-semibold">{{ $logs->firstItem() }}</span> sampai <span
                        class="font-semibold">{{ $logs->lastItem() }}</span> dari <span
                        class="font-semibold">{{ $logs->total() }}</span> data
                </div>
                <div class="pagination-clean">{{ $logs->links() }}</div>
            </div>
        </div>

        <!-- 1. DELETE MODAL -->
        <div x-show="deleteModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm p-4"
            x-transition.opacity>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md overflow-hidden"
                @click.away="deleteModalOpen = false">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full text-red-600 dark:text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Log Lama?</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sisakan 10 data terbaru saja?</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="deleteModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 cursor-pointer">Batal</button>
                        <form action="{{ route('admin.logactivity.prune') }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">Ya,
                                Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. DETAIL CHANGES MODAL -->
        <div x-show="detailModalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm p-4"
            x-transition.opacity>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
                @click.away="detailModalOpen = false">

                <!-- Modal Header -->
                <div
                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-indigo-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Detail Perubahan
                    </h3>
                    <button @click="detailModalOpen = false"
                        class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <div class="relative overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-1/3">Field / Kolom</th>
                                    <th scope="col" class="px-6 py-3 w-1/3 text-red-600 dark:text-red-400">Sebelum
                                        (Old)</th>
                                    <th scope="col" class="px-6 py-3 w-1/3 text-green-600 dark:text-green-400">Sesudah
                                        (New)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                <!-- Loop Data Alpine JS -->
                                <template x-for="(change, field) in detailData" :key="field">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize"
                                            x-text="field.replace(/_/g, ' ')"></td>
                                        <td class="px-6 py-4 font-mono text-xs text-red-500 break-all"
                                            x-text="change.old ?? '-'"></td>
                                        <td class="px-6 py-4 font-mono text-xs text-green-600 dark:text-green-400 font-semibold break-all"
                                            x-text="change.new"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div
                    class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 flex justify-end">
                    <button @click="detailModalOpen = false"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div> <!-- End Alpine Container -->
@endsection