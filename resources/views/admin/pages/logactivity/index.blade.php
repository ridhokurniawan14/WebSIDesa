@extends('admin.layouts.main')

@section('title', 'Log Activity | Admin Panel')

@section('content')
    <!-- CSS Trik untuk sembunyikan teks "Showing..." bawaan Laravel Pagination -->
    <style>
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

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-2">
                <!-- Icon Activity (Inline SVG) -->
                <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" class="w-7 h-7 text-blue-600 dark:text-blue-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                </svg>
                Log Activity
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Pantau aktivitas user dan keamanan sistem secara real-time.
            </p>
        </div>

        <!-- Action & Filter Toolbar -->
        <div x-data="{ searchOpen: {{ request('q') || request('method') ? 'true' : 'false' }} }" class="flex flex-wrap items-center gap-3">

            <form method="GET" action="{{ route('admin.logactivity') }}" class="flex items-center gap-2">

                <!-- Expandable Search Container -->
                <!-- Perbaikan Logic Border: Menggunakan ternary operator di Alpine untuk memastikan border muncul di light mode -->
                <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg border transition-colors duration-200"
                    :class="searchOpen ? 'border-gray-300 dark:border-gray-600 pr-2' : 'border-transparent'">

                    <!-- Trigger Icon -->
                    <button type="button" @click="searchOpen = !searchOpen"
                        class="p-2 rounded-lg text-gray-500 hover:text-blue-600 focus:outline-none transition-colors cursor-pointer"
                        :class="{ 'text-blue-600': searchOpen }">
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                    <!-- Input Field (Width Transition) -->
                    <input type="text" name="q" value="{{ request('q') }}" x-ref="searchInput"
                        class="bg-transparent border-none focus:ring-0 text-sm text-gray-900 dark:text-white placeholder-gray-400 transition-all duration-300 ease-in-out"
                        :class="searchOpen ? 'w-48 opacity-100 px-2' : 'w-0 opacity-0 px-0'" autocomplete="off"
                        placeholder="Search logs..." style="outline: none;">
                </div>

                <!-- Secondary Filters (Fade In Transition) -->
                <div x-show="searchOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                    class="flex items-center gap-2" style="display: none;">

                    <!-- Custom Dropdown (Appearance None + Custom Chevron) -->
                    <div class="relative">
                        <select name="method"
                            class="appearance-none w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm cursor-pointer">
                            <option value="">All Method</option>
                            @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $m)
                                <option value="{{ $m }}" @selected(request('method') === $m)>{{ $m }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Icon Panah Custom -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors cursor-pointer">
                        Filter
                    </button>

                    <!-- Reset Button -->
                    @if (request()->hasAny(['q', 'method']))
                        <a href="{{ route('admin.logactivity') }}"
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 shadow-sm transition-colors cursor-pointer"
                            title="Reset Filter">
                            <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tombol Hapus / Prune Log (Destructive Action Separated) -->
            <button onclick="openModal()"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 focus:outline-none dark:bg-gray-800 dark:text-red-400 dark:border-red-900 dark:hover:bg-gray-700 transition-colors shadow-sm cursor-pointer">
                <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Sisakan 10
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">User / Actor</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Action</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Method</th>
                        <th scope="col" class="px-6 py-4 font-semibold">IP Address</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Date</th>
                        <!-- Removed Details Column Header -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($logs as $log)
                        <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                            <!-- User Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @php
                                        $method = strtoupper($log->properties['method'] ?? 'GET');
                                    @endphp

                                    <div
                                        class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs uppercase
    {{ match ($method) {
        'POST' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
        'PUT', 'PATCH' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
        'DELETE' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
    } }}">
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $log->causer?->name ?? 'System' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->causer?->role ?? 'System' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Action / Subject Column -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ class_basename($log->subject_type ?? 'General') }}{{ $log->subject_type ? class_basename($log->subject_type) : 'Auth' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $log->description }}
                                    </span>
                                </div>
                            </td>

                            <!-- Method Column with Badges -->
                            <td class="px-6 py-4">
                                @php
                                    $method = strtoupper($log->properties['method'] ?? 'GET');

                                    $methodColor = match ($method) {
                                        'POST'
                                            => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'PUT',
                                        'PATCH'
                                            => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'DELETE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    };

                                    $dotColor = match ($method) {
                                        'POST' => 'bg-green-500',
                                        'PUT', 'PATCH' => 'bg-blue-500',
                                        'DELETE' => 'bg-red-500',
                                        default => 'bg-gray-500',
                                    };
                                @endphp

                                <span
                                    class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded text-xs font-medium {{ $methodColor }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $method }}
                                </span>
                            </td>

                            <!-- IP Column -->
                            <td class="px-6 py-4 font-mono text-xs text-gray-600 dark:text-gray-400">
                                {{ $log->properties['ip'] ?? '127.0.0.1' }}
                            </td>

                            <!-- Date Column -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-gray-200">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>

                            <!-- Removed Details Action Column TD -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <!-- Icon Inbox/Empty (Inline SVG) -->
                                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-10 h-10 mb-3 text-gray-300 dark:text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3.25a2.25 2.25 0 012.25-2.25h2.937a2.25 2.25 0 012.25 2.25v2.325a2.25 2.25 0 01-2.25 2.25h-2.937a2.25 2.25 0 01-2.25-2.25V10.75zm0 0H9.844l-.797-2.39a1.5 1.5 0 00-1.423-1.026H5.25" />
                                    </svg>
                                    <p>Belum ada aktivitas log yang terekam.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer / Pagination -->
        <div
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Menampilkan Data Text -->
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Menampilkan
                <span class="font-semibold text-gray-900 dark:text-white">{{ $logs->firstItem() }}</span>
                sampai
                <span class="font-semibold text-gray-900 dark:text-white">{{ $logs->lastItem() }}</span>
                dari
                <span class="font-semibold text-gray-900 dark:text-white">{{ $logs->total() }}</span>
                data
            </div>

            <!-- Links Pagination Laravel (Di-wrap class pagination-clean biar teks default hilang) -->
            <div class="pagination-clean">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRMATION (Hidden by default) -->
    <div id="deleteModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm p-4">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <!-- Modal Content -->
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full text-red-600 dark:text-red-400">
                        <!-- Icon Alert (Inline SVG) -->
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Log Lama?</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tindakan ini akan menghapus semua log kecuali 10 data terbaru. Apakah Anda yakin?
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 cursor-pointer text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Batal
                    </button>
                    <!-- Form Dummy Action -->
                    <form action="{{ route('admin.logactivity.prune') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 cursor-pointer py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none shadow-sm">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Modal Logic Sederhana
        function openModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endpush
