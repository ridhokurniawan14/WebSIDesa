@extends('frontend.layouts.main')

@section('content')
    @php
        $berita = [
            'title' => 'Pemerintah Desa Laksanakan Musrenbang Tahun 2025',
            'date' => '12 Jan 2025',
            'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80',
            'content' => "
            <p>Musyawarah Perencanaan Pembangunan Desa (Musrenbang) tahun 2025 telah sukses dilaksanakan di balai desa.</p>
            <p>Kegiatan ini dihadiri oleh perangkat desa, tokoh masyarakat, ketua RT/RW, serta lembaga-lembaga desa.</p>

            <h3>Agenda Musrenbang</h3>
            <ul>
                <li>Pemaparan program pembangunan</li>
                <li>Diskusi prioritas pembangunan tahun berjalan</li>
                <li>Usulan kegiatan dari warga</li>
            </ul>

            <p>Musrenbang desa merupakan langkah awal dalam menentukan arah pembangunan desa yang lebih baik.</p>
        ",
        ];

        $latest = [
            [
                'title' => 'Penyaluran BLT Tahap Awal Berjalan Lancar',
                'date' => '8 Jan 2025',
                'thumbnail' =>
                    'https://img.sokoguru.id/backend/9683294141758620507/3-bansos-cair-juli-2025-pkh-bpnt-dan-blt-dana-desa-untuk-warga-kurang-mampu.webp',
                'slug' => 'penyaluran-blt-tahap-awal',
            ],
            [
                'title' => 'Gotong Royong Warga Dalam Pembenahan Jalan Desa',
                'date' => '2 Jan 2025',
                'thumbnail' =>
                    'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/115/2025/07/01/Untitled-8-1440749030.jpg',
                'slug' => 'gotong-royong-jalan-desa',
            ],
        ];
    @endphp

    <div class="content-offset">

        <section class="mt-10">
            <div class="max-w-7xl mx-auto px-4">

                {{-- Breadcrumb --}}
                <nav class="text-sm mb-6 text-gray-600">
                    <a href="/" class="hover:underline">Beranda</a> /
                    <a href="/berita" class="hover:underline">Berita</a> /
                    <span class="text-gray-800 font-semibold">{{ $berita['title'] }}</span>
                </nav>

                <div class="grid md:grid-cols-3 gap-10">

                    {{-- Konten Utama --}}
                    <div class="md:col-span-2">

                        <h1 class="text-3xl font-bold mb-3">{{ $berita['title'] }}</h1>

                        <div class="text-sm text-gray-500 mb-6">
                            Dipublikasikan pada
                            <span class="font-medium">{{ $berita['date'] }}</span>
                            oleh <span class="font-medium">Admin</span>
                        </div>

                        {{-- Gambar + Modal --}}
                        <img src="{{ $berita['thumbnail'] }}" class="rounded-xl w-full mb-8 cursor-pointer"
                            onclick="openImageModal('{{ $berita['thumbnail'] }}')">

                        {{-- Isi Artikel --}}
                        <article class="prose max-w-none prose-li:marker:text-green-600 prose-h3:mt-6 prose-h3:mb-2"
                            style="text-align: justify;">
                            {!! $berita['content'] !!}
                        </article>

                        {{-- Bagikan Ke Sosmed --}}
                        <div class="mt-10 text-center">
                            <h5 class="text-lg font-bold mb-4">📢 Bagikan Berita Ini</h5>

                            @php
                                $url = urlencode(url()->current());
                                $text = urlencode($berita['title']);
                            @endphp

                            <div class="flex justify-center flex-wrap gap-3">

                                <a target="_blank"
                                    href="https://api.whatsapp.com/send?text={{ $text }}%20{{ $url }}"
                                    class="social-btn bg-green-500 hover:bg-green-600">
                                    <i class="bi bi-whatsapp"></i>
                                </a>

                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                    class="social-btn bg-blue-600 hover:bg-blue-700">
                                    <i class="bi bi-facebook"></i>
                                </a>

                                <a target="_blank"
                                    href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $text }}"
                                    class="social-btn bg-black hover:bg-gray-800">
                                    <i class="bi bi-twitter-x"></i>
                                </a>

                                <a target="_blank" href="https://www.instagram.com/?url={{ $url }}"
                                    class="social-btn bg-pink-500 hover:bg-pink-600">
                                    <i class="bi bi-instagram"></i>
                                </a>

                                <a href="mailto:?subject={{ $text }}&body={{ $url }}"
                                    class="social-btn bg-red-500 hover:bg-red-600">
                                    <i class="bi bi-envelope"></i>
                                </a>

                                <button onclick="copyLink()"
                                    class="social-btn bg-gray-300 text-gray-800 hover:bg-gray-400 hover:cursor-pointer">
                                    <i class="bi bi-link-45deg"></i>
                                </button>

                            </div>

                            <div id="copyAlert" class="hidden mt-4 text-green-600 font-semibold">
                                ✅ Link disalin!
                            </div>
                        </div>

                        {{-- Navigasi Sebelumnya / Selanjutnya --}}
                        <div class="flex justify-between mt-12 border-t pt-6">

                            <a href="#"
                                class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold text-gray-700">
                                ← Berita Sebelumnya
                            </a>

                            <a href="#"
                                class="px-5 py-3 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-white">
                                Berita Selanjutnya →
                            </a>

                        </div>

                    </div>

                    {{-- Sidebar Berita Lain --}}
                    <div class="md:col-span-1">

                        <div class="bg-white shadow-md rounded-xl p-5">

                            <h3 class="text-xl font-bold  bg-green-800 text-white px-4 py-3 -mx-5 -mt-5 mb-5 rounded-t-xl">
                                Berita Terbaru
                            </h3>


                            <div class="space-y-5">

                                @foreach ($latest as $item)
                                    <a href="{{ url('/berita/' . $item['slug']) }}"
                                        class="flex gap-4 p-2 rounded-md border border-transparent hover:border-green-600 hover:bg-green-50 hover:shadow-md hover:-translate-y-1 transition duration-200 cursor-pointer">

                                        <div class="w-24 h-20 rounded overflow-hidden flex-shrink-0">
                                            <img src="{{ $item['thumbnail'] }}" class="w-full h-full object-cover">
                                        </div>

                                        <div>
                                            <h4 class="font-semibold text-sm line-clamp-2">{{ $item['title'] }}</h4>
                                            <p class="text-xs text-gray-500">{{ $item['date'] }}</p>
                                        </div>

                                    </a>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>
    </div>

    {{-- Modal Zoom Gambar --}}
    <div id="imageModal" onclick="closeImageModal()"
        class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 cursor-pointer">

        <img id="modalImage" onclick="event.stopPropagation()"
            class="max-w-[85%] max-h-[85%] rounded shadow-lg cursor-default">
    </div>



    {{-- Script --}}
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            document.getElementById('copyAlert').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('copyAlert').classList.add('hidden');
            }, 2000);
        }
    </script>

    {{-- Style Sosial Media Button --}}
    <style>
        .social-btn {
            width: 45px;
            height: 45px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 20px;
            transition: 0.2s;
        }
    </style>
@endsection
