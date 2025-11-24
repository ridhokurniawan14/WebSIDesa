@extends('frontend.layouts.main')

@section('content')
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
                            'nama' => 'Ridho Ganteng',
                            'jabatan' => 'Kepala Desa',
                            'foto' => 'https://ridhokurniawan.my.id/img/rk3.webp',
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
