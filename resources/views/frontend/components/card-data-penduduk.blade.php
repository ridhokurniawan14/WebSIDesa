<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Judul -->
        <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Data Penduduk Desa</h2>
            <p class="text-gray-600">Rangkuman kondisi kependudukan terbaru</p>
        </div>

        <!-- GRID 12 -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">

            <!-- 1 Total Penduduk -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-green-100 rounded-full mr-4">
                        <i class="bi bi-people-fill text-green-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Penduduk</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->total_penduduk) }} Jiwa
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2 Laki-laki -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-blue-100 rounded-full mr-4">
                        <i class="bi bi-gender-male text-blue-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Laki-laki</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->total_laki_laki) }} Jiwa
                        </p>
                    </div>
                </div>
            </div>

            <!-- 3 Perempuan -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-pink-100 rounded-full mr-4">
                        <i class="bi bi-gender-female text-pink-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Perempuan</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->total_perempuan) }} Jiwa
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4 Usia Muda -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-yellow-100 rounded-full mr-4">
                        <i class="bi bi-emoji-smile text-yellow-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Usia Muda (0–17)</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->usia_muda) }} Jiwa</p>
                    </div>
                </div>
            </div>

            <!-- 5 Usia Dewasa -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-purple-100 rounded-full mr-4">
                        <i class="bi bi-person-standing text-purple-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Usia Dewasa (18–59)</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->usia_dewasa) }} Jiwa</p>
                    </div>
                </div>
            </div>

            <!-- 6 Lansia -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-red-100 rounded-full mr-4">
                        <i class="bi bi-person-walking text-red-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Lansia (60+)</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->usia_lansia) }} Jiwa</p>
                    </div>
                </div>
            </div>

            <!-- 7 Jumlah KK -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-indigo-100 rounded-full mr-4">
                        <i class="bi bi-house-door-fill text-indigo-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Jumlah KK</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->jumlah_kk) }} KK</p>
                    </div>
                </div>
            </div>

            <!-- 8 RT -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-orange-100 rounded-full mr-4">
                        <i class="bi bi-diagram-2-fill text-orange-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Jumlah RT</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->jumlah_rt) }} RT</p>
                    </div>
                </div>
            </div>

            <!-- 9 RW -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-teal-100 rounded-full mr-4">
                        <i class="bi bi-grid-3x3-gap-fill text-teal-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Jumlah RW</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->jumlah_rw) }} RW</p>
                    </div>
                </div>
            </div>

            <!-- 10 Dusun -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-green-100 rounded-full mr-4">
                        <i class="bi bi-geo-alt-fill text-green-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Jumlah Dusun</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->jumlah_dusun) }} Dusun
                        </p>
                    </div>
                </div>
            </div>

            <!-- 11 Desa Adat / Lingkungan -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-blue-100 rounded-full mr-4">
                        <i class="bi bi-building text-blue-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Desa Adat</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->desa_adat) }} Desa Adat
                        </p>
                    </div>
                </div>
            </div>

            <!-- 12 Keluarga Miskin -->
            <div data-aos="fade-up" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="p-4 bg-red-100 rounded-full mr-4">
                        <i class="bi bi-exclamation-triangle-fill text-red-600 text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Keluarga Miskin</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($beranda->keluarga_miskin) }} KK
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
