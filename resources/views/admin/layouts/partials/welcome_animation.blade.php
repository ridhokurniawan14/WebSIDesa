@if (session('just_logged_in'))
    {{-- Container Full Screen --}}
    <div id="windows-welcome-screen" class="welcome-overlay">
        <div class="welcome-content">
            {{-- Teks yang akan berubah-ubah --}}
            <h1 id="welcome-text" class="fade-text">Hallo..</h1>
            {{-- Hint kecil di bawah --}}
            <p class="skip-hint">Klik layar untuk melewati</p>
        </div>
    </div>

    {{-- CSS Khusus --}}
    <style>
        .welcome-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Gradasi Bergerak Modern */
            background: linear-gradient(-45deg, #000000, #1a1a2e, #16213e, #0f3460);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;

            z-index: 99999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: white;
            transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1), backdrop-filter 1s;
        }

        .welcome-content {
            text-align: center;
            width: 80%;
            position: relative;
        }

        .fade-text {
            font-size: 2.5rem;
            font-weight: 300;
            letter-spacing: 2px;
            margin: 0;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-in-out, transform 0.8s ease-out;
        }

        .fade-text.active {
            opacity: 1;
            transform: translateY(0);
        }

        .user-highlight {
            font-weight: 600;
            color: #ffffff;
            text-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
        }

        /* Hint kecil biar user tau bisa di-skip */
        .skip-hint {
            position: absolute;
            bottom: -100px;
            left: 0;
            right: 0;
            font-size: 0.8rem;
            opacity: 0;
            color: rgba(255, 255, 255, 0.4);
            transition: opacity 2s;
        }

        /* Munculkan hint setelah beberapa detik */
        .welcome-overlay.show-hint .skip-hint {
            opacity: 1;
        }

        @keyframes gradientBG {
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
    </style>

    {{-- Script Logika --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.getElementById('windows-welcome-screen');
            const textElement = document.getElementById('welcome-text');
            const body = document.body;

            // Masukan 2: Kunci scroll body saat animasi jalan
            body.style.overflow = 'hidden';

            // Data User
            const userName = "{{ Auth::user()->name ?? 'Admin' }}";

            // Masukan 1: Sapaan Waktu Otomatis
            const hour = new Date().getHours();
            let greeting = "Selamat Datang";
            if (hour >= 4 && hour < 11) greeting = "Selamat Pagi";
            else if (hour >= 11 && hour < 15) greeting = "Selamat Siang";
            else if (hour >= 15 && hour < 18) greeting = "Selamat Sore";
            else if (hour >= 18 || hour < 4) greeting = "Selamat Malam";

            let animationTimeouts = [];

            // Helper function update text
            const updateText = (htmlContent) => {
                textElement.classList.remove('active');
                const t1 = setTimeout(() => {
                    textElement.innerHTML = htmlContent;
                    textElement.classList.add('active');
                }, 800);
                animationTimeouts.push(t1);
            };

            // Fungsi untuk Mengakhiri Animasi (Selesai/Skip)
            const finishAnimation = () => {
                // Clear semua jadwal animasi yang belum jalan
                animationTimeouts.forEach(clearTimeout);

                overlay.style.opacity = '0';
                overlay.style.backdropFilter = 'blur(10px)'; // Efek blur saat hilang

                // Kembalikan scroll body
                setTimeout(() => {
                    body.style.overflow = 'auto';
                    overlay.remove();
                }, 1200);
            };

            // Masukan 3: Event Listener Click to Skip
            overlay.addEventListener('click', finishAnimation);

            // Tampilkan hint skip setelah 2 detik
            setTimeout(() => overlay.classList.add('show-hint'), 2000);

            // SEQUENCE ANIMASI UTAMA
            // 1. Hallo..
            const t1 = setTimeout(() => {
                textElement.classList.add('active');
            }, 100);
            animationTimeouts.push(t1);

            // 2. Greeting Waktu + Nama
            const t2 = setTimeout(() => {
                updateText(`${greeting}, <span class="user-highlight">${userName}</span>...`);
            }, 2000);
            animationTimeouts.push(t2);

            // 3. Selamat Bekerja
            const t3 = setTimeout(() => {
                updateText(`Selamat Bekerja...`);
            }, 5000); // Sedikit dipercepat biar ga terlalu boring
            animationTimeouts.push(t3);

            // 4. Selesai Otomatis
            const t4 = setTimeout(finishAnimation, 7500);
            animationTimeouts.push(t4);
        });
    </script>
@endif
