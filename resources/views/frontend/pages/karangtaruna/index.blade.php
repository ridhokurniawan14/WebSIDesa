@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">

        <!-- HERO -->
        <section class="bg-gradient-to-r from-green-700 to-green-600 text-white py-24">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">
                    {{ $karangtaruna['nama'] }}
                </h1>
                <p class="max-w-3xl mx-auto text-lg text-green-100">
                    {{ $karangtaruna['deskripsi'] }}
                </p>
            </div>
        </section>

        <!-- VISI MISI -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-10">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-2xl font-bold text-green-700 mb-4">Visi</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $karangtaruna['visi'] }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-2xl font-bold text-green-700 mb-4">Misi</h2>
                    <ul class="space-y-3 text-gray-700">
                        @foreach ($karangtaruna['misi'] as $misi)
                            <li class="flex gap-2">
                                <span class="text-green-600">✔</span>
                                <span>{{ $misi }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <!-- PROGRAM -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-green-700 mb-12">
                    Program Unggulan
                </h2>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($karangtaruna['program'] as $program)
                        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-8 text-center">
                            <div class="text-4xl mb-4">{{ $program['icon'] }}</div>
                            <h3 class="font-bold text-lg mb-2 text-gray-800">
                                {{ $program['judul'] }}
                            </h3>
                            <p class="text-gray-600 text-sm">
                                {{ $program['deskripsi'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- GALERI -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-green-700 mb-12">
                    Galeri Kegiatan
                </h2>

                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($karangtaruna['galeri'] as $foto)
                        <div class="group cursor-pointer">
                            <div class="overflow-hidden rounded-xl shadow">
                                <img src="{{ asset('images/karangtaruna/' . $foto['gambar']) }}" alt="{{ $foto['judul'] }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition">
                            </div>
                            <p class="text-center mt-3 text-sm text-gray-700 font-medium">
                                {{ $foto['judul'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- PENGURUS -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-green-700 mb-12">
                    Pengurus Karang Taruna
                </h2>

                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ($karangtaruna['pengurus'] as $p)
                        <div class="bg-white rounded-2xl shadow p-6 text-center">
                            <div
                                class="w-16 h-16 mx-auto rounded-full bg-green-600 text-white flex items-center justify-center text-xl font-bold mb-4">
                                {{ substr($p['nama'], 0, 1) }}
                            </div>
                            <h3 class="font-bold text-gray-800">{{ $p['nama'] }}</h3>
                            <p class="text-green-600 text-sm mt-1">{{ $p['jabatan'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- KONTAK -->
        <section class="py-16 bg-green-700 text-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-6">Kontak Karang Taruna</h2>

                <div class="flex flex-col md:flex-row justify-center gap-6 text-green-100">
                    <span>📞 {{ $karangtaruna['kontak']['telepon'] }}</span>
                    <span>✉️ {{ $karangtaruna['kontak']['email'] }}</span>
                    <span>📷 {{ $karangtaruna['kontak']['instagram'] }}</span>
                </div>
            </div>
        </section>

    </div>
@endsection
