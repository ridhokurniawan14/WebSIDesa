@extends('frontend.layouts.main')

@section('content')
    <style>
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
    <div class="font-sans content-offset text-gray-800 antialiased">
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        <!-- HERO SECTION -->
        <section data-aos="fade-down" class="relative bg-emerald-900 text-white py-10 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-emerald-400 blur-3xl mix-blend-multiply">
                </div>
                <div class="absolute top-1/2 right-0 w-64 h-64 rounded-full bg-teal-300 blur-3xl mix-blend-multiply"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-emerald-800/50 border border-emerald-700 text-emerald-100 text-sm font-medium mb-6 backdrop-blur-sm">
                    Est. Organisasi Pemuda
                </span>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tight mb-6 leading-tight">
                    {{ $karangtaruna['nama'] }}
                </h1>
                <p class="max-w-2xl mx-auto text-lg md:text-xl text-emerald-100 leading-relaxed font-light">
                    {{ $karangtaruna['deskripsi'] }}
                </p>

                <div class="mt-10 flex justify-center gap-4">
                    <a href="#program"
                        class="px-8 py-3 bg-white text-emerald-900 font-semibold rounded-full hover:bg-emerald-50 transition shadow-lg shadow-emerald-900/20">
                        Lihat Program
                    </a>
                    <a href="#narahubung"
                        class="px-8 py-3 bg-transparent border border-white/30 text-white font-semibold rounded-full hover:bg-white/10 transition backdrop-blur-sm">
                        Kontak Kami
                    </a>
                </div>
            </div>
        </section>

        <!-- VISI MISI -->
        <section class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-start">
                    <!-- Visi -->
                    <div data-aos="slide-right"
                        class="bg-emerald-50/50 rounded-3xl p-10 border border-emerald-100 hover:shadow-xl hover:shadow-emerald-900/5 transition duration-300">
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 text-2xl mb-6">
                            👁️
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4 tracking-tight">Visi Kami</h2>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            "{{ $karangtaruna['visi'] }}"
                        </p>
                    </div>

                    <!-- Misi -->
                    <div data-aos="slide-left" class="pl-4">
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 text-2xl mb-6">
                            🎯
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Misi Organisasi</h2>
                        <ul class="space-y-6">
                            @foreach ($karangtaruna['misi'] as $misi)
                                <li class="flex items-start group">
                                    <span
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-4 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                                        <svg class="w-4 h-4 text-emerald-700 group-hover:text-white transition"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span
                                        class="text-gray-600 group-hover:text-gray-900 transition text-lg">{{ $misi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROGRAM -->
        <section id="program" class="py-24 bg-gray-50 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div data-aos="fade" class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-4">Program Unggulan</h2>
                    <div class="w-20 h-1 bg-emerald-500 mx-auto rounded-full"></div>
                </div>

                <div data-aos="flip-down" class="grid md:grid-cols-3 gap-8">
                    @foreach ($karangtaruna['program'] as $program)
                        <div
                            class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                            <div
                                class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                {{ $program['icon'] }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-700 transition">
                                {{ $program['judul'] }}
                            </h3>
                            <p class="text-gray-500 leading-relaxed text-sm">
                                {{ $program['deskripsi'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- GALERI -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                {{-- FIX: Layout diubah menjadi flex-col pada mobile agar tombol turun ke bawah --}}
                <div class="flex flex-col md:flex-row justify-between md:items-end mb-12">
                    <div data-aos="fade-right">
                        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Dokumentasi</h2>
                        <p class="text-gray-500 mt-2">Momen kebersamaan kami</p>
                    </div>
                    {{-- FIX: Menghapus class 'hidden' dan menambahkan 'mt-4 md:mt-0' untuk margin mobile --}}
                    <a data-aos="fade-left" href="/galeri"
                        class="inline-flex mt-4 md:mt-0 items-center text-emerald-600 font-semibold hover:text-emerald-800 transition">
                        Lihat Semua <span class="ml-2">&rarr;</span>
                    </a>
                </div>

                <div data-aos="flip-up" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($karangtaruna['galeri'] as $foto)
                        <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer bg-gray-100">
                            {{-- Fallback image --}}
                            <img src="{{ asset('images/karangtaruna/' . $foto['gambar']) }}" alt="{{ $foto['judul'] }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/600x400/e2e8f0/1e293b?text=Foto+Kegiatan';"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-6">
                                <p
                                    class="text-white font-medium transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                    {{ $foto['judul'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- PENGURUS -->
        <section class="py-24 bg-emerald-50/30 relative">
            <div class="max-w-7xl mx-auto px-6">
                <h2 data-aos="fade" class="text-3xl font-bold text-center text-gray-900 tracking-tight mb-16">Pengurus Inti
                </h2>

                <div data-aos="flip-down" class="flex flex-wrap justify-center gap-8">
                    @foreach ($karangtaruna['pengurus'] as $p)
                        <div
                            class="w-full sm:w-72 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-emerald-200 transition group flex flex-col items-center text-center">
                            <div
                                class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-2xl font-bold mb-4 shadow-md group-hover:scale-110 transition duration-300">
                                {{ substr($p['nama'], 0, 1) }}
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg w-full">{{ $p['nama'] }}</h3>
                            <div class="h-1 w-8 bg-emerald-300 my-3 rounded-full"></div>
                            <p class="text-emerald-600 font-medium text-sm uppercase tracking-wider">{{ $p['jabatan'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- KONTAK KHUSUS KARANG TARUNA (CTA SECTION) -->
        <section data-aos="fade" id="narahubung" class="bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <!-- Card Container with Gradient -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-600 shadow-2xl">

                    <!-- Decorative patterns -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl">
                    </div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-black opacity-10 rounded-full blur-2xl">
                    </div>

                    <div
                        class="relative z-10 p-10 md:p-16 text-center md:text-left flex flex-col md:flex-row items-center justify-between gap-10">

                        <!-- Text Content -->
                        <div class="md:w-2/3">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Mari Bergerak Bersama!</h2>
                            <p class="text-emerald-50 text-lg mb-6 leading-relaxed">
                                Punya ide kreatif untuk memajukan desa? Atau ingin bergabung menjadi bagian dari perubahan?
                                Hubungi Sekretariat Karang Taruna {{ $karangtaruna['nama'] }}.
                            </p>

                            <!-- Detailed Info List -->
                            <div class="space-y-3 text-emerald-100">
                                <div class="flex items-center justify-center md:justify-start gap-3">
                                    <span>📍</span>
                                    <span>Sekretariat: Balai Desa Cipta Makmur, Lt. 1 (Ruang Karang Taruna)</span>
                                </div>
                                <div class="flex items-center justify-center md:justify-start gap-3">
                                    <span>🕒</span>
                                    <span>Jam Operasional: Senin - Jumat (15.00 - 17.00 WIB)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-4 w-full md:w-auto">
                            <!-- Tombol WhatsApp dengan Animasi Hover & Pulse -->
                            <a href="https://wa.me/{{ str_replace('-', '', $karangtaruna['kontak']['telepon']) }}"
                                target="_blank"
                                class="group flex items-center justify-center gap-3 px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-emerald-900/20">
                                <span class="text-2xl group-hover:animate-bounce">💬</span> Chat WhatsApp
                            </a>

                            <a href="mailto:{{ $karangtaruna['kontak']['email'] }}"
                                class="flex items-center justify-center gap-3 px-6 py-3 bg-emerald-700 text-white font-medium rounded-xl hover:bg-emerald-800 transition border border-emerald-500 hover:shadow-lg">
                                <span>✉️</span> Kirim Email
                            </a>
                            <a href="https://instagram.com/{{ str_replace('@', '', $karangtaruna['kontak']['instagram']) }}"
                                target="_blank"
                                class="flex items-center justify-center gap-3 px-6 py-3 bg-transparent text-white font-medium rounded-xl hover:bg-white/10 transition border border-white/30 hover:shadow-lg">
                                <span>📷</span> Instagram Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script>
        // --- PARTICLE ANIMATION LOGIC ---
        (function() {
            const canvas = document.getElementById('particleCanvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            // Konfigurasi Kepadatan dan Jarak
            // Semakin besar angka divider, semakin sedikit partikel (semakin renggang)
            const particleDensityDivider = 25000;
            // Jarak maksimal untuk menarik garis antar titik
            const connectionDistance = 150;

            function resize() {
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
                            ctx.strokeStyle = 'rgba(16, 185, 129, ' + (opacity * 0.5) + ')'; // Line color sangat tipis
                            ctx.lineWidth = 1.5;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', () => {
                resize();
                initParticles();
            });

            resize();
            initParticles();
            animate();
        })();
    </script>
@endsection
