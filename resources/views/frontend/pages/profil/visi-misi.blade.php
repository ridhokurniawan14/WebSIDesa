@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">

        <!-- Hero Banner -->
        <section class="relative h-[300px] w-full flex items-center justify-center bg-cover bg-center header-offset"
            style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80');">

            <div class="absolute inset-0 bg-black/50"></div>
            <h1 class="relative text-white text-4xl md:text-5xl font-bold drop-shadow-lg animate-fadeIn">
                Visi & Misi Desa
            </h1>
        </section>

        <!-- Wrapper -->
        <section class="max-w-6xl mx-auto px-6 mt-16">

            <!-- Card Visi -->
            <div data-aos="fade-right" data-aos-delay="100"
                class="bg-white rounded-2xl shadow-lg p-10 mb-14 border border-gray-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-3xl font-bold text-green-700 mb-4 flex items-center gap-3">
                    <span class="w-2 h-10 bg-green-600 rounded-full"></span>
                    Visi Desa
                </h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    “Terwujudnya Desa yang Maju, Mandiri, Sejahtera, dan Berbudaya dengan Mengedepankan Pelayanan Publik
                    Prima serta Pembangunan Berkelanjutan.”
                </p>
            </div>

            <!-- Card Misi -->
            <div data-aos="fade-left" data-aos-delay="100"
                class="bg-white rounded-2xl shadow-lg p-10 border border-gray-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center gap-3">
                    <span class="w-2 h-10 bg-green-600 rounded-full"></span>
                    Misi Desa
                </h2>

                <ul class="space-y-4 text-gray-700 text-lg">
                    <li class="flex gap-4">
                        <div
                            class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full">
                            1
                        </div>
                        <p>Meningkatkan kualitas pelayanan publik yang cepat, tepat, dan transparan.</p>
                    </li>

                    <li class="flex gap-4">
                        <div
                            class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full">
                            2
                        </div>
                        <p>Mengembangkan potensi ekonomi desa berbasis UMKM dan pertanian.</p>
                    </li>

                    <li class="flex gap-4">
                        <div
                            class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full">
                            3
                        </div>
                        <p>Meningkatkan pembangunan infrastruktur yang merata dan berkelanjutan.</p>
                    </li>

                    <li class="flex gap-4">
                        <div
                            class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full">
                            4
                        </div>
                        <p>Mendorong partisipasi masyarakat dalam pembangunan desa.</p>
                    </li>

                    <li class="flex gap-4">
                        <div
                            class="flex-shrink-0 bg-green-600 text-white w-9 h-9 flex items-center justify-center rounded-full">
                            5
                        </div>
                        <p>Melestarikan budaya lokal dan memperkuat nilai-nilai sosial kemasyarakatan.</p>
                    </li>
                </ul>
            </div>

        </section>

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
    </div>
@endsection
