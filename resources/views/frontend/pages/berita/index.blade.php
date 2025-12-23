@extends('frontend.layouts.main')

@section('content')
    <style>
        /* CSS Khusus untuk Efek Aurora */
        .aurora-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -10;
            background-color: #f8fafc;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background-color: #86efac;
            animation-delay: 0s;
        }

        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background-color: #bae6fd;
            animation-delay: -2s;
        }

        .blob-3 {
            top: 40%;
            left: 40%;
            width: 400px;
            height: 400px;
            background-color: #fef08a;
            animation-delay: -4s;
            opacity: 0.4;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }
    </style>

    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="content-offset">

        {{-- Hero Section --}}
        <section data-aos="fade" class="w-full bg-green-700 text-white py-16 bg-cover bg-center relative"
            style="background-image: url('https://www.pelita-air.com/admin/assets/uploads/images/promotion/2023-08/5-desa-wisata-terindah-di-sumatera-barat-6905.webp');">
            <!-- Overlay Gelap agar teks terbaca -->
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h1 class="text-4xl font-bold mb-2">Berita Desa</h1>
                <p class="text-white/90">Informasi terbaru dari Pemerintah {{ $aplikasi->nama_desa }}</p>
            </div>
        </section>

        {{-- Content Section --}}
        <section class="mt-10 mb-16">
            <div class="max-w-7xl mx-auto px-4">

                {{-- FITUR SEARCH (Pojok Kanan) --}}
                <div data-aos="fade-left" class="flex flex-col md:flex-row justify-end items-center mb-8 gap-4">
                    <!-- Form Search -->
                    <form action="{{ url()->current() }}" method="GET" class="w-full md:w-auto">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari berita..."
                                class="w-full md:w-72 pl-4 pr-10 py-2 rounded-full border border-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-sm bg-white/80 backdrop-blur-sm transition-all">
                            <button type="submit"
                                class="absolute right-0 top-0 mt-2 mr-3 text-green-600 hover:text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- List Berita Grid --}}
                @if ($beritas->count() > 0)
                    <div data-aos="fade-right" class="grid md:grid-cols-3 gap-10">
                        @foreach ($beritas as $item)
                            <a href="{{ url('/berita/' . $item->slug) }}"
                                class="group block bg-white/80 backdrop-blur-md rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-1 overflow-hidden border border-white/50">

                                {{-- Container Gambar dengan Efek Zoom Hover --}}
                                <div class="h-52 w-full overflow-hidden relative">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
                                        style="background-image: url('{{ $item['thumbnail'] }}')">
                                    </div>
                                    <!-- Overlay halus saat hover (opsional, biar teks makin jelas pas hover) -->
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300">
                                    </div>
                                </div>

                                <div class="p-5">
                                    <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-md">
                                        {{ $item->date->locale('id')->isoFormat('D MMMM Y') }}
                                    </span>

                                    <h2
                                        class="mt-3 font-bold text-lg line-clamp-2 text-gray-800 group-hover:text-green-700 transition-colors">
                                        {{ $item['title'] }}
                                    </h2>

                                    <p class="text-gray-600 mt-2 text-sm line-clamp-3">
                                        {{ $item['excerpt'] }}
                                    </p>

                                    <div class="mt-4 flex items-center text-green-700 font-semibold text-sm">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Tampilan Jika Data Kosong --}}
                    <div class="text-center py-20">
                        <div class="text-gray-400 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600">Berita tidak ditemukan</h3>
                        <p class="text-gray-500">Coba gunakan kata kunci lain.</p>
                        <a href="{{ url()->current() }}"
                            class="mt-4 inline-block text-green-600 font-medium hover:underline">Reset Pencarian</a>
                    </div>
                @endif

                {{-- AREA NAVIGASI & INFO (Flex Container) --}}
                <div
                    class="mt-12 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-green-100 pt-6">

                    {{-- INFO HALAMAN (Pojok Kiri Bawah) --}}
                    <div class="text-gray-600 font-medium text-sm order-2 md:order-1">
                        Menampilkan <span class="font-bold text-green-700">{{ $beritas->firstItem() ?? 0 }}</span>
                        sampai <span class="font-bold text-green-700">{{ $beritas->lastItem() ?? 0 }}</span>
                        dari total <span class="font-bold text-green-700">{{ $beritas->total() }}</span> berita
                    </div>

                    {{-- PAGINATION BUTTONS --}}
                    <div class="order-1 md:order-2 w-full md:w-auto">
                        @if ($beritas->hasPages())
                            <nav role="navigation" aria-label="Pagination Navigation"
                                class="flex justify-center md:justify-end">
                                <ul
                                    class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm border border-green-100">

                                    {{-- Tombol Previous --}}
                                    @if ($beritas->onFirstPage())
                                        <li>
                                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                                                &laquo;
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $beritas->previousPageUrl() }}"
                                                class="px-3 py-2 text-green-700 hover:bg-green-50 rounded-md transition font-medium">
                                                &laquo;
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Tombol Nomor Halaman --}}
                                    @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                                        <li>
                                            @if ($page == $beritas->currentPage())
                                                <span
                                                    class="px-3 py-2 bg-green-600 text-white rounded-md font-bold shadow-md">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $url }}"
                                                    class="px-3 py-2 text-gray-600 hover:bg-green-50 rounded-md transition font-medium">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach

                                    {{-- Tombol Next --}}
                                    @if ($beritas->hasMorePages())
                                        <li>
                                            <a href="{{ $beritas->nextPageUrl() }}"
                                                class="px-3 py-2 text-green-700 hover:bg-green-50 rounded-md transition font-medium">
                                                &raquo;
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">
                                                &raquo;
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
