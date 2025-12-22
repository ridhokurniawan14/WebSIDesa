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
        {{-- HERO --}}
        <section class="w-full h-[300px] bg-cover bg-center flex items-center justify-center relative"
            style="background-image: url('https://desa-ciasih.kuningankab.go.id/sites/des1806/files/photo-galeri/IMG_9940k%2010R.jpg');">

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

            {{-- STRUKTUR ORGANISASI --}}
            <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berikut adalah gambar struktur organisasi pemerintahan desa.
                </p>
            </div>

            <div data-aos="flip-up" data-aos-delay="500" class="flex justify-center mb-16">
                <img src="{{ asset('images/Bagan-Struktur-Organisasi.png') }}" alt="Struktur Organisasi Desa"
                    class="w-full max-w-4xl rounded-xl shadow-lg border">
            </div>


            {{-- DAFTAR PERANGKAT DESA --}}
            <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">Daftar Perangkat Desa</h2>
                <p class="text-gray-600">
                    Berikut adalah perangkat desa beserta foto, nama dan jabatannya.
                </p>
            </div>

            {{-- GRID PEGAWAI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                {{-- ITEM PEGAWAI --}}
                @php
                    $staff = [
                        [
                            'nama' => 'Supriyanto',
                            'jabatan' => 'Kepala Desa',
                            'foto' => 'https://upload.wikimedia.org/wikipedia/commons/d/d4/Kim_Jong-Un_Photorealistic-Sketch.jpg',
                        ],
                        [
                            'nama' => 'Nama Pegawai 1',
                            'jabatan' => 'Sekretaris Desa',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+1', // Diubah sedikit
                        ],
                        [
                            'nama' => 'Nama Pegawai 2',
                            'jabatan' => 'Kaur Umum',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+2', // Diubah sedikit
                        ],
                        [
                            'nama' => 'Nama Pegawai 3',
                            'jabatan' => 'Kasi Pemerintahan',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+3', // Diubah sedikit
                        ],
                        // --- TAMBAHAN 4 ITEM BARU UNTUK TOTAL 8 ---
                        [
                            'nama' => 'Nama Pegawai 4',
                            'jabatan' => 'Kaur Keuangan',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+4',
                        ],
                        [
                            'nama' => 'Nama Pegawai 5',
                            'jabatan' => 'Kasi Kesejahteraan',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+5',
                        ],
                        [
                            'nama' => 'Nama Pegawai 6',
                            'jabatan' => 'Kasi Pelayanan',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+6',
                        ],
                        [
                            'nama' => 'Nama Pegawai 7',
                            'jabatan' => 'Staf Pelaksana',
                            'foto' => 'https://via.placeholder.com/300x350?text=Pegawai+7',
                        ],
                    ];
                @endphp

                @foreach ($staff as $item)
                    <div data-aos="fade-right" data-aos-delay="100"
                        class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                        <img src="{{ $item['foto'] }}" class="w-full h-60 object-cover" alt="Foto {{ $item['nama'] }}">

                        <div class="p-5 text-center">
                            <h3 class="text-xl font-bold">{{ $item['nama'] }}</h3>
                            <p class="text-green-600 font-semibold mt-1">{{ $item['jabatan'] }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
