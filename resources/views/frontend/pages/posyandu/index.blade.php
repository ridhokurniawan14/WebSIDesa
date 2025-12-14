@extends('frontend.layouts.main')

@section('content')
    <div
        class="fixed inset-0 -z-10 h-full w-full bg-green-50/50 bg-[linear-gradient(to_right,#e6f5e6_1px,transparent_1px),linear-gradient(to_bottom,#e6f5e6_1px,transparent_1px)] bg-[size:4rem_4rem]">
    </div>

    <div class="content-offset">

        <section data-aos="fade-down"
            class="relative bg-gradient-to-br from-green-700 to-emerald-600 text-white py-20 rounded-b-[3rem] shadow-lg mb-12 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/leaves.png')]">
            </div>
            <div class="absolute bottom-0 right-0 opacity-20 transform translate-x-1/4 translate-y-1/4">
                <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#A7F3D0"
                        d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,80.8,-45.8C89.9,-32.4,95,-16.2,93.5,-0.9C92,14.4,83.8,28.8,74.2,41.5C64.5,54.2,53.4,65.2,40.4,73.6C27.4,82,12.5,87.8,-2.3,91.8C-17.1,95.8,-34.2,98.1,-49.4,93.1C-64.6,88.1,-77.9,75.8,-86.8,61.1C-95.7,46.3,-100.1,29.1,-99.8,12.3C-99.6,-4.5,-94.6,-20.8,-87.1,-35.9C-79.7,-51,-69.8,-64.8,-56.6,-72.6C-43.5,-80.4,-27.1,-82.2,-12.1,-79.8C3,-77.3,18,-70.6,30.6,-83.6C43.2,-96.6,53.4,-129.3,44.7,-76.4Z"
                        transform="translate(100 100)" />
                </svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
                <span
                    class="inline-block py-1 px-4 rounded-full bg-white/20 text-sm font-medium mb-6 backdrop-blur-sm border border-white/30">
                    Kesehatan Ibu & Anak
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight leading-tight">
                    Pos Pelayanan Terpadu <br> <span class="text-green-200">(POSYANDU)</span>
                </h1>
                <p class="text-green-50 text-lg md:text-xl max-w-2xl mx-auto font-light">
                    Wujudkan generasi sehat dan cerdas dimulai dari pelayanan kesehatan dasar yang berkualitas di desa kita.
                </p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 -mt-16 relative z-20 space-y-12">

            <div data-aos="fade-up" class="bg-white p-8 shadow-xl rounded-2xl border-t-4 border-green-600">
                <div class="flex flex-col md:flex-row items-start gap-8">
                    <div class="md:flex-1">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600">
                                🏥
                            </span>
                            Apa itu Posyandu?
                        </h2>
                        <div
                            class="prose prose-green prose-lg text-gray-600 leading-relaxed text-justify max-w-none font-medium">
                            {!! $posyandu['deskripsi'] !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-12 gap-8">
                <div data-aos="slide-right" class="md:col-span-5 space-y-8">
                    <div class="bg-white p-6 shadow-md rounded-2xl border border-green-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="text-green-600">🎯</span> Tujuan Utama
                        </h2>
                        <ul class="space-y-3">
                            @foreach ($posyandu['tujuan'] as $item)
                                <li class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-700 font-medium">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-white p-6 shadow-md rounded-2xl border border-green-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="text-green-600">👥</span> Sasaran Layanan
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($posyandu['sasaran'] as $item)
                                <span
                                    class="px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-semibold border border-green-200">
                                    {{ $item }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div data-aos="slide-left" class="md:col-span-7 bg-green-50 p-8 rounded-3xl border-2 border-green-200/70">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Layanan Kami</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach ($posyandu['layanan'] as $index => $item)
                            <div
                                class="bg-white p-4 rounded-xl shadow-sm border border-green-100 flex items-center gap-4 hover:shadow-md transition">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl flex-shrink-0">
                                    @if ($loop->iteration % 3 == 1)
                                        👶
                                    @elseif($loop->iteration % 3 == 2)
                                        ⚖️
                                    @else
                                        💉
                                    @endif
                                </div>
                                <p class="text-gray-700 font-medium">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="mt-8 bg-green-600 text-white p-6 rounded-2xl text-center shadow-lg relative overflow-hidden">
                        <div
                            class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]">
                        </div>
                        <h3 class="font-bold text-lg mb-2 relative z-10">📅 Jadwal Pelayanan Rutin</h3>
                        <p class="text-xl font-extrabold relative z-10 tracking-wide">
                            {{ $posyandu['jadwal'] }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="mb-12">
                <h2 data-aos="fade" class="text-3xl font-bold text-center text-gray-800 mb-10">Struktur Organisasi</h2>

                <div data-aos="fade-up" class="flex justify-center mb-10">
                    <div class="p-3 bg-white rounded-2xl shadow-xl border-2 border-green-100 cursor-pointer group relative hover:border-green-400 transition"
                        id="strukturImageBtn">
                        <img src="https://pasipinang.gampong.id/media/2023.08/struktur_posyandu1.jpg"
                            class="rounded-xl max-w-full h-auto md:max-h-[500px] object-contain" alt="Struktur Posyandu">
                        <div
                            class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white drop-shadow-lg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                        </div>
                        <p class="text-center text-sm text-gray-500 mt-2 font-medium group-hover:text-green-600">(Klik
                            gambar untuk memperbesar)</p>
                    </div>
                </div>

                <div data-aos="flip-down" class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        @php
                            $roles = [
                                ['label' => 'Ketua', 'val' => $posyandu['struktur']['ketua'], 'icon' => '👤'],
                                ['label' => 'Sekretaris', 'val' => $posyandu['struktur']['sekretaris'], 'icon' => '📝'],
                                ['label' => 'Bendahara', 'val' => $posyandu['struktur']['bendahara'], 'icon' => '💰'],
                            ];
                        @endphp

                        @foreach ($roles as $role)
                            <div class="flex items-center gap-4 p-4 rounded-2xl border border-green-100 bg-green-50/50">
                                <div class="w-12 h-12 flex items-center justify-center bg-green-200 rounded-full text-xl">
                                    {{ $role['icon'] }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-wider text-green-700 mb-1">
                                        {{ $role['label'] }}</div>
                                    <div class="text-lg font-bold text-gray-800">{{ $role['val'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-8">
                        <h3 class="font-bold text-lg text-gray-800 mb-4 text-center flex items-center justify-center gap-2">
                            ✨ Tim Kader Posyandu ✨
                        </h3>
                        <div class="flex flex-wrap justify-center gap-3">
                            @foreach ($posyandu['struktur']['kader'] as $item)
                                <div
                                    class="px-4 py-2 bg-white rounded-full text-center text-gray-700 text-sm font-medium shadow-sm border border-gray-200">
                                    {{ $item }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-start">
                <div data-aos="slide-right"
                    class="bg-white rounded-2xl shadow-md border-t-4 border-green-500 overflow-hidden h-full">
                    <div class="p-6 bg-green-50 border-b border-green-100">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                            <span>📌</span> Program Kerja
                        </h2>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-0 divide-y divide-gray-100">
                            @foreach ($posyandu['program'] as $item)
                                <li class="py-4 flex items-start gap-3 group">
                                    <span
                                        class="flex-shrink-0 w-3 h-3 rounded-full bg-green-400 mt-2 group-hover:bg-green-600 transition"></span>
                                    <p class="text-gray-700 font-medium group-hover:text-green-700 transition">
                                        {{ $item }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div data-aos="slide-left"
                    class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-2xl shadow-md overflow-hidden text-white h-full">
                    <div class="p-6 border-b border-green-500/30 bg-black/10">
                        <h2 class="text-2xl font-bold flex items-center gap-3">
                            <span>📞</span> Hubungi Pengurus
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach ($posyandu['kontak'] as $item)
                            @php
                                $waNumber = preg_replace('/[^0-9]/', '', $item['telepon']);
                                if (substr($waNumber, 0, 1) == '0') {
                                    $waNumber = '62' . substr($waNumber, 1);
                                }
                            @endphp

                            <div
                                class="flex items-center gap-4 p-4 rounded-xl bg-white/10 border border-white/20 hover:bg-white/20 transition">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-white rounded-full flex items-center justify-center text-green-600 text-2xl">
                                    📱
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-bold text-lg leading-tight">{{ $item['nama'] }}</h3>
                                    <p class="text-green-100 text-sm mb-2">{{ $item['jabatan'] }}</p>
                                </div>
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                    class="flex-shrink-0 px-4 py-2 bg-white text-green-700 rounded-lg font-bold text-sm hover:bg-green-50 transition shadow-sm flex items-center gap-2">
                                    Chat WA
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Perbaikan: Ditambahkan class 'flex' agar items-center berfungsi --}}
    <div id="imageModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4 transition-all duration-300 opacity-0">

        <div class="relative w-auto h-auto max-w-6xl max-h-[90vh] flex justify-center items-center rounded-2xl shadow-2xl scale-95 transition-transform duration-300"
            id="modalContent">

            <button id="closeModalBtn"
                class="absolute -top-12 right-0 md:-right-12 cursor-pointer text-white hover:text-green-400 transition z-50 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 drop-shadow-lg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <img src="https://pasipinang.gampong.id/media/2023.08/struktur_posyandu1.jpg"
                class="w-auto h-auto max-h-[90vh] max-w-full object-contain rounded-xl shadow-2xl border-4 border-white/10"
                alt="Struktur Posyandu Full">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalContent = document.getElementById('modalContent');
            const triggerBtn = document.getElementById('strukturImageBtn');
            const closeBtn = document.getElementById('closeModalBtn');

            function openModal() {
                // Hapus hidden agar display menjadi 'flex' (karena ada class flex di HTML)
                modal.classList.remove('hidden');

                // Timeout kecil biar animasi CSS transisi jalan
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 10);
                document.body.style.overflow = 'hidden'; // Stop scroll body
            }

            function closeModal() {
                modal.classList.add('opacity-0');
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');

                // Tunggu durasi transisi (300ms) baru sembunyikan elemen
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Balikin scroll body
                }, 300);
            }

            if (triggerBtn) triggerBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);

            // Tutup modal kalo klik di area gelap (backdrop)
            if (modal) {
                modal.addEventListener('click', function(e) {
                    // Pastikan yang diklik adalah backdrop (modal), bukan gambarnya
                    if (e.target === modal || e.target.id === 'modalContent') {
                        closeModal();
                    }
                });
            }

            // Tutup pakai tombol ESC keyboard
            document.addEventListener('keydown', function(e) {
                if (e.key === "Escape" && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
