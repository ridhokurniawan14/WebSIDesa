<footer data-aos="fade-up" class="relative bg-gray-900 text-gray-300 mt-20 pt-16 pb-6">
    <!-- Catatan: Class 'overflow-hidden' saya hapus dari tag footer utama agar tombol di atas tidak terpotong -->

    <!-- Animated Gradient Background (Overflow hidden dipindah ke sini) -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-green-400 via-gray-900 to-green-900 opacity-40 animate-gradientMove overflow-hidden">
    </div>

    <!-- Grid Texture Overlay -->
    <div class="absolute inset-0 bg-repeat opacity-10 pointer-events-none"
        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%2210%22 viewBox=%220 0 10 10%22><rect width=%2210%22 height=%2210%22 fill=%22none%22 /><rect x=%220%22 y=%220%22 width=%221%22 height=%221%22 fill=%22%232d3748%22 /></svg>');">
    </div>

    <!-- TOMBOL SCROLL TO TOP (BARU) -->
    <!-- Posisi absolute, ditarik ke atas (-top-6) dan di kanan (right-6/8/10 sesuai selera) -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="absolute cursor-pointer -top-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-green-500/50 focus:outline-none focus:ring-4 focus:ring-green-300"
        aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up text-xl font-bold"></i>
    </button>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div data-aos="fade-in" data-aos-delay="100" class="grid grid-cols-1 md:grid-cols-3 gap-12">

            <!-- BRAND -->
            <div>
                <h3 class="text-2xl font-extrabold text-white mb-4 border-b border-gray-700 pb-2 tracking-wider">
                    {{ strtoupper($aplikasi->nama_desa) }}
                </h3>

                <p class="text-sm leading-relaxed mb-6">
                    {{ $aplikasi->footer }}
                </p>

                <h4 class="text-lg font-semibold text-white mb-3">📲 Sosial Media</h4>
                <div class="flex space-x-5">
                    <a href="{{ $aplikasi->facebook }}" target="_blank"
                        class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-facebook text-2xl"></i></a>
                    <a href="{{ $aplikasi->instagram }}" target="_blank"
                        class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-instagram text-2xl"></i></a>
                    <a href="{{ $aplikasi->youtube }}" target="_blank"
                        class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-youtube text-2xl"></i></a>
                    <a href="http://wa.me/+{{ $aplikasi->wa_cs }}" target="_blank"
                        class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-whatsapp text-2xl"></i></a>
                </div>
            </div>

            <!-- ALAMAT -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">📍 Alamat Kantor</h3>
                <address class="text-sm not-italic space-y-2">
                    <p>
                        <strong>{{ $aplikasi->nama_kantor }}</strong><br>
                        {{ $aplikasi->alamat }}<br>
                    </p>
                    <p>
                        <i class="bi bi-telephone-fill mr-2 text-green-500"></i>
                        Telp: <a target="_blank" href="tel:{{ $aplikasi->telepon }}"
                            class="hover:text-white">{{ $aplikasi->telepon }}</a>
                    </p>
                    <p>
                        <i class="bi bi-envelope-fill mr-2 text-green-500"></i>
                        Email: <a href="mailto:{{ $aplikasi->email }}"
                            class="hover:text-white">{{ $aplikasi->email }}</a>
                    </p>
                </address>
            </div>

            <!-- MAP -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">🗺️ Peta Lokasi</h3>
                @if (!empty($aplikasi->map))
                    @php
                        preg_match('/src="([^"]+)"/', $aplikasi->map, $match);
                        $mapSrc = $match[1] ?? null;
                    @endphp

                    @if ($mapSrc)
                        <div class="rounded-lg overflow-hidden shadow-2xl">
                            <iframe src="{{ $mapSrc }}" class="w-full h-[250px] border-0" allowfullscreen
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    @endif
                @endif

                <p class="mt-2 text-xs text-white">Klik peta untuk menuju Google Maps.</p>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div data-aos="fade" data-aos-delay="100" data-aos-offset="0"
            class="text-center border-t border-gray-800 mt-12 pt-6 text-sm">
            <p class="mb-2">
                © {{ date('Y') }} {{ $aplikasi->nama_desa }}. Semua Hak Dilindungi.
            </p>
            <p class="text-xs text-gray-500 hover:text-green-500 transition duration-300">
                Dibuat dengan <i class="bi bi-heart-fill text-red-500 mx-1"></i> oleh
                <a href="#" class="font-medium hover:text-white">
                    Tim {{ $aplikasi->nama_desa }}
                </a>
            </p>
        </div>
    </div>
</footer>
