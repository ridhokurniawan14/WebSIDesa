<header id="header"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out
    {{ request()->is('/') ? 'header-home' : 'header-normal' }}">

    <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4">

        <!-- Logo + Nama Desa -->
        <a href="/" class="flex items-center gap-3 text-white z-50">
            <img src="{{ asset('images/lambang_daerah.png') }}" class="w-10 md:w-14 lg:w-16" alt="Logo Desa">

            <div class="flex flex-col leading-tight">
                <p class="font-bold text-sm md:text-base lg:text-lg">Desa Kembiritan</p>
                <p class="text-xs md:text-sm lg:text-base">Kab. Banyuwangi</p>
            </div>
        </a>

        <!-- DESKTOP MENU -->
        <nav class="hidden md:flex items-center gap-5 text-white font-semibold">

            <!-- HOME / BERANDA -->
            <!-- LOGIKA: Cek jika URL adalah '/' -->
            <!-- PERBAIKAN: Hapus 'text-yellow-400' agar hanya garis bawah yang muncul -->
            <a href="/"
                class="mantine-font-size-lg relative py-1 hover-underline {{ request()->is('/') ? 'menu-active' : '' }}">
                Beranda
            </a>

            <!-- Profil Desa -->
            <!-- LOGIKA: Cek jika URL adalah salah satu dari sub-menu Profil -->
            <div class="relative group">
                <!-- PERBAIKAN: Tambahkan 'text-white' di class utama, hapus ternary warna kuning -->
                <button
                    class="mantine-font-size-lg flex items-center gap-1 py-1 hover-underline cursor-pointer text-white
                    {{ request()->is(['visi-misi', 'sejarah-desa', 'perangkat-desa', 'peta-desa']) ? 'menu-active' : '' }}">
                    Profil Desa
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <!-- Dropdown Container -->
                <div class="hidden group-hover:block absolute left-0 top-full pt-4 z-50 w-52 animate-fade-in-up">
                    <div class="bg-white text-gray-800 shadow-lg rounded-lg border border-gray-100">
                        <a href="/visi-misi"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 rounded-t-lg relative hover-underline-dark {{ request()->is('visi-misi') ? 'text-yellow-600 font-bold' : '' }}">Visi
                            & Misi</a>
                        <a href="/sejarah-desa"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('sejarah-desa') ? 'text-yellow-600 font-bold' : '' }}">Sejarah
                            Desa</a>
                        <a href="/perangkat-desa"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('perangkat-desa') ? 'text-yellow-600 font-bold' : '' }}">Perangkat
                            Desa</a>
                        <a href="/peta-desa"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 rounded-b-lg relative hover-underline-dark {{ request()->is('peta-desa') ? 'text-yellow-600 font-bold' : '' }}">Peta
                            Desa</a>
                    </div>
                </div>
            </div>

            <!-- Informasi -->
            <!-- LOGIKA: Cek jika URL adalah salah satu dari sub-menu Informasi -->
            <div class="relative group">
                <!-- PERBAIKAN: Tambahkan 'text-white' di class utama, hapus ternary warna kuning -->
                <button
                    class="mantine-font-size-lg flex items-center gap-1 py-1 hover-underline cursor-pointer text-white
                    {{ request()->is(['administrasi', 'berita*', 'produk-hukum', 'lpmd', 'posyandu', 'pkk', 'bumdes', 'karang-taruna', 'koperasi-desa-merah-putih']) ? 'menu-active' : '' }}">
                    Informasi
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <!-- Dropdown Container -->
                <div class="hidden group-hover:block absolute left-0 top-full pt-4 z-50 w-52 animate-fade-in-up">
                    <div class="bg-white text-gray-800 shadow-lg rounded-lg border border-gray-100">
                        <a href="/administrasi"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 rounded-t-lg relative hover-underline-dark {{ request()->is('administrasi') ? 'text-yellow-600 font-bold' : '' }}">Syarat
                            Administrasi</a>
                        <a href="/berita"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('berita*') ? 'text-yellow-600 font-bold' : '' }}">Berita
                            Desa</a>
                        <a href="/produk-hukum"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('produk-hukum') ? 'text-yellow-600 font-bold' : '' }}">Produk
                            Hukum</a>

                        <!-- Parent Sub Menu -->
                        <div class="relative group/sub">
                            <button
                                class="mantine-font-size-lg flex justify-between items-center w-full px-4 py-2 hover:bg-gray-50 rounded-b-lg text-left relative hover-underline-dark
                                {{ request()->is(['lpmd', 'posyandu', 'pkk', 'bumdes', 'karang-taruna', 'koperasi-desa-merah-putih']) ? 'text-yellow-600 font-bold' : '' }}">
                                Lembaga Desa
                                <svg class="w-4 h-4 -rotate-90" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                                </svg>
                            </button>

                            <!-- Sub Dropdown -->
                            <div
                                class="hidden group-hover/sub:block absolute left-full top-0 pl-2 z-50 w-64 animate-fade-in-left">
                                <div
                                    class="bg-white text-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-100">
                                    <a href="/lpmd"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('lpmd') ? 'text-yellow-600 font-bold' : '' }}">LPMD</a>
                                    <a href="/posyandu"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('posyandu') ? 'text-yellow-600 font-bold' : '' }}">Posyandu</a>
                                    <a href="/pkk"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('pkk') ? 'text-yellow-600 font-bold' : '' }}">PKK</a>
                                    <a href="/bumdes"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('bumdes') ? 'text-yellow-600 font-bold' : '' }}">BUMDes</a>
                                    <a href="/karang-taruna"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('karang-taruna') ? 'text-yellow-600 font-bold' : '' }}">Karang
                                        Taruna</a>
                                    <a href="/koperasi-desa-merah-putih"
                                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 relative hover-underline-dark {{ request()->is('koperasi-desa-merah-putih') ? 'text-yellow-600 font-bold' : '' }}">Koperasi
                                        Desa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transparansi -->
            <div class="relative group">
                <!-- PERBAIKAN: Tambahkan 'text-white' di class utama, hapus ternary warna kuning -->
                <button
                    class="mantine-font-size-lg flex items-center gap-1 py-1 hover-underline cursor-pointer text-white
                     {{ request()->routeIs('informasi.apbdes*') || request()->routeIs('informasi.pembangunan*') ? 'menu-active' : '' }}">
                    Transparansi
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <div class="hidden group-hover:block absolute left-0 top-full pt-4 z-50 w-52 animate-fade-in-up">
                    <div class="bg-white text-gray-800 shadow-lg rounded-lg border border-gray-100">
                        <a href="{{ route('informasi.apbdes.tahun', date('Y')) }}"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 rounded-t-lg relative hover-underline-dark {{ request()->routeIs('informasi.apbdes*') ? 'text-yellow-600 font-bold' : '' }}">APBDes</a>
                        <a href="{{ route('informasi.pembangunan') }}"
                            class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-50 rounded-b-lg relative hover-underline-dark {{ request()->routeIs('informasi.pembangunan*') ? 'text-yellow-600 font-bold' : '' }}">Pembangunan
                            Desa</a>
                    </div>
                </div>
            </div>

            <!-- galeri -->
            <!-- PERBAIKAN: Hapus 'text-yellow-400' -->
            <a href="/galeri"
                class="mantine-font-size-lg relative py-1 hover-underline {{ request()->is('galeri') ? 'menu-active' : '' }}">
                Galeri
            </a>

            <!-- Kontak -->
            <!-- PERBAIKAN: Hapus 'text-yellow-400' -->
            <a href="/kontak"
                class="mantine-font-size-lg relative py-1 hover-underline {{ request()->is('kontak') ? 'menu-active' : '' }}">
                Kontak
            </a>

            <!-- SEARCH BUTTON -->
            <div class="relative flex items-center" id="desktopSearchContainer">
                <input type="text" id="desktopSearchInput" autocomplete="off"
                    class="w-0 p-0 opacity-0 transition-all duration-300 ease-in-out bg-transparent border-b-2 border-yellow-400 text-white placeholder-gray-300 focus:outline-none focus:opacity-100"
                    placeholder="Cari menu...">

                <button id="desktopSearchBtn"
                    class="p-1 text-white hover:text-yellow-400 transition-colors focus:outline-none z-10 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <div id="desktopSearchResults"
                    class="absolute right-0 top-full mt-3 w-64 bg-white text-gray-800 rounded-lg shadow-xl hidden overflow-hidden z-[60] border border-gray-100">
                </div>
            </div>

        </nav>

        <!-- BURGER MOBILE -->
        <button id="mobileMenuBtn" class="md:hidden text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- MOBILE MENU -->
    <nav id="mobileMenu"
        class="hidden md:hidden bg-green-800 text-white px-6 pb-6 pt-2 h-screen overflow-y-auto fixed inset-0 z-40 top-[60px]">
        <div class="mb-4 mt-2 relative">
            <input type="text" id="mobileSearchInput"
                class="w-full bg-green-900/50 border border-green-600 rounded-lg px-4 py-2 text-sm text-white placeholder-green-200 focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:border-yellow-400"
                placeholder="Cari menu disini...">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-2.5 text-green-300"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <div id="mobileSearchResults"
                class="hidden flex-col gap-1 mt-2 bg-white text-gray-800 rounded shadow-lg p-2">
            </div>
        </div>

        <div id="mobileMenuList">
            <a href="/"
                class="flex items-center gap-3 py-3 mantine-font-size-lg font-semibold border-b border-green-700 {{ request()->is('/') ? 'text-yellow-400' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>

            <div class="border-b border-green-700 py-2">
                <button
                    class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg {{ request()->is(['visi-misi', 'sejarah-desa', 'perangkat-desa', 'peta-desa']) ? 'text-yellow-400' : '' }}">
                    <div class="flex items-center gap-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Desa
                    </div>
                    <span class="icon">+</span>
                </button>
                <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                    <a href="/visi-misi"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('visi-misi') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Visi & Misi
                    </a>
                    <a href="/sejarah-desa"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('sejarah-desa') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sejarah Desa
                    </a>
                    <a href="/perangkat-desa"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('perangkat-desa') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Perangkat Desa
                    </a>
                    <a href="/peta-desa"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('peta-desa') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Peta Desa
                    </a>
                </div>
            </div>

            <div class="border-b border-green-700 py-2">
                <button
                    class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg {{ request()->is(['administrasi', 'berita*', 'produk-hukum', 'lpmd', 'posyandu', 'pkk', 'bumdes', 'karang-taruna', 'koperasi-desa-merah-putih']) ? 'text-yellow-400' : '' }}">
                    <div class="flex items-center gap-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi
                    </div>
                    <span class="icon">+</span>
                </button>
                <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                    <a href="/administrasi"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('administrasi') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Syarat Administrasi
                    </a>
                    <a href="/berita"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('berita*') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        Berita Desa
                    </a>
                    <a href="/produk-hukum"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->is('produk-hukum') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                            </path>
                        </svg>
                        Produk Hukum Desa
                    </a>
                    <div class="border-l border-green-700 pl-3 mt-2">
                        <button
                            class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg {{ request()->is(['lpmd', 'posyandu', 'pkk', 'bumdes', 'karang-taruna', 'koperasi-desa-merah-putih']) ? 'text-yellow-400' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Lembaga Desa
                            </div>
                            <span class="icon">+</span>
                        </button>
                        <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                            <a href="/lpmd"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('lpmd') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> LPMD
                            </a>
                            <a href="/posyandu"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('posyandu') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> Posyandu
                            </a>
                            <a href="/pkk"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('pkk') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> PKK
                            </a>
                            <a href="/bumdes"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('bumdes') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> BUMDes
                            </a>
                            <a href="/karang-taruna"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('karang-taruna') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> Karang Taruna
                            </a>
                            <a href="/koperasi-desa-merah-putih"
                                class="flex items-center gap-2 py-1 opacity-90 hover:opacity-100 {{ request()->is('koperasi-desa-merah-putih') ? 'text-yellow-400 font-bold' : '' }}">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full"></span> Koperasi Desa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b border-green-700 py-2">
                <button
                    class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg {{ request()->routeIs('informasi.apbdes*') || request()->routeIs('informasi.pembangunan*') ? 'text-yellow-400' : '' }}">
                    <div class="flex items-center gap-3 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Transparansi
                    </div>
                    <span class="icon">+</span>
                </button>
                <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                    <a href="{{ route('informasi.apbdes.tahun', date('Y')) }}"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->routeIs('informasi.apbdes*') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        APBDes
                    </a>
                    <a href="{{ route('informasi.pembangunan') }}"
                        class="flex items-center gap-3 py-1.5 opacity-90 hover:opacity-100 {{ request()->routeIs('informasi.pembangunan*') ? 'text-yellow-400 font-bold' : '' }}">
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                        Pembangunan Desa
                    </a>
                </div>
            </div>

            <a href="/galeri"
                class="flex items-center gap-3 py-3 mantine-font-size-lg border-b border-green-700 {{ request()->is('galeri') ? 'text-yellow-400' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Galeri
            </a>

            <a href="/kontak"
                class="flex items-center gap-3 py-3 mantine-font-size-lg {{ request()->is('kontak') ? 'text-yellow-400' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Kontak
            </a>
        </div>
    </nav>
</header>

<style>
    /* Custom style untuk animasi hover garis bawah utama */
    .hover-underline::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #fbbf24;
        /* yellow-400 */
        transition: width 0.3s ease-in-out;
    }

    .hover-underline:hover::after {
        width: 100%;
    }

    /* === NEW: MENU ACTIVE STATE === */
    /* Ini membuat garis bawah tetap muncul 100% jika class menu-active ada */
    .menu-active::after {
        width: 100% !important;
    }

    /* Custom style untuk animasi hover garis bawah pada dropdown (Darker/Sama) */
    .hover-underline-dark::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #f59e0b;
        /* yellow-500 agar terlihat di background putih */
        transition: width 0.3s ease-in-out;
    }

    .hover-underline-dark:hover::after {
        width: 100%;
    }

    /* Animasi dropdown sederhana */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.2s ease-out forwards;
    }

    .animate-fade-in-left {
        animation: fadeInUp 0.2s ease-out forwards;
    }
</style>

<script>
    // 1. MOBILE MENU TOGGLE
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuBtn.onclick = () => {
        mobileMenu.classList.toggle('hidden');
        if (!mobileMenu.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    };

    // 2. MOBILE ACCORDION LOGIC
    const accordions = document.querySelectorAll('.mobile-accordion');
    accordions.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('.icon');
            const isChild = btn.closest('.border-l') !== null;

            if (!isChild) {
                accordions.forEach((otherBtn) => {
                    const otherContent = otherBtn.nextElementSibling;
                    const otherIcon = otherBtn.querySelector('.icon');
                    const otherIsChild = otherBtn.closest('.border-l') !== null;
                    if (otherBtn !== btn && !otherIsChild) {
                        otherContent.classList.add('hidden');
                        if (otherIcon) otherIcon.textContent = '+';
                    }
                });
            }

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = '–';
            } else {
                content.classList.add('hidden');
                icon.textContent = '+';
            }
        });
    });

    // 3. SEARCH FUNCTIONALITY (MENU ONLY)
    function getMenuItems() {
        const links = [];
        const anchors = document.querySelectorAll('#mobileMenuList a');
        anchors.forEach(a => {
            const text = a.innerText.trim();
            const href = a.getAttribute('href');
            if (text && href && href !== '#') {
                links.push({
                    text,
                    href
                });
            }
        });
        return links;
    }

    const menuItems = getMenuItems();

    // -- Desktop Search Logic --
    const desktopSearchBtn = document.getElementById('desktopSearchBtn');
    const desktopSearchInput = document.getElementById('desktopSearchInput');
    const desktopSearchResults = document.getElementById('desktopSearchResults');

    // Toggle Input Width
    desktopSearchBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (desktopSearchInput.classList.contains('w-0')) {
            // Expand
            desktopSearchInput.classList.remove('w-0', 'p-0', 'opacity-0');
            desktopSearchInput.classList.add('w-48', 'pr-8', 'opacity-100');
            desktopSearchInput.focus();
        } else {
            // Collapse
            if (desktopSearchInput.value === '') {
                closeDesktopSearch();
            } else {
                desktopSearchInput.focus();
            }
        }
    });

    function closeDesktopSearch() {
        // Tambahkan p-0 lagi agar tidak memakan tempat
        desktopSearchInput.classList.add('w-0', 'p-0', 'opacity-0');
        desktopSearchInput.classList.remove('w-48', 'pr-8', 'opacity-100');
        desktopSearchResults.classList.add('hidden');
        desktopSearchInput.value = '';
    }

    // Filter Logic Desktop
    desktopSearchInput.addEventListener('keyup', (e) => {
        const query = e.target.value.toLowerCase();
        desktopSearchResults.innerHTML = '';

        if (query.length < 1) {
            desktopSearchResults.classList.add('hidden');
            return;
        }

        const filtered = menuItems.filter(item => item.text.toLowerCase().includes(query));

        if (filtered.length > 0) {
            desktopSearchResults.classList.remove('hidden');
            filtered.forEach(item => {
                const a = document.createElement('a');
                a.href = item.href;
                a.className =
                    'block px-4 py-2 hover:bg-gray-100 text-sm border-b border-gray-50 last:border-0';
                a.innerText = item.text;
                desktopSearchResults.appendChild(a);
            });
        } else {
            desktopSearchResults.classList.remove('hidden');
            desktopSearchResults.innerHTML =
                '<div class="px-4 py-2 text-sm text-gray-500">Menu tidak ditemukan</div>';
        }
    });

    // Close desktop search when clicking outside
    document.addEventListener('click', (e) => {
        const container = document.getElementById('desktopSearchContainer');
        if (!container.contains(e.target)) {
            closeDesktopSearch();
        }
    });

    // -- Mobile Search Logic --
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    const mobileSearchResults = document.getElementById('mobileSearchResults');
    const mobileMenuList = document.getElementById('mobileMenuList');

    mobileSearchInput.addEventListener('keyup', (e) => {
        const query = e.target.value.toLowerCase();
        mobileSearchResults.innerHTML = '';

        if (query.length < 1) {
            mobileSearchResults.classList.add('hidden');
            mobileMenuList.classList.remove('hidden');
            return;
        }

        mobileMenuList.classList.add('hidden');
        mobileSearchResults.classList.remove('hidden');
        mobileSearchResults.classList.add('flex');

        const filtered = menuItems.filter(item => item.text.toLowerCase().includes(query));

        if (filtered.length > 0) {
            filtered.forEach(item => {
                const a = document.createElement('a');
                a.href = item.href;
                a.className =
                    'block px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 rounded border border-gray-200';
                a.innerText = item.text;
                mobileSearchResults.appendChild(a);
            });
        } else {
            mobileSearchResults.innerHTML =
                '<div class="px-4 py-2 text-center text-gray-500">Menu tidak ditemukan</div>';
        }
    });

    // 4. HEADER SCROLL LOGIC
    document.addEventListener("DOMContentLoaded", () => {
        const header = document.getElementById("header");
        if (!header.classList.contains("header-home")) return;

        function handleScroll() {
            if (window.scrollY > 10) {
                header.classList.add("header-scrolled");
            } else {
                header.classList.remove("header-scrolled");
            }
        }
        handleScroll();
        window.addEventListener("scroll", handleScroll);
    });
</script>
