@extends('frontend.layouts.main')

@section('title', 'Data Wilayah Administratif')

@section('content')
    <div class="content-offset bg-gray-50 min-h-screen font-sans relative">

        {{-- PARTICLE CANVAS --}}
        <canvas id="particleCanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0 opacity-40"></canvas>

        {{-- HEADER SECTION --}}
        <section data-aos="fade-down" class="pt-24 pb-20 bg-white shadow-sm relative overflow-hidden">
            {{-- Green Gradient Line --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-500 to-emerald-600"></div>

            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <span
                    class="text-emerald-600 font-bold tracking-wider uppercase text-xs bg-emerald-50 px-3 py-1 rounded-full mb-3 inline-block border border-emerald-100">
                    Pemerintahan Desa
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-4 tracking-tight">
                    Data Wilayah <span class="text-emerald-600">Administratif</span>
                </h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">
                    Informasi lengkap struktur kewilayahan Dusun, Rukun Warga (RW), dan Rukun Tetangga (RT).
                </p>
            </div>

            {{-- Background Decoration (Green Blobs) --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-50 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-emerald-50 rounded-full opacity-50 blur-3xl">
            </div>
        </section>

        {{-- CONTENT SECTION --}}
        <section class="-mt-10 relative z-10 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- FILTER CARD --}}
                <div class="bg-white rounded-xl shadow-lg border border-green-100 p-6 mb-8" data-aos="fade-up">
                    <form action="{{ route('rtrw.index') }}" method="GET">
                        <div class="grid md:grid-cols-12 gap-5 items-end">

                            {{-- Search Input --}}
                            <div class="md:col-span-6">
                                <label
                                    class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 block ml-1">Pencarian</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="Cari Nama RW, RT, atau Ketua..."
                                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white block transition-all outline-none shadow-sm">
                                </div>
                            </div>

                            {{-- Filter Dusun --}}
                            <div class="md:col-span-4">
                                <label
                                    class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 block ml-1">Filter
                                    Dusun</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <select name="dusun" onchange="this.form.submit()"
                                        class="w-full pl-11 pr-8 py-3 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white block cursor-pointer outline-none shadow-sm appearance-none">
                                        <option value="">Semua Dusun</option>
                                        @foreach ($dusunOptions as $dusun)
                                            <option value="{{ $dusun }}"
                                                {{ request('dusun') == $dusun ? 'selected' : '' }}>
                                                Dusun {{ $dusun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Button Submit --}}
                            <div class="md:col-span-2">
                                <button type="submit"
                                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-md transition-colors duration-200 flex justify-center items-center gap-2">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- GRID DATA RW --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($data as $rw)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 border border-gray-100 hover:border-green-200 overflow-hidden transition-all duration-300 group"
                            data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">

                            {{-- Header Card (RW) --}}
                            <div
                                class="bg-gradient-to-br from-gray-50 to-white border-b border-gray-100 p-5 group-hover:from-green-50/30 group-hover:to-white transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        Dusun {{ $rw->dusun }}
                                    </span>
                                    <div class="bg-emerald-900 text-white text-xs font-bold px-2 py-1 rounded shadow-sm">
                                        RW {{ $rw->nomor_rw }}
                                    </div>
                                </div>
                                <h3
                                    class="text-gray-900 font-bold text-lg leading-tight group-hover:text-emerald-700 transition-colors">
                                    {{ $rw->nama_ketua_rw ?? 'Belum ada Ketua' }}
                                </h3>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mt-1">Ketua RW</p>
                            </div>

                            {{-- Body Card (List RT) --}}
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Daftar RT
                                    </h4>
                                    <span
                                        class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">{{ $rw->rts->count() }}
                                        RT</span>
                                </div>

                                <div
                                    class="space-y-2 max-h-48 overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent">
                                    @forelse ($rw->rts as $rt)
                                        <div
                                            class="flex justify-between items-center text-sm p-2 rounded-lg hover:bg-green-50 border border-transparent hover:border-green-100 transition-colors">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="font-bold text-emerald-600 bg-white border border-emerald-100 px-1.5 py-0.5 rounded text-xs shadow-sm">
                                                    RT {{ $rt->nomor_rt }}
                                                </span>
                                                <span class="text-gray-700 truncate max-w-[120px]"
                                                    title="{{ $rt->nama_ketua_rt }}">
                                                    {{ $rt->nama_ketua_rt ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-xs text-gray-400 italic bg-gray-50/50 rounded-lg">
                                            Belum ada data RT
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center bg-white rounded-xl shadow-sm border border-gray-100">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Data Tidak Ditemukan</h3>
                            <p class="text-gray-500 mt-1">Coba cari dengan kata kunci lain atau ubah filter dusun.</p>
                            @if (request()->hasAny(['q', 'dusun']))
                                <a href="{{ route('rtrw.index') }}"
                                    class="inline-block mt-4 text-emerald-600 hover:text-emerald-800 font-medium text-sm underline underline-offset-4 decoration-emerald-200 hover:decoration-emerald-500 transition-all">
                                    Reset Pencarian
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="mt-10">
                    {{ $data->links('pagination::tailwind') }}
                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        // PARTICLE SCRIPT (Update warna ke Hijau/Emerald)
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('particleCanvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let width, height;
                let particles = [];

                // Konfigurasi Warna Hijau (Emerald-500: #10b981)
                const particleColor = 'rgba(16, 185, 129, 0.5)';
                const lineColor = 'rgba(16, 185, 129, 0.2)';
                const density = 20000;
                const connectionDist = 120;

                function resize() {
                    width = canvas.width = window.innerWidth;
                    height = canvas.height = window.innerHeight;
                }

                class Particle {
                    constructor() {
                        this.x = Math.random() * width;
                        this.y = Math.random() * height;
                        this.vx = (Math.random() - 0.5) * 0.5;
                        this.vy = (Math.random() - 0.5) * 0.5;
                        this.size = Math.random() * 2 + 1;
                    }
                    update() {
                        this.x += this.vx;
                        this.y += this.vy;
                        if (this.x < 0 || this.x > width) this.vx *= -1;
                        if (this.y < 0 || this.y > height) this.vy *= -1;
                    }
                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        ctx.fillStyle = particleColor;
                        ctx.fill();
                    }
                }

                function initParticles() {
                    particles = [];
                    const count = (width * height) / density;
                    for (let i = 0; i < count; i++) {
                        particles.push(new Particle());
                    }
                }

                function animate() {
                    ctx.clearRect(0, 0, width, height);

                    for (let i = 0; i < particles.length; i++) {
                        particles[i].update();
                        particles[i].draw();

                        // Draw connections
                        for (let j = i; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const dist = Math.sqrt(dx * dx + dy * dy);

                            if (dist < connectionDist) {
                                ctx.beginPath();
                                ctx.strokeStyle = lineColor;
                                ctx.lineWidth = 1;
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
            }
        });
    </script>
@endsection
