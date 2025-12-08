@extends('frontend.layouts.main')

@section('content')
    <style>
        /* CSS Khusus untuk Efek Aurora */
        .aurora-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -10;
            /* Pastikan di paling belakang */
            background-color: #f8fafc;
            /* Warna dasar putih tulang */
            overflow: hidden;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            /* Efek blur yang kuat */
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        /* Bola 1: Hijau Desa */
        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background-color: #86efac;
            /* green-300 */
            animation-delay: 0s;
        }

        /* Bola 2: Biru Langit */
        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background-color: #bae6fd;
            /* sky-200 */
            animation-delay: -2s;
        }

        /* Bola 3: Kuning Matahari (Aksen) */
        .blob-3 {
            top: 40%;
            left: 40%;
            width: 400px;
            height: 400px;
            background-color: #fef08a;
            /* yellow-200 */
            animation-delay: -4s;
            opacity: 0.4;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        /* Agar konten tetap terbaca jelas */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
    </style>
    <!-- BAGIAN 1: Elemen Background Aurora -->
    <div class="aurora-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    {{-- Spacer supaya tidak ketutup header --}}
    <div class="content-offset">

        <!-- Hero Section -->
        <section class="relative h-[320px] w-full bg-cover bg-center overflow-hidden"
            style="background-image: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80');">

            <div class="absolute inset-0 bg-black/40"></div>

            <div data-aos="fade-right" data-aos-delay="100"
                class="relative z-10 max-w-5xl mx-auto px-4 h-full flex items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-wide">
                        Sejarah Desa
                    </h1>
                    <p class="text-gray-200 text-lg max-w-xl">
                        Mengenal perjalanan panjang Desa dari masa ke masa.
                    </p>
                </div>
            </div>
        </section>

        <!-- Section Konten Sejarah -->
        <section class="max-w-5xl mx-auto px-4 mt-16 mb-24">
            <div class="grid md:grid-cols-2 gap-10 items-center">

                {{-- FOTO / ILUSTRASI --}}
                <div data-aos="flip-right" data-aos-delay="100" class="relative">
                    <img src="https://images.unsplash.com/photo-1528892952291-009c663ce843?auto=format&fit=crop&w=900&q=80"
                        class="rounded-xl shadow-lg" alt="Sejarah Desa">

                    <div class="absolute -bottom-5 -right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm">
                        Dokumentasi Lama
                    </div>
                </div>

                {{-- TEXT SEJARAH --}}
                <div data-aos="fade-left" data-aos-delay="100">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                        Asal Usul Desa
                    </h2>

                    <p class="text-gray-600 leading-relaxed mb-4 text-justify">
                        Desa ini berdiri pada sekitar tahun <strong>1900-an</strong> sebagai permukiman kecil
                        yang dipimpin oleh tokoh masyarakat setempat. Pada awalnya, wilayah ini masih berupa
                        hutan dan ladang, kemudian berkembang menjadi kawasan pemukiman tetap.
                    </p>

                    <p class="text-gray-600 leading-relaxed mb-4 text-justify">
                        Pada masa kolonial, desa ini mulai dikenal karena memiliki potensi hasil bumi yang melimpah,
                        sehingga menarik banyak penduduk untuk menetap. Seiring berjalannya waktu, desa ini mengalami
                        perkembangan
                        pesat dalam bidang sosial, ekonomi, serta budaya.
                    </p>

                    <p class="text-gray-600 leading-relaxed text-justify">
                        Hingga saat ini, Desa terus menjaga nilai-nilai tradisi leluhur sambil tetap beradaptasi
                        dengan perkembangan zaman agar tetap maju dan sejahtera.
                    </p>
                </div>

            </div>

            <!-- Timeline Sejarah -->
            <div class="mt-20">
                <h2 data-aos="fade-in" data-aos-delay="100" class="text-3xl font-bold text-gray-800 mb-10 text-center">
                    Timeline Perkembangan Desa
                </h2>

                <div class="relative border-l-4 border-green-600 ml-4">

                    {{-- Item 1 --}}
                    <div class="mb-10 ml-8 relative">
                        <div class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full"></div>

                        <div data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-xl font-semibold text-gray-800">1900 – Awal Pembentukan</h3>
                            <p class="text-gray-600 mt-2">
                                Pemukiman kecil mulai terbentuk oleh beberapa keluarga.
                            </p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="mb-10 ml-8 relative">
                        <div class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full"></div>

                        <div data-aos="fade-up" data-aos-delay="150">
                            <h3 class="text-xl font-semibold text-gray-800">1950 – Pengakuan Administratif</h3>
                            <p class="text-gray-600 mt-2">
                                Desa resmi diakui sebagai wilayah administrasi pemerintahan.
                            </p>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="mb-10 ml-8 relative">
                        <div class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full"></div>

                        <div data-aos="fade-up" data-aos-delay="200">
                            <h3 class="text-xl font-semibold text-gray-800">1980 – Pembangunan Infrastruktur</h3>
                            <p class="text-gray-600 mt-2">
                                Mulai dibangun jalan desa, irigasi, dan fasilitas publik.
                            </p>
                        </div>
                    </div>

                    {{-- Item 4 --}}
                    <div class="mb-10 ml-8 relative">
                        <div class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full"></div>

                        <div data-aos="fade-up" data-aos-delay="250">
                            <h3 class="text-xl font-semibold text-gray-800">2000 – Modernisasi</h3>
                            <p class="text-gray-600 mt-2">
                                Desa mulai menerima akses teknologi dan program pemberdayaan masyarakat.
                            </p>
                        </div>
                    </div>

                    {{-- Item 5 --}}
                    <div class="mb-10 ml-8 relative">
                        <div class="absolute -left-11 w-6 h-6 bg-green-600 rounded-full"></div>

                        <div data-aos="fade-up" data-aos-delay="300">
                            <h3 class="text-xl font-semibold text-gray-800">Sekarang – Era Digital</h3>
                            <p class="text-gray-600 mt-2">
                                Pemerintah Desa mengembangkan layanan digital dan transparansi publik.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    </div>
    {{-- Animasi simple --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.9s ease-out forwards;
        }
    </style>
@endsection
