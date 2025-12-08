<header id="header"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out
    {{ request()->is('/') ? 'header-home' : 'header-normal' }}">

    <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4">

        <!-- Logo + Nama Desa -->
        <a href="/" class="flex items-center gap-3 text-white">
            <img src="{{ asset('images/lambang_daerah.png') }}" class="w-10 md:w-14 lg:w-16" alt="Logo Desa">

            <div class="flex flex-col leading-tight">
                <p class="font-bold text-sm md:text-base lg:text-lg">Desa Kembiritan</p>
                <p class="text-xs md:text-sm lg:text-base">Kab. Banyuwangi</p>
            </div>
        </a>

        <!-- DESKTOP MENU -->
        <nav class="hidden md:flex items-center gap-4 text-white font-semibold">

            <!-- HOME / BERANDA -->
            <a href="/" class="mantine-font-size-lg hover:opacity-80 px-2 py-1">
                Beranda
            </a>

            <!-- Profil Desa -->
            <div class="relative group">
                <button class="mantine-font-size-lg flex items-center gap-1 px-2 py-1 text-white">
                    Profil Desa
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>
                <div
                    class="hidden group-hover:block absolute left-0 top-full mt-0 z-50 w-52 bg-white text-gray-800 shadow-lg rounded">
                    <a href="/visi-misi" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Visi & Misi</a>
                    <a href="/sejarah-desa" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Sejarah
                        Desa</a>
                    <a href="/perangkat-desa" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Perangkat
                        Desa</a>
                    <a href="/peta-desa" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Peta Desa</a>
                </div>
            </div>

            <!-- Informasi -->
            <div class="relative group">
                <button class="mantine-font-size-lg flex items-center gap-1 px-2 py-1 text-white">
                    Informasi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>
                <div
                    class="hidden group-hover:block absolute left-0 top-full mt-0 z-50 w-52 bg-white text-gray-800 shadow-lg rounded">
                    <a href="/administrasi" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Syarat-syarat
                        Administrasi
                        Desa</a>
                    <a href="/berita" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Berita Desa</a>
                    <a href="/produk-hukum-desa" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Produk
                        Hukum Desa</a>

                    <div class="relative group/sub">
                        <button
                            class="mantine-font-size-lg flex justify-between items-center w-full px-4 py-2 hover:bg-gray-100 text-left">
                            Lembaga Desa
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div
                            class="hidden group-hover/sub:block absolute left-full top-0 mt-0 z-50 w-64 bg-white text-gray-800 shadow-lg rounded">
                            <a href="/lpmd" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">LPMD</a>
                            <a href="/posyandu"
                                class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Posyandu</a>
                            <a href="/pkk" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">PKK</a>
                            <a href="/bumdes" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">BUMDes</a>
                            <a href="/karang-taruna"
                                class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Karang Taruna</a>
                            <a href="/koperasi-desa-merah-putih"
                                class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Koperasi Desa Merah
                                Putih</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transparansi -->
            <div class="relative group">
                <button class="mantine-font-size-lg flex items-center gap-1 px-2 py-1 text-white">
                    Transparansi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>
                <div
                    class="hidden group-hover:block absolute left-0 top-full mt-0 z-50 w-52 bg-white text-gray-800 shadow-lg rounded">
                    <a href="/apbdes" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">APBDes</a>
                    <a href="/realisasi-apbdes" class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Realisasi
                        APBDes</a>
                    <a href="/pembangunan-desa"
                        class="mantine-font-size-lg block px-4 py-2 hover:bg-gray-100">Pembangunan Desa</a>
                </div>
            </div>

            <!-- galeri -->
            <a href="/galeri" class="mantine-font-size-lg hover:opacity-80 px-2 py-1">
                Galeri
            </a>

            <!-- Kontak -->
            <a href="/kontak" class="mantine-font-size-lg hover:opacity-80 px-2 py-1">
                Kontak
            </a>

        </nav>

        <!-- BURGER MOBILE -->
        <button id="mobileMenuBtn" class="md:hidden text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- MOBILE MENU -->
    <nav id="mobileMenu" class="hidden md:hidden bg-green-800 text-white px-6 pb-4">

        <!-- HOME -->
        <a href="/" class="block py-3 mantine-font-size-lg font-semibold border-b border-green-700">
            Beranda
        </a>

        <!-- PROFIL DESA -->
        <div class="border-b border-green-700 py-2">
            <button class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg">
                Profil Desa
                <span class="icon">+</span>
            </button>
            <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                <a href="/visi-misi">Visi & Misi</a>
                <a href="/sejarah-desa">Sejarah Desa</a>
                <a href="/perangkat-desa">Perangkat Desa</a>
                <a href="/peta-desa">Peta Desa</a>
            </div>
        </div>

        <!-- INFORMASI -->
        <div class="border-b border-green-700 py-2">
            <button class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg">
                Informasi
                <span class="icon">+</span>
            </button>
            <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">

                <a href="/administrasi">Syarat-syarat Administrasi Desa</a>
                <a href="/berita">Berita Desa</a>
                <a href="/produk-hukum-desa">Produk Hukum Desa</a>

                <!-- SUB/child menu lembaga -->
                <div class="border-l border-green-700 pl-3 mt-2">

                    <button class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg">
                        Lembaga Desa
                        <span class="icon">+</span>
                    </button>

                    <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                        <a href="/lpmd">LPMD</a>
                        <a href="/posyandu">Posyandu</a>
                        <a href="/pkk">PKK</a>
                        <a href="/bumdes">BUMDes</a>
                        <a href="/karang-taruna">Karang Taruna</a>
                        <a href="/koperasi-desa-merah-putih">Koperasi Desa Merah Putih</a>
                    </div>

                </div>

            </div>
        </div>

        <!-- TRANSPARANSI -->
        <div class="border-b border-green-700 py-2">
            <button class="w-full flex justify-between items-center mobile-accordion mantine-font-size-lg">
                Transparansi
                <span class="icon">+</span>
            </button>
            <div class="hidden ml-4 mt-2 flex flex-col gap-1 mantine-font-size-lg">
                <a href="/apbdes">APBDes</a>
                <a href="/realisasi-apbdes">Realisasi APBDes</a>
                <a href="/pembangunan-desa">Pembangunan Desa</a>
            </div>
        </div>

        <!-- GALERI -->
        <a href="/galeri" class="block py-3 mantine-font-size-lg border-b border-green-700">
            Galeri
        </a>

        <!-- KONTAK -->
        <a href="/kontak" class="block py-3 mantine-font-size-lg">
            Kontak
        </a>

    </nav>


</header>

<script>
    document.getElementById('mobileMenuBtn').onclick = () =>
        document.getElementById('mobileMenu').classList.toggle('hidden');

    const accordions = document.querySelectorAll('.mobile-accordion');

    accordions.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation(); // penting supaya child accordion tidak menutup parent

            const content = btn.nextElementSibling;
            const icon = btn.querySelector('.icon');

            // DETEKSI LEVEL (parent atau child)
            const isChild = btn.closest('.border-l') !== null;

            // Jika bukan child → tutup accordion utama lainnya
            if (!isChild) {
                accordions.forEach((otherBtn) => {
                    const otherContent = otherBtn.nextElementSibling;
                    const otherIcon = otherBtn.querySelector('.icon');

                    const otherIsChild = otherBtn.closest('.border-l') !== null;

                    // Jangan menutup child saat parent yang diklik
                    if (otherBtn !== btn && !otherIsChild) {
                        otherContent.classList.add('hidden');
                        if (otherIcon) otherIcon.textContent = '+';
                    }
                });
            }

            // Toggle accordion yang dipilih
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.textContent = '–';
            } else {
                content.classList.add('hidden');
                icon.textContent = '+';
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const header = document.getElementById("header");

        // Jika bukan halaman home → tidak usah diproses scroll
        if (!header.classList.contains("header-home")) {
            return;
        }

        function handleScroll() {
            if (window.scrollY > 10) {
                header.classList.add("header-scrolled");
            } else {
                header.classList.remove("header-scrolled");
            }
        }

        // jalankan di awal (biar rapi kalau refresh di tengah scroll)
        handleScroll();

        window.addEventListener("scroll", handleScroll);
    });
</script>
