@extends('frontend.layouts.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <style>
        /* CSS Khusus untuk Efek Aurora */
        .aurora-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -10;
            /* Pastikan di paling belakang */
            background-color: #f8fafc;
            /* Warna dasar putih tulang */
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            /* Efek blur yang kuat */
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        /* Bola 1: Hijau Desa */
        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background-color: #86efac;
            /* green-300 */
            animation-delay: 0s;
        }

        /* Bola 2: Biru Langit */
        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background-color: #bae6fd;
            /* sky-200 */
            animation-delay: -2s;
        }

        /* Bola 3: Kuning Matahari (Aksen) */
        .blob-3 {
            top: 40%;
            left: 40%;
            width: 400px;
            height: 400px;
            background-color: #fef08a;
            /* yellow-200 */
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

        /* Agar konten tetap terbaca jelas */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
    </style>
    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    <div class="content-offset">
        {{-- HERO --}}
        <section class="w-full h-[300px] bg-cover bg-center flex items-center justify-center relative"
            style="background-image: url('https://plus.unsplash.com/premium_photo-1661429002035-1a48a1f78cf6?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmVrZXJqYSUyMGJlcnNhbWF8ZW58MHx8MHx8fDA%3D');">

            <div class="absolute inset-0 bg-black/50"></div>

            <div data-aos="fade-up" data-aos-delay="100" class="text-center relative z-10 p-4">

                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-2 leading-tight">
                    SOTK
                </h1>

                <p class="text-lg md:text-xl text-gray-200 font-medium">
                    Struktur Organisasi dan Tata Kerja
                </p>

            </div>
        </section>


        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 mt-16">

            {{-- STRUKTUR ORGANISASI (DENGAN FITUR ZOOM) --}}
            <div data-aos="fade-in" class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Klik gambar untuk memperbesar struktur organisasi.</p>
            </div>

            <div data-aos="flip-up" class="flex justify-center mb-16">
                @php
                    $urlStruktur =
                        $perangkat && $perangkat->foto_struktur_organisasi
                            ? asset('storage/' . $perangkat->foto_struktur_organisasi)
                            : asset('images/Bagan-Struktur-Organisasi.png');
                @endphp

                {{-- Tambahkan class 'glightbox' untuk trigger zoom --}}
                <a href="{{ $urlStruktur }}" class="glightbox">
                    <img src="{{ $urlStruktur }}" alt="Struktur Organisasi Desa"
                        class="w-full max-w-4xl rounded-xl shadow-lg border hover:scale-[1.02] transition-transform duration-300 cursor-zoom-in">
                </a>
            </div>


            {{-- DAFTAR PERANGKAT DESA (DENGAN PERBAIKAN POSISI TENGAH) --}}
            <div data-aos="fade-in" class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">Daftar Perangkat Desa</h2>
                <p class="text-gray-600">Berikut adalah perangkat desa beserta foto, nama dan jabatannya.</p>
            </div>

            {{-- PERBAIKAN: Menggunakan Flexbox agar item ganjil tetap di tengah --}}
            <div class="flex flex-wrap justify-center gap-8">

                @if ($perangkat && is_array($perangkat->data_perangkat))
                    @foreach ($perangkat->data_perangkat as $item)
                        {{-- Lebar diatur agar tetap rapi (W-full pada HP, W-64/72 pada Desktop) --}}
                        <div data-aos="fade-up"
                            class="bg-white w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.33%-1.5rem)] lg:w-[calc(25%-1.5rem)] max-w-[280px] rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">

                            <div class="relative group overflow-hidden">
                                <img src="{{ asset('storage/' . $item['foto']) }}"
                                    class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110"
                                    alt="Foto {{ $item['nama'] }}"
                                    onerror="this.src='https://via.placeholder.com/300x400?text=No+Photo'">
                            </div>

                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $item['nama'] }}</h3>
                                <p class="text-green-600 font-semibold mt-1 text-sm">{{ $item['jabatan'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

    {{-- Script untuk inisialisasi Glightbox --}}
    <script type="text/javascript">
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
@endsection
