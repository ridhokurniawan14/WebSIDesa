<style>
    .subtle-underline {
        position: relative;
        cursor: pointer;
    }

    /* Garis bawah yang awalnya tidak terlihat */
    .subtle-underline::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        /* Jarak dari teks */
        left: 0;
        background-color: #16a34a;
        /* Warna digital */
        transition: width 0.3s ease-out;
        /* Animasi yang halus */
    }

    /* Saat di-hover, lebar garis menjadi 100% */
    .subtle-underline:hover::after {
        width: 100%;
    }

    <style>.text-shadow-md {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .text-shadow-lg {
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.6);
    }
</style>

<!-- Hero Section -->
<section class="w-full h-screen relative overflow-hidden">

    <div id="hero-slider" class="absolute inset-0">
        @php
            // 1. Siapkan gambar default (Placeholder kalau DB kosong)
            $defaultSlides = [
                'https://png.pngtree.com/thumb_back/fh260/background/20210902/pngtree-aerial-photography-of-green-rice-seedlings-in-beautiful-rural-agricultural-rice-image_786584.jpg',
                'https://awsimages.detik.net.id/community/media/visual/2024/11/19/desa-wisata-mekarbuana-karawang-jawa-barat-1_169.jpeg?w=700&q=90',
            ];

            // 2. Inisialisasi variable slides dengan default dulu
            $slides = $defaultSlides;

            // 3. Cek apakah variable $beranda ada isinya DAN kolom banner_images tidak kosong
            if (isset($beranda) && !empty($beranda->banner_images)) {
                $slides = []; // Kosongkan array untuk diisi data DB
                foreach ($beranda->banner_images as $imagePath) {
                    // Pastikan path gambar mengarah ke storage (jika upload lokal)
                    // Kalau di DB isinya sudah "http...", function asset() tidak perlu dipakai.
                    // Asumsi standar Laravel upload: path/to/image.jpg
                    $slides[] = asset('storage/' . $imagePath);
                }
            }
        @endphp

        @foreach ($slides as $index => $img)
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-[1200ms] 
                    {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                style="background-image: url('{{ $img }}')">
            </div>
        @endforeach
    </div>

    <!-- Overlay -->
    <div data-aos="fade-in" data-aos-delay="100" class="absolute inset-0 bg-black/40 flex items-center">
        <div class="max-w-7xl mx-auto px-4 text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-3 text-shadow-lg">
                Selamat Datang di Website <span class="subtle-underline">{{ $aplikasi->nama_desa }}</span>
            </h1>
            <p class="text-lg md:text-xl max-w-2xl text-shadow-md">
                {{ $beranda->deskripsi }}
            </p>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelectorAll(".hero-slide");
        let current = 0;

        setInterval(() => {
            slides[current].classList.remove("opacity-100");
            slides[current].classList.add("opacity-0");

            current = (current + 1) % slides.length;

            slides[current].classList.remove("opacity-0");
            slides[current].classList.add("opacity-100");
        }, 5000); // ganti slide tiap 5 detik
    });
</script>
