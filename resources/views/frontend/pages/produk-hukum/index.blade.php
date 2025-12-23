@extends('frontend.layouts.main')

@section('content')
    {{-- Gunakan bg-gray-100 agar kontras dengan kartu putih --}}
    <div class="content-offset bg-gray-100 min-h-screen font-sans relative">

        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        {{-- HEADER SECTION --}}
        <section data-aos="fade-down" class="pt-16 pb-24 bg-white shadow-sm relative overflow-hidden">
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

            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-green-50 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-50 rounded-full opacity-50 blur-3xl"></div>
        </section>

        {{-- CONTENT SECTION --}}
        <section data-aos="fade-up" class="-mt-16 relative z-20">
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

                                    {{-- REVISI: Loop berdasarkan data dari Controller --}}
                                    @foreach ($tahun_tersedia as $th)
                                        <option value="{{ $th }}">{{ $th }}</option>
                                    @endforeach

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
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-10">
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
                                    <tr class="hover:bg-green-50/50 transition-colors duration-200 group data-row">

                                        {{-- Nomor --}}
                                        <td class="py-4 px-6 text-center text-gray-500 font-medium row-number">
                                            {{ $i + 1 }}
                                        </td>

                                        {{-- Judul Dokumen --}}
                                        <td class="py-4 px-6 align-middle">
                                            {{-- Ganti $item['judul'] jadi $item->judul --}}
                                            <div
                                                class="text-sm font-bold text-gray-800 group-hover:text-green-700 transition-colors line-clamp-2 title-cell">
                                                {{ $item->judul }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 md:hidden">
                                                {{ $item->jenis }} • {{ $item->tahun }}
                                            </div>
                                        </td>

                                        {{-- Kategori & Tahun --}}
                                        <td class="py-4 px-6 align-middle category-cell">
                                            <div class="flex flex-col items-start gap-2">
                                                @php
                                                    // Gunakan object syntax $item->jenis
                                                    $badgeColor = match ($item->jenis) {
                                                        'Peraturan Desa'
                                                            => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/20',
                                                        'Peraturan Kepala Desa'
                                                            => 'bg-purple-50 text-purple-700 border-purple-200 ring-purple-500/20',
                                                        'Keputusan Kepala Desa'
                                                            => 'bg-orange-50 text-orange-700 border-orange-200 ring-orange-500/20',
                                                        'Surat Edaran'
                                                            => 'bg-teal-50 text-teal-700 border-teal-200 ring-teal-500/20',
                                                        default
                                                            => 'bg-gray-50 text-gray-700 border-gray-200 ring-gray-500/20',
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeColor }}">
                                                    {{ $item->jenis }}
                                                </span>
                                                <span class="text-xs text-gray-500 font-medium flex items-center">
                                                    <i class="fa-regular fa-calendar mr-1.5 text-gray-400"></i>
                                                    Tahun {{ $item->tahun }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Aksi (Tombol Lihat) --}}
                                        <td class="py-4 px-6 text-center align-middle">
                                            {{-- 
                    PENTING: 
                    1. Pastikan path file benar. Jika upload via storage, gunakan asset('storage/'...)
                    2. Jika di DB isinya full URL, pakai langsung $item->file
                    Di bawah ini saya asumsikan file ada di folder 'storage'
                --}}
                                            <button
                                                onclick="openPdfModal('{{ asset('storage/' . $item->file) }}', '{{ $item->judul }}')"
                                                class="inline-flex cursor-pointer items-center justify-center w-10 h-10 rounded-full bg-green-50 border border-green-200 text-green-600 hover:bg-green-600 hover:text-gray-800 hover:border-green-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200"
                                                title="Lihat Dokumen">
                                                <i class="bi bi-eye text-gray-400 hover:text-gray-800"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Empty State (Tidak perlu diubah, sudah benar logic JS-nya) --}}
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

                    {{-- PAGINATION & INFO SECTION (BARU) --}}
                    <div id="paginationWrapper"
                        class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
                        {{-- Info Text (Kiri) --}}
                        <div class="text-sm text-gray-500 text-center md:text-left">
                            Menampilkan <span id="startInfo" class="font-semibold text-gray-900">0</span> sampai <span
                                id="endInfo" class="font-semibold text-gray-900">0</span> dari <span id="totalInfo"
                                class="font-semibold text-gray-900">0</span> data
                        </div>

                        {{-- Pagination Buttons (Kanan) --}}
                        <div class="flex items-center gap-1" id="paginationControls">
                            {{-- Tombol akan digenerate via JS --}}
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>

    {{-- MODAL PDF --}}
    <div id="pdfModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        {{-- Backdrop Gelap --}}
        <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

        {{-- Wrapper Utama (Area Klik Luar) --}}
        <div class="fixed inset-0 z-10 overflow-y-auto" id="modalWrapper">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                {{-- Panel Modal --}}
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl opacity-0 scale-95"
                    id="modalPanel" onclick="event.stopPropagation()">
                    {{-- stopPropagation agar klik di dalam panel TIDAK menutup modal --}}

                    {{-- Header --}}
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-200">
                        <h3 class="text-base font-bold text-gray-800" id="modalTitle">Pratinjau Dokumen</h3>

                        {{-- TOMBOL CLOSE (Pakai SVG biar pasti muncul) --}}
                        <button type="button" onclick="closePdfModal()"
                            class="bg-red-600 cursor-pointer hover:bg-red-700 text-white rounded-md p-2 transition-colors focus:outline-none flex items-center justify-center shadow-md">
                            {{-- SVG Icon X --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- PDF Viewer --}}
                    <div class="bg-gray-200 h-[80vh] relative">
                        <div id="loadingIndicator"
                            class="absolute inset-0 flex items-center justify-center bg-white z-10 hidden">
                            <div class="animate-spin rounded-full h-10 w-10 border-4 border-gray-200 border-t-green-600">
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {

            // --- MODAL LOGIC (REVISI) ---
            const modal = document.getElementById('pdfModal');
            const backdrop = document.getElementById('modalBackdrop');
            const wrapper = document.getElementById('modalWrapper');
            const panel = document.getElementById('modalPanel');
            const viewer = document.getElementById('pdfViewer');
            const modalTitle = document.getElementById('modalTitle');
            const loadingIndicator = document.getElementById('loadingIndicator');

            window.openPdfModal = function(pdfUrl, title) {
                if (!modal) return;
                loadingIndicator.classList.remove('hidden');
                viewer.src = pdfUrl;

                viewer.onload = function() {
                    loadingIndicator.classList.add('hidden');
                };

                if (modalTitle) modalTitle.innerText = title || 'Pratinjau Dokumen';

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // Matikan scroll body

                // Animasi Masuk
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    panel.classList.remove('opacity-0', 'scale-95');
                    panel.classList.add('opacity-100', 'scale-100');
                }, 10);
            };

            window.closePdfModal = function() {
                if (!modal) return;

                // Animasi Keluar
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'scale-100');
                panel.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    viewer.src = ""; // Reset source biar gak berat
                }, 300);
            };

            // LOGIC KLIK LUAR (CLOSE ON OUTSIDE CLICK)
            if (wrapper) {
                wrapper.addEventListener('click', function(e) {
                    // Kalau yang diklik adalah wrapper (area kosong) atau backdrop
                    if (e.target === wrapper || e.target === backdrop) {
                        closePdfModal();
                    }
                });
            }

            // Logic tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closePdfModal();
                }
            });


            // --- FILTER & PAGINATION LOGIC ---
            const searchInput = document.getElementById('searchInput');
            const filterTahun = document.getElementById('filterTahun');
            const filterKategori = document.getElementById('filterKategori');
            const tableBody = document.querySelector('#produkTable tbody');
            const noDataRow = document.getElementById('noDataRow');
            const paginationWrapper = document.getElementById('paginationWrapper');

            // Pagination Elements
            const startInfo = document.getElementById('startInfo');
            const endInfo = document.getElementById('endInfo');
            const totalInfo = document.getElementById('totalInfo');
            const paginationControls = document.getElementById('paginationControls');

            // Pagination Settings
            const rowsPerPage = 5; // Ganti angka ini jika ingin 10/20 data per halaman
            let currentPage = 1;
            let currentFilteredRows = []; // Menyimpan baris yang lolos filter

            if (searchInput && filterTahun && filterKategori && tableBody) {

                // Ambil semua baris data awal (kecuali baris "tidak ditemukan")
                const allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));

                function filterTable() {
                    const searchText = searchInput.value.toLowerCase();
                    const tahun = filterTahun.value;
                    const kategori = filterKategori.value;

                    // 1. Filter Data
                    currentFilteredRows = allRows.filter(row => {
                        const judul = row.querySelector('.title-cell').innerText.toLowerCase();
                        const jenisTahunText = row.querySelector('.category-cell').innerText;

                        let matchSearch = !searchText || judul.includes(searchText);
                        let matchTahun = !tahun || jenisTahunText.includes(tahun);
                        let matchKategori = !kategori || jenisTahunText.includes(kategori);

                        return matchSearch && matchTahun && matchKategori;
                    });

                    // 2. Reset ke halaman 1 setiap kali filter berubah
                    currentPage = 1;

                    // 3. Render Ulang Tampilan
                    updateTableDisplay();
                }

                function updateTableDisplay() {
                    const totalRows = currentFilteredRows.length;
                    const totalPages = Math.ceil(totalRows / rowsPerPage);

                    // Validasi current page
                    if (currentPage < 1) currentPage = 1;
                    if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;

                    // Hitung Index Start & End
                    const startIndex = (currentPage - 1) * rowsPerPage;
                    const endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                    // Sembunyikan SEMUA baris dulu
                    allRows.forEach(row => row.style.display = 'none');
                    noDataRow.classList.add('hidden');

                    if (totalRows === 0) {
                        // Jika tidak ada data
                        noDataRow.classList.remove('hidden');
                        paginationWrapper.classList.add('hidden'); // Sembunyikan pagination bar jika kosong
                    } else {
                        paginationWrapper.classList.remove('hidden');

                        // Tampilkan hanya baris yang sesuai halaman saat ini
                        for (let i = startIndex; i < endIndex; i++) {
                            currentFilteredRows[i].style.display = '';
                        }

                        // Update Info Text
                        startInfo.innerText = startIndex + 1;
                        endInfo.innerText = endIndex;
                        totalInfo.innerText = totalRows;

                        // Render Tombol Pagination
                        renderPaginationControls(totalPages);
                    }
                }

                function renderPaginationControls(totalPages) {
                    paginationControls.innerHTML = '';

                    // Helper create button
                    const createBtn = (text, page, isActive = false, isDisabled = false, isIcon = false) => {
                        const btn = document.createElement('button');
                        // PERBAIKAN: Tambahkan 'min-w-[2rem] h-8' agar tombol kotak dan 'flex items-center justify-center' agar konten di tengah
                        btn.className = `min-w-[2rem] h-8 px-3 text-sm font-medium rounded-md transition-all duration-200 border flex items-center justify-center gap-1 ${
                            isActive 
                            ? 'bg-green-600 text-white border-green-600 shadow-sm' 
                            : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 hover:text-green-600'
                        } ${isDisabled ? 'opacity-50 cursor-not-allowed hover:bg-white hover:text-gray-600' : ''}`;

                        if (isIcon) {
                            btn.innerHTML = text;
                        } else {
                            btn.innerText = text;
                        }

                        if (!isDisabled && !isActive) {
                            btn.onclick = () => {
                                currentPage = page;
                                updateTableDisplay();
                            };
                        }
                        return btn;
                    };

                    // Tombol Prev (Ganti ke bi-chevron-left agar pasti muncul)
                    const prevBtn = createBtn('<i class="bi bi-chevron-left text-xs"></i>', currentPage - 1, false,
                        currentPage === 1, true);
                    paginationControls.appendChild(prevBtn);

                    // Logic untuk "Smart" Pagination
                    const maxVisibleButtons = 5;
                    let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
                    let endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);

                    if (endPage - startPage + 1 < maxVisibleButtons) {
                        startPage = Math.max(1, endPage - maxVisibleButtons + 1);
                    }

                    // First Page button if gap exists
                    if (startPage > 1) {
                        paginationControls.appendChild(createBtn('1', 1, currentPage === 1));
                        if (startPage > 2) {
                            const dots = document.createElement('span');
                            dots.className = "px-2 text-gray-400";
                            dots.innerText = "...";
                            paginationControls.appendChild(dots);
                        }
                    }

                    // Numbered Buttons
                    for (let i = startPage; i <= endPage; i++) {
                        paginationControls.appendChild(createBtn(i, i, currentPage === i));
                    }

                    // Last Page button if gap exists
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            const dots = document.createElement('span');
                            dots.className = "px-2 text-gray-400";
                            dots.innerText = "...";
                            paginationControls.appendChild(dots);
                        }
                        paginationControls.appendChild(createBtn(totalPages, totalPages, currentPage ===
                            totalPages));
                    }

                    // Tombol Next (Ganti ke bi-chevron-right agar pasti muncul)
                    const nextBtn = createBtn('<i class="bi bi-chevron-right text-xs"></i>', currentPage + 1, false,
                        currentPage === totalPages, true);
                    paginationControls.appendChild(nextBtn);
                }

                searchInput.addEventListener('keyup', filterTable);
                filterTahun.addEventListener('change', filterTable);
                filterKategori.addEventListener('change', filterTable);

                // Initialize pertama kali
                filterTable();
            }


            // --- PARTICLE LOGIC (TETAP SAMA) ---
            const canvas = document.getElementById('particleCanvas');
            if (canvas) {
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
                    if (width && height) {
                        const numberOfParticles = (width * height) / particleDensityDivider;
                        for (let i = 0; i < numberOfParticles; i++) {
                            particles.push(new Particle());
                        }
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
            }
        });
    </script>
@endsection
