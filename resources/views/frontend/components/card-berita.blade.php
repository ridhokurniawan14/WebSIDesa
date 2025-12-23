<section class="max-w-7xl mx-auto mt-16 px-6 sm:px-8">
    <h2 data-aos="fade-right" data-aos-delay="100"
        class="text-3xl font-extrabold text-gray-900 mb-3 border-b-2 border-green-600 pb-2">Berita Terbaru</h2>

    <p data-aos="fade-left" data-aos-delay="100" class="text-lg text-gray-600 mb-10">
        Kumpulan berita terhangat, terkini, dan terpercaya dari berbagai sektor.
        Jangan lewatkan perkembangan terbaru!
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- LOOPING DATA BERITA --}}
        @forelse($beritaTerbaru as $item)
            <div data-aos="flip-right" data-aos-delay="100"
                class="group relative bg-white shadow-xl hover:shadow-2xl transition-all duration-300 rounded-xl overflow-hidden transform hover:scale-[1.02] flex flex-col h-full">

                {{-- Bagian Gambar --}}
                <div class="relative h-48 overflow-hidden">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    @else
                        <img src="https://placehold.co/600x350/047857/ffffff?text={{ urlencode($item->title) }}"
                            alt="Default Image"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    @endif

                    {{-- Overlay tipis saat hover agar gambar sedikit gelap --}}
                    <div
                        class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    {{-- Metadata Tanggal --}}
                    <p class="text-xs text-gray-500 font-medium mb-1">
                        {{ $item->date ? $item->date->format('d F Y') : '-' }}
                    </p>

                    {{-- Judul Berita --}}
                    <h3
                        class="font-bold text-xl mb-2 text-gray-900 line-clamp-2 group-hover:text-green-700 transition-colors">
                        {{-- Link Utama (Menggunakan class "after:absolute after:inset-0" agar seluruh card bisa diklik) --}}
                        <a href="{{ route('berita.show', $item->slug) }}" class="after:absolute after:inset-0">
                            {{ $item->title }}
                        </a>
                    </h3>

                    {{-- Ringkasan/Excerpt --}}
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-grow">
                        {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 100) }}
                    </p>

                    {{-- Tombol Lihat Selengkapnya (Tanpa Underline) --}}
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div
                            class="inline-flex items-center text-sm font-bold text-green-600 group-hover:text-green-800 transition-colors">
                            Lihat Selengkapnya
                            <svg class="ml-1 w-4 h-4 transform group-hover:translate-x-2 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 text-lg">Belum ada berita yang diterbitkan saat ini.</p>
            </div>
        @endforelse

    </div>

    <div data-aos="flip-up" data-aos-delay="100" class="mt-12 text-center">
        <a href="{{ url('/berita') }}"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 transition duration-150 ease-in-out">
            Lihat Berita Lainnya
            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                </path>
            </svg>
        </a>
    </div>

</section>
