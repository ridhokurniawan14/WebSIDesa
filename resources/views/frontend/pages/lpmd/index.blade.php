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

        <div class="bg-slate-50 min-h-screen">
            {{-- Hero / Header Section --}}
            <div class="relative bg-emerald-700 py-16 px-4 sm:px-6 lg:px-8 mb-12 overflow-hidden">
                <div class="absolute inset-0">
                    <svg class="h-full w-full opacity-10" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                    </svg>
                </div>
                <div class="relative max-w-7xl mx-auto text-center">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-emerald-800 text-emerald-100 text-sm font-semibold mb-4 border border-emerald-600">
                        Lembaga Desa
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
                        Lembaga Pemberdayaan Masyarakat Desa
                    </h1>
                    <p class="mt-2 max-w-2xl mx-auto text-xl text-emerald-100">
                        Mitra Pemerintah Desa dalam menampung dan mewujudkan aspirasi kebutuhan masyarakat.
                    </p>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">

                {{-- 1. Apa itu LPMD (Highlight Card) --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 border border-slate-100">
                    <div class="p-8 md:p-10">
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-100 text-emerald-600">
                                    {{-- Icon Info --}}
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-800 mb-4">Tentang LPMD</h2>
                                <div class="prose prose-emerald max-w-none text-slate-600 leading-relaxed">
                                    {!! $lpmd['deskripsi'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    {{-- 2. Dasar Hukum --}}
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-t-4 border-emerald-500">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                                </path>
                            </svg>
                            <h2 class="text-2xl font-bold text-slate-800">Dasar Hukum</h2>
                        </div>
                        <ul class="space-y-3">
                            @foreach ($lpmd['dasar_hukum'] as $item)
                                <li
                                    class="flex items-start gap-3 text-slate-600 bg-slate-50 p-3 rounded-lg hover:bg-emerald-50 transition-colors">
                                    <span class="mt-1 flex-shrink-0 h-2 w-2 rounded-full bg-emerald-500"></span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- 3. Tugas & Fungsi --}}
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-t-4 border-blue-500">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            <h2 class="text-2xl font-bold text-slate-800">Tugas & Fungsi</h2>
                        </div>
                        <ul class="space-y-3">
                            @foreach ($lpmd['tugas_fungsi'] as $item)
                                <li class="flex items-start gap-3 text-slate-600">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- 4. Struktur Organisasi --}}
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-slate-800">Struktur Organisasi</h2>
                        <p class="text-slate-500 mt-2">Susunan Pengurus LPMD Periode Berjalan</p>
                    </div>

                    {{-- Gambar Bagan dengan Modal Trigger --}}
                    <div class="bg-white p-4 rounded-2xl shadow-lg mb-10 border border-slate-100">
                        <div onclick="openModal('https://psikologi.unj.ac.id/wp-content/uploads/2025/07/Bagan-Struktur-Organisasi-fakultas-psikologi-Universitas-negeri-jakarta-2.png')"
                            class="relative rounded-xl overflow-hidden bg-slate-100 group cursor-pointer">
                            <img src="https://psikologi.unj.ac.id/wp-content/uploads/2025/07/Bagan-Struktur-Organisasi-fakultas-psikologi-Universitas-negeri-jakarta-2.png"
                                class="w-full h-auto object-contain mx-auto transition-transform duration-500 group-hover:scale-105"
                                alt="Struktur Organisasi LPMD">

                            {{-- Overlay Hover Effect dengan Ikon Zoom --}}
                            <div
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-4 group-hover:translate-y-0 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-800" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-semibold text-slate-800">Perbesar</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-sm text-slate-400 mt-3 italic">Klik gambar untuk memperbesar</p>
                    </div>

                    {{-- Grid Pengurus Inti --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        {{-- Helper Component untuk Card Pengurus --}}
                        @php
                            $officers = [
                                [
                                    'title' => 'Ketua',
                                    'name' => $lpmd['struktur']['ketua'],
                                    'color' => 'bg-emerald-600',
                                    'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                ],
                                [
                                    'title' => 'Wakil Ketua',
                                    'name' => $lpmd['struktur']['wakil'],
                                    'color' => 'bg-emerald-500',
                                    'icon' =>
                                        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                ],
                                [
                                    'title' => 'Sekretaris',
                                    'name' => $lpmd['struktur']['sekretaris'],
                                    'color' => 'bg-blue-500',
                                    'icon' =>
                                        'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                                ],
                                [
                                    'title' => 'Bendahara',
                                    'name' => $lpmd['struktur']['bendahara'],
                                    'color' => 'bg-yellow-500',
                                    'icon' =>
                                        'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                            ];
                        @endphp

                        @foreach ($officers as $officer)
                            <div
                                class="bg-white rounded-xl shadow p-6 border-l-4 {{ str_replace('bg-', 'border-', $officer['color']) }} hover:-translate-y-1 transition-transform duration-300">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="p-3 rounded-full {{ $officer['color'] }} bg-opacity-10 text-{{ str_replace('bg-', '', $officer['color']) }}">
                                        <svg class="w-6 h-6 text-{{ str_replace('bg-', '', $officer['color']) }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $officer['icon'] }}"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                            {{ $officer['title'] }}</p>
                                        <p class="font-bold text-slate-800 text-lg">{{ $officer['name'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Daftar Bidang --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-100">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                            Bidang & Seksi
                        </h3>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($lpmd['struktur']['bidang'] as $nama => $pj)
                                <div class="flex flex-col bg-slate-50 p-4 rounded-lg border border-slate-200">
                                    <span class="font-semibold text-emerald-700 mb-1">{{ $nama }}</span>
                                    <span class="text-slate-600 text-sm">{{ $pj }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 5. Program Kerja --}}
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl p-8 md:p-12 text-white">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold">Program Kerja</h2>
                            <p class="text-slate-400 mt-1">Rencana aksi nyata untuk kemajuan desa</p>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach ($lpmd['program'] as $item)
                            <div
                                class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-white text-sm">
                                    {{ $loop->iteration }}
                                </div>
                                <p class="text-slate-200 leading-relaxed">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL COMPONENT (Lightbox) --}}
        <div id="imageModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            {{-- Backdrop Blur --}}
            <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl opacity-0 scale-95"
                        id="modalPanel">

                        {{-- Close Button --}}
                        <button onclick="closeModal()"
                            class="absolute cursor-pointer top-4 right-4 z-50 text-white bg-black/50 hover:bg-black/70 rounded-full p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        {{-- Image Container --}}
                        <div class="bg-transparent" onclick="event.stopPropagation()">
                            <img id="modalImage" src="" alt="Full size"
                                class="w-full h-auto rounded-lg shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCRIPT SEDERHANA UNTUK MODAL --}}
        <script>
            function openModal(imageSrc) {
                const modal = document.getElementById('imageModal');
                const backdrop = document.getElementById('modalBackdrop');
                const panel = document.getElementById('modalPanel');
                const img = document.getElementById('modalImage');

                // Set image source
                img.src = imageSrc;

                // Show modal container
                modal.classList.remove('hidden');

                // Trigger animations (small delay to allow display:block to apply first)
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    panel.classList.remove('opacity-0', 'scale-95');
                    panel.classList.add('opacity-100', 'scale-100');
                }, 10);

                // Prevent scrolling on body
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                const modal = document.getElementById('imageModal');
                const backdrop = document.getElementById('modalBackdrop');
                const panel = document.getElementById('modalPanel');

                // Reverse animations
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'scale-100');
                panel.classList.add('opacity-0', 'scale-95');

                // Hide modal container after animation finishes
                setTimeout(() => {
                    modal.classList.add('hidden');
                    // Restore scrolling
                    document.body.style.overflow = 'auto';
                }, 300);
            }

            // Close when clicking outside the image (on the backdrop)
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this || e.target.closest('#modalBackdrop')) {
                    closeModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('imageModal').classList.contains('hidden')) {
                    closeModal();
                }
            });
        </script>
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
    </div>
@endsection
