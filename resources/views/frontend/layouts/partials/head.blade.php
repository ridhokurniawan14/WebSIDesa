<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Website Desa' }}</title>
    @include('frontend.layouts.partials.seo')
    @vite('resources/css/app.css')
    <style>
        .header-scrolled {
            background-color: rgba(22, 163, 74, 0.85);
            /* hijau green-600 tapi transparan */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
