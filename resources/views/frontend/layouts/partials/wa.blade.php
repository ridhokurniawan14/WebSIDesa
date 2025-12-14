<!-- Container Floating Bottom Right -->
<div class="fixed bottom-8 right-8 z-50 flex flex-col items-end gap-3 font-sans">

    {{-- LOGIKA: Sapaan HANYA di Home ('/') --}}
    @if (request()->is('/') || request()->routeIs('home'))
        <div id="wa-greeting"
            class="relative bg-white px-5 py-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] mb-2 max-w-[280px] animate-fade-in-up transition-all duration-300 transform translate-y-0 opacity-100">
            <!-- Teks Sapaan (Lebih Besar & Jelas) -->
            <p class="text-[15px] leading-relaxed text-gray-700 font-medium">
                Halo, ada yang bisa kami bantu?
            </p>

            <!-- Tombol Close (Posisi Kiri Atas - Sesuai Referensi) -->
            <button onclick="closeGreeting()"
                class="absolute -top-3 -left-3 bg-gray-200 hover:bg-gray-300 text-gray-500 rounded-full w-6 h-6 flex items-center justify-center shadow-sm transition-colors border border-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Buntut Bubble (Arah ke Tombol WA) -->
            <div class="absolute -bottom-2 right-6 w-5 h-5 bg-white transform rotate-45"></div>
        </div>
    @endif

    <!-- Tombol Floating WA (Icon Besar & Jelas) -->
    <button onclick="toggleWaModal()"
        class="group bg-[#25D366] hover:bg-[#20bd5a] text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-[0_0_20px_rgba(37,211,102,0.5)] active:scale-95">
        <i class="bi bi-whatsapp text-white text-3xl"></i>
    </button>
</div>

<!-- 3. Modal Form Modern (Backdrop Blur & No Scroll) -->
<div id="waModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <!-- Backdrop (Gelap + Blur) -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0 ease-out duration-300"
        id="waBackdrop"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <!-- Modal Panel -->
            <div id="waModalContent"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md scale-95 opacity-0 duration-300 ease-out border border-gray-100">

                <!-- Header Modal -->
                <div class="bg-[#075e54] px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-1.5 rounded-full">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white leading-6">Chat WhatsApp</h3>
                    </div>
                    <button onclick="toggleWaModal()"
                        class="text-white/70 hover:text-white transition-colors p-1 hover:bg-white/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body Modal -->
                <div class="px-6 py-6 space-y-5">
                    <div class="text-center mb-2">
                        <p class="text-sm text-gray-500">Isi formulir singkat di bawah ini untuk terhubung langsung
                            dengan tim kami.</p>
                    </div>

                    <!-- Input Nama -->
                    <div class="relative">
                        <input type="text" id="waName"
                            class="peer w-full border-2 border-gray-200 rounded-xl px-4 py-3 placeholder-transparent focus:border-[#25D366] focus:ring-0 focus:outline-none transition-all text-gray-800 font-medium bg-gray-50/50 focus:bg-white"
                            placeholder="Nama Lengkap">
                        <label for="waName"
                            class="absolute left-4 -top-2.5 bg-white px-1 text-xs font-semibold text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-[#25D366]">Nama
                            Lengkap</label>
                    </div>

                    <!-- Input Keperluan -->
                    <div class="relative">
                        <textarea id="waPurpose" rows="3"
                            class="peer w-full border-2 border-gray-200 rounded-xl px-4 py-3 placeholder-transparent focus:border-[#25D366] focus:ring-0 focus:outline-none transition-all text-gray-800 bg-gray-50/50 focus:bg-white resize-none"
                            placeholder="Keperluan"></textarea>
                        <label for="waPurpose"
                            class="absolute left-4 -top-2.5 bg-white px-1 text-xs font-semibold text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-[#25D366]">Tulis
                            Keperluan Anda...</label>
                    </div>

                    <!-- Tombol Kirim -->
                    <button onclick="sendToWa()"
                        class="w-full cursor-pointer bg-[#25D366] hover:bg-[#1da851] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 hover:shadow-green-300 transform transition-all active:scale-[0.98] flex items-center justify-center gap-2 group">
                        <span>Mulai Chat Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>

                <!-- Footer Kecil -->
                <div class="bg-gray-50 px-6 py-3 text-center">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Powered by WhatsApp
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
