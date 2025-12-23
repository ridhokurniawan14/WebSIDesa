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
    </style>
    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="content-offset">
        <section
            class="relative h-[220px] md:h-[300px] w-full flex items-center justify-center bg-cover bg-center header-offset"
            style="background-image: url('https://png.pngtree.com/background/20220720/original/pngtree-grassland-highway-at-dusk-picture-image_1689734.jpg');">

            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative text-center px-6 mt-6">
                <h1 class="text-white text-3xl md:text-5xl font-bold drop-shadow-lg animate-fadeIn">
                    Visi & Misi Desa
                </h1>

                <p class="text-white/90 text-xs md:text-base mt-2 max-w-xl mx-auto leading-relaxed animate-fadeIn"
                    style="animation-delay: 0.3s">
                    Membangun masa depan desa yang lebih cerah melalui visi yang terarah dan misi yang nyata untuk
                    kesejahteraan seluruh warga.
                </p>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 mt-16">
            @if ($data)
                <div data-aos="fade-right" data-aos-delay="100"
                    class="bg-white rounded-2xl shadow-lg p-10 mb-14 border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <h2 class="text-3xl font-bold text-green-700 mb-4 flex items-center gap-3">
                        <span class="w-2 h-10 bg-green-600 rounded-full"></span>
                        Visi Desa
                    </h2>
                    <p class="text-lg text-gray-700 leading-relaxed italic">
                        "{{ $data->visi }}"
                    </p>
                </div>

                <div data-aos="fade-left" data-aos-delay="100"
                    class="bg-white rounded-2xl shadow-lg p-10 border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center gap-3">
                        <span class="w-2 h-10 bg-green-600 rounded-full"></span>
                        Misi Desa
                    </h2>

                    <ul class="space-y-4 text-gray-700 text-lg">
                        @if (is_array($data->misi))
                            @foreach ($data->misi as $index => $misiItem)
                                <li class="flex gap-4">
                                    <div
                                        class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <p>{{ $misiItem }}</p>
                                </li>
                            @endforeach
                        @else
                            <p class="text-gray-500 italic">Data misi belum tersedia dalam format yang benar.</p>
                        @endif
                    </ul>
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-500 text-xl">Data Visi & Misi belum diisi oleh admin.</p>
                </div>
            @endif
        </section>

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
    </div>
@endsection
