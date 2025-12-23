@extends('frontend.layouts.main')

@section('content')
    <!-- Wrapper Utama agar font konsisten -->
    <div class="font-sans content-offset text-gray-600 antialiased">

        <!-- 1. HERO SECTION DENGAN BACKGROUND IMAGE -->
        <section data-aos='fade-down' class="relative h-[500px] flex items-center justify-center overflow-hidden">
            <!-- Background Image (Ganti URL dengan foto desa asli jika ada) -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=1740&auto=format&fit=crop"
                    alt="Desa Merah Putih" class="w-full h-full object-cover">
                <!-- Overlay Gradient untuk keterbacaan teks -->
                <div class="absolute inset-0 bg-gradient-to-b from-green-900/80 to-green-800/90"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 text-center text-white">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-yellow-500/20 border border-yellow-400/50 text-yellow-300 text-sm font-semibold tracking-wider mb-6 backdrop-blur-sm">
                    EKONOMI KUAT, DESA BERDAULAT
                </span>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 tracking-tight font-serif">
                    {{ $koperasi->nama_koperasi ?? 'Koperasi Desa' }}
                </h1>
                <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-100 font-light leading-relaxed">
                    {{ $koperasi->deskripsi ?? 'Deskripsi default jika kosong.' }}
                </p>
                <div class="mt-8">
                    <a href="#tentang"
                        class="inline-block px-8 py-3 bg-white text-green-800 font-bold rounded-full hover:bg-green-50 transition transform hover:-translate-y-1 shadow-lg">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Dekorasi Gelombang Bawah -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="fill-white" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
                    </path>
                </svg>
            </div>
        </section>

        <!-- 2. PROFIL (Layout Asimetris Modern) -->
        <section id="tentang" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <!-- Sisi Teks -->
                    <div data-aos='fade-right' class="w-full md:w-1/2">
                        <h4 class="text-green-600 font-bold uppercase tracking-widest text-sm mb-2">Tentang Kami</h4>
                        <h2 class="text-4xl font-serif font-bold text-gray-900 mb-6 leading-tight">
                            Membangun Ekonomi <br>Dari Desa Untuk Desa
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                            Koperasi Desa Merah Putih bukan sekadar lembaga keuangan, melainkan jantung pergerakan ekonomi
                            desa. Kami hadir untuk memastikan setiap potensi lokal dikelola secara transparan dan
                            profesional.
                        </p>
                        <div class="border-l-4 border-green-500 pl-6 italic text-gray-500 my-8">
                            "Bersama kita kuat, bergotong royong kita sejahtera. Koperasi adalah soko guru perekonomian
                            desa."
                        </div>
                    </div>

                    <!-- Sisi Kartu Poin -->
                    <div data-aos='fade-left' class="w-full md:w-1/2">
                        <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 relative shadow-xl">
                            <!-- Aksen Dekoratif -->
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full opacity-20 blur-xl">
                            </div>

                            <ul class="space-y-6 relative z-10">
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">Dikelola Anggota</h4>
                                        <p class="text-sm text-gray-500 mt-1">Keputusan diambil melalui musyawarah untuk
                                            mufakat anggota.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 3v18h18"></path>
                                            <path d="M18 17V9"></path>
                                            <path d="M13 17V5"></path>
                                            <path d="M8 17v-3"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">Berbasis Potensi Lokal</h4>
                                        <p class="text-sm text-gray-500 mt-1">Memaksimalkan sumber daya alam dan manusia
                                            asli desa.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">Transparan & Akuntabel</h4>
                                        <p class="text-sm text-gray-500 mt-1">Laporan keuangan terbuka dan diaudit secara
                                            berkala.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. TUJUAN (Menggunakan Grid Card Minimalis) -->
        <section class="py-20 bg-green-50/50">
            <div class="max-w-7xl mx-auto px-4">
                <div data-aos="fade" class="text-center mb-16">
                    <h2 class="text-3xl font-serif font-bold text-gray-900">Tujuan Utama</h2>
                    <div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
                </div>

                <div data-aos="flip-up" class="grid md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border-t-4 border-green-500 group">
                        <div
                            class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-6 group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-gray-900">Ekonomi Produktif</h3>
                        <p class="text-gray-500 leading-relaxed">Mengembangkan unit usaha yang secara langsung meningkatkan
                            pendapatan harian anggota.</p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border-t-4 border-yellow-400 group">
                        <div
                            class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-600 mb-6 group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-gray-900">Kemandirian Desa</h3>
                        <p class="text-gray-500 leading-relaxed">Mengurangi ketergantungan pasokan dari luar dengan
                            memproduksi kebutuhan sendiri.</p>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border-t-4 border-green-500 group">
                        <div
                            class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-6 group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline>
                                <polyline points="7.5 19.79 7.5 14.6 3 12"></polyline>
                                <polyline points="21 12 16.5 14.6 16.5 19.79"></polyline>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-gray-900">Jangka Panjang</h3>
                        <p class="text-gray-500 leading-relaxed">Mewariskan sistem ekonomi yang sehat dan berkelanjutan
                            untuk generasi mendatang.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. BIDANG USAHA (Grid dengan Hover Effect) -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div data-aos="fade-left" class="flex flex-col md:flex-row justify-between items-end mb-12">
                    <div>
                        <h2 class="text-3xl font-serif font-bold text-gray-900">Unit Usaha Kami</h2>
                        <p class="mt-2 text-gray-500">Beragam layanan untuk memenuhi kebutuhan warga.</p>
                    </div>
                </div>

                <div data-aos="flip-down" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Item 1 -->
                    <div
                        class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-green-500 hover:bg-green-50/30 transition-all duration-300 cursor-default">
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Simpan Pinjam</h3>
                        <p class="text-sm text-gray-500">Solusi keuangan mikro dengan bunga rendah dan proses mudah.</p>
                    </div>

                    <!-- Item 2 -->
                    <div
                        class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-green-500 hover:bg-green-50/30 transition-all duration-300 cursor-default">
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Toko Desa</h3>
                        <p class="text-sm text-gray-500">Menyediakan sembako dan kebutuhan harian dengan harga terjangkau.
                        </p>
                    </div>

                    <!-- Item 3 -->
                    <div
                        class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-green-500 hover:bg-green-50/30 transition-all duration-300 cursor-default">
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 2.69l5.74 5.88a1 1 0 0 1 0 1.41l-9.37 9.58a10 10 0 0 1-14.14 0"></path>
                                <path d="M14 7h7v7"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Agro & UMKM</h3>
                        <p class="text-sm text-gray-500">Menampung dan memasarkan hasil panen serta produk kreatif warga.
                        </p>
                    </div>

                    <!-- Item 4 -->
                    <div
                        class="group bg-white border border-gray-200 rounded-2xl p-6 hover:border-green-500 hover:bg-green-50/30 transition-all duration-300 cursor-default">
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Jasa Layanan</h3>
                        <p class="text-sm text-gray-500">PPOB, pembayaran listrik, air, dan layanan digital desa.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. STRUKTUR PENGURUS (Diganti dari Table ke Card Grid) -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-5xl mx-auto px-4">
                <div data-aos="fade" class="text-center mb-16">
                    <h2 class="text-3xl font-serif font-bold text-gray-900">Struktur Pengurus</h2>
                    <p class="text-gray-500 mt-2">Amanah dalam bekerja, profesional dalam melayani.</p>
                </div>

                <div data-aos="flip-up" class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Cek apakah data ada --}}
                    @if ($koperasi && $koperasi->struktur_pengurus)
                        @foreach ($koperasi->struktur_pengurus as $pengurus)
                            <div
                                class="bg-white p-6 rounded-2xl text-center shadow-sm border border-gray-100 hover:shadow-md transition">
                                <div
                                    class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 overflow-hidden border-4 border-green-50">
                                    {{-- Menampilkan Foto dari Storage --}}
                                    {{-- Pastikan folder 'storage' sudah di-link --}}
                                    <img src="{{ asset('storage/' . $pengurus['foto']) }}" alt="{{ $pengurus['nama'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                                {{-- Nama Pengurus --}}
                                <h3 class="font-bold text-lg text-gray-900">{{ $pengurus['nama'] }}</h3>
                                {{-- Jabatan --}}
                                <div class="text-xs font-semibold tracking-wider text-green-600 uppercase mt-1">
                                    {{ $pengurus['jabatan'] }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center col-span-3 text-gray-400">Belum ada data pengurus.</p>
                    @endif

                </div>
            </div>
        </section>

        <!-- 6. CTA (Inverted Design: Card Hijau di Block Putih) -->
        <section class=" bg-white">

            <!-- Konten Card di Tengah -->
            <div data-aos="fade" class="relative max-w-5xl mx-auto px-4">
                <div class="bg-green-900 rounded-3xl p-10 md:p-14 text-center shadow-2xl relative overflow-hidden">

                    <!-- Pattern Background (Dipindah ke dalam Card) -->
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <svg class="w-full h-full" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid-cta" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="white" stroke-width="2"
                                        fill="none" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid-cta)" />
                        </svg>
                    </div>

                    <!-- Konten Card dengan Z-Index agar di atas pattern -->
                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-6 text-white">
                            Siap Menjadi Bagian dari Perubahan?
                        </h2>
                        <p class="text-lg text-green-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                            Mari bergabung bersama ratusan warga lainnya untuk membangun ekonomi desa yang kuat, mandiri,
                            dan berkelanjutan.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <!-- Tombol WhatsApp -->
                            <a href="https://wa.me/{{ $koperasi->contact_person ?? '628123456789' }}?text=Halo%20Admin%20Koperasi,%20saya%20ingin%20bertanya%20tentang%20keanggotaan."
                                target="_blank"
                                class="group px-8 py-4 bg-yellow-500 text-green-900 font-bold rounded-full hover:bg-yellow-400 transition shadow-lg shadow-black/20 flex items-center gap-2">
                                <!-- Icon WA -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="group-hover:scale-110 transition-transform">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                                Hubungi Kami Sekarang
                            </a>

                            <!-- Tombol Trigger Modal Syarat (Outline White) -->
                            <button onclick="toggleModal('modalSyarat')"
                                class="group cursor-pointer px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-green-900 transition flex items-center gap-2">
                                <!-- Icon Dokumen -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="group-hover:scale-110 transition-transform">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                Syarat Anggota
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MODAL SYARAT ANGGOTA (Hidden by Default) -->
        <div id="modalSyarat" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <!-- Background Backdrop -->
            <div class="fixed inset-0 bg-black/60 transition-opacity backdrop-blur-sm"
                onclick="toggleModal('modalSyarat')"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal Panel -->
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border-t-8 border-green-600">

                    <!-- Header Modal -->
                    <div class="bg-green-50 px-6 py-4 flex justify-between items-center border-b border-green-100">
                        <h3 class="text-xl font-bold text-green-800 flex items-center gap-2" id="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-green-600">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            Syarat Menjadi Anggota
                        </h3>
                        <button onclick="toggleModal('modalSyarat')" type="button"
                            class="text-gray-400 hover:text-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <!-- Isi Modal -->
                    <div class="px-6 py-6">
                        <p class="text-sm text-gray-500 mb-4">
                            Berikut adalah persyaratan administrasi dan ketentuan untuk bergabung menjadi anggota Koperasi
                            Desa Merah Putih:
                        </p>
                        <ul class="space-y-3 text-gray-700">
                            @if ($koperasi && $koperasi->syarat_anggota)
                                @foreach ($koperasi->syarat_anggota as $index => $syarat)
                                    <li class="flex items-start gap-3">
                                        <div
                                            class="mt-1 w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">
                                            {{ $loop->iteration }} {{-- Otomatis angka 1, 2, 3... --}}
                                        </div>
                                        <span>
                                            {{-- Jika syarat di DB berupa string biasa --}}
                                            @if (is_string($syarat))
                                                {{ $syarat }}
                                            @elseif(is_array($syarat) && isset($syarat['text']))
                                                {{-- Jika struktur JSON kamu {text: "blabla"} --}}
                                                {{ $syarat['text'] }}
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            @else
                                <li>Data syarat belum diinput.</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Footer Modal -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse sm:gap-2">
                        <a href="https://wa.me/{{ $koperasi->contact_person ?? '628123456789' }}?text=Halo,%20saya%20sudah%20membaca%20syarat%20dan%20ingin%20mendaftar%20anggota."
                            target="_blank"
                            class="inline-flex w-full justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:w-auto items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            Daftar via WhatsApp
                        </a>
                        <button onclick="toggleModal('modalSyarat')" type="button"
                            class="mt-3 cursor-pointer inline-flex w-full justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Sederhana untuk Modal -->
    <script>
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.body.classList.toggle("overflow-hidden"); // Agar body tidak bisa discroll saat modal muncul
        }
    </script>
@endsection
