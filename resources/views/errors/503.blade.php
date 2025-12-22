<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Dalam Pemeliharaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animasi Floating Lebih Luas Jangkauannya */
        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(50px, -50px) rotate(10deg);
            }

            66% {
                transform: translate(-40px, 40px) rotate(-5deg);
            }
        }

        .animate-blob {
            animation: float 10s ease-in-out infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Animasi Gear */
        .animate-spin-slow {
            animation: spin 12s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Animasi Content */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up-1 {
            animation: slideUpFade 0.8s ease-out forwards;
        }

        .animate-slide-up-2 {
            animation: slideUpFade 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }

        .animate-slide-up-3 {
            animation: slideUpFade 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gray-100 overflow-hidden relative h-screen flex items-center justify-center px-4">

    <div class="absolute inset-0 w-full h-full overflow-hidden">
        <div
            class="absolute top-0 left-0 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob">
        </div>

        <div
            class="absolute top-0 right-0 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000">
        </div>

        <div
            class="absolute -bottom-32 left-20 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-4000">
        </div>
    </div>

    <div
        class="relative z-10 max-w-lg w-full bg-white/70 backdrop-blur-xl p-8 md:p-12 rounded-3xl shadow-2xl border border-white/50 text-center animate-slide-up-1">

        {{-- Icon Section --}}
        <div class="mb-8 relative flex justify-center items-center">
            <svg class="w-40 h-40 text-indigo-500/10 animate-spin-slow absolute scale-150"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            </svg>

            <div
                class="relative z-10 bg-gradient-to-tr from-indigo-600 to-purple-600 p-5 rounded-2xl shadow-xl shadow-indigo-300 transform rotate-3 hover:rotate-6 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4 animate-slide-up-2 tracking-tight">
            Under Maintenance
        </h1>

        <p class="text-gray-600 mb-8 leading-relaxed text-base md:text-lg animate-slide-up-3">
            Sistem kami sedang istirahat sebentar untuk pembaruan fitur. <br class="hidden md:block">Kami akan segera
            kembali dengan performa yang lebih baik!
        </p>

        <div class="animate-slide-up-3">
            <div
                class="inline-flex items-center gap-2 px-5 py-2 bg-white/80 rounded-full text-sm font-bold text-indigo-600 border border-indigo-100 shadow-sm">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
                Status: Updating System...
            </div>
        </div>
    </div>
    @if (isset($preview) && $preview)
        <div class="fixed bottom-5 right-5 z-50">
            {{-- TRIK: Gunakan URL Secret agar browser dipaksa ambil tiket resmi --}}
            <a href="{{ url($secret ?? 'admin-access') }}"
                class="px-5 py-2.5 bg-white/90 hover:bg-white text-indigo-600 font-bold rounded-full text-xs shadow-lg border border-indigo-100 transition-all flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Pengaturan
            </a>
        </div>
    @endif
</body>

</html>
