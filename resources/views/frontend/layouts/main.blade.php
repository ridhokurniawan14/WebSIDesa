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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: false,
            duration: 800,
            easing: 'ease-in-out',
            mirror: true,
        });
    </script>
</body>

</html>
