@extends('frontend.layouts.main')
@section('content')
    <!-- Hero Section -->
    <section class="w-full bg-cover bg-center h-[450px] flex items-center" style="background-image: url('/images/hero.jpg')">
        <div class="w-full bg-black/40 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-3">Selamat Datang di Website Desa Kita</h1>
                <p class="text-lg md:text-xl max-w-2xl">Informasi terbaru, layanan publik, dan kegiatan desa tersedia di
                    sini.</p>
            </div>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="max-w-7xl mx-auto mt-12 px-4">
        <h2 class="text-2xl font-bold mb-4">Berita Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <img src="/images/berita1.jpg" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Judul Berita 1</h3>
                    <p class="text-sm text-gray-600">Ringkasan singkat berita...</p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <img src="/images/berita2.jpg" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Judul Berita 2</h3>
                    <p class="text-sm text-gray-600">Ringkasan singkat berita...</p>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <img src="/images/berita3.jpg" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Judul Berita 3</h3>
                    <p class="text-sm text-gray-600">Ringkasan singkat berita...</p>
                </div>
            </div>
        </div>
    </section>
@endsection
