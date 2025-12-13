@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">

        {{-- Header/Hero - Deep Navy Contrast (Geometric Focus) --}}
        <header class="bg-gray-800 text-white py-20 border-b-8 border-cyan-400">
            <div class="max-w-6xl mx-auto px-4 text-center">
                <h1 class="text-6xl font-black tracking-tight mb-3">{{ $nama }}</h1>
                <p class="text-xl font-light text-gray-300 max-w-4xl mx-auto">{{ $slogan }}</p>

                {{-- Horizontal line as a subtle divider --}}
                <div class="h-0.5 bg-cyan-400 w-1/4 mx-auto mt-6"></div>
            </div>
        </header>

        {{-- Section 1: Tentang Kami - Two Column Layout for Visual Interest --}}
        <section id="tentang" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-12 gap-10 items-start">

                <div class="lg:col-span-4">
                    <h2 class="text-4xl font-extrabold text-gray-900 border-l-4 border-cyan-500 pl-4">Tentang<br>BUMDes Kami
                    </h2>
                    <p class="text-gray-500 mt-4 text-sm uppercase tracking-wider">Lembaga Usaha Desa</p>
                </div>

                <div class="lg:col-span-8">
                    <p class="text-xl text-gray-700 leading-relaxed italic">
                        "{{ $tentang }}"
                    </p>
                </div>
            </div>
        </section>

        {{-- Section 2: Visi & Misi - Strong Border Divider (The Elegant Split) --}}
        <section id="visi-misi" class="py-20 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12">

                {{-- Visi --}}
                <div class="p-6">
                    <span class="text-2xl font-black text-cyan-600 mb-2 block">Visi</span>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-2">Filosofi Inti</h3>
                    <p class="text-lg text-gray-700 leading-relaxed">{{ $visi }}</p>
                </div>

                {{-- Misi --}}
                <div class="p-6 border-l-4 border-gray-300">
                    <span class="text-2xl font-black text-cyan-600 mb-2 block">Misi</span>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-2">Langkah Strategis</h3>
                    <ul class="space-y-4 text-gray-700 list-none pl-0">
                        @foreach ($misi as $index => $item)
                            <li class="flex items-start">
                                <span class="mr-3 font-extrabold text-cyan-500 text-lg">
                                    {{ $index + 1 }}.
                                </span>
                                <span class="text-lg">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        {{-- Section 3: Unit Usaha - Clean Grid Cards --}}
        <section id="unit-usaha" class="py-24 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4 text-center">Unit Bisnis</h2>
                <p class="text-center text-gray-600 mb-12">Layanan yang kami sediakan untuk kemajuan desa.</p>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        // Ikon yang konsisten dan clean
                        $icons_biz = ['🏦', '🛍️', '⚙️', '📈'];
                    @endphp

                    @foreach ($unit_usaha as $index => $usaha)
                        <div
                            class="group p-6 bg-white rounded-lg border-2 border-gray-100 hover:border-cyan-500 transition duration-300 shadow-md">
                            <div class="text-3xl mb-3 text-cyan-600">
                                {{ $icons_biz[$index % count($icons_biz)] }}
                            </div>
                            <h4 class="font-black text-lg text-gray-900 mb-1 uppercase tracking-wider">{{ $usaha['nama'] }}
                            </h4>
                            <p class="text-gray-600 text-sm">{{ $usaha['deskripsi'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Section 4: Pengurus & Kontak - Final Anchor Block --}}
        <section id="pengurus-kontak" class="py-20 bg-gray-800 text-white">
            <div class="max-w-6xl mx-auto px-4 grid lg:grid-cols-2 gap-16">

                {{-- Struktur Pengurus --}}
                <div class="border-b-4 border-cyan-400 pb-4">
                    <h3 class="text-2xl font-black mb-6 text-cyan-400">Manajemen Inti</h3>

                    <dl class="space-y-4">
                        @foreach ($pengurus as $jabatan => $nama)
                            <div class="flex justify-between items-center pb-2 border-b border-gray-600 last:border-b-0">
                                <dt class="font-semibold text-gray-300 capitalize">{{ $jabatan }}</dt>
                                <dd class="text-white font-medium text-lg">{{ $nama }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                {{-- Kontak Informasi --}}
                <div class="border-b-4 border-cyan-400 pb-4">
                    <h3 class="text-2xl font-black mb-6 text-cyan-400">Kantor Pusat</h3>

                    <div class="space-y-4 text-gray-300">
                        <p class="flex items-start space-x-4">
                            <span class="text-cyan-400 mt-1">📍</span>
                            <span><strong>Alamat:</strong> {{ $kontak['alamat'] }}</span>
                        </p>
                        <p class="flex items-start space-x-4">
                            <span class="text-cyan-400 mt-1">📞</span>
                            <span><strong>Telepon:</strong> <a href="tel:{{ $kontak['telepon'] }}"
                                    class="text-cyan-400 hover:text-white transition">{{ $kontak['telepon'] }}</a></span>
                        </p>
                        <p class="flex items-start space-x-4">
                            <span class="text-cyan-400 mt-1">📧</span>
                            <span><strong>Email:</strong> <a href="mailto:{{ $kontak['email'] }}"
                                    class="text-cyan-400 hover:text-white transition">{{ $kontak['email'] }}</a></span>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
