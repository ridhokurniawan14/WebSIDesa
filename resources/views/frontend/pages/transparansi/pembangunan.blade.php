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

    {{-- 
        =============================================
        DATA LOGIC (PHP)
        ============================================= 
    --}}
    @php
        // Data Statis (Saya set path gambar ke local path agar sesuai kebutuhan umum)
        // Jika file tidak ada, script 'onerror' di bawah akan otomatis menggantinya.
        $pembangunanData = [
            [
                'slug' => 'pembangunan-1',
                'judul' => 'Pembangunan Jalan RT 2 RW 1',
                'desa' => 'Krajan Satu',
                'anggaran' => 51575000,
                'lokasi' => 'RT 2 / RW 1 - SUSUKAN KIDUL',
                'volume' => '200 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Hariyanto',
                'status' => 'Selesai',
                'status_color' => 'bg-blue-100 text-blue-700',
                'keterangan' => 'Pekerjaan sudah selesai 100%',
                'thumbnail' => '/img/pembangunan/1/thumb.jpg',
                'foto' => ['/img/pembangunan/1/1.jpg', '/img/pembangunan/1/2.jpg', '/img/pembangunan/1/3.jpg'],
            ],
            [
                'slug' => 'pembangunan-2',
                'judul' => 'TPT Sungai Dusun Pandan',
                'desa' => 'Pandan',
                'anggaran' => 87500000,
                'lokasi' => 'RT 1 / RW 2',
                'volume' => '150 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Sutarman',
                'status' => 'Proses',
                'status_color' => 'bg-yellow-100 text-yellow-700',
                'keterangan' => 'Progres 90%',
                'thumbnail' => '/img/pembangunan/2/thumb.jpg',
                'foto' => ['/img/pembangunan/2/1.jpg', '/img/pembangunan/2/2.jpg'],
            ],
            [
                'slug' => 'pembangunan-1',
                'judul' => 'Pembangunan Jalan RT 2 RW 1',
                'desa' => 'Krajan Satu',
                'anggaran' => 51575000,
                'lokasi' => 'RT 2 / RW 1 - SUSUKAN KIDUL',
                'volume' => '200 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Hariyanto',
                'status' => 'Selesai',
                'status_color' => 'bg-blue-100 text-blue-700',
                'keterangan' => 'Pekerjaan sudah selesai 100%',
                'thumbnail' => '/img/pembangunan/1/thumb.jpg',
                'foto' => ['/img/pembangunan/1/1.jpg', '/img/pembangunan/1/2.jpg', '/img/pembangunan/1/3.jpg'],
            ],
            [
                'slug' => 'pembangunan-2',
                'judul' => 'TPT Sungai Dusun Pandan',
                'desa' => 'Pandan',
                'anggaran' => 87500000,
                'lokasi' => 'RT 1 / RW 2',
                'volume' => '150 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Sutarman',
                'status' => 'Proses',
                'status_color' => 'bg-yellow-100 text-yellow-700',
                'keterangan' => 'Progres 90%',
                'thumbnail' => '/img/pembangunan/2/thumb.jpg',
                'foto' => ['/img/pembangunan/2/1.jpg', '/img/pembangunan/2/2.jpg'],
            ],
            [
                'slug' => 'pembangunan-1',
                'judul' => 'Pembangunan Jalan RT 2 RW 1',
                'desa' => 'Krajan Satu',
                'anggaran' => 51575000,
                'lokasi' => 'RT 2 / RW 1 - SUSUKAN KIDUL',
                'volume' => '200 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Hariyanto',
                'status' => 'Selesai',
                'status_color' => 'bg-blue-100 text-blue-700',
                'keterangan' => 'Pekerjaan sudah selesai 100%',
                'thumbnail' => '/img/pembangunan/1/thumb.jpg',
                'foto' => ['/img/pembangunan/1/1.jpg', '/img/pembangunan/1/2.jpg', '/img/pembangunan/1/3.jpg'],
            ],
            [
                'slug' => 'pembangunan-2',
                'judul' => 'TPT Sungai Dusun Pandan',
                'desa' => 'Pandan',
                'anggaran' => 87500000,
                'lokasi' => 'RT 1 / RW 2',
                'volume' => '150 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Sutarman',
                'status' => 'Proses',
                'status_color' => 'bg-yellow-100 text-yellow-700',
                'keterangan' => 'Progres 90%',
                'thumbnail' => '/img/pembangunan/2/thumb.jpg',
                'foto' => ['/img/pembangunan/2/1.jpg', '/img/pembangunan/2/2.jpg'],
            ],
            [
                'slug' => 'pembangunan-1',
                'judul' => 'Pembangunan Jalan RT 2 RW 1',
                'desa' => 'Krajan Satu',
                'anggaran' => 51575000,
                'lokasi' => 'RT 2 / RW 1 - SUSUKAN KIDUL',
                'volume' => '200 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Hariyanto',
                'status' => 'Selesai',
                'status_color' => 'bg-blue-100 text-blue-700',
                'keterangan' => 'Pekerjaan sudah selesai 100%',
                'thumbnail' => '/img/pembangunan/1/thumb.jpg',
                'foto' => ['/img/pembangunan/1/1.jpg', '/img/pembangunan/1/2.jpg', '/img/pembangunan/1/3.jpg'],
            ],
            [
                'slug' => 'pembangunan-2',
                'judul' => 'TPT Sungai Dusun Pandan',
                'desa' => 'Pandan',
                'anggaran' => 87500000,
                'lokasi' => 'RT 1 / RW 2',
                'volume' => '150 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Sutarman',
                'status' => 'Proses',
                'status_color' => 'bg-yellow-100 text-yellow-700',
                'keterangan' => 'Progres 90%',
                'thumbnail' => '/img/pembangunan/2/thumb.jpg',
                'foto' => ['/img/pembangunan/2/1.jpg', '/img/pembangunan/2/2.jpg'],
            ],
        ];

        // Filter Logic
        $selectedDesa = request('desa');
        $filtered = collect($pembangunanData)->filter(fn($i) => !$selectedDesa || $i['desa'] == $selectedDesa);

        // Pagination Logic
        $perPage = 6;
        $page = request('page', 1);
        $totalItems = $filtered->count();
        $totalPages = ceil($totalItems / $perPage);
        // PENTING: values() digunakan agar index array urut (0,1,2..) untuk JavaScript
        $items = $filtered->slice(($page - 1) * $perPage, $perPage)->values();
    @endphp

    <style>
        /* Custom Scrollbar for Modal */
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

        /* Skeleton Animation */
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
    </style>

    <div class="bg-gray-50 min-h-screen font-sans text-gray-800 mt-10">
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        {{-- 
            =============================================
            HEADER SECTION
            ============================================= 
        --}}
        <div data-aos="fade-down" class="bg-emerald-700 pt-24 pb-32 rounded-b-[3rem] shadow-xl relative overflow-hidden">
            <!-- Decorative patterns -->
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
                    class="inline-block py-1 px-3 rounded-full bg-emerald-600 text-emerald-100 text-sm font-medium mb-4 border border-emerald-500">Transparansi
                    Dana Desa</span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    Realisasi Pembangunan
                </h1>
                <p class="text-emerald-100 max-w-2xl mx-auto text-lg">
                    Memantau perkembangan infrastruktur dan penggunaan anggaran desa secara transparan dan akuntabel.
                </p>
            </div>
        </div>

        {{-- 
            =============================================
            MAIN CONTENT (FILTER & GRID)
            ============================================= 
        --}}
        <div data-aos="fade-up" class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">

            {{-- FILTER CARD --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-10 border border-gray-100">
                <form method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex items-center gap-2 text-gray-600 w-full md:w-auto">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <span class="font-semibold">Filter Data:</span>
                    </div>

                    <div class="flex w-full md:w-auto gap-3">
                        <div class="relative w-full md:w-64">
                            <select name="desa"
                                class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2.5 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition cursor-pointer">
                                <option value="">Semua Wilayah</option>
                                @foreach (['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'] as $desa)
                                    <option value="{{ $desa }}" {{ request('desa') == $desa ? 'selected' : '' }}>
                                        Dusun {{ $desa }}
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

                        <button
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg flex items-center gap-2">
                            <span>Terapkan</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- GRID CONTAINER --}}
            <div id="gridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- ITEM SKELETON (Hidden by JS later) --}}
                <template id="skeletonTemplate">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-full flex flex-col">
                        <div class="h-48 animate-shimmer"></div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="h-4 w-1/3 animate-shimmer rounded mb-4"></div>
                            <div class="h-6 w-3/4 animate-shimmer rounded mb-2"></div>
                            <div class="h-6 w-1/2 animate-shimmer rounded mb-6"></div>
                            <div class="mt-auto h-10 w-full animate-shimmer rounded-lg"></div>
                        </div>
                    </div>
                </template>

                {{-- REAL CARDS --}}
                @forelse ($items as $item)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-1 real-content hidden flex flex-col h-full">

                        {{-- Image Wrapper --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            {{-- PERBAIKAN: Menambahkan this.onerror=null untuk mencegah infinite loop dan mengganti ke placeholder --}}
                            <img src="{{ $item['thumbnail'] }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=No+Image'">

                            {{-- Badge Overlay --}}
                            <div class="absolute top-4 right-4">
                                <span
                                    class="{{ $item['status_color'] ?? 'bg-gray-100 text-gray-800' }} text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wide">
                                    {{ $item['status'] ?? 'Proses' }}
                                </span>
                            </div>

                            {{-- Year Badge --}}
                            <div
                                class="absolute bottom-0 left-0 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-tr-lg">
                                TA {{ $item['tahun'] }}
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
                                {{ $item['desa'] }}
                            </div>

                            <h3
                                class="font-bold text-gray-800 text-lg mb-3 leading-snug line-clamp-2 group-hover:text-emerald-700 transition-colors">
                                {{ $item['judul'] }}
                            </h3>

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <p class="text-sm text-gray-500 mb-1">Nilai Anggaran:</p>
                                <p class="text-lg font-bold text-emerald-600 mb-4">
                                    Rp {{ number_format($item['anggaran'], 0, ',', '.') }}
                                </p>

                                {{-- PERBAIKAN: Menggunakan $loop->index untuk memanggil modal, bukan object item --}}
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
            @if ($totalPages > 1)
                <div class="mt-12 flex justify-center gap-2">
                    @if ($page > 1)
                        <a href="?page={{ $page - 1 }}{{ $selectedDesa ? '&desa=' . $selectedDesa : '' }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-600 transition">
                            &laquo;
                        </a>
                    @endif

                    @for ($i = 1; $i <= $totalPages; $i++)
                        <a href="?page={{ $i }}{{ $selectedDesa ? '&desa=' . $selectedDesa : '' }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border {{ $i == $page ? 'bg-emerald-600 border-emerald-600 text-white shadow-md' : 'border-gray-300 hover:bg-gray-50 text-gray-600' }} transition font-medium">
                            {{ $i }}
                        </a>
                    @endfor

                    @if ($page < $totalPages)
                        <a href="?page={{ $page + 1 }}{{ $selectedDesa ? '&desa=' . $selectedDesa : '' }}"
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-600 transition">
                            &raquo;
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>


    {{-- 
        =============================================
        MODAL DETAIL (Glassmorphism Style)
        ============================================= 
    --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity opacity-0"
            id="modalBackdrop"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                <div id="modalPanel"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl opacity-0 translate-y-4 scale-95">

                    <!-- Header Modal -->
                    <div class="bg-emerald-600 px-4 py-4 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg font-semibold leading-6 text-white" id="modalTitle">Detail Pembangunan</h3>
                        <button type="button" onclick="closeDetailModal()"
                            class="rounded-md bg-emerald-700 text-emerald-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white p-1">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body Modal -->
                    <div class="px-4 py-5 sm:p-6 max-h-[70vh] overflow-y-auto custom-scroll" id="modalContent">
                        <!-- Content Injected via JS -->
                    </div>

                    <!-- Footer Modal -->
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                        <button type="button" onclick="closeDetailModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Tutup
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 
        =============================================
        JAVASCRIPT LOGIC
        ============================================= 
    --}}
    <script>
        // PERBAIKAN UTAMA: Menyimpan data PHP ke variabel JS global
        const pageData = @json($items);

        document.addEventListener("DOMContentLoaded", () => {
            const grid = document.getElementById("gridContainer");
            const skeletonTemplate = document.getElementById("skeletonTemplate");
            const realCards = document.querySelectorAll(".real-content");

            // 1. Inject Skeletons
            realCards.forEach(() => {
                grid.appendChild(skeletonTemplate.content.cloneNode(true));
            });

            // 2. Simulate Loading then Switch
            setTimeout(() => {
                const skeletons = document.querySelectorAll(".animate-shimmer").forEach(el => {
                    el.closest('.bg-white').remove();
                });
                realCards.forEach(c => {
                    c.classList.remove("hidden");
                    void c.offsetWidth;
                });
            }, 800);
        });

        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        // Fungsi sekarang menerima INDEX array, bukan objek item langsung
        function openDetailModal(index) {
            // Ambil data dari variabel global berdasarkan index
            const item = pageData[index];

            if (!item) return;

            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const content = document.getElementById('modalContent');
            const title = document.getElementById('modalTitle');

            // Set Title
            title.innerText = "Detail: " + item.judul;

            // HTML Structure for Modal Content
            let html = `
                <div class="space-y-6">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Desa / Lokasi</span>
                            <span class="font-semibold text-gray-900">${item.desa} / ${item.lokasi}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Anggaran</span>
                            <span class="font-semibold text-emerald-600 text-base">${formatRupiah(item.anggaran)}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Volume</span>
                            <span class="font-semibold text-gray-900">${item.volume}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Sumber Dana</span>
                            <span class="font-semibold text-gray-900">${item.sumber_dana} (${item.tahun})</span>
                        </div>
                        <div class="col-span-1 sm:col-span-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Pelaksana</span>
                            <span class="font-semibold text-gray-900">${item.pelaksana}</span>
                        </div>
                         <div class="col-span-1 sm:col-span-2">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Keterangan / Progres</span>
                            <p class="text-gray-700 leading-relaxed bg-blue-50 p-3 rounded-lg border border-blue-100 text-blue-800">
                                ${item.keterangan}
                            </p>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Dokumentasi Kegiatan
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            ${item.foto.map(img => `
                                                                    <div class="group relative aspect-square overflow-hidden rounded-xl bg-gray-200 cursor-pointer shadow-sm hover:shadow-md transition" onclick="zoomImage('${img}')">
                                                                        <img src="${img}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.onerror=null; this.src='https://placehold.co/300?text=No+Img'">
                                                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                                        </div>
                                                                    </div>
                                                                `).join('')}
                        </div>
                    </div>
                </div>
            `;

            content.innerHTML = html;
            modal.classList.remove('hidden');

            // Animation In
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

            // Animation Out
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Wait for transition
        }

        function zoomImage(src) {
            const overlay = document.createElement('div');
            overlay.className =
                "fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-[100] p-4 opacity-0 transition-opacity duration-300";
            overlay.innerHTML = `
                <img src="${src}" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onerror="this.src='https://placehold.co/600x400?text=Image+Error'">
                <button class="absolute top-4 right-4 text-white hover:text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
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
