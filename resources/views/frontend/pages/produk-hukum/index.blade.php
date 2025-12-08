@extends('frontend.layouts.main')

@section('content')
    {{-- Gunakan bg-gray-100 agar kontras dengan kartu putih --}}
    <div class="content-offset bg-gray-100 min-h-screen font-sans relative">

        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        {{-- HEADER SECTION --}}
        {{-- Menggunakan padding bottom besar (pb-24) untuk memberi ruang bagi kartu filter yang akan naik ke atas --}}
        <section class="pt-16 pb-24 bg-white shadow-sm relative overflow-hidden">
            {{-- Top Gradient Line --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-emerald-600"></div>

            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <span
                    class="text-green-600 font-bold tracking-wider uppercase text-xs bg-green-50 px-3 py-1 rounded-full mb-3 inline-block">
                    Transparansi Publik
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-4 tracking-tight">
                    Produk Hukum <span class="text-green-600">Desa</span>
                </h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">
                    Arsip digital Peraturan, Keputusan, dan Surat Edaran resmi pemerintah desa sebagai wujud keterbukaan
                    informasi publik.
                </p>
            </div>

            {{-- Background Decoration (Optional Pattern) --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-green-50 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-50 rounded-full opacity-50 blur-3xl"></div>
        </section>

        {{-- CONTENT SECTION --}}
        {{-- Margin top negatif (-mt-16) membuat konten naik menutupi sebagian header --}}
        <section class="-mt-16 pb-12 relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- FILTER CARD --}}
                <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 mb-8">
                    <div class="grid md:grid-cols-12 gap-5 items-end">

                        {{-- Search Input --}}
                        <div class="md:col-span-5">
                            <label
                                class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 block ml-1">Pencarian</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="bi bi-search text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <input type="text" id="searchInput" placeholder="Cari nomor atau judul dokumen..."
                                    class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:bg-white block transition-all outline-none shadow-sm">
                            </div>
                        </div>

                        {{-- Filter Tahun --}}
                        <div class="md:col-span-3">
                            <label
                                class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 block ml-1">Tahun</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-calendar text-gray-400"></i>
                                </div>
                                <select id="filterTahun"
                                    class="w-full pl-11 pr-8 py-3 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:bg-white block cursor-pointer outline-none shadow-sm appearance-none">
                                    <option value="">Semua Tahun</option>
                                    @for ($t = date('Y'); $t >= 2020; $t--)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endfor
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="md:col-span-4">
                            <label
                                class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 block ml-1">Kategori</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-funnel text-gray-400"></i>
                                </div>
                                <select id="filterKategori"
                                    class="w-full pl-11 pr-8 py-3 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:bg-white block cursor-pointer outline-none shadow-sm appearance-none">
                                    <option value="">Semua Kategori</option>
                                    <option value="Peraturan Desa">Peraturan Desa</option>
                                    <option value="Peraturan Kepala Desa">Peraturan Kepala Desa</option>
                                    <option value="Keputusan Kepala Desa">Keputusan Kepala Desa</option>
                                    <option value="Surat Edaran">Surat Edaran</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TABLE CARD --}}
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="produkTable">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider w-16 text-center">
                                        No</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul
                                        Dokumen</th>
                                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider w-64">
                                        Kategori & Tahun</th>
                                    <th
                                        class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider w-24 text-center">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($data as $i => $item)
                                    <tr class="hover:bg-green-50/50 transition-colors duration-200 group">
                                        <td class="py-4 px-6 text-center text-gray-500 font-medium">{{ $i + 1 }}</td>

                                        <td class="py-4 px-6 align-middle">
                                            <div
                                                class="text-sm font-bold text-gray-800 group-hover:text-green-700 transition-colors line-clamp-2">
                                                {{ $item['judul'] }}
                                            </div>
                                            {{-- Mobile helper --}}
                                            <div class="text-xs text-gray-500 mt-1 md:hidden">
                                                {{ $item['jenis'] }} • {{ $item['tahun'] }}
                                            </div>
                                        </td>

                                        <td class="py-4 px-6 align-middle">
                                            <div class="flex flex-col items-start gap-2">
                                                {{-- Badge Logic --}}
                                                @php
                                                    $badgeColor = match ($item['jenis']) {
                                                        'Peraturan Desa'
                                                            => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/20',
                                                        'Peraturan Kepala Desa'
                                                            => 'bg-purple-50 text-purple-700 border-purple-200 ring-purple-500/20',
                                                        'Keputusan Kepala Desa'
                                                            => 'bg-orange-50 text-orange-700 border-orange-200 ring-orange-500/20',
                                                        default
                                                            => 'bg-gray-50 text-gray-700 border-gray-200 ring-gray-500/20',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                                                    {{ $item['jenis'] }}
                                                </span>
                                                <span class="text-xs text-gray-500 font-medium flex items-center">
                                                    <i class="fa-regular fa-calendar mr-1.5 text-gray-400"></i>
                                                    Tahun {{ $item['tahun'] }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="py-4 px-6 text-center align-middle">
                                            <button onclick="openPdfModal('{{ $item['file'] }}', '{{ $item['judul'] }}')"
                                                class="inline-flex cursor-pointer items-center justify-center w-10 h-10 rounded-full bg-green-50 border border-green-200 text-green-600 hover:bg-green-600 hover:text-gray-800 hover:border-green-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
                                                title="Lihat Dokumen">
                                                <i class="bi bi-eye text-gray-400  hover:text-gray-800"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Empty State --}}
                                <tr id="noDataRow" class="hidden">
                                    <td colspan="4" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                                <i class="fa-solid fa-file-circle-xmark text-2xl text-gray-300"></i>
                                            </div>
                                            <p class="font-medium text-gray-600">Dokumen tidak ditemukan</p>
                                            <p class="text-sm mt-1">Silakan sesuaikan filter atau kata kunci pencarian Anda.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

    </div>

    {{-- MODAL PDF --}}
    <div id="pdfModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

        {{-- Scrollable Wrapper with Click Handler --}}
        <div class="fixed inset-0 z-10 overflow-y-auto" id="modalWrapper">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                {{-- Modal Panel --}}
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl opacity-0 scale-95"
                    id="modalPanel">

                    {{-- Modal Header --}}
                    <div class="bg-white px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div
                                class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <h3 class="text-sm md:text-base font-semibold text-gray-800 truncate" id="modalTitle">
                                Pratinjau Dokumen
                            </h3>
                        </div>
                        <button type="button" onclick="closePdfModal()"
                            class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-full transition-all focus:outline-none">
                            <i class="fa-solid fa-xmark text-lg w-5 h-5 flex items-center justify-center"></i>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="bg-gray-100 h-[80vh] relative">
                        <div id="loadingIndicator"
                            class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10 hidden">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                        </div>
                        <iframe id="pdfViewer" src="" class="w-full h-full border-0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const modal = document.getElementById('pdfModal');
        const backdrop = document.getElementById('modalBackdrop');
        const wrapper = document.getElementById('modalWrapper');
        const panel = document.getElementById('modalPanel');
        const viewer = document.getElementById('pdfViewer');
        const modalTitle = document.getElementById('modalTitle');
        const loadingIndicator = document.getElementById('loadingIndicator');

        function openPdfModal(pdfUrl, title) {
            // Show loading
            loadingIndicator.classList.remove('hidden');

            viewer.src = pdfUrl;

            // Hide loading when iframe loads (not perfect for PDF but helps)
            viewer.onload = function() {
                loadingIndicator.classList.add('hidden');
            };

            modalTitle.innerText = title || 'Pratinjau Dokumen';

            modal.classList.remove('hidden');
            // Animation In
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closePdfModal() {
            // Animation Out
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                viewer.src = "";
            }, 300);
        }

        // Close when clicking outside (on wrapper)
        wrapper.addEventListener('click', function(e) {
            if (e.target === wrapper) {
                closePdfModal();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closePdfModal();
            }
        });

        // FILTER LOGIC
        const searchInput = document.getElementById('searchInput');
        const filterTahun = document.getElementById('filterTahun');
        const filterKategori = document.getElementById('filterKategori');
        const tableBody = document.querySelector('#produkTable tbody');
        const noDataRow = document.getElementById('noDataRow');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const tahun = filterTahun.value;
            const kategori = filterKategori.value;
            let visibleCount = 0;

            const rows = Array.from(tableBody.querySelectorAll('tr:not(#noDataRow)'));

            rows.forEach(row => {
                const judul = row.cells[1].innerText.toLowerCase();
                const jenisTahunText = row.cells[2].innerText;

                let show = true;

                if (searchText && !judul.includes(searchText)) show = false;
                if (tahun && !jenisTahunText.includes(tahun)) show = false;
                if (kategori && !jenisTahunText.includes(kategori)) show = false;

                if (show) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            if (visibleCount === 0) {
                noDataRow.classList.remove('hidden');
            } else {
                noDataRow.classList.add('hidden');
            }
        }

        searchInput.addEventListener('keyup', filterTable);
        filterTahun.addEventListener('change', filterTable);
        filterKategori.addEventListener('change', filterTable);

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
