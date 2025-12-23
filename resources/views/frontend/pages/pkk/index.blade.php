@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">
        <canvas id="particleCanvas"
            class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60 bg-gray-100"></canvas>
        <div class="font-inter min-h-screen relative z-10">
            <header data-aos="fade-down" class="relative overflow-hidden pt-20 pb-32 text-white">
                <div class="absolute inset-0 bg-gradient-to-br from-green-800 via-teal-600 to-emerald-500 opacity-95 z-0">
                </div>

                <div class="max-w-7xl mx-auto px-4 relative z-20 text-center">
                    <!-- Eyebrow Text: Badge Style -->
                    <div class="inline-block mb-6 animate-fadeIn">
                        <span
                            class="py-1.5 px-4 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-green-50 font-bold tracking-[0.15em] uppercase text-xs sm:text-sm shadow-sm">
                            Pemberdayaan Kesejahteraan Keluarga
                        </span>
                    </div>

                    <!-- Main Heading: Better Hierarchy -->
                    <h1 class="text-5xl sm:text-7xl font-black mb-6 leading-tight tracking-tight drop-shadow-lg">
                        <span
                            class="block text-green-200 text-2xl sm:text-3xl font-extrabold mb-1 tracking-normal uppercase opacity-90">PKK
                            Desa</span>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-green-100">
                            Membangun Keluarga Sejahtera
                        </span>
                    </h1>

                    <!-- Description: Better Readability -->
                    <p
                        class="text-green-50 max-w-2xl mx-auto text-lg sm:text-xl font-medium leading-relaxed drop-shadow-md mb-8">
                        Gerakan nasional yang memberdayakan setiap keluarga sebagai pondasi utama kemajuan dan kemandirian
                        desa.
                    </p>

                    <!-- Button: Modern Call to Action -->
                    <a href="#program-pokok"
                        class="group inline-flex items-center px-8 py-4 border border-transparent text-base font-bold rounded-full shadow-xl text-teal-800 bg-white hover:bg-green-50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                        <span>Lihat 10 Program Pokok</span>
                        <!-- Animated Arrow Icon -->
                        <svg class="ml-2 w-5 h-5 text-teal-600 group-hover:translate-x-1 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>

                <svg class="absolute bottom-0 left-0 w-full h-auto text-gray-100 z-10" viewBox="0 0 1340 255"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <!-- Note: text-gray-100 di sini agar menyatu dengan background canvas -->
                    <path fill-opacity="1"
                        d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,192C672,213,768,235,864,213.3C960,192,1056,128,1152,106.7C1248,85,1344,107,1392,117.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </header>

            <main class="content-offset">
                <div class="max-w-7xl mx-auto px-4 space-y-24 pt-12">

                    <!-- TENTANG PKK (Split Section with Visual) -->
                    <section data-aos="flip-up" class="grid lg:grid-cols-2 gap-12 items-center">
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
                            @php
                                // Ambil gambar dari DB field gambar_ilustrasi
                                $ilustrasiSrc =
                                    $pkk && $pkk->gambar_ilustrasi
                                        ? asset('storage/' . $pkk->gambar_ilustrasi)
                                        : 'https://placehold.co/600x400/34D399/ffffff?text=ILUSTRASI+KEGIATAN+PKK';
                            @endphp
                            <img src="{{ $ilustrasiSrc }}" alt="Ilustrasi Kegiatan PKK"
                                class="w-full h-full object-cover rounded-2xl transform hover:scale-105 transition duration-500 ease-in-out">
                        </div>
                    </section>

                    <!-- 10 PROGRAM POKOK PKK (Dynamic Grid with Highlight) -->
                    <section id="program-pokok">
                        <div data-aos="fade" class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-green-600 bg-green-100 py-1 px-3 rounded-full">Fokus
                                Utama</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Sepuluh Pilar Pemberdayaan</h2>
                        </div>
                        <div data-aos="flip-right" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {{-- Cek jika data kosong, tampilkan default atau kosong --}}
                            @php
                                // Jika data DB kosong, gunakan default ini (opsional, bisa dihapus jika yakin DB terisi)
                                $programs = empty($program_pokok)
                                    ? [
                                        'Penghayatan dan Pengamalan Pancasila',
                                        'Gotong Royong',
                                        'Pangan',
                                        'Sandang',
                                        'Perumahan dan Tata Laksana Rumah Tangga',
                                        'Pendidikan dan Keterampilan',
                                        'Kesehatan',
                                        'Pengembangan Kehidupan Berkoperasi',
                                        'Kelestarian Lingkungan Hidup',
                                        'Perencanaan Sehat',
                                    ]
                                    : $program_pokok;
                            @endphp

                            @foreach ($programs as $index => $program)
                                @php
                                    $number = $index + 1;
                                    $iconColor = $number % 2 === 0 ? 'bg-teal-500' : 'bg-lime-500';
                                    $borderColor = $number % 2 === 0 ? 'border-teal-200' : 'border-lime-200';
                                @endphp

                                {{-- Tampilan Card Program Pokok Tetap Sama --}}
                                <div
                                    class="bg-white rounded-xl p-6 shadow-lg border-2 {{ $borderColor }} transition duration-300 hover:shadow-2xl hover:border-teal-400 relative z-20">
                                    <div class="flex items-start mb-3">
                                        <span
                                            class="w-10 h-10 {{ $iconColor }} text-white flex items-center justify-center font-bold text-xl rounded-lg shadow-md mr-4 flex-shrink-0">
                                            {{ $number }}
                                        </span>
                                        <div>
                                            <h3 class="font-bold text-xl text-gray-900">{{ $program }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Fokus pada {{ strtolower(explode(' ', $program)[0]) }} dan peningkatan
                                                kualitas hidup.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- STRUKTUR PENGURUS (Modern Grid) -->
                    <section class="text-center">
                        <div data-aos="fade-down" class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-gray-600 bg-gray-200 py-1 px-3 rounded-full">Tim
                                Penggerak</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Struktur Pengurus Inti</h2>
                        </div>

                        {{-- REVISI LAYOUT: Pakai Flex Wrap & Justify Center agar item ganjil ada di tengah --}}
                        <div data-aos="flip-left" class="flex flex-wrap justify-center gap-8">
                            @forelse ($pengurus as $item)
                                {{-- Atur lebar card: HP (Full), Tablet (45%), Desktop (22%) --}}
                                <div
                                    class="w-full sm:w-[calc(50%-2rem)] lg:w-[calc(25%-2rem)] bg-white rounded-2xl p-6 shadow-xl border border-gray-100 transition duration-300 hover:bg-green-50 transform hover:-translate-y-1 relative z-20">

                                    @php
                                        $imgSrc = !empty($item['photo_url'])
                                            ? asset('storage/' . $item['photo_url'])
                                            : 'https://placehold.co/120x120/E0F2F1/047857?text=' .
                                                urlencode($item['nama']);
                                    @endphp

                                    <img src="{{ $imgSrc }}" alt="Foto {{ $item['nama'] }}"
                                        class="w-28 h-28 mx-auto mb-4 rounded-full object-cover border-4 border-green-500">

                                    <h4 class="text-xl font-extrabold text-gray-900">{{ $item['nama'] }}</h4>
                                    <p class="text-md font-medium text-green-600 mt-1">{{ $item['jabatan'] }}</p>
                                </div>
                            @empty
                                <div class="w-full text-center py-10 text-gray-500">
                                    Belum ada data pengurus.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- KEGIATAN PKK (New Grid Card Design) -->
                    <section>
                        <div data-aos="fade" class="text-center mb-12">
                            <span
                                class="text-sm font-semibold uppercase text-teal-600 bg-teal-100 py-1 px-3 rounded-full">Aksi
                                Nyata</span>
                            <h2 class="text-4xl font-extrabold mt-3 text-gray-800">Jadwal & Fokus Kegiatan</h2>
                        </div>

                        {{-- UBAH DISINI: Ganti Grid jadi Flex + Justify Center --}}
                        <div data-aos="flip-up" class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto">
                            @php
                                // Ambil dari $pkk jika ada, atau fallback array
                                $listKegiatan = !empty($pkk->kegiatan)
                                    ? $pkk->kegiatan
                                    : $kegiatan ?? [
                                            'Posyandu Balita & Lansia',
                                            'Pelatihan Kerajinan Tangan',
                                            'Bazar UMKM Desa',
                                            'Jumat Bersih Lingkungan',
                                            'Senam Sehat Bersama',
                                        ];
                            @endphp

                            @foreach ($listKegiatan as $index => $k)
                                @php
                                    $cardBg = $index % 2 === 0 ? 'bg-white' : 'bg-green-50';
                                    $titleColor = $index % 2 === 0 ? 'text-teal-700' : 'text-green-700';
                                    $iconColor = $index % 2 === 0 ? 'text-teal-500' : 'text-green-500';
                                    $namaKegiatan = is_array($k) ? $k['nama'] ?? 'Kegiatan' : $k;
                                @endphp

                                {{-- UBAH ITEM SIZE: 
                 1. w-full (HP) 
                 2. md:w-[calc(50%-2rem)] (Tablet: 2 kolom)
                 3. lg:w-[calc(33.33%-2rem)] (Laptop: 3 kolom) 
            --}}
                                <div
                                    class="w-full md:w-[calc(50%-2rem)] lg:w-[calc(33.333%-2rem)] {{ $cardBg }} rounded-xl p-6 shadow-lg border border-gray-100 transition duration-300 hover:shadow-2xl relative z-20 flex flex-col">

                                    <div class="flex items-center mb-3">
                                        <svg class="w-8 h-8 {{ $iconColor }} mr-3 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            @if ($index == 0)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            @elseif ($index == 1)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H7a2 2 0 00-2 2v11a2 2 0 002 2z">
                                                </path>
                                            @elseif ($index == 2)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4V5a2 2 0 012-2h12a2 2 0 012 2v2zm-2 0h-4m4 0v14a2 2 0 01-2 2H6a2 2 0 01-2-2V7h16z">
                                                </path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            @endif
                                        </svg>
                                        <h3 class="text-xl font-bold {{ $titleColor }}">{{ $namaKegiatan }}</h3>
                                    </div>

                                    <p class="text-base text-gray-600 flex-grow">
                                        @if ($index == 0)
                                            Penyediaan layanan kesehatan rutin dan peningkatan gizi bagi Balita dan dukungan
                                            Lansia.
                                        @elseif ($index == 1)
                                            Mengembangkan potensi ibu rumah tangga menjadi sumber pendapatan keluarga
                                            melalui pelatihan.
                                        @elseif ($index == 2)
                                            Mendorong pertumbuhan ekonomi lokal melalui pendampingan usaha mikro (UMKM).
                                        @else
                                            Aktivitas rutin yang mendukung lingkungan yang bersih, sehat, dan pelestarian
                                            alam desa.
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- KONTAK (Clear Call-to-Action) -->
                    <section>
                        <div data-aos="fade"
                            class="bg-green-50 rounded-3xl p-10 sm:p-16 text-center shadow-2xl transition duration-300 transform hover:scale-[1.01] hover:shadow-3xl border border-green-100 relative z-20">
                            <h2 class="text-3xl font-extrabold mb-4 text-green-800">Mari Berpartisipasi!</h2>
                            <p class="text-gray-700 max-w-2xl mx-auto text-lg mb-6">
                                Dukung dan jadilah bagian dari perubahan positif di desa Anda. Hubungi kami sekarang untuk
                                informasi lebih lanjut.
                            </p>
                            <div
                                class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">

                                {{-- POINT 2: NAMA KETUA DARI DB --}}
                                <p class="font-semibold text-2xl text-green-600">
                                    Ibu {{ $pkk->nama_ketua ?? 'Ketua PKK' }} (Ketua)
                                </p>

                                {{-- POINT 1: NOMOR WA DARI DB --}}
                                @php
                                    $waNumber = $pkk->nomor_hp_wa ?? '628123456789';
                                    // Pastikan format bersih angka saja untuk link WA
                                    $waClean = preg_replace('/[^0-9]/', '', $waNumber);
                                @endphp

                                <a href="https://wa.me/{{ $waClean }}?text=Halo%20Ibu%20{{ urlencode($pkk->nama_ketua ?? 'Ketua') }}%2C%20saya%20tertarik%20dengan%20program%20PKK%20Desa."
                                    target="_blank"
                                    class="inline-flex items-center px-6 py-3 border-2 border-green-600 text-base font-medium rounded-full shadow-md text-white bg-green-600 hover:bg-green-700 transition duration-150 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z">
                                        </path>
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>
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
            const canvas = document.getElementById('particleCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            // Konfigurasi
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

            // Init
            resize();
            initParticles();
            animate();

        })();
    </script>
@endsection
