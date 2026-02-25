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

    <canvas id="bg-network-apbdes"></canvas>

    <div class="max-w-7xl mx-auto px-4 apbdes-content">

        <div data-aos="fade-in" data-aos-delay="100" class="text-center mb-10 text-white">
            <h2 class="text-3xl font-bold">APBDes Tahun {{ date('Y') }}</h2>
            <p class="opacity-90 mt-2">Rangkuman Anggaran Pendapatan dan Belanja Desa</p>
        </div>

        <div data-aos="flip-down" data-aos-delay="100" class="bg-white rounded-none shadow-lg p-6 mb-10">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik APBDes {{ date('Y') }}</h3>
            <div id="chartApbdes" class="w-full h-[350px]"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-green-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-coin text-green-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pendapatan Desa</p>
                    {{-- Menggunakan variabel dari Controller --}}
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($totalPendapatan, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-red-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-cash-stack text-red-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Belanja Desa</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($totalBelanja, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-blue-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-graph-up text-blue-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pembiayaan Desa</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($totalPembiayaan, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-yellow-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-piggy-bank text-yellow-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Surplus / Defisit</p>
                    {{-- Tambahkan class text-red-600 jika nilainya minus agar lebih jelas --}}
                    <p class="text-2xl font-bold {{ $surplusDefisit < 0 ? 'text-red-600' : 'text-gray-800' }}">
                        Rp {{ number_format($surplusDefisit, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-purple-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-wallet2 text-purple-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">SiLPA / SiKPA</p>
                    <p class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($silpa, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div data-aos="flip-down" data-aos-delay="100"
                class="bg-white p-6 rounded-none shadow flex items-center gap-4 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
                <div class="p-3 bg-teal-100 rounded-full transition-all duration-300 hover:scale-110">
                    <i class="bi bi-calendar3 text-teal-700 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tahun Anggaran</p>
                    <p class="text-2xl font-bold text-gray-800">{{ date('Y') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Bagian Scripts --}}
@section('scripts')
    {{-- Script Animasi Background (Tidak diubah) --}}
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
                ctxApb.beginPath();
                ctxApb.fillStyle = "rgba(255,255,255,0.85)";
                ctxApb.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctxApb.fill();
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

    {{-- Script Chart (DIPERBAIKI DESAINNYA) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit' // Agar font mengikuti website
                },
                series: [{
                    name: 'Nilai (Rp)',
                    // INJEK DATA DARI CONTROLLER DI SINI
                    data: [
                        {{ $totalPendapatan }},
                        {{ $totalBelanja }},
                        {{ $totalPembiayaan }},
                        {{ $surplusDefisit }},
                        {{ $silpa }}
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
                    ],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                // Warna bar
                colors: ['#16a34a', '#dc2626', '#2563eb', '#ca8a04', '#9333ea'],

                plotOptions: {
                    bar: {
                        // ⭐ PERBAIKAN DESAIN DI SINI ⭐
                        borderRadius: 0, // Ubah jadi 0 agar persegi tajam
                        distributed: true,
                        columnWidth: '50%', // Sedikit dirampingkan barnya
                    }
                },

                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px'
                        },
                        formatter: function(val) {
                            // Formatter untuk sumbu Y (Miliar/Juta)
                            // Kita gunakan Math.abs agar tanda minus tidak hilang saat dibagi
                            let absVal = Math.abs(val);
                            let prefix = val < 0 ? "-" : "";

                            if (absVal >= 1000000000) return prefix + (absVal / 1e9).toFixed(2) + " M";
                            if (absVal >= 1000000) return prefix + (absVal / 1e6).toFixed(2) + " Jt";
                            return val.toLocaleString('id-ID');
                        }
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            // Tooltip Hover: Pakai options untuk memaksa 2 digit desimal
                            return "Rp " + val.toLocaleString("id-ID", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                },

                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                legend: {
                    show: false
                } // Sembunyikan legend di bawah karena sudah ada label di sumbu X
            };

            var chart = new ApexCharts(document.querySelector("#chartApbdes"), options);
            chart.render();
        });
    </script>
@endsection
