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
    <div class="content-offset min-h-screen relative">
        {{-- Canvas ini diposisikan fixed di belakang konten --}}
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>
        <!-- Main Map Section -->
        <section class="py-14">
            <div class="max-w-7xl mx-auto px-4">
                {{-- JUDUL --}}
                <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">Wilayah Desa</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Berikut adalah wilayah pemerintah desa kembiritan.
                    </p>
                </div>

                <!-- Leaflet Map -->
                <div data-aos="fade-right" data-aos-delay="100" class="relative z-0">
                    <div id="desaMap" class="w-full h-[480px] rounded-xl shadow-lg border"></div>
                </div>

                <!-- Informasi Batas Desa -->
                <div data-aos="fade-up" data-aos-delay="150" class="mt-12">
                    <h2 class="text-3xl font-bold mb-6 text-gray-900 border-b-4 border-green-700 pb-2 inline-block">
                        Informasi Wilayah
                    </h2>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div
                            class="p-8 border-2 border-gray-100 rounded-2xl shadow-lg bg-white transition-transform duration-300 hover:shadow-xl hover:scale-[1.02]">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243m10.606-2.121a5 5 0 00-7.07 0m7.07 0l2.121 2.121M10.536 12.071l-2.121-2.121m0 0a5 5 0 017.07 0">
                                    </path>
                                </svg>
                                <h3 class="text-2xl font-bold text-green-700">Batas Desa</h3>
                            </div>
                            <ul class="space-y-3 text-gray-700 text-lg">
                                <li class="flex justify-between border-b border-gray-100 pb-1">
                                    <strong class="font-semibold text-gray-800 w-1/4">Utara:</strong>
                                    <span class="w-3/4 text-right">DESA NANGA ENGKULUN</span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-1">
                                    <strong class="font-semibold text-gray-800 w-1/4">Timur:</strong>
                                    <span class="w-3/4 text-right">DESA LANDAU KUMPAI</span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-1">
                                    <strong class="font-semibold text-gray-800 w-1/4">Selatan:</strong>
                                    <span class="w-3/4 text-right">DESA LANDAU APIN</span>
                                </li>
                                <li class="flex justify-between">
                                    <strong class="font-semibold text-gray-800 w-1/4">Barat:</strong>
                                    <span class="w-3/4 text-right">DESA CENAYAN</span>
                                </li>
                            </ul>
                        </div>

                        <div
                            class="p-8 border-2 border-gray-100 rounded-2xl shadow-lg bg-white transition-transform duration-300 hover:shadow-xl hover:scale-[1.02]">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <h3 class="text-2xl font-bold text-green-700">Luas Wilayah Desa</h3>
                            </div>
                            <div class="text-center mt-8">
                                <p class="text-5xl font-extrabold text-green-600 tracking-tight mb-2">
                                    54.482.300
                                </p>
                                <p class="text-xl font-semibold text-gray-600">
                                    <span class="text-2xl font-bold text-gray-800">m²</span>
                                </p>
                                <p class="text-base text-gray-500 mt-4 italic">
                                    (Sekitar 54,48 Hektare)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Lokasi Kantor -->
                <div data-aos="fade-left" data-aos-delay="200" class="mt-12">
                    <h2 class="text-2xl font-semibold mb-3 text-gray-800">Lokasi Kantor Desa (Google Maps)</h2>
                    <div class="rounded-xl overflow-hidden shadow-md border">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4857.084405882541!2d114.18541967589385!3d-8.367703684351222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd15562ff3a6b3f%3A0x3b0181738285d4bc!2sBalai%20desa%20kembiritan!5e1!3m2!1sid!2sid!4v1763988123097!5m2!1sid!2sid"
                            width="100%" height="400" style="border:0;" allowfullscreen loading="lazy">
                        </iframe>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        // Init Map
        var map = L.map('desaMap').setView([-8.36770, 114.18542], 15);

        // Tile Layer Satellite
        var satelit = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 20
            }
        );

        // Tile Layer Biasa
        var biasa = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

        // Default layer: satelit
        satelit.addTo(map);

        // Layer control
        L.control.layers({
            "Map Biasa": biasa,
            "Satelit": satelit,
        }).addTo(map);

        // Marker Kantor Desa
        var kantorDesa = L.marker([-8.367703684351222, 114.18541967589385]).addTo(map);
        kantorDesa.bindPopup("<b>Kantor Desa Kembiritan</b><br>Lokasi Resmi Desa.");

        // Polygon Wilayah Desa (dummy)
        var wilayahDesa = [
            [-8.3669, 114.1830],
            [-8.3681, 114.1837],
            [-8.3690, 114.1859],
            [-8.3683, 114.1873],
            [-8.3667, 114.1860]
        ];

        var polygon = L.polygon(wilayahDesa, {
            color: "#16a34a",
            weight: 3,
            fillColor: "#16a34a",
            fillOpacity: 0.25
        }).addTo(map);

        polygon.bindPopup("Perkiraan Wilayah Desa");

        map.fitBounds(polygon.getBounds());
    </script>
@endpush
