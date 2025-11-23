<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Website Desa' }}</title>
    @include('frontend.layouts.partials.seo')
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .header-scrolled {
            /* background-color: rgba(22, 163, 74, 0.85); */
            background-color: #16a34a;

            /* hijau green-600 tapi transparan */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
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
</head>
