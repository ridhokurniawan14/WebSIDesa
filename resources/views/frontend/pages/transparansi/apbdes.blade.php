@extends('frontend.layouts.main')

@section('content')
    <style>
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(5px);
            }

            20% {
                opacity: 1;
                transform: translateY(0);
            }

            80% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(5px);
            }
        }

        .animate-fadeIn {
            animation: fadeInOut 2.8s ease-in-out;
        }
    </style>

    <div class="content-offset min-h-screen bg-gray-100 content-offset">
        {{-- Canvas ini diposisikan fixed di belakang konten --}}
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-60"></canvas>

        <!-- HERO SECTION & FILTER -->
        <div class="bg-gradient-to-r from-emerald-900 to-emerald-700 pb-28 pt-12 relative overflow-hidden">
            <!-- Pattern Dekoratif -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center text-white gap-4">
                    <div class="mb-2 md:mb-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="px-3 py-1 rounded-full bg-emerald-800 bg-opacity-50 border border-emerald-600 text-xs font-semibold tracking-wide uppercase text-emerald-100">
                                Transparansi Publik
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold tracking-tight">APBDes Tahun {{ $tahun }}</h1>
                        <p class="text-emerald-100 mt-2 text-lg">Laporan realisasi pelaksanaan Anggaran Pendapatan dan
                            Belanja Desa.</p>
                        <p class="text-emerald-200 text-xs mt-1 opacity-80 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Data per {{ date('d F Y') }}
                        </p>
                    </div>

                    <!-- Filter Tahun (Style Hijau Transparan, Option Putih) -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <div class="relative flex-grow md:flex-grow-0">
                            <form action="" id="tahunForm">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <!-- Icon Calendar Light/White -->
                                        <svg class="h-5 w-5 text-emerald-200" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    @php
                                        if (is_array($daftarTahun)) {
                                            rsort($daftarTahun);
                                        }
                                    @endphp

                                    <!-- Select Hijau, tapi Optionnya Putih -->
                                    <select name="tahun" id="tahunSelect"
                                        class="block w-full md:w-48 pl-10 pr-10 py-3 text-base border border-emerald-500/30 rounded-xl leading-6 bg-emerald-800/50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-emerald-800/80 transition cursor-pointer appearance-none font-semibold hover:bg-emerald-800/70">
                                        @foreach ($daftarTahun as $t)
                                            <!-- Class bg-white text-gray-900 memastikan dropdown putih bersih -->
                                            <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}
                                                class="bg-white text-gray-900 py-2 font-medium">
                                                Tahun {{ $t }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <!-- Icon Chevron Light -->
                                        <svg class="h-4 w-4 text-emerald-200" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20">

            <!-- RINGKASAN CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6 mb-8">
                @php
                    $cardStyles = [
                        'pendapatan' => [
                            'bg' => 'bg-emerald-400',
                            'icon' =>
                                'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        ],
                        'belanja' => [
                            'bg' => 'bg-rose-500',
                            'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                        ],
                        'pembiayaan' => [
                            'bg' => 'bg-teal-500',
                            'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
                        ],
                        'surplus' => [
                            'bg' => 'bg-cyan-500',
                            'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                        ],
                        'silpa' => [
                            'bg' => 'bg-indigo-500',
                            'icon' =>
                                'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                        ],
                    ];
                @endphp

                @foreach ($ringkasan as $key => $value)
                    @php
                        $style = $cardStyles[$key] ?? [
                            'bg' => 'bg-gray-500',
                            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        ];
                    @endphp
                    <div
                        class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-5 lg:p-6 transform hover:-translate-y-1 transition duration-300 relative overflow-hidden group border border-gray-100 flex flex-col justify-between h-full">
                        <div class="flex items-start justify-between relative z-10 w-full">
                            <div class="flex-1 pr-2">
                                <p
                                    class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $style['bg'] }}"></span>
                                    {{ ucfirst($key) }}
                                </p>
                                <!-- Perbaikan: Menghapus truncate/ellipsis agar angka muncul lengkap. break-words agar tidak overflow layout -->
                                <p class="text-lg lg:text-xl font-bold text-gray-800 tracking-tight break-words">
                                    Rp {{ number_format($value, 0, ',', '.') }}
                                </p>
                            </div>
                            <div
                                class="h-10 w-10 flex-shrink-0 rounded-xl {{ $style['bg'] }} bg-opacity-10 group-hover:bg-opacity-20 transition flex items-center justify-center">
                                <svg class="w-6 h-6 {{ str_replace('bg-', 'text-', $style['bg']) }}" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $style['icon'] }}"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Decorative bg shape -->
                        <div
                            class="absolute -bottom-6 -right-6 w-24 h-24 {{ $style['bg'] }} opacity-5 group-hover:opacity-10 transition rounded-full z-0">
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- GRAFIK UTAMA -->
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-6 md:p-8 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Grafik Pelaksanaan APBDes
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Perbandingan Pagu Anggaran vs Realisasi Tahun
                            {{ $tahun }}</p>
                    </div>
                    <!-- Legend Custom -->
                    <div class="flex gap-4 mt-4 md:mt-0 text-sm bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-slate-400"></span>
                            <span class="text-gray-600 font-medium">Anggaran</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-emerald-500"></span>
                            <span class="text-gray-600 font-medium">Realisasi</span>
                        </div>
                    </div>
                </div>

                <!-- Data Container untuk Grafik (Hidden) -->
                <div id="grafik-data-source" data-chart="{{ json_encode($pelaksanaan) }}" class="hidden"></div>

                <div id="grafikPelaksanaan" class="w-full h-96"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- DETAIL PENDAPATAN -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border-t-4 border-emerald-500 p-6 relative">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Rincian Pendapatan</h2>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Sumber
                            Masuk</span>
                    </div>

                    <div class="space-y-6">
                        @foreach ($pendapatan as $item)
                            @php
                                $persen = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                                // Gradasi warna bar berdasarkan capaian
                                $barColor = 'bg-emerald-500';
                                if ($persen < 50) {
                                    $barColor = 'bg-emerald-300';
                                } elseif ($persen < 80) {
                                    $barColor = 'bg-emerald-400';
                                }
                            @endphp

                            <div class="group">
                                <div class="flex justify-between items-end mb-1">
                                    <span
                                        class="font-semibold text-gray-700 text-sm group-hover:text-emerald-700 transition">{{ $item['nama'] }}</span>
                                    <span
                                        class="text-xs font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">{{ number_format($persen, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5 mb-2 overflow-hidden">
                                    <div class="h-2.5 {{ $barColor }} rounded-full transition-all duration-1000 ease-out relative"
                                        style="width: {{ $persen }}%">
                                        <!-- Shimmer effect -->
                                        <div
                                            class="absolute top-0 left-0 bottom-0 right-0 bg-gradient-to-r from-transparent via-white/20 to-transparent w-full -translate-x-full animate-[shimmer_2s_infinite]">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Pagu: <span class="font-medium text-gray-600">Rp
                                            {{ number_format($item['anggaran'], 0, ',', '.') }}</span></span>
                                    <span>Real: <span class="font-medium text-emerald-600">Rp
                                            {{ number_format($item['realisasi'], 0, ',', '.') }}</span></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- DETAIL BELANJA -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border-t-4 border-rose-500 p-6 relative">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-100 rounded-lg text-rose-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Rincian Belanja</h2>
                        </div>
                        <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded">Pengeluaran</span>
                    </div>

                    <div class="space-y-6">
                        @foreach ($pembelanjaan as $item)
                            @php
                                $persen = $item['anggaran'] > 0 ? ($item['realisasi'] / $item['anggaran']) * 100 : 0;
                                $barColor = 'bg-rose-500';
                                if ($persen < 50) {
                                    $barColor = 'bg-rose-300';
                                } elseif ($persen < 80) {
                                    $barColor = 'bg-rose-400';
                                }
                            @endphp

                            <div class="group">
                                <div class="flex justify-between items-end mb-1">
                                    <span
                                        class="font-semibold text-gray-700 text-sm group-hover:text-rose-700 transition">{{ $item['nama'] }}</span>
                                    <span
                                        class="text-xs font-bold px-2 py-0.5 rounded bg-rose-50 text-rose-700">{{ number_format($persen, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5 mb-2 overflow-hidden">
                                    <div class="h-2.5 {{ $barColor }} rounded-full transition-all duration-1000 ease-out relative"
                                        style="width: {{ $persen }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Pagu: <span class="font-medium text-gray-600">Rp
                                            {{ number_format($item['anggaran'], 0, ',', '.') }}</span></span>
                                    <span>Real: <span class="font-medium text-rose-600">Rp
                                            {{ number_format($item['realisasi'], 0, ',', '.') }}</span></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // --- PARTICLE ANIMATION LOGIC ---
        (function() {
            const canvas = document.getElementById('particleCanvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];

            // Konfigurasi Kepadatan dan Jarak
            // Semakin besar angka divider, semakin sedikit partikel (semakin renggang)
            const particleDensityDivider = 25000;
            // Jarak maksimal untuk menarik garis antar titik
            const connectionDistance = 150;

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            }

            class Particle {
                constructor() {
                    this.x = Math.random() * width;
                    this.y = Math.random() * height;
                    // Kecepatan sangat lambat agar santai
                    this.vx = (Math.random() - 0.5) * 0.3;
                    this.vy = (Math.random() - 0.5) * 0.3;
                    this.size = Math.random() * 2 + 1; // Ukuran titik variatif
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    // Bounce off edges
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    // Warna titik hijau pudar
                    ctx.fillStyle = 'rgba(16, 185, 129, 0.6)';
                    ctx.fill();
                }
            }

            function initParticles() {
                particles = [];
                const numberOfParticles = (width * height) / particleDensityDivider;
                for (let i = 0; i < numberOfParticles; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);

                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();

                    // Cek jarak dengan partikel lain untuk menggambar garis
                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < connectionDistance) {
                            ctx.beginPath();
                            // Semakin jauh, garis semakin transparan
                            const opacity = 1 - (distance / connectionDistance);
                            ctx.strokeStyle = 'rgba(16, 185, 129, ' + (opacity * 0.5) + ')'; // Line color sangat tipis
                            ctx.lineWidth = 1.5;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', () => {
                resize();
                initParticles();
            });

            resize();
            initParticles();
            animate();
        })();
    </script>
    <script>
        // Filter Tahun
        const tahunSelect = document.getElementById('tahunSelect');
        if (tahunSelect) {
            tahunSelect.addEventListener('change', function() {
                window.location.href = "/informasi/apbdes/" + this.value;
            });
        }

        // --- GRAFIK SETUP ---
        let chartData = [];
        try {
            const dataSource = document.getElementById('grafik-data-source');
            if (dataSource && dataSource.dataset.chart) {
                chartData = JSON.parse(dataSource.dataset.chart);
            }
        } catch (e) {
            console.warn('Gagal memuat data grafik:', e);
            chartData = [{
                    nama: 'Pendapatan',
                    anggaran: 0,
                    realisasi: 0
                },
                {
                    nama: 'Belanja',
                    anggaran: 0,
                    realisasi: 0
                },
                {
                    nama: 'Pembiayaan',
                    anggaran: 0,
                    realisasi: 0
                }
            ];
        }

        const dataAnggaran = chartData.map(item => item.anggaran);
        const dataRealisasi = chartData.map(item => item.realisasi);
        const dataKategori = chartData.map(item => item.nama);

        var options = {
            series: [{
                name: 'Anggaran',
                data: dataAnggaran
            }, {
                name: 'Realisasi',
                data: dataRealisasi
            }],
            chart: {
                type: 'bar',
                height: 400,
                fontFamily: 'inherit',
                toolbar: {
                    show: false
                },
                // Animasi saat load
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%', // Lebar batang
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top',
                    },
                },
            },
            dataLabels: {
                enabled: false // Matikan label angka di atas batang agar tidak penuh
            },
            // Konfigurasi State (Hover/Active) untuk mengatasi warna hilang
            states: {
                hover: {
                    filter: {
                        type: 'darken', // Ubah jadi darken atau none agar warna tidak jadi putih/hilang
                        value: 0.9
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'darken',
                        value: 0.9
                    }
                }
            },
            stroke: {
                show: true,
                width: 3, // Jarak antar batang
                colors: ['transparent']
            },
            xaxis: {
                categories: dataKategori,
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '13px',
                        fontWeight: 600
                    },
                    offsetY: 5
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#94a3b8'
                    },
                    formatter: function(value) {
                        // Format Miliar (M) dan Juta (Jt)
                        if (value >= 1000000000) return (value / 1000000000).toFixed(1) + ' M';
                        if (value >= 1000000) return (value / 1000000).toFixed(0) + ' Jt';
                        return value;
                    }
                }
            },
            fill: {
                opacity: 1
            },
            // Warna Chart: Abu-abu lebih gelap (Slate-400) dan Hijau Emerald (Emerald-500)
            colors: ['#94a3b8', '#10b981'],

            tooltip: {
                theme: 'light',
                style: {
                    fontSize: '13px'
                },
                y: {
                    formatter: function(val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val)
                    }
                },
                // Custom tooltip header agar lebih informatif
                x: {
                    show: true,
                    formatter: function(val) {
                        return val; // Nama kategori
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            },
            legend: {
                show: false // Kita pakai legend custom HTML
            }
        };

        var chartElement = document.querySelector("#grafikPelaksanaan");
        if (chartElement) {
            var chart = new ApexCharts(chartElement, options);
            chart.render();
        }
    </script>
@endsection
