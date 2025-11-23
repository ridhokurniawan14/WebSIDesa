<!DOCTYPE html>
<html lang="id">
@include('frontend.layouts.partials.head')

<body class="bg-gray-100 text-gray-900">
    @include('frontend.layouts.partials.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')

    @vite('resources/js/app.js')

    @yield('scripts')
</body>

</html>
