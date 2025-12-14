<!DOCTYPE html>
<html lang="id">
@include('frontend.layouts.partials.head')

{{-- Tambahkan ID pada body untuk manipulasi scroll nanti --}}

<body id="body-content"
    class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-green-100 selection:text-green-900">

    {{-- CDN Bootstrap Icons (Agar icon WA pasti muncul dan standar) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @include('frontend.layouts.partials.header')

    <main class="min-h-screen relative">
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')

    @include('frontend.layouts.partials.wa')

    @vite('resources/js/app.js')

    @yield('scripts')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    once: false,
                    duration: 800,
                    easing: 'ease-in-out',
                    mirror: true,
                });

                // FIX UTAMA: Refresh AOS setelah semua konten (gambar/canvas/font) selesai dimuat
                // Ini mencegah halaman blank karena AOS mengira konten belum siap
                window.addEventListener('load', function() {
                    AOS.refresh();
                });
            }
        });

        // === CONFIG SCRIPT WA ===
        const waNumber = "6281234567890"; // GANTI NOMOR DI SINI

        const body = document.getElementById('body-content');
        const modal = document.getElementById('waModal');
        const backdrop = document.getElementById('waBackdrop');
        const modalContent = document.getElementById('waModalContent');

        // Logic Auto Hide Greeting
        document.addEventListener('DOMContentLoaded', () => {
            const greeting = document.getElementById('wa-greeting');
            if (greeting) {
                // Hilang otomatis setelah 8 detik (bisa diatur)
                setTimeout(() => {
                    closeGreeting();
                }, 8000);
            }
        });

        function toggleWaModal() {
            if (modal.classList.contains('hidden')) {
                // OPEN MODAL
                modal.classList.remove('hidden');
                // Lock Scroll
                body.classList.add('overflow-hidden');

                // Animation In
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);

                // Sembunyikan greeting bubble jika masih ada saat tombol diklik
                closeGreeting();

            } else {
                // CLOSE MODAL
                closeModalAnim();
            }
        }

        function closeModalAnim() {
            // Animation Out
            backdrop.classList.add('opacity-0');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                // Unlock Scroll
                body.classList.remove('overflow-hidden');
            }, 300);
        }

        function closeGreeting() {
            const greeting = document.getElementById('wa-greeting');
            if (greeting) {
                // Tambahkan class opacity-0 dan translate biar smooth hilangnya
                greeting.classList.remove('opacity-100', 'translate-y-0');
                greeting.classList.add('opacity-0', 'translate-y-4'); // Efek turun sedikit

                // Hapus dari DOM setelah animasi selesai
                setTimeout(() => {
                    if (greeting.parentNode) {
                        greeting.parentNode.removeChild(greeting);
                    }
                }, 500);
            }
        }

        function sendToWa() {
            const name = document.getElementById('waName').value;
            const purpose = document.getElementById('waPurpose').value;

            if (!name || !purpose) {
                // Efek getar jika error
                modalContent.classList.add('animate-pulse');
                setTimeout(() => modalContent.classList.remove('animate-pulse'), 200);
                // Ganti border jadi merah sebentar
                const inputName = document.getElementById('waName');
                inputName.classList.add('border-red-500');
                setTimeout(() => inputName.classList.remove('border-red-500'), 2000);
                return;
            }

            const message = `Halo Admin, perkenalkan saya *${name}*.\n\nKeperluan saya:\n${purpose}`;
            const url = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;

            window.open(url, '_blank');
            closeModalAnim();

            // Reset Form
            document.getElementById('waName').value = '';
            document.getElementById('waPurpose').value = '';
        }

        // Close on click outside
        modal.addEventListener('click', function(e) {
            if (e.target.closest('#waModalContent') === null) {
                closeModalAnim();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
