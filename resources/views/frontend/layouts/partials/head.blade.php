<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Website Desa' }}</title>
    @include('frontend.layouts.partials.seo')
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('images/lambang_daerah.png') }}" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    <style>
        /* keadaan default (digunakan untuk halaman selain home) */
        .header-normal {
            background-color: rgba(21, 128, 61, 0.85);
            /* hijau */
            backdrop-filter: blur(10px);
        }

        /* halaman HOME awalnya transparan */
        .header-home {
            background-color: transparent;
            backdrop-filter: blur(0px);
        }

        /* setelah scroll */
        .header-scrolled {
            background-color: rgba(21, 128, 61, 0.85);
            /* hijau */
            backdrop-filter: blur(10px);
        }

        .content-offset {
            padding-top: 107px;
            /* sesuaikan dengan py-3 + element dalam header */
        }

        /* mobile: header lebih tinggi → kecilin gap */
        @media (max-width: 768px) {
            .content-offset {
                padding-top: 76px;
                /* adjust sesuai UI real */
            }
        }

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
    </style>
    @stack('styles')
</head>
