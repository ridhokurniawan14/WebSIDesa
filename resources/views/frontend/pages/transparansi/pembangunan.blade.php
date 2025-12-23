@extends('frontend.layouts.main')

@section('content')
    <style>
        /* Animasi Fade In */
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

        /* Custom Scrollbar Modal */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Skeleton Shimmer Animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite linear;
            background: linear-gradient(to right, #f3f4f6 4%, #e5e7eb 25%, #f3f4f6 36%);
            background-size: 1000px 100%;
        }

        /* Utility class agar body tidak bisa discroll saat modal open */
        body.modal-open {
            overflow: hidden;
        }
    </style>

    <div class="bg-gray-50 min-h-screen font-sans text-gray-800 mt-10">
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        {{-- HEADER SECTION --}}
        <div data-aos="fade-down" class="bg-emerald-700 pt-24 pb-32 rounded-b-[3rem] shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-emerald-600 text-emerald-100 text-sm font-medium mb-4 border border-emerald-500">
                    Transparansi Dana Desa
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">Realisasi Pembangunan</h1>
                <p class="text-emerald-100 max-w-2xl mx-auto text-lg">
                    Memantau perkembangan infrastruktur dan penggunaan anggaran desa secara transparan dan akuntabel.
                </p>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div data-aos="fade-up" class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">

            {{-- FILTER CARD --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-10 border border-gray-100">

                {{-- 
                    DATA PREPARATION FOR FILTER 
                    Menggunakan data dari Controller ($desas & $years) jika ada.
                    Jika belum diupdate controllernya, pakai fallback manual biar gak error.
                --}}
                @php
                    $filterDesas = isset($desas)
                        ? $desas
                        : ['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'];
                    $filterTahun = isset($years) ? $years : range(date('Y'), 2019);
                @endphp

                {{-- Form Filter --}}
                <form method="GET" action="{{ url()->current() }}"
                    class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-600 w-full lg:w-auto mb-2 lg:mb-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <span class="font-semibold whitespace-nowrap">Filter Data:</span>
                    </div>

                    <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3">

                        {{-- Filter Desa --}}
                        <div class="relative w-full sm:w-64">
                            <select name="desa"
                                class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition cursor-pointer">
                                <option value="">Semua Wilayah</option>
                                @foreach ($filterDesas as $desa)
                                    <option value="{{ $desa }}" {{ request('desa') == $desa ? 'selected' : '' }}>
                                        {{-- Cek jika $desa itu object atau string (tergantung dari controller pluck atau manual) --}}
                                        Dusun {{ is_object($desa) ? $desa->desa : $desa }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Filter Tahun (DINAMIS DARI DB) --}}
                        <div class="relative w-full sm:w-40">
                            <select name="tahun"
                                class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition cursor-pointer">
                                <option value="">Semua Tahun</option>
                                @foreach ($filterTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                            <span>Terapkan</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- GRID CONTAINER --}}
            <div id="gridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- SKELETON TEMPLATE --}}
                <template id="skeletonTemplate">
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-full flex flex-col skeleton-card">
                        <div class="h-48 animate-shimmer"></div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="h-4 w-1/3 animate-shimmer rounded mb-4"></div>
                            <div class="h-6 w-3/4 animate-shimmer rounded mb-2"></div>
                            <div class="h-6 w-1/2 animate-shimmer rounded mb-6"></div>
                            <div class="mt-auto h-10 w-full animate-shimmer rounded-lg"></div>
                        </div>
                    </div>
                </template>

                {{-- REAL DATA LOOP --}}
                @forelse ($items as $item)
                    @php
                        // Logika Warna Status
                        $statusColor = 'bg-gray-100 text-gray-800';
                        $status = strtolower($item->status);
                        if ($status == 'selesai') {
                            $statusColor = 'bg-blue-100 text-blue-700';
                        } elseif ($status == 'proses') {
                            $statusColor = 'bg-yellow-100 text-yellow-700';
                        } elseif ($status == 'batal') {
                            $statusColor = 'bg-red-100 text-red-700';
                        }

                        // Logika Thumbnail
                        $firstPhoto = !empty($item->foto) && isset($item->foto[0]) ? $item->foto[0] : null;

                        // Inject properties for JS
                        $item->status_color = $statusColor;
                    @endphp

                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-1 real-content hidden flex flex-col h-full">
                        {{-- Image Wrapper --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            {{-- Asset storage --}}
                            <img src="{{ asset('storage/' . ($firstPhoto ?? '')) }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=No+Image'">

                            <div class="absolute top-4 right-4">
                                <span
                                    class="{{ $statusColor }} text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide">
                                    {{ $item->status }}
                                </span>
                            </div>

                            <div
                                class="absolute bottom-0 left-0 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-tr-lg">
                                TA {{ $item->tahun }}
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 flex-1 flex flex-col">
                            <div
                                class="flex items-center gap-2 text-xs text-gray-500 font-medium mb-2 uppercase tracking-wide">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $item->desa }}
                            </div>

                            <h3
                                class="font-bold text-gray-800 text-lg mb-3 leading-snug line-clamp-2 group-hover:text-emerald-700 transition-colors">
                                {{ $item->judul }}
                            </h3>

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <p class="text-sm text-gray-500 mb-1">Nilai Anggaran:</p>
                                <p class="text-lg font-bold text-emerald-600 mb-4">
                                    Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                </p>
                                <button onclick="openDetailModal({{ $loop->index }})"
                                    class="w-full bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-semibold py-2.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer">
                                    <span>Lihat Rincian</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 py-10 text-center text-gray-500 real-content hidden">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <p class="text-lg">Tidak ada data pembangunan ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if ($items->hasPages())
                <div class="mt-12 flex justify-center gap-2">
                    @if (!$items->onFirstPage())
                        <a href="{{ $items->previousPageUrl() }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-600 transition cursor-pointer">&laquo;</a>
                    @endif
                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border {{ $page == $items->currentPage() ? 'bg-emerald-600 border-emerald-600 text-white shadow-md' : 'border-gray-300 hover:bg-gray-50 text-gray-600' }} transition font-medium cursor-pointer">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if ($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-600 transition cursor-pointer">&raquo;</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity opacity-0"
            id="modalBackdrop"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal Panel -->
                <div id="modalPanel"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl opacity-0 translate-y-4 scale-95">

                    <!-- Header Modal -->
                    <div
                        class="bg-gradient-to-r from-emerald-600 to-emerald-800 px-6 py-5 flex justify-between items-center border-b border-emerald-500">
                        <div class="flex flex-col text-left">
                            <h3 class="text-xl font-bold text-white tracking-wide" id="modalTitle">Detail Pembangunan</h3>
                            <p class="text-emerald-100 text-sm mt-1" id="modalSubtitle">Informasi Transparansi Dana Desa
                            </p>
                        </div>
                        <button type="button" onclick="closeDetailModal()"
                            class="rounded-full bg-white/20 p-2 text-white hover:bg-white/40 focus:outline-none transition cursor-pointer">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body Modal -->
                    <div class="px-6 py-6 max-h-[75vh] overflow-y-auto custom-scroll" id="modalContent">
                        <!-- Content Injected via JS -->
                    </div>

                    <!-- Footer Modal -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse border-t border-gray-200">
                        <button type="button" onclick="closeDetailModal()"
                            class="inline-flex w-full justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-100 sm:w-auto transition cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // Data dari Laravel
        const pageData = @json($items->items());
        const storageBaseUrl = "{{ asset('storage') }}/";

        // ============================================
        // 1. SKELETON LOADING LOGIC
        // ============================================
        document.addEventListener("DOMContentLoaded", () => {
            const grid = document.getElementById("gridContainer");
            const skeletonTemplate = document.getElementById("skeletonTemplate");
            const realCards = document.querySelectorAll(".real-content");

            // Hanya jalankan jika ada data
            if (realCards.length > 0) {
                // Tampilkan Skeleton
                realCards.forEach(() => {
                    grid.appendChild(skeletonTemplate.content.cloneNode(true));
                });

                // Simulate Loading
                setTimeout(() => {
                    // Hapus Skeleton
                    document.querySelectorAll(".skeleton-card").forEach(el => el.remove());
                    // Munculkan Real Content
                    realCards.forEach(c => {
                        c.classList.remove("hidden");
                        void c.offsetWidth; // Trigger reflow animation
                    });
                }, 800);
            } else {
                // Jika kosong
                const emptyState = document.querySelector(".real-content");
                if (emptyState) emptyState.classList.remove("hidden");
            }
        });

        // ============================================
        // 2. UTILITIES
        // ============================================
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        // ============================================
        // 3. MODAL LOGIC
        // ============================================
        function openDetailModal(index) {
            const item = pageData[index];
            if (!item) return;

            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const content = document.getElementById('modalContent');
            const title = document.getElementById('modalTitle');
            const subtitle = document.getElementById('modalSubtitle');

            // Set Header
            title.innerText = item.judul;
            subtitle.innerText = `TA ${item.tahun} - ${item.sumber_dana}`;

            // Lock Scroll Body
            document.body.classList.add('modal-open');

            // --- Logic Gambar ---
            let galleryHtml = '';
            let photos = [];

            // Parsing Data Foto dengan aman
            if (Array.isArray(item.foto)) {
                photos = item.foto;
            } else if (typeof item.foto === 'string') {
                try {
                    photos = JSON.parse(item.foto);
                } catch (e) {
                    photos = [];
                }
            }

            if (photos && photos.length > 0) {
                const photoElements = photos.map(path => {
                    // Combine Base URL + Path
                    const fullSrc = path.startsWith('http') ? path : storageBaseUrl + path;

                    return `
                        <div class="group relative aspect-video overflow-hidden rounded-xl bg-gray-100 cursor-pointer shadow-sm border border-gray-200 hover:shadow-lg transition ring-0 hover:ring-2 hover:ring-emerald-500" onclick="zoomImage('${fullSrc}')">
                            <img src="${fullSrc}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                 alt="Dokumentasi"
                                 onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Error'">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                <span class="bg-black/50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </span>
                            </div>
                        </div>
                    `;
                }).join('');

                galleryHtml = `
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Dokumentasi Kegiatan
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            ${photoElements}
                        </div>
                    </div>`;
            } else {
                galleryHtml =
                    `<div class="mt-8 pt-6 border-t border-gray-100 text-center"><p class="text-gray-400 text-sm italic py-4">Belum ada dokumentasi foto.</p></div>`;
            }

            // HTML Builder
            let html = `
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Desa & Lokasi</label>
                                <div class="font-semibold text-gray-800 text-lg border-l-4 border-emerald-500 pl-3">
                                    ${item.desa} <span class="text-gray-400 font-normal">/</span> ${item.lokasi}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Volume</label>
                                <div class="font-medium text-gray-700 bg-gray-50 px-3 py-2 rounded-lg inline-block border border-gray-200">${item.volume}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pelaksana</label>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs">${item.pelaksana.charAt(0)}</div>
                                    <span class="font-semibold text-gray-700">${item.pelaksana}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Anggaran</label>
                                <div class="font-bold text-2xl text-emerald-600 tracking-tight">${formatRupiah(item.anggaran)}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sumber Dana</label>
                                <div class="font-medium text-gray-700">${item.sumber_dana}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status</label>
                                <div class="${item.status_color} inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border border-current opacity-90">
                                    <span class="w-2 h-2 rounded-full bg-current mr-2 animate-pulse"></span>
                                    ${item.status} (${item.keterangan || '-'})
                                </div>
                            </div>
                        </div>
                    </div>
                    ${galleryHtml}
                </div>
            `;

            content.innerHTML = html;
            modal.classList.remove('hidden');

            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');

            document.body.classList.remove('modal-open'); // Unlock Scroll

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function zoomImage(src) {
            document.body.classList.add('modal-open');

            const overlay = document.createElement('div');
            overlay.className =
                "fixed inset-0 bg-black/95 backdrop-blur-md flex items-center justify-center z-[60] p-4 opacity-0 transition-opacity duration-300 cursor-zoom-out";
            overlay.innerHTML = `
                <div class="relative max-w-5xl w-full flex justify-center">
                    <img src="${src}" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300 object-contain">
                    <button class="absolute -top-12 right-0 text-white hover:text-emerald-400 transition p-2 cursor-pointer">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <p class="absolute -bottom-10 text-gray-400 text-sm">Klik di mana saja untuk menutup</p>
                </div>
            `;
            document.body.appendChild(overlay);

            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                overlay.querySelector('img').classList.remove('scale-95');
                overlay.querySelector('img').classList.add('scale-100');
            });

            overlay.onclick = () => {
                overlay.classList.add('opacity-0');
                overlay.querySelector('img').classList.add('scale-95');
                setTimeout(() => overlay.remove(), 300);
            };
        }
    </script>

    {{-- PARTICLE SCRIPT --}}
    <script>
        (function() {
            const canvas = document.getElementById('particleCanvas');
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
    </script>
@endsection
