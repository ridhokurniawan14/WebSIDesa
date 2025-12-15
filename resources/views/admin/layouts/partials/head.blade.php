<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Custom Styles (Fallback CSS) --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Fallback background jika Tailwind belum load */
        html.dark {
            background-color: #111827;
        }

        html:not(.dark) {
            background-color: #f9fafb;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    {{-- HANYA LOAD LIBRARY ALPINE SAJA DISINI --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
