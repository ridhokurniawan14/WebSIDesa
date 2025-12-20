<!DOCTYPE html>
<html lang="id">

@include('admin.layouts.partials.head')

{{-- GLOBAL TOAST NOTIFICATION --}}
<div x-data="{
    show: {{ session()->has('success') || session()->has('error') ? 'true' : 'false' }},
    message: '{{ session('success') ?? session('error') }}',
    type: '{{ session()->has('success') ? 'success' : 'error' }}'
}" x-show="show" x-init="if (show) setTimeout(() => show = false, 5000)"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed top-6 right-6 z-50 max-w-sm w-full" style="display: none;">

    <div
        class="relative overflow-hidden rounded-xl border border-gray-100 bg-white p-4 shadow-xl dark:border-slate-700 dark:bg-slate-800 dark:shadow-slate-900/50">
        <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'" class="absolute top-0 bottom-0 left-0 w-1">
        </div>

        <div class="flex items-start gap-4 pl-2">
            <div :class="type === 'success' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' :
                'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full transition-colors">

                <svg x-show="type === 'success'" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>

                <svg x-show="type === 'error'" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <div class="flex-1 pt-0.5">
                <p x-text="type === 'success' ? 'Berhasil!' : 'Gagal!'"
                    class="font-bold text-gray-900 dark:text-white text-sm"></p>
                <p x-text="message" class="mt-1 text-sm text-gray-600 dark:text-slate-300 leading-relaxed"></p>
            </div>

            <button @click="show = false"
                class="shrink-0 text-gray-400 hover:text-gray-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none transition-colors">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

<body class="antialiased" x-data="adminLayout">
    <!-- Hilangkan initTheme() dari x-init body karena sudah ditangani script di head -->

    <div
        class="flex h-screen bg-white text-gray-800 dark:bg-slate-900 dark:text-slate-200 transition-colors duration-300">

        {{-- SIDEBAR --}}
        @include('admin.layouts.partials.sidebar')

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- HEADER --}}
            @include('admin.layouts.partials.header')

            {{-- CONTENT --}}
            <main
                class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-8 transition-colors duration-300 flex flex-col">
                <div class="flex-1">
                    @yield('content')
                </div>

                {{-- FOOTER --}}
                @include('admin.layouts.partials.footer')
            </main>

        </div>
    </div>

    @stack('scripts')
    @include('admin.layouts.partials.scripts')
    @include('admin.layouts.partials.welcome_animation')
</body>

</html>
