<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Official Website {{ $aplikasi->nama_desa ?? 'Website Desa' }}</title>
    @include('frontend.layouts.partials.seo')
    @yield('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="/build/assets/app-BdqU5m6A.css">
    <script src="/build/assets/app-CAiCLEjY.js" defer></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $aplikasi->logo) }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    <style>
        /* Keadaan default (Halaman selain Home) */
        /* 1. Tambal celah 1px dengan shadow hijau (Trick Lem) */
        .header-normal {
            background-color: rgb(21, 128, 61) !important;
            box-shadow: 0 1px 0 0 rgb(21, 128, 61) !important;
            /* "Lem" warna hijau */
        }

        /* Halaman HOME awalnya transparan */
        .header-home {
            background-color: transparent;
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
        }

        /* Setelah scroll (untuk Home) */
        .header-scrolled {
            background-color: rgba(21, 128, 61, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content-offset {
            padding-top: 108px;
            /* Standar tinggi header py-3 */
        }

        /* 2. Logika Khusus Mobile (di bawah 768px) */
        @media (max-width: 767px) {

            /* Jika header yang aktif adalah header-normal,
       paksa konten di bawahnya naik sedikit */
            .header-normal+.content-offset>section:first-of-type,
            .header-normal~.content-offset>section:first-of-type {
                margin-top: -2px !important;
                /* Menaikkan konten 2px ke atas header */
            }

            .content-offset {
                /* Sesuaikan padding-top agar pas dengan tinggi header mobile kamu */
                padding-top: 77px;
            }
        }

        /* Menghilangkan paksa margin top pada section pertama di dalam content-offset */
        .content-offset>section:first-of-type {
            margin-top: 0 !important;
        }

        /* Animasi Gradient */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-gradientMove {
            background-size: 200% 200%;
            animation: gradientMove 10s ease-in-out infinite;
        }

        /* 3. Pastikan Beranda Tetap Aman (Tanpa Offset) */
        .header-home+.content-offset,
        .header-home~.content-offset {
            padding-top: 0 !important;
        }
    </style>
    @stack('styles')
</head>
