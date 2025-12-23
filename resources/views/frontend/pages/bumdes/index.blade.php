@extends('frontend.layouts.main')

@section('content')
    {{-- Custom Styles untuk Animasi Background --}}
    <style>
        /* Animasi Gradient Latar Belakang */
        .animated-hero-bg {
            background: linear-gradient(-45deg, #0f172a, #064e3b, #0f766e, #1e293b);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Animasi Blob Melayang */
        .blob-float {
            animation: blob-bounce 10s infinite ease-in-out alternate;
        }

        .blob-float-delay {
            animation: blob-bounce 12s infinite ease-in-out alternate-reverse;
            animation-delay: 2s;
        }

        @keyframes blob-bounce {
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
    </style>

    <div class="font-sans content-offset text-slate-600 antialiased">

        {{-- Hero Section: Animated Gradient & Floating Elements --}}
        <header data-aos="fade-down" class="relative overflow-hidden animated-hero-bg pt-12 pb-24 sm:pt-20 sm:pb-32">

            {{-- Background decorative elements (Living Blobs) --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                {{-- Blob 1 (Top Left - Emerald) --}}
                <div class="absolute -top-[10%] -left-[10%] opacity-40 mix-blend-screen blob-float">
                    <div class="h-[500px] w-[500px] rounded-full bg-emerald-500 blur-[100px]"></div>
                </div>
                {{-- Blob 2 (Bottom Right - Cyan) --}}
                <div class="absolute top-[20%] -right-[10%] opacity-30 mix-blend-screen blob-float-delay">
                    <div class="h-[600px] w-[600px] rounded-full bg-teal-500 blur-[120px]"></div>
                </div>
                {{-- Blob 3 (Bottom Center - Blue) --}}
                <div class="absolute -bottom-[20%] left-[30%] opacity-30 mix-blend-screen blob-float">
                    <div class="h-[400px] w-[400px] rounded-full bg-blue-600 blur-[100px]"></div>
                </div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 text-center lg:px-8 z-10">
                <div class="mx-auto max-w-3xl">
                    <div class="mb-6 flex justify-center">
                        <span class="relative inline-block overflow-hidden rounded-full p-[1px]">
                            <span
                                class="absolute inset-0 animate-spin-slow bg-[conic-gradient(from_90deg_at_50%_50%,#10b981_0%,#0f172a_50%,#10b981_100%)]"></span>
                            <span
                                class="relative inline-flex h-full w-full cursor-pointer items-center justify-center rounded-full bg-slate-900 px-4 py-1.5 text-sm font-semibold text-emerald-400 backdrop-blur-3xl">
                                Badan Usaha Milik Desa
                            </span>
                        </span>
                    </div>

                    <h1
                        class="mb-6 text-4xl font-bold tracking-tight text-white sm:text-6xl lg:leading-tight drop-shadow-lg">
                        {{ $nama }}
                    </h1>
                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-200 drop-shadow-md">
                        {{ $slogan }}
                    </p>

                    {{-- CTA Buttons with Glassmorphism --}}
                    <div class="mt-10 flex justify-center gap-x-6">
                        <a href="#unit-usaha"
                            class="rounded-full bg-emerald-600 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 hover:bg-emerald-500 hover:scale-105 transition-all duration-300">
                            Lihat Unit Usaha
                        </a>
                        <a href="#tentang"
                            class="text-sm font-semibold leading-6 text-white flex items-center gap-2 hover:text-emerald-300 transition-colors">
                            Pelajari Selengkapnya <span aria-hidden="true" class="animate-pulse">→</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bottom Wave Divider (Fixed: Smooth & Clean Curve) --}}
            <div class="absolute -bottom-1 left-0 right-0 w-full overflow-hidden leading-[0] z-20">
                <svg class="relative block w-full h-[60px] sm:h-[120px] text-white" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path fill="currentColor" fill-opacity="1"
                        d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,202.7C1120,203,1280,181,1360,170.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
                    </path>
                </svg>
            </div>
        </header>

        {{-- Section 1: Tentang Kami --}}
        <section data-aos="flip-right" id="tentang" class="py-24 bg-white relative">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-y-12 lg:grid-cols-2 lg:gap-x-16 lg:items-center">

                    <div class="relative">
                        <div class="relative pl-8 sm:pl-0">
                            {{-- Decorative line --}}
                            <div
                                class="absolute -left-2 top-0 h-full w-1 bg-gradient-to-b from-emerald-400 to-transparent lg:hidden">
                            </div>
                            <h2 class="text-base font-semibold leading-7 text-emerald-600 uppercase tracking-wide">Tentang
                                Kami</h2>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Mengabdi Untuk
                                Kemajuan Ekonomi Desa</p>
                            <p class="mt-6 text-lg leading-relaxed text-slate-600 text-justify">
                                {{ $tentang }}
                            </p>
                        </div>
                    </div>

                    {{-- Right side visual --}}
                    <div
                        class="bg-slate-50 rounded-2xl p-8 border border-slate-100 shadow-xl relative overflow-hidden group hover:border-emerald-200 transition-colors duration-300">
                        {{-- Subtle animated blob inside card --}}
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100 rounded-full blur-2xl opacity-50 group-hover:scale-150 transition-transform duration-700">
                        </div>

                        <blockquote class="relative">
                            <svg class="h-10 w-10 text-emerald-500 mb-4" fill="currentColor" viewBox="0 0 32 32"
                                aria-hidden="true">
                                <path
                                    d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                            <p class="text-xl font-medium italic text-slate-800">
                                "Membangun desa mandiri melalui pengelolaan aset dan potensi yang profesional, transparan,
                                dan akuntabel."
                            </p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: Visi & Misi --}}
        <section data-aos="flip-left" id="visi-misi" class="bg-slate-50 py-24 relative overflow-hidden">
            {{-- Subtle Background Pattern --}}
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                style="background-image: radial-gradient(#059669 1px, transparent 1px); background-size: 32px 32px;">
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8 relative">
                <div class="grid md:grid-cols-2 gap-10">

                    {{-- Visi Card --}}
                    <div
                        class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="h-12 w-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6 text-blue-600">
                            <span class="text-2xl">🔭</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Visi Kami</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $visi }}</p>
                    </div>

                    {{-- Misi Card --}}
                    <div
                        class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                        <div
                            class="h-12 w-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-6 text-emerald-600">
                            <span class="text-2xl">🎯</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Misi Strategis</h3>
                        <ul class="space-y-4">
                            @foreach ($misi as $index => $item)
                                <li class="flex gap-4 group">
                                    <div class="flex-none transition-transform group-hover:scale-110">
                                        <span
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-600">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <span
                                        class="text-slate-600 group-hover:text-slate-900 transition-colors">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        {{-- Section 3: Unit Usaha --}}
        <section id="unit-usaha" class="py-24 bg-white relative">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div data-aos="fade" class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-base font-semibold leading-7 text-emerald-600">Layanan & Produk</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Unit Bisnis Unggulan</p>
                    <p class="mt-4 text-lg text-slate-600">Diversifikasi usaha untuk memaksimalkan potensi ekonomi desa.</p>
                </div>

                <div data-aos="flip-up" class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @php
                        $icons_biz = ['🏦', '🛍️', '⚙️', '📈', '🚜', '🥩'];
                    @endphp

                    @foreach ($unit_usaha as $index => $usaha)
                        <div
                            class="group relative bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                            {{-- Hover Gradient Background --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            <div class="relative z-10">
                                {{-- Icon Box --}}
                                <div
                                    class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-slate-50 text-3xl group-hover:bg-white group-hover:text-4xl group-hover:shadow-md transition-all duration-300">
                                    {{ $icons_biz[$index % count($icons_biz)] }}
                                </div>

                                <h3
                                    class="text-lg font-bold text-slate-900 mb-2 group-hover:text-emerald-700 transition-colors">
                                    {{ $usaha['nama'] }}
                                </h3>
                                <p class="text-sm leading-6 text-slate-500 group-hover:text-slate-600">
                                    {{ $usaha['deskripsi'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Section 4: Pengurus & Kontak --}}
        <section id="kontak" class="pt-15 relative">
            {{-- Subtle Top Border Gradient --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-emerald-200 to-transparent">
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8">

                {{-- Section Header --}}
                <div data-aos="fade-up" class="text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Hubungi Tim Kami</h2>
                    <p class="mt-4 text-lg text-slate-600">Kami siap melayani kebutuhan informasi dan kerjasama Anda.</p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                    {{-- Card Manajemen --}}
                    <div data-aos="slide-right"
                        class="bg-white rounded-3xl p-10 shadow-lg border border-slate-100 hover:shadow-xl transition-shadow duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-16 -mt-16 transition-transform hover:scale-110">
                        </div>

                        <div class="flex items-center gap-4 mb-8 relative z-10">
                            <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl">
                                👥
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900">Struktur Manajemen</h3>
                        </div>

                        <div class="space-y-4 relative z-10">
                            {{-- Kode BARU (Benar untuk struktur JSON kamu) --}}
                            @foreach ($pengurus as $item)
                                <div
                                    class="flex items-center justify-between border-b border-slate-100 pb-4 last:border-0 last:pb-0 hover:bg-slate-50 transition-colors rounded-lg px-2 -mx-2">
                                    {{-- Panggil Key 'jabatan' dari JSON --}}
                                    <span class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">
                                        {{ $item['jabatan'] }}
                                    </span>
                                    {{-- Panggil Key 'nama' dari JSON --}}
                                    <span class="text-slate-700 font-medium text-right">
                                        {{ $item['nama'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Card Kontak --}}
                    <div data-aos="slide-left"
                        class="bg-white rounded-3xl p-10 shadow-lg border border-slate-100 hover:shadow-xl transition-shadow duration-300 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-16 -mt-16 transition-transform hover:scale-110">
                        </div>

                        <div class="flex items-center gap-4 mb-8 relative z-10">
                            <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">
                                💬
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900">Informasi Kontak</h3>
                        </div>

                        <ul class="space-y-6 relative z-10">
                            <li class="flex items-start gap-4">
                                <div class="flex-none mt-1">
                                    <span class="block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                </div>
                                <div>
                                    <strong class="block text-slate-900 mb-1">Alamat Kantor</strong>
                                    <span class="text-slate-600 leading-relaxed block">{{ $kontak['alamat'] }}</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="flex-none mt-1">
                                    <span class="block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                </div>
                                <div>
                                    <strong class="block text-slate-900 mb-1">Telepon / WhatsApp</strong>
                                    <a href="https://wa.me/{{ $kontak['telepon'] }}" target="_blank"
                                        class="text-emerald-600 font-medium hover:text-emerald-500 transition-colors">
                                        +{{ $kontak['telepon'] }}
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="flex-none mt-1">
                                    <span class="block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                </div>
                                <div>
                                    <strong class="block text-slate-900 mb-1">Email Resmi</strong>
                                    <a href="mailto:{{ $kontak['email'] }}"
                                        class="text-emerald-600 font-medium hover:text-emerald-500 transition-colors">
                                        {{ $kontak['email'] }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection
