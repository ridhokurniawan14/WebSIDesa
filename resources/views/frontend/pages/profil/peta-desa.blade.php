@extends('frontend.layouts.main')

@section('content')
    {{-- Paksa load CSS Leaflet disini biar aman --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* --- FIX LEAFLET VS TAILWIND --- */
        /* Ini wajib ada biar gambar peta gak berantakan */
        .leaflet-pane,
        .leaflet-tile,
        .leaflet-marker-icon,
        .leaflet-marker-shadow,
        .leaflet-tile-container,
        .leaflet-pane>svg,
        .leaflet-pane>canvas,
        .leaflet-zoom-box,
        .leaflet-image-layer,
        .leaflet-layer {
            position: absolute;
            left: 0;
            top: 0;
        }

        /* Memaksa gambar tiles leaflet tidak kena reset Tailwind */
        .leaflet-pane img,
        .leaflet-tile-container img {
            max-width: none !important;
            max-height: none !important;
            width: auto;
            padding: 0;
        }

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
                <div data-aos="fade-right" data-aos-delay="100" class="relative z-10">
                    <div id="desaMap" class="w-full h-[480px] rounded-xl shadow-lg border bg-gray-100"></div>
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
                                    {{-- Ganti Hardcoded --}}
                                    <span class="w-3/4 text-right uppercase">{{ $peta->batas_utara ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-1">
                                    <strong class="font-semibold text-gray-800 w-1/4">Timur:</strong>
                                    <span class="w-3/4 text-right uppercase">{{ $peta->batas_timur ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-1">
                                    <strong class="font-semibold text-gray-800 w-1/4">Selatan:</strong>
                                    <span class="w-3/4 text-right uppercase">{{ $peta->batas_selatan ?? '-' }}</span>
                                </li>
                                <li class="flex justify-between">
                                    <strong class="font-semibold text-gray-800 w-1/4">Barat:</strong>
                                    <span class="w-3/4 text-right uppercase">{{ $peta->batas_barat ?? '-' }}</span>
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
                                    {{-- Format angka desimal ke format Indonesia (titik sebagai ribuan) --}}
                                    {{ number_format($peta->luas_wilayah, 0, ',', '.') }}
                                </p>
                                <p class="text-xl font-semibold text-gray-600">
                                    <span class="text-2xl font-bold text-gray-800">m²</span>
                                </p>
                                <p class="text-base text-gray-500 mt-4 italic">
                                    {{-- Rumus konversi m2 ke Hektare --}}
                                    (Sekitar {{ number_format($peta->luas_wilayah / 10000, 2, ',', '.') }} Hektare)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Lokasi Kantor -->
                <div data-aos="fade-left" data-aos-delay="200" class="mt-12">
                    <h2 class="text-2xl font-semibold mb-3 text-gray-800">Lokasi Kantor Desa (Google Maps)</h2>
                    @if (!empty($aplikasi->map))
                        @php
                            preg_match('/src="([^"]+)"/', $aplikasi->map, $match);
                            $mapSrc = $match[1] ?? null;
                        @endphp

                        @if ($mapSrc)
                            <div class="rounded-xl overflow-hidden shadow-md border">
                                <iframe src="{{ $mapSrc }}" class="w-full border-0" height="400" allowfullscreen
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        @endif
                    @endif

                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Tunggu sampai HTML selesai dimuat baru jalankan script
        document.addEventListener("DOMContentLoaded", function() {

            // --- 1. PARTICLE ANIMATION LOGIC ---
            (function() {
                const canvas = document.getElementById('particleCanvas');
                if (!canvas) return; // Safety check

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

            // --- 2. MAP LOGIC ---

            // Cek apakah container map ada
            if (document.getElementById('desaMap')) {
                console.log("Inisialisasi Peta...");

                // A. Persiapan Data
                var defaultLat = -8.36770;
                var defaultLng = 114.18542;
                var latKantor = defaultLat;
                var lngKantor = defaultLng;

                // Ambil string koordinat dari Blade
                var koorString = "{{ optional($peta)->koordinat_kantor ?? '' }}";

                // Ambil Polygon (Tanpa quote karena ini json object/array)
                var polygonData = {!! json_encode(optional($peta)->polygon_wilayah) !!};

                // Ambil Zoom
                var zoomLevel = {{ optional($peta)->zoom_level ?? 15 }};

                // Parsing Koordinat
                if (koorString && koorString.includes(',')) {
                    var split = koorString.split(',');
                    // Bersihkan spasi jika ada
                    latKantor = parseFloat(split[0].trim());
                    lngKantor = parseFloat(split[1].trim());
                }

                console.log("Koordinat Kantor:", latKantor, lngKantor);
                console.log("Data Polygon:", polygonData);

                // B. Init Map
                var map = L.map('desaMap').setView([latKantor, lngKantor], zoomLevel);

                // C. Layers
                var satelit = L.tileLayer(
                    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                        maxZoom: 20,
                        attribution: 'Tiles &copy; Esri'
                    });

                var biasa = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                });

                // Set default layer
                satelit.addTo(map);

                // Layer Control
                L.control.layers({
                    "Peta Jalan": biasa,
                    "Satelit": satelit,
                }).addTo(map);

                // D. Marker Kantor
                var iconKantor = L.divIcon({
                    className: 'custom-div-icon',
                    html: "<div style='background-color:#ef4444; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.5);'></div>",
                    iconSize: [12, 12],
                    iconAnchor: [6, 6]
                });

                // Gunakan marker standar leaflet dulu biar pasti muncul
                L.marker([latKantor, lngKantor])
                    .addTo(map)
                    .bindPopup("<b>Kantor Desa</b><br>Pusat Pemerintahan");

                // E. Polygon Wilayah
                if (polygonData && Array.isArray(polygonData) && polygonData.length > 0) {
                    try {
                        var polygon = L.polygon(polygonData, {
                            color: "#16a34a",
                            weight: 3,
                            fillColor: "#16a34a",
                            fillOpacity: 0.25
                        }).addTo(map);

                        polygon.bindPopup("Batas Wilayah Administrasi");
                        map.fitBounds(polygon.getBounds());
                        console.log("Polygon berhasil digambar");
                    } catch (e) {
                        console.error("Gagal menggambar polygon:", e);
                    }
                } else {
                    console.warn("Data polygon kosong atau format salah");
                }

                // Fix map render issue (abu-abu) saat load pertama
                setTimeout(function() {
                    map.invalidateSize();
                }, 400);
            } else {
                console.error("Element #desaMap tidak ditemukan!");
            }
        });
    </script>
@endpush
