<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waduh! Nyasar - Desa Makmur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            overflow: hidden;
            background: linear-gradient(180deg, #87CEEB 0%, #E0F7FA 40%, #A7F3D0 100%);
        }

        /* Landscape Layers */
        .layer {
            position: absolute;
            width: 100%;
            bottom: 0;
            left: 0;
            transition: transform 0.1s ease-out;
        }

        /* Mountains */
        .mountain-bg {
            height: 60vh;
            /* Diperbesar manual tanpa transform scale */
            width: 120%;
            /* Lebih lebar dari layar */
            left: -10%;
            /* Posisi tengah (ada sisa kiri kanan) */
            background: #065F46;
            /* dark green */
            border-radius: 100% 100% 0 0;
            /* Hapus transform: scale(1.5) agar tidak konflik dengan JS */
            bottom: -15vh;
            z-index: 1;
        }

        .mountain-fg {
            height: 45vh;
            background: #059669;
            /* emerald 600 */
            border-radius: 80% 80% 0 0;
            left: -10%;
            /* Sesuaikan buffer */
            width: 120%;
            /* Lebih lebar dari layar */
            bottom: -15vh;
            z-index: 2;
        }

        /* Rice Fields (Sawah) */
        .sawah {
            height: 35vh;
            width: 120%;
            /* Buffer untuk parallax */
            left: -10%;
            /* Center buffer */
            background: linear-gradient(180deg, #10B981 0%, #047857 100%);
            clip-path: polygon(0 20%, 100% 0, 100% 100%, 0% 100%);
            z-index: 3;
            bottom: 0;
        }

        /* Sun Animation */
        .sun {
            width: 100px;
            height: 100px;
            background: #FCD34D;
            border-radius: 50%;
            position: absolute;
            top: 10%;
            right: 15%;
            box-shadow: 0 0 40px #F59E0B;
            animation: sun-pulse 4s infinite alternate;
            z-index: 0;
        }

        @keyframes sun-pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 40px #F59E0B;
            }

            100% {
                transform: scale(1.1);
                box-shadow: 0 0 60px #FBBF24;
            }
        }

        /* Clouds Animation */
        .cloud {
            position: absolute;
            color: rgba(255, 255, 255, 0.8);
            z-index: 1;
            animation: float-cloud linear infinite;
        }

        .c1 {
            top: 15%;
            left: -10%;
            font-size: 3rem;
            animation-duration: 25s;
        }

        .c2 {
            top: 25%;
            left: -20%;
            font-size: 5rem;
            animation-duration: 35s;
            animation-delay: 2s;
        }

        .c3 {
            top: 10%;
            left: -15%;
            font-size: 2rem;
            animation-duration: 40s;
            animation-delay: 5s;
        }

        @keyframes float-cloud {
            0% {
                transform: translateX(-100px);
            }

            100% {
                transform: translateX(110vw);
            }
        }

        /* Tractor Animation */
        .tractor-container {
            position: absolute;
            bottom: 22vh;
            /* Adjusted to sit on the sawah line */
            left: -100px;
            z-index: 10;
            /* Naikkan index biar mudah di-hover */
            animation: drive-tractor 25s linear infinite;
            cursor: pointer;
            /* Ubah kursor jadi tangan */
            transition: transform 0.3s;
        }

        /* Saat di-hover: Animasi jalan berhenti */
        .tractor-container:hover {
            animation-play-state: paused;
            z-index: 50;
            /* Pastikan di paling depan saat di-hover */
        }

        /* Saat di-hover: Traktor bergetar (Idle engine effect) */
        .tractor-container:hover .tractor-icon {
            animation: rumble 0.2s infinite;
        }

        /* Saat di-hover: Munculkan balon kata */
        .tractor-container:hover .speech-bubble {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        .tractor-icon {
            font-size: 3.5rem;
            color: #1F2937;
            transform: scaleX(-1);
            /* Face right */
            transition: transform 0.2s;
            filter: drop-shadow(0 5px 5px rgba(0, 0, 0, 0.2));
        }

        /* Balon Kata Lucu */
        .speech-bubble {
            position: absolute;
            top: -50px;
            left: 20px;
            background: white;
            padding: 8px 12px;
            border-radius: 12px;
            border-bottom-left-radius: 0;
            font-size: 0.8rem;
            font-weight: bold;
            color: #065F46;
            white-space: nowrap;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            /* Hidden by default */
            transform: scale(0.8) translateY(10px);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }

        @keyframes drive-tractor {
            0% {
                left: -150px;
                transform: rotate(0deg);
            }

            45% {
                transform: rotate(0deg);
            }

            50% {
                left: 105vw;
                transform: rotate(-2deg);
            }

            100% {
                left: 105vw;
            }
        }

        @keyframes rumble {
            0% {
                transform: scaleX(-1) translate(0, 0) rotate(0deg);
            }

            25% {
                transform: scaleX(-1) translate(1px, 1px) rotate(1deg);
            }

            50% {
                transform: scaleX(-1) translate(-1px, -1px) rotate(-1deg);
            }

            75% {
                transform: scaleX(-1) translate(1px, -1px) rotate(0deg);
            }

            100% {
                transform: scaleX(-1) translate(0, 0) rotate(0deg);
            }
        }

        /* Grass Animation */
        .grass {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 20px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0 20 L5 0 L10 20 Z M10 20 L15 5 L20 20 Z M20 20 L25 0 L30 20 Z" fill="%23064E3B" /></svg>');
            background-size: 30px 20px;
            z-index: 5;
            animation: wave 2s ease-in-out infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: skewX(0deg);
            }

            50% {
                transform: skewX(2deg);
            }
        }

        /* Floating 404 Text */
        .float-text {
            animation: float-y 3s ease-in-out infinite;
        }

        @keyframes float-y {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Signpost Swing */
        .signpost {
            transform-origin: top center;
            animation: swing 3s ease-in-out infinite;
        }

        @keyframes swing {
            0% {
                transform: rotate(1deg);
            }

            50% {
                transform: rotate(-1deg);
            }

            100% {
                transform: rotate(1deg);
            }
        }
    </style>
</head>

<body class="h-screen w-full relative overflow-hidden text-gray-800">

    <!-- Background Elements -->
    <div class="sun"></div>
    <i class="fas fa-cloud cloud c1"></i>
    <i class="fas fa-cloud cloud c2"></i>
    <i class="fas fa-cloud cloud c3"></i>

    <!-- Parallax Landscape -->
    <div id="scene" class="w-full h-full absolute top-0 left-0">
        <!-- Mountains -->
        <div class="layer mountain-bg" data-speed="0.02"></div>
        <div class="layer mountain-fg" data-speed="0.04"></div>

        <!-- Moving Tractor with Interaction -->
        <div class="tractor-container">
            <!-- Balon Kata (Hidden by default) -->
            <div class="speech-bubble">
                Ngapain diberhentiin? 👀
            </div>

            <div class="tractor-icon">🚜</div>
            <div
                class="text-xs font-bold text-white bg-green-700 px-2 py-0.5 rounded-full -mt-2 ml-2 opacity-80 shadow-md border border-white/20">
                Pak Kades Lewat...</div>
        </div>

        <!-- Rice Field Foreground -->
        <div class="layer sawah shadow-2xl" data-speed="0.06"></div>

        <!-- Animated Grass at the very bottom -->
        <div class="grass"></div>
    </div>

    <!-- Main Content Card -->
    <!-- Tambahkan 'pointer-events-none' di sini agar mouse bisa menembus area kosong ke belakang -->
    <div class="relative z-20 flex flex-col items-center justify-center h-full px-4 text-center pointer-events-none">

        <!-- Glass Card Container -->
        <!-- Tambahkan 'pointer-events-auto' di sini agar tombol & teks tetap bisa diklik -->
        <div
            class="bg-white/70 backdrop-blur-md rounded-3xl p-8 border-2 border-white/60 shadow-2xl max-w-2xl mx-auto pointer-events-auto">

            <!-- Funny Signpost Icon -->
            <div class="signpost mb-4 -mt-16">
                <div
                    class="bg-amber-700 text-amber-100 p-2 rounded-lg border-4 border-amber-900 shadow-xl inline-block relative z-10">
                    <i class="fas fa-map-signs text-5xl"></i>
                </div>
                <div class="h-12 w-2 bg-amber-900 mx-auto -mt-1 shadow-inner"></div>
            </div>

            <!-- Big 404 -->
            <h1
                class="text-8xl md:text-9xl font-black text-green-900 drop-shadow-sm opacity-90 float-text tracking-tighter leading-none">
                4<span class="text-green-600">0</span>4
            </h1>

            <!-- Fun Copywriting -->
            <h2 class="text-2xl md:text-3xl font-bold text-green-900 mt-4 mb-2 drop-shadow-sm">
                Waduh! Jalannya Buntu, Lur.
            </h2>

            <p class="text-lg text-green-800 font-medium mb-8">
                Halaman yang kamu cari mungkin lagi <strong>diangkut traktor</strong>,
                lagi rapat sama Pak Kades, atau emang belum dibangun dari Dana Desa. 🤭
            </p>

            <!-- Buttons -->
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="/"
                    class="group relative px-8 py-3 bg-green-600 text-white font-bold rounded-full shadow-lg hover:bg-green-500 transition-all transform hover:-translate-y-1 hover:shadow-green-400/50 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fas fa-home"></i> Balik ke Balai Desa
                    </span>
                    <div
                        class="absolute inset-0 h-full w-full bg-green-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                    </div>
                </a>

                <button onclick="history.back()"
                    class="px-8 py-3 bg-white text-green-700 border-2 border-green-600 font-bold rounded-full shadow-md hover:bg-green-50 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Putar Balik
                </button>
            </div>
        </div>

    </div>

    <script>
        // Simple Parallax Effect on Mouse Move
        document.addEventListener('mousemove', (e) => {
            const layers = document.querySelectorAll('.layer');
            const x = (window.innerWidth - e.pageX * 2) / 100;
            const y = (window.innerHeight - e.pageY * 2) / 100;

            layers.forEach(layer => {
                const speed = layer.getAttribute('data-speed');
                const xPos = x * speed * 100;
                // Only move horizontally to keep the "ground" grounded
                layer.style.transform = `translateX(${xPos}px)`;
            });
        });

        // Add a console log for developers looking at the site
        console.log("%c Halo Warga Desa! ",
            "background: #059669; color: #fff; padding: 5px; border-radius: 5px; font-weight: bold;");
        console.log("Lagi nyari kutu (bug) ya? Hati-hati kecebur sawah.");
    </script>
</body>

</html>
