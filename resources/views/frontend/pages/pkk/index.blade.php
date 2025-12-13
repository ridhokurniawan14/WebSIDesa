@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset relative">
        <!-- Canvas for Particle Animation (Background Layer - z-0) -->
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        <!-- Main Content Wrapper (Elevated Layer - relative z-10) -->
        <div class="font-inter min-h-screen relative z-10">
            <!-- Header Banner / Hero Section - Focus & Clarity (Warna Dominan HIJAU) -->
            <header class="relative overflow-hidden pt-15 pb-32 text-white">
                <!-- Background Layer dengan Opacity (90%) agar Partikel terlihat -->
                <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-teal-500 opacity-90 z-0"></div>

                <div class="max-w-7xl mx-auto px-4 relative z-20 text-center">
                    <p class="text-green-200 uppercase tracking-widest text-sm mb-3">Pemberdayaan Kesejahteraan Keluarga</p>
                    <h1 class="text-5xl sm:text-6xl font-extrabold mb-4 leading-tight">
                        PKK Desa <span class="block mt-2">Membangun Keluarga Sejahtera</span>
                    </h1>
                    <p class="text-green-100 max-w-3xl mx-auto text-xl">
                        Gerakan nasional yang memberdayakan setiap keluarga sebagai pondasi utama kemajuan desa.
                    </p>
                    <a href="#program-pokok"
                        class="mt-8 inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-green-700 bg-white hover:bg-green-50 transition duration-300 transform hover:scale-105">
                        Lihat 10 Program Pokok
                    </a>
                </div>
                <!-- Wave Effect/Visual Accent (Dipastikan di atas background gradient, z-10) -->
                <svg class="absolute bottom-0 left-0 w-full h-auto text-gray-50 z-10" viewBox="0 0 1340 255"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path fill-opacity="1"
                        d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,192C672,213,768,235,864,213.3C960,192,1056,128,1152,106.7C1248,85,1344,107,1392,117.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </header>

            <main class="content-offset">
                <div class="max-w-7xl mx-auto px-4 space-y-24 py-16">

                    <!-- TENTANG PKK (Split Section with Visual) -->
                    <section class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Text Content -->
                        <div class="lg:order-1">
                            <h2 class="text-4xl font-extrabold mb-4 text-green-800">Misi Kami: Memberdayakan Keluarga</h2>
                            <p class="text-gray-600 leading-relaxed text-lg mb-6">
                                PKK berfokus pada pilar-pilar penting pembangunan, menjadikan keluarga
                                sebagai motor penggerak perubahan positif. Kami percaya keluarga yang kuat
                                adalah cerminan desa yang maju.
                            </p>
                            <ul class="space-y-3 text-gray-700">
                                <li class="flex items-center"><span class="text-green-500 mr-3 text-2xl font-bold">✓</span>
                                    Menciptakan Keluarga Sehat.</li>
                                <li class="flex items-center"><span class="text-green-500 mr-3 text-2xl font-bold">✓</span>
                                    Meningkatkan Kemandirian Ekonomi.</li>
                                <li class="flex items-center"><span class="text-green-500 mr-3 text-2xl font-bold">✓</span>
                                    Mengembangkan Potensi Masyarakat Desa.</li>
                            </ul>
                        </div>
                        <!-- Visual Placeholder -->
                        <div
                            class="bg-green-100 rounded-3xl p-8 shadow-xl relative overflow-hidden h-96 flex items-center justify-center">
                            <img src="https://placehold.co/600x400/34D399/ffffff?text=ILUSTRASI+KEGIATAN+PKK"
                                alt="Ilustrasi Kegiatan PKK"
                                class="w-full h-full object-cover rounded-2xl transform hover:scale-105 transition duration-500 ease-in-out"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/34D399/ffffff?text=ILUSTRASI+KEGIATAN+PKK';">
                        </div>
                    </section>

                    <!-- 10 PROGRAM POKOK PKK (Dynamic Grid with Highlight) -->
                    <section id="program-pokok">
                        <div class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-green-600 bg-green-100 py-1 px-3 rounded-full">Fokus
                                Utama</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Sepuluh Pilar Pemberdayaan</h2>
                        </div>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @php
                                $programs = $program_pokok ?? [];
                            @endphp

                            @foreach ($programs as $index => $program)
                                @php
                                    $number = $index + 1;
                                    // Menggunakan Teal dan Lime sebagai warna alternatif
                                    $iconColor = $number % 2 === 0 ? 'bg-teal-500' : 'bg-lime-500';
                                    $borderColor = $number % 2 === 0 ? 'border-teal-200' : 'border-lime-200';
                                @endphp
                                <div
                                    class="bg-white rounded-xl p-6 shadow-lg border-2 {{ $borderColor }} transition duration-300 hover:shadow-2xl hover:border-teal-400">
                                    <div class="flex items-start mb-3">
                                        <span
                                            class="w-10 h-10 {{ $iconColor }} text-white flex items-center justify-center font-bold text-xl rounded-lg shadow-md mr-4 flex-shrink-0">
                                            {{ $number }}
                                        </span>
                                        <div>
                                            <h3 class="font-bold text-xl text-gray-900">{{ $program }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Fokus pada {{ strtolower(explode(' ', $program)[0]) }} dan peningkatan
                                                kualitas
                                                hidup.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- STRUKTUR PENGURUS (Modern Grid) -->
                    <section class="text-center">
                        <div class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-gray-600 bg-gray-200 py-1 px-3 rounded-full">Tim
                                Penggerak</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Struktur Pengurus Inti</h2>
                        </div>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach ($pengurus as $item)
                                <div
                                    class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 transition duration-300 hover:bg-green-50 transform hover:-translate-y-1">
                                    <!-- Foto Pengurus -->
                                    <img src="{{ $item['photo_url'] ?? 'https://placehold.co/120x120/E0F2F1/047857?text=FOTO' }}"
                                        alt="Foto {{ $item['nama'] }}"
                                        class="w-28 h-28 mx-auto mb-4 rounded-full object-cover border-4 border-green-500"
                                        onerror="this.onerror=null;this.src='https://placehold.co/120x120/E0F2F1/047857?text=FOTO';">
                                    <h4 class="text-xl font-extrabold text-gray-900">{{ $item['nama'] }}</h4>
                                    <p class="text-md font-medium text-green-600 mt-1">{{ $item['jabatan'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- KEGIATAN PKK (New Grid Card Design) -->
                    <section>
                        <div class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-teal-600 bg-teal-100 py-1 px-3 rounded-full">Aksi
                                Nyata</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Jadwal & Fokus Kegiatan</h2>
                        </div>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                            @foreach ($kegiatan as $index => $k)
                                @php
                                    // Mengganti warna latar belakang kartu secara bergantian
                                    $cardBg = $index % 2 === 0 ? 'bg-white' : 'bg-green-50';
                                    $titleColor = $index % 2 === 0 ? 'text-teal-700' : 'text-green-700';
                                    $iconColor = $index % 2 === 0 ? 'text-teal-500' : 'text-green-500';
                                @endphp
                                <div
                                    class="{{ $cardBg }} rounded-xl p-6 shadow-lg border border-gray-100 transition duration-300 hover:shadow-2xl">
                                    <div class="flex items-center mb-3">
                                        <!-- Icon Kegiatan -->
                                        <svg class="w-8 h-8 {{ $iconColor }} mr-3 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <!-- Ikon berubah sesuai indeks -->
                                            @if ($index == 0)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path> <!-- Kesehatan/Posyandu -->
                                            @elseif ($index == 1)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H7a2 2 0 00-2 2v11a2 2 0 002 2z">
                                                </path> <!-- Pelatihan/Keterampilan -->
                                            @elseif ($index == 2)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4V5a2 2 0 012-2h12a2 2 0 012 2v2zm-2 0h-4m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V7h16z">
                                                </path> <!-- UMKM/Ekonomi -->
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path> <!-- Lingkungan/Umum -->
                                            @endif
                                        </svg>
                                        <h3 class="text-xl font-bold {{ $titleColor }}">{{ $k }}</h3>
                                    </div>
                                    <p class="text-base text-gray-600">
                                        @if ($index == 0)
                                            Penyediaan layanan kesehatan rutin dan peningkatan gizi bagi Balita dan dukungan
                                            Lansia.
                                        @elseif ($index == 1)
                                            Mengembangkan potensi ibu rumah tangga menjadi sumber pendapatan keluarga
                                            melalui
                                            pelatihan intensif.
                                        @elseif ($index == 2)
                                            Mendorong pertumbuhan ekonomi lokal melalui pendampingan usaha mikro, kecil, dan
                                            menengah (UMKM).
                                        @else
                                            Aktivitas rutin yang mendukung lingkungan yang bersih, sehat, dan pelestarian
                                            alam
                                            desa.
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- KONTAK (Clear Call-to-Action) -->
                    <section class="pb-16 pt-8">
                        <!-- MODIFICATION: Mengganti shadow-inner dengan shadow-2xl dan menambahkan efek hover -->
                        <div
                            class="bg-green-50 rounded-3xl p-10 sm:p-16 text-center shadow-2xl transition duration-300 transform hover:scale-[1.01] hover:shadow-3xl border border-green-100">
                            <h2 class="text-3xl font-extrabold mb-4 text-green-800">Mari Berpartisipasi!</h2>
                            <p class="text-gray-700 max-w-2xl mx-auto text-lg mb-6">
                                Dukung dan jadilah bagian dari perubahan positif di desa Anda. Hubungi kami sekarang untuk
                                informasi lebih lanjut.
                            </p>
                            <div
                                class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                                <p class="font-semibold text-2xl text-green-600">
                                    Ibu Siti Aminah (Ketua)
                                </p>
                                <!-- START MODIFICATION: Tombol WhatsApp -->
                                <a href="https://wa.me/6281234567890?text=Halo%20Ibu%20Siti%20Aminah%2C%20saya%20tertarik%20dengan%20program%20PKK%20Desa."
                                    target="_blank"
                                    class="inline-flex items-center px-6 py-3 border-2 border-green-600 text-base font-medium rounded-full shadow-md text-white bg-green-600 hover:bg-green-700 transition duration-150 transform hover:scale-105">
                                    <!-- New Chat/Message Icon -->
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z">
                                        </path>
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>
                                <!-- END MODIFICATION -->
                            </div>
                        </div>
                    </section>

                </div>
            </main>
        </div>
    </div>

    <style>
        /* CSS Umum */
        .font-inter {
            font-family: 'Inter', sans-serif;
        }

        /* Keyframes untuk Animasi Fade */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(5px);
            }

            20% {
                opacity: 1;
                transform: translateY(0);
            }

            80% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(5px);
            }
        }

        .animate-fadeIn {
            animation: fadeInOut 2.8s ease-in-out;
        }
    </style>

    <script>
        // --- PARTICLE ANIMATION LOGIC ---
        (function() {
            // Pastikan elemen canvas sudah tersedia
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return; // Guard clause

            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            // Konfigurasi Kepadatan dan Jarak
            const particleDensityDivider = 25000;
            const connectionDistance = 150;

            function resize() {
                // Set ukuran canvas sesuai ukuran window
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    // Kecepatan sangat lambat agar santai
                    this.vx = (Math.random() - 0.5) * 0.3;
                    this.vy = (Math.random() - 0.5) * 0.3;
                    this.size = Math.random() * 2 + 1; // Ukuran titik variatif
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    // Bounce off edges
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    // Warna titik hijau pudar
                    ctx.fillStyle = 'rgba(16, 185, 129, 0.6)';
                    ctx.fill();
                }
            }

            function initParticles() {
                particles = [];
                // Hitung jumlah partikel berdasarkan area layar
                const numberOfParticles = (width * height) / particleDensityDivider;
                for (let i = 0; i < numberOfParticles; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);

                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();

                    // Cek jarak dengan partikel lain untuk menggambar garis
                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < connectionDistance) {
                            ctx.beginPath();
                            // Semakin jauh, garis semakin transparan
                            const opacity = 1 - (distance / connectionDistance);
                            // Line color sangat tipis
                            ctx.strokeStyle = 'rgba(16, 185, 129, ' + (opacity * 0.5) + ')';
                            ctx.lineWidth = 1.5;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animate);
            }

            // Inisialisasi dan resize listener
            window.addEventListener('resize', () => {
                resize();
                initParticles();
            });

            // Pastikan inisialisasi berjalan saat window load
            window.onload = function() {
                resize();
                initParticles();
                animate();
            };

            // Jalankan inisialisasi saat script dimuat (untuk environment Canvas)
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                resize();
                initParticles();
                animate();
            }

        })();
    </script>
@endsection
