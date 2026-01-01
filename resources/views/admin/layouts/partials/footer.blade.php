<footer class="mt-10 border-t border-gray-200 dark:border-gray-700 pt-6 pb-2">
    <!-- Container Flexbox: Layout simpel kiri-kanan (justify-between) -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 px-4">

        <!-- Bagian Kiri: Copyright, Tahun, dan Nama digabung jadi satu -->
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center md:text-left">
            &copy; <span id="year"></span> Dibuat dengan <span class="text-red-500" aria-label="cinta">💖</span> oleh
            <b>
                <!-- Update: Hover Emerald, No Underline, efek tracking-wide -->
                <a href="#"
                    class="transition-all duration-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:tracking-wide">
                    Tim {{ $aplikasi->nama_desa }}
                </a>
            </b>
        </p>

        <!-- Bagian Kanan: Versi -->
        <span
            class="text-xs text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full border border-gray-200 dark:border-gray-600">
            v1.0.2
        </span>
    </div>
</footer>
<script>
    // Ambil elemen dengan id "year" dan isi dengan tahun sekarang
    document.getElementById('year').textContent = new Date().getFullYear();
</script>
