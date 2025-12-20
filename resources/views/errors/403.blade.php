<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Admin Panel Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="bg-[#0a0a0a] text-slate-200 min-h-screen flex items-center justify-center p-6 selection:bg-indigo-500/30">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-blue-900/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-xl w-full text-center relative z-10">
        <!-- Icon Section - Dikasih margin top lebih besar biar nggak mepet -->
        <div class="relative mb-12 pt-16 flex justify-center">
            <div class="animate-float relative z-10">
                <div class="p-6 bg-slate-900/50 rounded-3xl border border-slate-700/50 shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="text-indigo-400">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        <circle cx="12" cy="16" r="1" />
                    </svg>
                </div>
            </div>
            <!-- Glow Effect -->
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl animate-pulse">
            </div>
        </div>

        <!-- Main Card -->
        <div class="glass-card p-10 md:p-14 rounded-[2.5rem] shadow-2xl border border-white/5">
            <span
                class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest uppercase bg-indigo-500/10 text-indigo-400 rounded-full border border-indigo-500/20">
                Error Code: 403
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                Akses Terbatas
            </h1>

            <p class="text-slate-400 text-lg mb-10 leading-relaxed max-w-md mx-auto">
                Waduh bro, sepertinya kamu mencoba mengakses area terlarang. Halaman ini hanya untuk otorisasi khusus.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-900/20 flex items-center justify-center gap-3 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Ke Dashboard
                </a>
                <button onclick="window.history.back()"
                    class="w-full sm:w-auto px-8 py-4 bg-slate-800/50 hover:bg-slate-800 text-slate-300 border border-slate-700 rounded-2xl transition-all duration-300 flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    Kembali
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-16 text-slate-500">
            <p class="text-sm tracking-wide font-medium">Admin Panel Web Desa <span class="text-slate-600 mx-2">•</span>
                v1.0.2</p>
        </div>
    </div>

</body>

</html>
