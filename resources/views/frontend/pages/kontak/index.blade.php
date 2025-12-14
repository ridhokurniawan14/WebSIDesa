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
    <div class="content-offset">
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        {{-- Header / Judul Halaman --}}
        <section data-aos="fade" class="bg-gray-50 pt-10 pb-10 text-center ">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">Kontak & Pengaduan</h1>
            <p class="text-gray-500 mt-2 text-lg">Kami siap melayani dan mendengar masukan Anda.</p>
        </section>

        {{-- SECTION 1: Peta Full Width --}}
        <div data-aos="fade" class="w-full h-[450px] relative z-0">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d19428.337358401794!2d114.187995!3d-8.367709!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd15562ff3a6b3f%3A0x3b0181738285d4bc!2sBalai%20desa%20kembiritan!5e1!3m2!1sid!2sid!4v1765549952054!5m2!1sid!2sid"
                class="w-full h-full border-0 grayscale hover:grayscale-0 transition duration-700" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>

            {{-- Overlay gradient tipis di bawah peta agar transisi ke kartu lebih halus --}}
            <div
                class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/10 to-transparent pointer-events-none">
            </div>
        </div>

        {{-- SECTION 2: Floating Card (Info & Form) --}}
        <section data-aos="flip-down" class="px-4 -mt-24 relative z-10">
            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

                {{-- Bagian Kiri: Informasi Kontak (Background Hijau Gelap) --}}
                <div class="md:w-5/12 bg-green-800 text-white p-10 flex flex-col justify-between relative overflow-hidden">

                    {{-- Pattern hiasan lingkaran transparan --}}
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-green-700 opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-green-700 opacity-50">
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-8 border-b border-green-600 pb-4 inline-block">Info Kontak</h3>

                        <div class="space-y-8">
                            <div class="flex items-start">
                                <i class="fa-solid fa-location-dot text-2xl text-green-300 mt-1 w-8"></i>
                                <div>
                                    <h4 class="font-semibold text-lg text-green-100">Alamat Kantor</h4>
                                    <p class="text-green-50 mt-1 leading-relaxed">
                                        Jalan Utama Desa No. 05,<br>
                                        Kecamatan ABC, Kabupaten XYZ
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fa-solid fa-phone text-2xl text-green-300 mt-1 w-8"></i>
                                <div>
                                    <h4 class="font-semibold text-lg text-green-100">Telepon</h4>
                                    <p class="text-green-50 mt-1">+62 812-3456-7890</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fa-solid fa-envelope text-2xl text-green-300 mt-1 w-8"></i>
                                <div>
                                    <h4 class="font-semibold text-lg text-green-100">Email</h4>
                                    <p class="text-green-50 mt-1">kantordesa@example.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fa-solid fa-clock text-2xl text-green-300 mt-1 w-8"></i>
                                <div>
                                    <h4 class="font-semibold text-lg text-green-100">Jam Operasional</h4>
                                    <p class="text-green-50 mt-1">Senin - Jumat: 08.00 - 15.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 relative z-10">
                        <p class="text-sm text-green-200">
                            *Silakan datang langsung untuk keperluan administrasi mendesak.
                        </p>
                    </div>
                </div>

                {{-- Bagian Kanan: Form Kontak (Background Putih) --}}
                <div class="md:w-7/12 p-10 bg-white">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Kirim Pesan</h3>
                    <p class="text-gray-500 mb-8">Silakan isi formulir di bawah ini untuk mengirim pesan atau pengaduan.</p>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border-l-4 border-green-500">
                            <strong>Terima kasih!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none"
                                    placeholder="Jhon Doe" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none"
                                    placeholder="email@anda.com" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek / Perihal</label>
                            <input type="text" name="subject"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none"
                                placeholder="Contoh: Pengaduan Jalan Rusak" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pesan</label>
                            <textarea name="pesan" rows="4"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none"
                                placeholder="Tuliskan detail pesan Anda..." required></textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-4 cursor-pointer bg-green-700 hover:bg-green-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                            Kirim Pesan Sekarang <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
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
