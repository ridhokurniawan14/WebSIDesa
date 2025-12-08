@extends('frontend.layouts.main')

@section('content')
    <!-- Gunakan bg-gray-50 agar kontras dengan kartu putih -->
    <div class="content-offset bg-gray-100 min-h-screen">

        <!-- HEADER SECTION -->
        <section class="pt-16 pb-10 bg-white shadow-sm relative overflow-hidden">
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
        <section class="mt-[-2rem]">
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
                        <!-- Card Item -->
                        <div class="layananCard group h-full" data-id="{{ $item['id'] }}"
                            data-nama="{{ strtolower($item['nama']) }}" data-kategori="{{ $item['kategori'] }}"
                            onclick="openModal('{{ $item['id'] }}')">

                            <div
                                class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer h-full flex flex-col relative overflow-hidden">

                                <!-- Decorative colored top bar on hover -->
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
                                        {{-- Jika ada nama kategori di array layanan, tampilkan disini. Jika tidak, pakai ID --}}
                                        {{ $kategori[$item['kategori']] ?? 'Umum' }}
                                    </span>
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-800 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                    {{ $item['nama'] }}
                                </h3>

                                <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-grow line-clamp-3">
                                    {{ $item['deskripsi'] }}
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

        <!-- MODAL DETAIL -->
        @foreach ($layanan as $item)
            <div id="modal-{{ $item['id'] }}" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">

                <!-- Backdrop with blur -->
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0"
                    id="backdrop-{{ $item['id'] }}" onclick="closeModal('{{ $item['id'] }}')"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                        <!-- Modal Content -->
                        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl opacity-0 scale-95"
                            id="content-{{ $item['id'] }}">

                            <!-- Header Modal -->
                            <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-xl font-bold text-gray-800 pr-8 leading-snug">{{ $item['nama'] }}</h2>
                                <button onclick="closeModal('{{ $item['id'] }}')"
                                    class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50">
                                    <i class="bi bi-x-lg text-lg"></i>
                                </button>
                            </div>

                            <!-- Body Modal -->
                            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto custom-scrollbar">

                                <!-- Syarat Section -->
                                <div class="mb-8">
                                    <h3 class="flex items-center text-md font-bold text-gray-800 mb-4">
                                        <span
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 text-sm">
                                            <i class="bi bi-folder2-open"></i>
                                        </span>
                                        Syarat Dokumen
                                    </h3>
                                    <ul class="grid gap-2">
                                        @foreach ($item['syarat'] as $s)
                                            <li
                                                class="flex items-start bg-blue-50/50 p-3 rounded-lg border border-blue-100/50">
                                                <i
                                                    class="bi bi-check-circle-fill text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                                                <span class="text-gray-700 text-sm">{{ $s }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Prosedur Section -->
                                <div>
                                    <h3 class="flex items-center text-md font-bold text-gray-800 mb-4">
                                        <span
                                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3 text-sm">
                                            <i class="bi bi-diagram-3"></i>
                                        </span>
                                        Alur Prosedur
                                    </h3>
                                    <ol class="relative border-l border-emerald-200 ml-3 space-y-6">
                                        @foreach ($item['prosedur'] as $index => $p)
                                            <li class="ml-6">
                                                <span
                                                    class="absolute flex items-center justify-center w-6 h-6 bg-emerald-100 rounded-full -left-3 ring-4 ring-white">
                                                    <span
                                                        class="text-xs text-emerald-600 font-bold">{{ $index + 1 }}</span>
                                                </span>
                                                <p class="text-sm text-gray-600 leading-relaxed bg-white">
                                                    {{ $p }}</p>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>

                            </div>

                            <!-- Footer / Share -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                <p class="text-center text-xs text-gray-400 mb-3 font-medium uppercase tracking-wider">
                                    Bagikan Informasi Ini</p>

                                @php
                                    $url = urlencode(url()->current());
                                    $text = urlencode('Info Layanan Desa: ' . $item['nama']);
                                @endphp

                                <div class="flex justify-center gap-2">
                                    <a href="https://api.whatsapp.com/send?text={{ $text }}%20{{ $url }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white hover:bg-green-600 hover:-translate-y-1 transition-all shadow-sm"
                                        title="WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                        target="_blank"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white hover:bg-blue-700 hover:-translate-y-1 transition-all shadow-sm"
                                        title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <button onclick="copyLink('{{ url()->current() }}', '{{ $item['id'] }}')"
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 hover:-translate-y-1 transition-all shadow-sm"
                                        title="Copy Link">
                                        <i class="bi bi-link-45deg text-lg"></i>
                                    </button>
                                </div>

                                <div id="copyAlert-{{ $item['id'] }}"
                                    class="hidden mt-2 text-center text-xs text-emerald-600 font-medium animate-pulse">
                                    Link berhasil disalin!
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- SCRIPT -->
        <script>
            function openModal(id) {
                const modal = document.getElementById('modal-' + id);
                const backdrop = document.getElementById('backdrop-' + id);
                const content = document.getElementById('content-' + id);

                modal.classList.remove('hidden');

                // Animation In
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

                // Animation Out
                backdrop.classList.add('opacity-0');
                content.classList.remove('opacity-100', 'scale-100');
                content.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    // Hide copy alert when closed
                    document.getElementById('copyAlert-' + id).classList.add('hidden');
                }, 300); // Wait for transition
            }

            function copyLink(link, id) {
                navigator.clipboard.writeText(link);
                const alertBox = document.getElementById('copyAlert-' + id);
                alertBox.classList.remove('hidden');

                setTimeout(() => {
                    alertBox.classList.add('hidden');
                }, 3000);
            }

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

                // Toggle Empty State
                const emptyState = document.getElementById('emptyState');
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            }
        </script>

        <!-- CSS Tambahan untuk Scrollbar Modal yang cantik -->
        <style>
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
    </div>
@endsection
