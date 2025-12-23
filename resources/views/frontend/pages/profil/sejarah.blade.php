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

        .content-offset {
            padding-top: 80px;
        }

        /* Tambahan agar tidak tertutup navbar */
    </style>
    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="content-offset">
        <section class="relative h-[320px] w-full bg-cover bg-center overflow-hidden"
            style="background-image: url('https://kemenkopmk.go.id/sites/default/files/articles/2020-08/petani.jpg');">
            <div class="absolute inset-0 bg-black/40"></div>
            <div data-aos="fade-right" class="relative z-10 max-w-5xl mx-auto px-4 h-full flex items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-wide">Sejarah Desa</h1>
                    <p class="text-gray-200 text-lg max-w-xl">Mengenal perjalanan panjang Desa dari masa ke masa.</p>
                </div>
            </div>
        </section>

        <section class="max-w-5xl mx-auto px-4 mt-16 mb-24">
            @if ($sejarah)
                <div class="grid md:grid-cols-2 gap-10 items-center">
                    {{-- FOTO DARI DB --}}
                    <div data-aos="flip-right" class="relative">
                        <img src="{{ asset('storage/' . $sejarah->foto) }}"
                            class="rounded-xl shadow-lg w-full object-cover h-[400px]" alt="Foto Sejarah">
                        <div
                            class="absolute -bottom-5 -right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm">
                            Dokumentasi
                        </div>
                    </div>

                    {{-- TEXT SEJARAH DARI DB --}}
                    <div data-aos="fade-left">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Asal Usul Desa</h2>
                        <div class="text-gray-600 leading-relaxed text-justify space-y-4">
                            {!! nl2br(e($sejarah->asal_usul)) !!}
                        </div>
                    </div>
                </div>

                <div class="mt-20">
                    <h2 data-aos="fade-in" class="text-3xl font-bold text-gray-800 mb-10 text-center">
                        Timeline Perkembangan Desa
                    </h2>

                    <div class="relative border-l-4 border-green-600 ml-4">
                        @if (!empty($sejarah->timeline))
                            @foreach ($sejarah->timeline as $index => $item)
                                <div class="mb-10 ml-8 relative">
                                    {{-- Titik Hijau di Garis --}}
                                    <div
                                        class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full border-4 border-white shadow-sm">
                                    </div>

                                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                        {{-- Di sini kita hilangkan tanda hubung di depan --}}
                                        <h3 class="text-xl font-semibold text-gray-800">
                                            {{ $item['tahun'] ?? '' }} <span class="mx-1 text-green-600">–</span>
                                            {{ $item['judul'] ?? '' }}
                                        </h3>

                                        <p class="text-gray-600 mt-2">
                                            {{ $item['ket'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-500">Data sejarah belum tersedia.</p>
                </div>
            @endif
        </section>
    </div>
    {{-- Animasi simple --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.9s ease-out forwards;
        }
    </style>
@endsection
