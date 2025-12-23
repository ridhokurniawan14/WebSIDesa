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

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <!-- Gunakan bg-gray-50 agar kontras dengan kartu putih -->
    <div class="content-offset bg-gray-100 min-h-screen relative">
        {{-- Canvas ini diposisikan fixed di belakang konten --}}
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        <!-- HEADER SECTION -->
        <section data-aos="fade-down" class="pt-16 pb-10 bg-white shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
            <div class="max-w-7xl mx-auto px-4 text-center">
                <span class="text-emerald-600 font-semibold tracking-wide uppercase text-sm">Pelayanan Publik</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mt-2 mb-4">
                    Syarat & Prosedur <span class="text-emerald-600">Administrasi Desa</span>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Temukan informasi lengkap mengenai persyaratan dan alur pengurusan dokumen administrasi kependudukan dan
                    layanan desa lainnya.
                </p>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section data-aos="fade-up" class="mt-[-2rem]">
            <div class="max-w-7xl mx-auto px-4">

                <!-- SEARCH + FILTER CARD -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-10 border border-gray-100 relative z-10">
                    <div class="flex flex-col md:flex-row gap-4">

                        <!-- Search Input -->
                        <div class="w-full md:w-2/3 relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="bi bi-search text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                            </div>
                            <input id="searchInput" type="text"
                                placeholder="Cari layanan (misal: KTP, KK, Surat Pindah)..."
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-gray-700 bg-gray-50 focus:bg-white"
                                onkeyup="filterLayanan()">
                        </div>

                        <!-- Kategori Dropdown -->
                        <div class="w-full md:w-1/3 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-funnel text-gray-400"></i>
                            </div>
                            <select id="kategoriInput" onchange="filterLayanan()"
                                class="w-full pl-11 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-gray-700 bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategori as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="bi bi-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Grid Layanan -->
                <div id="layananContainer" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach ($layanan as $item)
                        <div class="layananCard group h-full" data-id="{{ $item->id }}"
                            data-nama="{{ strtolower($item->nama) }}" data-kategori="{{ $item->kategori }}"
                            onclick="openModal('{{ $item->id }}')">

                            <div
                                class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer h-full flex flex-col relative overflow-hidden">

                                <div
                                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                </div>

                                <div class="flex justify-between items-start mb-4">
                                    <div
                                        class="p-3 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                        <i class="bi bi-file-earmark-text text-xl"></i>
                                    </div>
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">
                                        {{ $kategori[$item->kategori] ?? 'Umum' }}
                                    </span>
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                    {{ $item->nama }}
                                </h3>

                                <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-grow line-clamp-3">
                                    {{ $item->deskripsi }}
                                </p>

                                <div
                                    class="flex items-center text-emerald-600 font-medium text-sm mt-auto group-hover:underline decoration-2 underline-offset-4">
                                    Lihat Detail <i
                                        class="bi bi-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State (Hidden by default) -->
                <div id="emptyState" class="hidden text-center py-20">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                        <i class="bi bi-search text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">Layanan tidak ditemukan</h3>
                    <p class="text-gray-400">Coba kata kunci lain atau ganti kategori.</p>
                </div>
            </div>
        </section>

        <!-- MODALS -->
        @foreach ($layanan as $item)
            {{-- Penyiapan Teks Copy Data --}}
            @php
                $textToCopy = '*' . strtoupper($item->nama) . "*\n\n";
                $textToCopy .= $item->deskripsi . "\n\n";

                $textToCopy .= "*SYARAT DOKUMEN:*\n";
                if (is_array($item->syarat) || is_object($item->syarat)) {
                    foreach ($item->syarat as $s) {
                        $textToCopy .= '✅ ' . $s . "\n";
                    }
                }

                $textToCopy .= "\n*ALUR PROSEDUR:*\n";
                if (is_array($item->prosedur) || is_object($item->prosedur)) {
                    foreach ($item->prosedur as $idx => $p) {
                        $textToCopy .= $idx + 1 . '. ' . $p . "\n";
                    }
                }

                $textToCopy .= "\n_Informasi dari Website $aplikasi->nama_desa._";
            @endphp

            <div id="modal-{{ $item->id }}" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">

                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity opacity-0"
                    id="backdrop-{{ $item->id }}" onclick="closeModal('{{ $item->id }}')"></div>

                <!-- Modal Panel -->
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-lg md:max-w-2xl opacity-0 scale-95"
                            id="content-{{ $item->id }}">

                            <!-- 1. Header dengan Aksen Warna -->
                            <div class="relative bg-white px-6 py-6 border-b border-gray-100">
                                <div
                                    class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-500 to-teal-400">
                                </div>

                                <div class="flex justify-between items-start mt-2">
                                    <div>
                                        <span
                                            class="inline-block px-3 py-1 mb-2 text-xs font-bold tracking-wide text-emerald-600 uppercase bg-emerald-50 rounded-full">
                                            Layanan Desa
                                        </span>
                                        <h2 class="text-2xl font-bold text-gray-800 leading-tight">{{ $item->nama }}</h2>
                                    </div>
                                    <button onclick="closeModal('{{ $item->id }}')"
                                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all cursor-pointer">
                                        <i class="bi bi-x-lg text-xl"></i>
                                    </button>
                                </div>
                                <p class="mt-2 text-gray-500 text-sm leading-relaxed">{{ $item->deskripsi }}</p>
                            </div>

                            <!-- 2. Body Scrollable -->
                            <div class="px-6 py-6 max-h-[65vh] overflow-y-auto custom-scrollbar space-y-6">

                                <!-- Section: Syarat -->
                                <div class="bg-amber-50 rounded-xl p-5 border border-amber-100">
                                    <h3 class="flex items-center text-lg font-bold text-gray-800 mb-4">
                                        <span
                                            class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                                            <i class="bi bi-file-earmark-check"></i>
                                        </span>
                                        Syarat Dokumen
                                    </h3>
                                    <ul class="space-y-3">
                                        @if (is_array($item->syarat) || is_object($item->syarat))
                                            @foreach ($item->syarat as $s)
                                                <li class="flex items-start">
                                                    <i
                                                        class="bi bi-check-circle-fill text-amber-500 mt-0.5 mr-3 flex-shrink-0 text-lg"></i>
                                                    <span
                                                        class="text-gray-700 text-sm font-medium">{{ $s }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <!-- Section: Prosedur -->
                                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-100">
                                    <h3 class="flex items-center text-lg font-bold text-gray-800 mb-4">
                                        <span
                                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                                            <i class="bi bi-diagram-3"></i>
                                        </span>
                                        Alur & Prosedur
                                    </h3>
                                    <ol class="relative border-l-2 border-emerald-200 ml-3 space-y-6">
                                        @if (is_array($item->prosedur) || is_object($item->prosedur))
                                            @foreach ($item->prosedur as $index => $p)
                                                <li class="ml-6">
                                                    <span
                                                        class="absolute flex items-center justify-center w-7 h-7 bg-white border-2 border-emerald-500 rounded-full -left-[15px]">
                                                        <span
                                                            class="text-xs text-emerald-700 font-bold">{{ $index + 1 }}</span>
                                                    </span>
                                                    <p class="text-sm text-gray-700 leading-relaxed font-medium">
                                                        {{ $p }}
                                                    </p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ol>
                                </div>
                            </div>

                            <!-- 3. Footer: Tombol Copy Data -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                                <button type="button" onclick="copyData(this)" data-text="{{ $textToCopy }}"
                                    class="cursor-pointer w-full sm:w-auto flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-md active:scale-95 group">

                                    <!-- Icon Clipboard (Hapus group-hover:hidden agar tidak hilang saat disorot) -->
                                    <i class="bi bi-clipboard text-lg default-icon"></i>
                                    <!-- Icon Checklis (Hidden by default) -->
                                    <i class="bi bi-check-lg hidden success-icon text-lg"></i>

                                    <span class="btn-text">Salin Info Lengkap</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- SCRIPT -->
        <script>
            // --- PARTICLE ANIMATION LOGIC (TETAP SAMA) ---
            (function() {
                const canvas = document.getElementById('particleCanvas');
                const ctx = canvas.getContext('2d');
                let width, height, particles = [];
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
                    for (let i = 0; i < numberOfParticles; i++) particles.push(new Particle());
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

            // --- MODAL FUNCTIONS ---
            function openModal(id) {
                const modal = document.getElementById('modal-' + id);
                const backdrop = document.getElementById('backdrop-' + id);
                const content = document.getElementById('content-' + id);

                // === PERBAIKAN: Kunci scroll body saat modal terbuka ===
                document.body.classList.add('overflow-hidden');

                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    content.classList.remove('opacity-0', 'scale-95');
                    content.classList.add('opacity-100', 'scale-100');
                }, 10);
            }

            function closeModal(id) {
                const modal = document.getElementById('modal-' + id);
                const backdrop = document.getElementById('backdrop-' + id);
                const content = document.getElementById('content-' + id);

                // === PERBAIKAN: Kembalikan scroll body saat modal tertutup ===
                document.body.classList.remove('overflow-hidden');

                backdrop.classList.add('opacity-0');
                content.classList.remove('opacity-100', 'scale-100');
                content.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // --- ROBUST COPY FUNCTION (Support HTTP & HTTPS) ---
            function copyData(button) {
                const textToCopy = button.getAttribute('data-text');

                // Fungsi fallback untuk browser lama atau non-secure context (HTTP)
                function fallbackCopyTextToClipboard(text) {
                    var textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.top = "0";
                    textArea.style.left = "0";
                    textArea.style.position = "fixed"; // Hindari scrolling
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();

                    try {
                        var successful = document.execCommand('copy');
                        if (successful) {
                            showSuccessState(button);
                        } else {
                            alert('Gagal menyalin teks.');
                        }
                    } catch (err) {
                        console.error('Fallback: Oops, unable to copy', err);
                        alert('Gagal menyalin teks.');
                    }

                    document.body.removeChild(textArea);
                }

                // Cek apakah navigator.clipboard tersedia
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(textToCopy);
                    return;
                }

                navigator.clipboard.writeText(textToCopy).then(function() {
                    showSuccessState(button);
                }, function(err) {
                    // Jika gagal pakai API modern, coba fallback
                    fallbackCopyTextToClipboard(textToCopy);
                });
            }

            function showSuccessState(button) {
                const originalText = "Salin Info Lengkap"; // Teks asli
                const iconDefault = button.querySelector('.default-icon');
                const iconSuccess = button.querySelector('.success-icon');
                const btnText = button.querySelector('.btn-text');

                // 1. Ubah Style Tombol (Gelap)
                button.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                button.classList.add('bg-gray-800', 'text-white', 'scale-95'); // Tambah efek tekan

                // 2. Toggle Icon
                if (iconDefault) iconDefault.classList.add('hidden');
                if (iconSuccess) iconSuccess.classList.remove('hidden');

                // 3. Ubah Teks
                if (btnText) btnText.innerText = "Tersalin!";

                // 4. Reset setelah 2 detik
                setTimeout(() => {
                    button.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                    button.classList.remove('bg-gray-800', 'text-white', 'scale-95');

                    if (iconDefault) iconDefault.classList.remove('hidden');
                    if (iconSuccess) iconSuccess.classList.add('hidden');

                    if (btnText) btnText.innerText = originalText;
                }, 2000);
            }

            // --- FILTER SEARCH ---
            function filterLayanan() {
                let search = document.getElementById('searchInput').value.toLowerCase();
                let kategori = document.getElementById('kategoriInput').value;
                let cards = document.querySelectorAll('.layananCard');
                let visibleCount = 0;

                cards.forEach(card => {
                    let nama = card.dataset.nama;
                    let kat = card.dataset.kategori;
                    let matchSearch = nama.includes(search);
                    let matchKat = kategori === "" || kategori === kat;

                    if (matchSearch && matchKat) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                const emptyState = document.getElementById('emptyState');
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        </script>
    </div>
@endsection
