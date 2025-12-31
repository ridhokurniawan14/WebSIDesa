<style>
    /* Canvas selalu berada di belakang */
    #bg-network {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* Konten utama tetap di atas */
    .sambutan-content {
        position: relative;
        z-index: 10;
    }
</style>

<section class="py-20 bg-white relative overflow-hidden">

    <!-- Canvas Animasi Background -->
    <canvas id="bg-network"></canvas>

    <div class="max-w-7xl mx-auto px-6 sambutan-content">

        <!-- Judul -->
        <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900">Sambutan Kepala Desa</h2>
            <p class="text-lg text-green-600 mt-2">Pesan untuk masyarakat Desa</p>
        </div>

        <!-- Box Konten -->
        <div data-aos="flip-up" data-aos-delay="100" class="bg-white shadow-2xl rounded-3xl p-10">
            <div class="md:grid md:grid-cols-3 md:gap-10 items-center">

                <!-- Foto -->
                <div class="flex justify-center mb-8 md:mb-0">
                    <div class="relative w-48 h-48 sm:w-56 sm:h-56">
                        <img src="{{ asset('storage/' . $beranda->foto_kepala_desa) }}" alt="Kepala Desa"
                            class="w-full h-full object-cover rounded-full shadow-2xl 
                            ring-4 ring-green-500 ring-offset-4 ring-offset-white">
                    </div>
                </div>

                <!-- Teks Sambutan -->
                <div class="md:col-span-2">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6 border-l-4 border-green-500 pl-5 italic">
                        "{{ $beranda->sambutan_kades }}"
                    </p>

                    <div class="pt-4 border-t border-gray-200 text-right">
                        <p class="text-xl font-bold text-green-600">{{ $beranda->nama_kepala_desa }}</p>
                        <p class="text-sm text-gray-500">Kepala {{ $aplikasi->nama_desa }} • Periode
                            {{ $beranda->periode_jabatan }}</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- SCRIPT ANIMASI NODE + LINE -->
<script>
    const canvas = document.getElementById("bg-network");
    const ctx = canvas.getContext("2d");

    function resizeCanvas() {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);

    let particles = [];
    const particleCount = 60;
    const maxDistance = 140;

    /* Generate particles */
    for (let i = 0; i < particleCount; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            vx: (Math.random() - 0.5) * 0.6,
            vy: (Math.random() - 0.5) * 0.6,
            size: 2 + Math.random() * 2
        });
    }

    /* Animate */
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach((p, index) => {
            p.x += p.vx;
            p.y += p.vy;

            if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
            if (p.y < 0 || p.y > canvas.height) p.vy *= -1;

            ctx.beginPath();
            ctx.fillStyle = "rgba(34,197,94,0.8)"; /* green-500 */
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fill();

            for (let j = index + 1; j < particles.length; j++) {
                const p2 = particles[j];
                const dist = Math.hypot(p.x - p2.x, p.y - p2.y);

                if (dist < maxDistance) {
                    ctx.strokeStyle = `rgba(34,197,94, ${1 - dist/maxDistance})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.stroke();
                }
            }
        });

        requestAnimationFrame(animate);
    }
    animate();
</script>
