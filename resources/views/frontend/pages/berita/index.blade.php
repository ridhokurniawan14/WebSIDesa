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
    @php
        $beritas = [
            [
                'title' => 'Pemerintah Desa Laksanakan Musrenbang Tahun 2025',
                'date' => '12 Jan 2025',
                'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80',
                'excerpt' =>
                    'Musyawarah perencanaan pembangunan desa telah dilaksanakan dengan melibatkan seluruh unsur masyarakat...',
                'slug' => 'musrenbang-tahun-2025',
            ],
            [
                'title' => 'Penyaluran BLT Tahap Awal Berjalan Lancar',
                'date' => '8 Jan 2025',
                'thumbnail' =>
                    'https://img.sokoguru.id/backend/9683294141758620507/3-bansos-cair-juli-2025-pkh-bpnt-dan-blt-dana-desa-untuk-warga-kurang-mampu.webp',
                'excerpt' =>
                    'Pemerintah Desa menyalurkan Bantuan Langsung Tunai kepada warga yang memenuhi syarat penerima manfaat...',
                'slug' => 'penyaluran-blt-tahap-awal',
            ],
            [
                'title' => 'Gotong Royong Warga Dalam Pembenahan Jalan Desa',
                'date' => '2 Jan 2025',
                'thumbnail' =>
                    'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/115/2025/07/01/Untitled-8-1440749030.jpg',
                'excerpt' =>
                    'Warga desa melaksanakan kegiatan gotong royong dalam rangka memperbaiki akses jalan yang rusak...',
                'slug' => 'gotong-royong-jalan-desa',
            ],
            [
                'title' => 'Pemerintah Desa Laksanakan Musrenbang Tahun 2025',
                'date' => '12 Jan 2025',
                'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80',
                'excerpt' =>
                    'Musyawarah perencanaan pembangunan desa telah dilaksanakan dengan melibatkan seluruh unsur masyarakat...',
                'slug' => 'musrenbang-tahun-2025',
            ],
            [
                'title' => 'Penyaluran BLT Tahap Awal Berjalan Lancar',
                'date' => '8 Jan 2025',
                'thumbnail' =>
                    'https://img.sokoguru.id/backend/9683294141758620507/3-bansos-cair-juli-2025-pkh-bpnt-dan-blt-dana-desa-untuk-warga-kurang-mampu.webp',
                'excerpt' =>
                    'Pemerintah Desa menyalurkan Bantuan Langsung Tunai kepada warga yang memenuhi syarat penerima manfaat...',
                'slug' => 'penyaluran-blt-tahap-awal',
            ],
            [
                'title' => 'Gotong Royong Warga Dalam Pembenahan Jalan Desa',
                'date' => '2 Jan 2025',
                'thumbnail' =>
                    'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/115/2025/07/01/Untitled-8-1440749030.jpg',
                'excerpt' =>
                    'Warga desa melaksanakan kegiatan gotong royong dalam rangka memperbaiki akses jalan yang rusak...',
                'slug' => 'gotong-royong-jalan-desa',
            ],
        ];
    @endphp
    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    <div class="content-offset">

        {{-- Hero --}}
        <section class="w-full bg-green-700 text-white py-16 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1503264116251-35a269479413?q=80');">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-2">Berita Desa</h1>
                <p class="text-white/90">Informasi terbaru dari Pemerintah Desa</p>
            </div>
        </section>

        {{-- List Berita --}}
        <section class="mt-16">
            <div class="max-w-7xl mx-auto px-4">

                <div class="grid md:grid-cols-3 gap-10">

                    @foreach ($beritas as $item)
                        <a href="{{ url('/berita/' . $item['slug']) }}"
                            class="block bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                            <div class="h-52 w-full bg-cover bg-center"
                                style="background-image: url('{{ $item['thumbnail'] }}')"></div>

                            <div class="p-5">
                                <span class="text-xs text-green-700 font-semibold">
                                    {{ $item['date'] }}
                                </span>

                                <h2 class="mt-2 font-bold text-lg line-clamp-2">
                                    {{ $item['title'] }}
                                </h2>

                                <p class="text-gray-600 mt-2 text-sm line-clamp-3">
                                    {{ $item['excerpt'] }}
                                </p>

                                <button class="mt-4 text-green-700 font-semibold hover:underline cursor-pointer">
                                    Baca Selengkapnya →
                                </button>
                            </div>

                        </a>
                    @endforeach

                </div>

            </div>
        </section>
    </div>
@endsection
