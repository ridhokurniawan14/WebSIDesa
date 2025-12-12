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
    <div class="content-offset min-h-screen">

        <section class="pt-12 pb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- HEADER SECTION --}}
                <div class="text-center mb-12">
                    <h2 class="text-green-600 font-semibold tracking-wide uppercase text-sm">Dokumentasi</h2>
                    <h1 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Galeri Kegiatan Desa
                    </h1>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Melihat lebih dekat perkembangan dan kebersamaan warga desa kami.
                    </p>
                </div>

                {{-- SKELETON LOADER (Tampil saat loading JS) --}}
                <div id="skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="animate-pulse rounded-2xl overflow-hidden h-72 relative bg-gray-200">
                            <div class="absolute bottom-0 left-0 w-full p-4">
                                <div class="h-4 bg-gray-300 rounded w-1/3 mb-2"></div>
                                <div class="h-6 bg-gray-300 rounded w-3/4"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- CONTENT GRID --}}
                <div id="galeriContent" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                    @foreach ($galeri as $g)
                        {{-- CARD ITEM MODERN --}}
                        <div class="group relative h-72 rounded-2xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                            onclick="openGalleryModal('{{ asset($g['image']) }}', '{{ $g['title'] }}', '{{ \Carbon\Carbon::parse($g['date'])->format('d M Y') }}')">

                            {{-- Image Background --}}
                            <img src="{{ asset($g['image']) }}" alt="{{ $g['title'] }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            {{-- Gradient Overlay (Supaya teks terbaca jelas) --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300">
                            </div>

                            {{-- Text Content (Posisi di bawah) --}}
                            <div
                                class="absolute bottom-0 left-0 w-full p-5 translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        {{ \Carbon\Carbon::parse($g['date'])->format('d M Y') }}
                                    </span>
                                </div>
                                <h3
                                    class="text-lg font-bold text-white leading-tight group-hover:text-green-300 transition-colors">
                                    {{ $g['title'] }}
                                </h3>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </section>

    </div>

    {{-- =========================== --}}
    {{-- MODAL VIEWER MODERN --}}
    {{-- =========================== --}}
    <div id="galleryModal"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/90 backdrop-blur-sm p-4 transition-opacity duration-300 opacity-0">

        <div class="relative w-full max-w-5xl transform transition-all scale-95 duration-300" id="modalPanel">

            {{-- Close Button --}}
            <button onclick="closeGalleryModal()"
                class="absolute -top-12 right-0 md:-right-10 text-white/70 hover:text-white transition focus:outline-none cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Image Container --}}
            <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-2xl border border-gray-700">
                <img id="modalImage" src="" class="w-full max-h-[75vh] object-contain bg-black">

                <div class="p-6 bg-gray-900 text-left border-t border-gray-800 flex justify-between items-start">
                    <div>
                        <h2 id="modalTitle" class="text-2xl font-bold text-white mb-1"></h2>
                        <p id="modalDate" class="text-green-400 text-sm font-medium"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Loading skeleton effect
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const skeleton = document.getElementById("skeleton");
                const content = document.getElementById("galeriContent");

                skeleton.classList.add("hidden");
                content.classList.remove("hidden");

                // Add fade-in animation
                content.classList.add("animate-fade-in-up");
            }, 800); // Sedikit dipercepat biar snappy
        });

        const modal = document.getElementById("galleryModal");
        const modalPanel = document.getElementById("modalPanel");

        function openGalleryModal(image, title, date) {
            document.getElementById("modalImage").src = image;
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalDate").innerText = date;

            modal.classList.remove("hidden");
            // Sedikit delay biar transisi CSS opacity jalan
            setTimeout(() => {
                modal.classList.remove("opacity-0");
                modalPanel.classList.remove("scale-95");
                modalPanel.classList.add("scale-100");
                modal.classList.add("flex");
            }, 10);
        }

        function closeGalleryModal() {
            modal.classList.add("opacity-0");
            modalPanel.classList.remove("scale-100");
            modalPanel.classList.add("scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }, 300); // Sesuai durasi transisi CSS
        }

        // Close on click outside
        modal.addEventListener("click", function(e) {
            if (e.target === this) closeGalleryModal();
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape" && !modal.classList.contains('hidden')) {
                closeGalleryModal();
            }
        });
    </script>
@endsection
