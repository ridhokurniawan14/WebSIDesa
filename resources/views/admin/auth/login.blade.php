<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Desa Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $aplikasi->logo) }}">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* === ANIMASI BACKGROUND RANDOM === */
        @keyframes move1 {
            0% {
                transform: translate(0, 0) scale(1);
            }

            30% {
                transform: translate(40vw, 20vh) scale(1.2);
            }

            60% {
                transform: translate(10vw, 60vh) scale(0.9);
            }

            80% {
                transform: translate(-10vw, 30vh) scale(1.1);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        @keyframes move2 {
            0% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }

            40% {
                transform: translate(-60vw, -30vh) rotate(120deg) scale(1.3);
            }

            70% {
                transform: translate(-30vw, -70vh) rotate(240deg) scale(0.8);
            }

            100% {
                transform: translate(0, 0) rotate(360deg) scale(1);
            }
        }

        @keyframes move3 {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(50vw, -50vh) scale(0.8);
            }

            75% {
                transform: translate(20vw, -20vh) scale(1.2);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.5;
            border-radius: 50%;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: #86efac;
            animation: move1 25s infinite alternate ease-in-out;
        }

        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: #15803d;
            animation: move2 32s infinite alternate ease-in-out;
        }

        .blob-3 {
            bottom: 0;
            left: 10%;
            width: 400px;
            height: 400px;
            background: #4ade80;
            animation: move3 28s infinite alternate-reverse ease-in-out;
        }

        /* === MYSTERY CARD === */
        .mystery-card {
            filter: blur(15px) grayscale(80%);
            opacity: 0.4;
            transform: scale(0.9) translateY(20px);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .mystery-card:hover,
        .mystery-card:focus-within {
            filter: blur(0px) grayscale(0%);
            opacity: 1;
            transform: scale(1) translateY(0);
            box-shadow: 0 25px 50px -12px rgba(22, 101, 52, 0.3);
        }

        /* === FIX FLOATING LABEL === */
        .floating-input:not(:placeholder-shown)~label {
            top: -0.625rem;
            font-size: 0.75rem;
            color: #16a34a;
            background-color: white;
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }

        /* Transisi Tombol Login */
        #loginBtn {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hidden-btn {
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
            height: 0;
            overflow: hidden;
            margin-top: 0;
        }

        .visible-btn {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            height: auto;
            margin-top: 1rem;
        }

        /* === MODAL "HUKUMAN" === */
        #punishmentModal {
            transition: opacity 0.3s ease-in-out;
        }

        .modal-hidden {
            opacity: 0;
            pointer-events: none;
            z-index: -50;
        }

        .modal-visible {
            opacity: 1;
            pointer-events: auto;
            z-index: 100;
            /* Paling atas nutupin semuanya */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-50 relative overflow-hidden">

    <!-- Background Elements -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- Lapisan Kaca Tipis -->
    <div class="absolute inset-0 bg-white/20 backdrop-blur-[2px] z-0"></div>

    <!-- === MODAL HUKUMAN === -->
    <div id="punishmentModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center modal-hidden">
        <div
            class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl transform scale-100 animate-bounce">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">🤣</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Kasian Sekali!</h2>
            <p class="text-gray-600 mb-6">Masa isi form login aja salah sih bro? <br>Tunggu dulu ya, jangan buru-buru.
            </p>

            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 overflow-hidden">
                <div id="progressBar" class="bg-red-500 h-2.5 rounded-full transition-all duration-1000 ease-linear"
                    style="width: 100%"></div>
            </div>

            <p class="text-red-500 font-bold text-lg" id="countdownText">Tunggu 5 detik...</p>
        </div>
    </div>

    <!-- Main Card Container -->
    <div class="relative z-10 w-full max-w-md px-6">

        <!-- Kartu Login -->
        <!-- Logic untuk menghilangkan blur saat error DIHAPUS, jadi tetap nge-blur saat reload -->
        <div class="mystery-card bg-white/80 backdrop-blur-xl rounded-3xl border border-white/60 p-8 md:p-10 relative">

            <!-- Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 text-green-700 mb-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Admin Login</h1>
                <p class="text-gray-500 mt-2 text-sm">Masuk untuk mengelola website desa</p>
            </div>

            <!-- Form -->
            <form id="loginForm" method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf
                <!-- Note: Pesan Error dihilangkan karena diganti Modal -->

                <!-- Email Input Group -->
                <div class="relative group">
                    <!-- value="{{ old('email') }}" DIHAPUS agar input kembali kosong -->
                    <input type="email" id="email" name="email" required autocomplete="off"
                        class="floating-input peer w-full px-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-600 focus:bg-white transition-all duration-300 text-gray-700 placeholder-transparent"
                        placeholder=" ">
                    <label for="email"
                        class="absolute left-4 top-3.5 text-gray-400 text-sm transition-all duration-300 pointer-events-none
                        peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-green-600 peer-focus:bg-white peer-focus:px-2 peer-focus:font-medium">
                        Alamat Email
                    </label>
                </div>

                <!-- Password Input Group -->
                <div class="relative group">
                    <input type="password" id="password" name="password" required
                        class="floating-input peer w-full px-4 py-3.5 rounded-xl bg-gray-50/50 border border-gray-200 outline-none focus:ring-2 focus:ring-green-500/30 focus:border-green-600 focus:bg-white transition-all duration-300 text-gray-700 placeholder-transparent"
                        placeholder=" ">
                    <label for="password"
                        class="absolute left-4 top-3.5 text-gray-400 text-sm transition-all duration-300 pointer-events-none
                        peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-green-600 peer-focus:bg-white peer-focus:px-2 peer-focus:font-medium">
                        Kata Sandi
                    </label>

                    <!-- Toggle Password Button -->
                    <button type="button" id="togglePassword"
                        class="absolute right-4 top-3.5 text-gray-400 hover:text-green-600 transition-colors focus:outline-none p-1 rounded-full hover:bg-gray-100">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-2.968-3.091c.883-.759 1.942-1.396 3.125-1.789a20.086 20.086 0 0110.428.188M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <!-- Submit Button Container -->
                <div class="relative min-h-[20px] flex flex-col items-center justify-center">
                    <p id="helperText" class="text-xs text-gray-400 mt-2 text-center transition-colors duration-300">
                        Masukkan email & password untuk melanjutkan
                    </p>

                    <button type="submit" id="loginBtn"
                        class="hidden-btn w-full bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-bold py-4 rounded-xl shadow-xl shadow-green-600/30 active:scale-95 flex items-center justify-center gap-2 transition-all">
                        <span>Login</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-gray-400 tracking-wider uppercase">
                    Sistem Informasi Desa &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </p>
            </div>
        </div>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');
        const helperText = document.getElementById('helperText');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        // === LOGIC MODAL HUKUMAN ===
        function startPunishment() {
            const modal = document.getElementById('punishmentModal');
            const countdownText = document.getElementById('countdownText');
            const progressBar = document.getElementById('progressBar');
            let timeLeft = 5;

            // Tampilkan Modal
            modal.classList.remove('modal-hidden');
            modal.classList.add('modal-visible');

            // Timer Logic
            const timer = setInterval(() => {
                timeLeft--;
                countdownText.innerText = `Tunggu ${timeLeft} detik...`;

                // Update Progress Bar
                const percentage = (timeLeft / 5) * 100;
                progressBar.style.width = `${percentage}%`;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    modal.classList.remove('modal-visible');
                    modal.classList.add('modal-hidden');
                }
            }, 1000);
        }

        // Logic 1: Toggle Password Visibility
        togglePasswordBtn.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        });

        // Function untuk Validasi Email
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        // Logic 2: Validasi Strict & Tampilkan Tombol
        function checkInputs() {
            const emailValue = emailInput.value.trim();
            const passwordValue = passwordInput.value.trim();
            const emailValid = isValidEmail(emailValue);
            const passwordValid = passwordValue.length > 5;

            if (emailValid && passwordValid) {
                loginBtn.classList.remove('hidden-btn');
                loginBtn.classList.add('visible-btn');
                helperText.style.display = 'none';
            } else {
                loginBtn.classList.remove('visible-btn');
                loginBtn.classList.add('hidden-btn');
                helperText.style.display = 'block';

                if (emailValue === '' && passwordValue === '') {
                    helperText.innerText = "Masukkan email & password untuk melanjutkan";
                    helperText.className = "text-xs text-gray-400 mt-2 text-center transition-colors duration-300";
                } else if (!emailValid && emailValue !== '') {
                    helperText.innerText = "Format email tidak valid";
                    helperText.className = "text-xs text-red-500 mt-2 text-center transition-colors duration-300";
                } else if (!passwordValid && passwordValue !== '') {
                    helperText.innerText = "Password minimal 6 karakter";
                    helperText.className = "text-xs text-orange-500 mt-2 text-center transition-colors duration-300";
                } else {
                    helperText.innerText = "Lengkapi data login...";
                    helperText.className = "text-xs text-gray-400 mt-2 text-center transition-colors duration-300";
                }
            }
        }

        emailInput.addEventListener('input', checkInputs);
        passwordInput.addEventListener('input', checkInputs);
    </script>

    <!-- SCRIPT KHUSUS UNTUK MENANGKAP ERROR DARI LARAVEL -->
    <!-- Jika ada error, script ini akan dieksekusi otomatis saat halaman selesai loading -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                startPunishment();
            });
        </script>
    @endif

</body>

</html>
