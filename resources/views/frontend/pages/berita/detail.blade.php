@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">
        <section class="mt-20">
            <div class="max-w-7xl mx-auto px-4">

                {{-- Breadcrumb --}}
                <nav data-aos="fade-right" class="text-sm mb-6 mt-10 text-gray-600">
                    <a href="/" class="hover:underline">Beranda</a> /
                    <a href="/berita" class="hover:underline">Berita</a> /
                    <span class="text-gray-800 font-semibold">{{ $berita->title }}</span>
                </nav>

                <div class="grid md:grid-cols-3 gap-10">

                    {{-- Konten Utama --}}
                    <div class="md:col-span-2">

                        <h1 data-aos="fade-up" class="text-3xl font-bold mb-3">{{ $berita->title }}</h1>

                        <div data-aos="fade-up" class="text-sm text-gray-500 mb-6">
                            Dipublikasikan pada
                            <span class="font-medium">
                                {{ $berita->date ? $berita->date->translatedFormat('d F Y') : '-' }}
                            </span>
                            oleh <span class="font-medium">Admin</span>
                            &nbsp; | &nbsp; <i class="bi bi-eye"></i> {{ $berita->views }}x Dilihat
                        </div>

                        {{-- Logika Gambar Tampilan (Tetap diperlukan untuk tag <img>) --}}
                        @php
                            $imgSrc = asset('images/default-news.jpg');
                            if ($berita->thumbnail) {
                                if (Str::startsWith($berita->thumbnail, ['http://', 'https://'])) {
                                    $imgSrc = $berita->thumbnail;
                                } else {
                                    $imgSrc = asset('storage/' . $berita->thumbnail);
                                }
                            }
                        @endphp

                        <img data-aos="fade-up" src="{{ $imgSrc }}"
                            class="rounded-xl w-full mb-8 cursor-pointer object-cover max-h-[500px]"
                            onclick="openImageModal('{{ $imgSrc }}')" alt="{{ $berita->title }}"
                            onerror="this.src='https://placehold.co/800x400?text=No+Image'">

                        {{-- Isi Artikel --}}
                        {{-- 
                             UPDATE: Menambahkan 'prose-strong:font-bold' dan 'prose-strong:text-black' 
                             agar text bold dari database muncul dengan benar.
                        --}}
                        <article data-aos="fade-up"
                            class="prose max-w-none prose-li:marker:text-green-600 prose-h3:mt-6 prose-h3:mb-2 prose-a:text-green-600 prose-strong:font-bold prose-strong:text-black"
                            style="text-align: justify;">

                            @if (!empty($berita->content))
                                {!! $berita->content !!}
                            @else
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800">
                                    <p class="font-bold">⚠️ Konten belum tersedia.</p>
                                </div>
                            @endif

                        </article>

                        {{-- Bagikan Ke Sosmed --}}
                        <div data-aos="flip-up" class="mt-10 text-center">
                            <h5 class="text-lg font-bold mb-4">📢 Bagikan Berita Ini</h5>

                            @php
                                $url = urlencode(url()->current());
                                $text = urlencode($berita->title);
                            @endphp

                            <div class="flex justify-center flex-wrap gap-3">
                                <a target="_blank"
                                    href="https://api.whatsapp.com/send?text={{ $text }}%20{{ $url }}"
                                    class="social-btn bg-green-500 hover:bg-green-600" title="Share ke WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                    class="social-btn bg-blue-600 hover:bg-blue-700" title="Share ke Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                {{-- Tombol Copy Link --}}
                                <button type="button" onclick="copyLink()"
                                    class="social-btn bg-gray-300 text-gray-800 hover:bg-gray-400 hover:cursor-pointer relative group"
                                    title="Salin Link">
                                    <i class="bi bi-link-45deg"></i>
                                </button>
                            </div>

                            {{-- Notifikasi Copy Sederhana --}}
                            <div id="copySuccess" class="hidden mt-3 transition-all duration-300">
                                <span
                                    class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold shadow-sm border border-green-200 flex items-center justify-center gap-2 inline-flex">
                                    <i class="bi bi-check-circle-fill"></i> Link berhasil disalin!
                                </span>
                            </div>
                        </div>

                        {{-- Navigasi Berita --}}
                        <div class="flex flex-col sm:flex-row justify-between items-center mt-12 border-t pt-8 gap-4">
                            {{-- Tombol Kembali --}}
                            <a href="/berita"
                                class="w-full sm:w-auto px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-lg font-semibold text-gray-700 transition flex items-center justify-center gap-2 group">
                                <i class="bi bi-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                                Kembali ke Berita
                            </a>

                            {{-- Tombol Berita Selanjutnya --}}
                            @if ($latest->count() > 0)
                                <a href="{{ url('/berita/' . $latest->first()->slug) }}"
                                    class="w-full sm:w-auto px-5 py-3 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-white transition flex items-center justify-center gap-2 group text-right">
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs font-normal opacity-90">Berita Selanjutnya</span>
                                        <span
                                            class="text-sm truncate max-w-[150px] sm:max-w-[200px]">{{ $latest->first()->title }}</span>
                                    </div>
                                    <i class="bi bi-arrow-right text-xl group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @endif
                        </div>

                    </div>

                    {{-- Sidebar Berita Lain --}}
                    <div class="md:col-span-1">
                        <div data-aos="fade-left" class="bg-white shadow-md rounded-xl p-5 sticky top-24">
                            <h3 class="text-xl font-bold bg-green-800 text-white px-4 py-3 -mx-5 -mt-5 mb-5 rounded-t-xl">
                                Berita Terbaru
                            </h3>
                            <div class="space-y-5">
                                @forelse ($latest as $item)
                                    @php
                                        $sideImg = asset('images/default-thumb.jpg');
                                        if ($item->thumbnail) {
                                            $sideImg = Str::startsWith($item->thumbnail, ['http', 'https'])
                                                ? $item->thumbnail
                                                : asset('storage/' . $item->thumbnail);
                                        }
                                    @endphp

                                    <a href="{{ url('/berita/' . $item->slug) }}"
                                        class="flex gap-4 p-2 rounded-md border border-transparent hover:border-green-600 hover:bg-green-50 hover:shadow-md hover:-translate-y-1 transition duration-200 cursor-pointer">

                                        <div class="w-24 h-20 rounded overflow-hidden flex-shrink-0 bg-gray-200">
                                            <img src="{{ $sideImg }}" class="w-full h-full object-cover"
                                                onerror="this.src='https://placehold.co/100x100?text=News'">
                                        </div>

                                        <div>
                                            <h4 class="font-semibold text-sm line-clamp-2 text-gray-800">
                                                {{ $item->title }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $item->date ? $item->date->translatedFormat('d M Y') : '-' }}
                                            </p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-center text-gray-500 text-sm">Belum ada berita lain.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    {{-- Modal Zoom Gambar --}}
    <div id="imageModal" onclick="closeImageModal()"
        class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 cursor-pointer p-4">
        <img id="modalImage" onclick="event.stopPropagation()"
            class="max-w-full max-h-full rounded shadow-lg cursor-default object-contain">
    </div>

    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function copyLink() {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            var notif = document.getElementById('copySuccess');
            notif.classList.remove('hidden');
            setTimeout(function() {
                notif.classList.add('hidden');
            }, 2000);
        }
    </script>

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
