<!DOCTYPE html>
<html lang="id">
@include('admin.layouts.partials.head')

<body class="antialiased transition-colors duration-300" x-data="adminLayout" x-init="initTheme()">

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
