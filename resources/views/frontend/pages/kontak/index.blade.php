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

        /* Tambahan style transisi untuk alert */
        #success-alert {
            transition: opacity 0.5s ease-out;
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
            @if (!empty($aplikasi->map))
                @php
                    preg_match('/src="([^"]+)"/', $aplikasi->map, $match);
                    $mapSrc = $match[1] ?? null;
                @endphp

                @if ($mapSrc)
                    <iframe src="{{ $mapSrc }}"
                        class="w-full h-full border-0 grayscale hover:grayscale-0 transition duration-700"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            @endif

            {{-- Overlay gradient tipis --}}
            <div
                class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/10 to-transparent pointer-events-none">
            </div>
        </div>

        {{-- SECTION 2: Floating Card (Info & Form) --}}
        <section data-aos="flip-down" class="px-4 -mt-24 relative z-10">
            <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

                {{-- Bagian Kiri: Informasi Kontak --}}
                <div
                    class="md:w-5/12 bg-green-800 text-white p-8 md:p-10 flex flex-col justify-between relative overflow-hidden">
                    {{-- Pattern hiasan --}}
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-green-700 opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-green-700 opacity-50">
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-8 border-b border-green-600 pb-4 inline-block">Info Kontak</h3>

                        <div class="space-y-8">
                            {{-- Item 1: Alamat --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 flex justify-center mt-1">
                                    <i class="fa-solid fa-location-dot text-2xl text-green-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-xl text-green-100">Alamat Kantor</h4>
                                    <p class="text-green-50 mt-1 leading-relaxed text-base">
                                        {{ $aplikasi->alamat ?? 'Jl. Contoh Alamat No.123, Desa Contoh' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Item 2: Telepon --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 flex justify-center mt-1">
                                    <i class="fa-solid fa-phone text-2xl text-green-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-xl text-green-100">Telepon</h4>
                                    <p class="text-green-50 mt-1 text-base">{{ $aplikasi->telepon ?? '+62 812-3456-7890' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Item 3: Email --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 flex justify-center mt-1">
                                    <i class="fa-solid fa-envelope text-2xl text-green-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-xl text-green-100">Email</h4>
                                    <p class="text-green-50 mt-1 text-base">{{ $aplikasi->email ?? 'kantor@example.com' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Item 4: Jam Operasional --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-10 flex justify-center mt-1">
                                    <i class="fa-solid fa-clock text-2xl text-green-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-xl text-green-100">Jam Operasional</h4>
                                    <p class="text-green-50 mt-1 text-base">
                                        {{ $aplikasi->jam_operasional ?? 'Senin - Jumat: 08.00 - 15.00 WIB' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 relative z-10">
                        <p class="text-sm text-green-200 italic">
                            *Silakan datang langsung untuk keperluan administrasi mendesak.
                        </p>
                    </div>
                </div>

                {{-- Bagian Kanan: Form Kontak --}}
                <div class="md:w-7/12 p-8 md:p-10 bg-white">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Kirim Pesan</h3>
                    <p class="text-gray-500 mb-6 text-sm">Silakan isi formulir di bawah ini untuk mengirim pesan atau
                        pengaduan.</p>

                    {{-- NOTIFIKASI SUKSES (Dengan ID untuk JS) --}}
                    @if (session('success'))
                        <div id="success-alert"
                            class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border-l-4 border-green-500 text-sm flex items-center shadow-sm">
                            <i class="fa-solid fa-check-circle mr-2 text-lg"></i>
                            <div>
                                <strong>Berhasil!</strong> {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    {{-- Menampilkan Error Validasi (Opsional tapi penting) --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border-l-4 border-red-500 text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kontak.kirim') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none text-sm"
                                    placeholder="Jhon Doe" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP / WhatsApp</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none text-sm"
                                    placeholder="0812xxxxx" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none text-sm"
                                placeholder="email@anda.com" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek / Perihal</label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none text-sm"
                                placeholder="Contoh: Pengaduan Jalan Rusak" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pesan</label>
                            <textarea name="pesan" rows="4"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition outline-none text-sm"
                                placeholder="Tuliskan detail pesan Anda..." required>{{ old('pesan') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-3 cursor-pointer bg-green-700 hover:bg-green-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-1 text-sm flex justify-center items-center gap-2">
                            Kirim Pesan Sekarang <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        // --- AUTO HIDE NOTIFICATION LOGIC ---
        document.addEventListener('DOMContentLoaded', function() {
            const alertBox = document.getElementById('success-alert');

            if (alertBox) {
                // Tunggu 4 detik (4000ms)
                setTimeout(function() {
                    // Ubah opacity jadi 0 (efek fade out)
                    alertBox.style.opacity = '0';

                    // Setelah transisi fade out selesai (500ms sesuai CSS), hilangkan elemen dari layout
                    setTimeout(function() {
                        alertBox.style.display = 'none';
                    }, 500);
                }, 4000);
            }
        });

        // --- PARTICLE ANIMATION LOGIC (TETAP SAMA) ---
        (function() {
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return; // Guard clause biar aman
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            const particleDensityDivider = 25000;
            const connectionDistance = 150;

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    this.vx = (Math.random() - 0.5) * 0.3;
                    this.vy = (Math.random() - 0.5) * 0.3;
                    this.size = Math.random() * 2 + 1;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
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
                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < connectionDistance) {
                            ctx.beginPath();
                            const opacity = 1 - (distance / connectionDistance);
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
