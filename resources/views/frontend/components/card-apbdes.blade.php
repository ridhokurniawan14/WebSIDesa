<style>
    #bg-network-apbdes {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .apbdes-content {
        position: relative;
        z-index: 10;
    }
</style>

<section class="py-12 w-full relative overflow-hidden" style="background-color: rgba(6, 78, 55, 0.85);">

    <!-- Canvas Animasi di Belakang -->
    <canvas id="bg-network-apbdes"></canvas>

    <div class="max-w-7xl mx-auto px-4 apbdes-content">

        <!-- Judul -->
        <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-10 text-white">
            <h2 class="text-3xl font-bold">APBDes Tahun 2024</h2>
            <p class="opacity-90 mt-2">Rangkuman Anggaran Pendapatan dan Belanja Desa</p>
        </div>

        <!-- Chart Section -->
        <div data-aos="flip-down" data-aos-delay="100" class="bg-white rounded-2xl shadow-lg p-6 mb-10">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik APBDes 2024</h3>

            <div id="chartApbdes" class="w-full h-[350px]"></div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Pendapatan -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
                    transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-green-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-coin text-green-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pendapatan Desa</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 2.150.000.000</p>
                </div>
            </div>

            <!-- Belanja -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
                    transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-red-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-cash-stack text-red-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Belanja Desa</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 1.870.000.000</p>
                </div>
            </div>

            <!-- Pembiayaan -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
                    transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-blue-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-graph-up text-blue-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pembiayaan Desa</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 280.000.000</p>
                </div>
            </div>

            <!-- Surplus/Defisit -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
        transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-yellow-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-piggy-bank text-yellow-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Surplus / Defisit</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 80.000.000</p>
                </div>
            </div>

            <!-- SiLPA -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
                    transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-purple-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-wallet2 text-purple-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">SiLPA / SiKPA</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 50.000.000</p>
                </div>
            </div>

            <!-- Tahun -->
            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-xl shadow flex items-center gap-4
                    transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-teal-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-calendar3 text-teal-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tahun Anggaran</p>
                    <p class="text-2xl font-bold text-gray-800">2024</p>
                </div>
            </div>

        </div>
    </div>
</section>

@section('scripts')
    <script>
        const canvasApb = document.getElementById("bg-network-apbdes");
        const ctxApb = canvasApb.getContext("2d");

        function resizeCanvasApb() {
            canvasApb.width = canvasApb.offsetWidth;
            canvasApb.height = canvasApb.offsetHeight;
        }
        resizeCanvasApb();
        window.addEventListener("resize", resizeCanvasApb);

        let particlesApb = [];
        const particleCountApb = 55;
        const maxDistanceApb = 140;

        for (let i = 0; i < particleCountApb; i++) {
            particlesApb.push({
                x: Math.random() * canvasApb.width,
                y: Math.random() * canvasApb.height,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                size: 2 + Math.random() * 1.8
            });
        }

        function animateApb() {
            ctxApb.clearRect(0, 0, canvasApb.width, canvasApb.height);

            particlesApb.forEach((p, index) => {
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0 || p.x > canvasApb.width) p.vx *= -1;
                if (p.y < 0 || p.y > canvasApb.height) p.vy *= -1;

                // DOT Warna Putih
                ctxApb.beginPath();
                ctxApb.fillStyle = "rgba(255,255,255,0.85)";
                ctxApb.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctxApb.fill();

                // LINE Warna Putih
                for (let j = index + 1; j < particlesApb.length; j++) {
                    const p2 = particlesApb[j];
                    const dist = Math.hypot(p.x - p2.x, p.y - p2.y);

                    if (dist < maxDistanceApb) {
                        ctxApb.strokeStyle = `rgba(255,255,255, ${1 - dist/maxDistanceApb})`;
                        ctxApb.lineWidth = 1;
                        ctxApb.beginPath();
                        ctxApb.moveTo(p.x, p.y);
                        ctxApb.lineTo(p2.x, p2.y);
                        ctxApb.stroke();
                    }
                }
            });

            requestAnimationFrame(animateApb);
        }
        animateApb();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },

                series: [{
                    name: 'Nilai (Rp)',
                    data: [
                        2150000000,
                        1870000000,
                        280000000,
                        80000000,
                        50000000
                    ]
                }],
                dataLabels: {
                    enabled: false
                },

                xaxis: {
                    categories: [
                        'Pendapatan',
                        'Belanja',
                        'Pembiayaan',
                        'Surplus/Defisit',
                        'SiLPA'
                    ]
                },

                colors: ['#16a34a', '#dc2626', '#2563eb', '#ca8a04', '#9333ea'],

                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        distributed: true,
                        columnWidth: '55%',
                    }
                },

                // ⭐ format number di sumbu Y
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            if (val >= 1000000000) return (val / 1e9).toFixed(2) + " M";
                            if (val >= 1000000) return (val / 1e6).toFixed(2) + " Jt";
                            return val.toLocaleString('id-ID');
                        }
                    }
                },

                // ⭐ Tooltip rupiah full
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toLocaleString("id-ID");
                        }
                    }
                },

                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartApbdes"), options);
            chart.render();


        });
    </script>
@endsection
