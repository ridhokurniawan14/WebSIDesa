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
                    DESA KITA
                </h3>

                <p class="text-sm leading-relaxed mb-6">
                    Website resmi informasi pelayanan dan publikasi Desa Cipta Makmur. Melayani dengan integritas.
                </p>

                <h4 class="text-lg font-semibold text-white mb-3">📲 Sosial Media</h4>
                <div class="flex space-x-5">
                    <a href="#" class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-facebook text-2xl"></i></a>
                    <a href="#" class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-instagram text-2xl"></i></a>
                    <a href="#" class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-youtube text-2xl"></i></a>
                    <a href="#" class="text-gray-500 hover:text-green-500 transition duration-300"><i
                            class="bi bi-whatsapp text-2xl"></i></a>
                </div>
            </div>

            <!-- ALAMAT -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">📍 Alamat Kantor</h3>
                <address class="text-sm not-italic space-y-2">
                    <p>
                        <strong>Kantor Kepala Desa Cipta Makmur</strong><br>
                        Jl. Swadaya No. 10, RT 01 RW 02<br>
                        Kecamatan Makmur Jaya, [Nama Kabupaten]<br>
                    </p>
                    <p>
                        <i class="bi bi-telephone-fill mr-2 text-green-500"></i>
                        Telp: <a href="tel:081234567890" class="hover:text-white">0812-3456-7890</a>
                    </p>
                    <p>
                        <i class="bi bi-envelope-fill mr-2 text-green-500"></i>
                        Email: <a href="mailto:desaciptamakmur@email.go.id"
                            class="hover:text-white">desaciptamakmur@email.go.id</a>
                    </p>
                </address>
            </div>

            <!-- MAP -->
            <div>
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">🗺️ Peta Lokasi</h3>
                <div class="rounded-lg overflow-hidden shadow-2xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4857.084405882541!2d114.18541967589385!3d-8.367703684351222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd15562ff3a6b3f%3A0x3b0181738285d4bc!2sBalai%20desa%20kembiritan!5e1!3m2!1sid!2sid!4v1763930591999!5m2!1sid!2sid"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <p class="mt-2 text-xs text-white">Klik peta untuk menuju Google Maps.</p>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div data-aos="fade-up" data-aos-delay="100" data-aos-offset="0"
            class="text-center border-t border-gray-800 mt-12 pt-6 text-sm">
            <p class="mb-2">
                © 2025 Desa Cipta Makmur. Semua Hak Dilindungi.
            </p>
            <p class="text-xs text-gray-500 hover:text-green-500 transition duration-300">
                Dibuat dengan <i class="bi bi-heart-fill text-red-500 mx-1"></i> oleh
                <a href="https://ridhokurniawan.my.id" target="_blank" class="font-medium hover:text-white">
                    Ridho Kurniawan
                </a>
            </p>
        </div>
    </div>
</footer>
