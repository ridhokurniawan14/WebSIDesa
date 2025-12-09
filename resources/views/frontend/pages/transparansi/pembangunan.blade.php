@extends('frontend.layouts.main')

@section('content')

    @php
        /* ==========================
| DATA STATIS (EDIT DI SINI)
========================== */
        $pembangunanData = [
            [
                'slug' => 'pembangunan-1',
                'judul' => 'Pembangunan Jalan RT 2 RW 1',
                'desa' => 'Krajan Satu',
                'anggaran' => 51575000,
                'lokasi' => 'RT 2 / RW 1 - SUSUKAN KIDUL',
                'volume' => '200 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Hariyanto',
                'keterangan' => 'Pekerjaan sudah selesai 100%',
                'thumbnail' => '/img/pembangunan/1/thumb.jpg',
                'foto' => ['/img/pembangunan/1/1.jpg', '/img/pembangunan/1/2.jpg', '/img/pembangunan/1/3.jpg'],
            ],
            [
                'slug' => 'pembangunan-2',
                'judul' => 'TPT Sungai Dusun Pandan',
                'desa' => 'Pandan',
                'anggaran' => 87500000,
                'lokasi' => 'RT 1 / RW 2',
                'volume' => '150 m',
                'sumber_dana' => 'Dana Desa',
                'tahun' => '2024',
                'pelaksana' => 'Sutarman',
                'keterangan' => 'Progres 90%',
                'thumbnail' => '/img/pembangunan/2/thumb.jpg',
                'foto' => ['/img/pembangunan/2/1.jpg', '/img/pembangunan/2/2.jpg'],
            ],
        ];
    @endphp


    @php
        /* ==========================
| FILTER & PAGINATION
========================== */
        $selectedDesa = request('desa');
        $filtered = collect($pembangunanData)->filter(fn($i) => !$selectedDesa || $i['desa'] == $selectedDesa);

        $perPage = 6;
        $page = request('page', 1);
        $totalItems = $filtered->count();
        $totalPages = ceil($totalItems / $perPage);
        $items = $filtered->slice(($page - 1) * $perPage, $perPage);
    @endphp

    <style>
        .skeleton {
            background: linear-gradient(90deg, #eee, #f7f7f7, #eee);
            background-size: 200%;
            animation: loading 1.6s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200%;
            }

            100% {
                background-position: -200%;
            }
        }
    </style>

    <section class="content-offset py-12">
        <div class="max-w-7xl mx-auto px-4">

            <h1 class="text-3xl font-bold mb-10 text-center">Pembangunan Desa</h1>

            {{-- FILTER --}}
            <form method="GET" class="mb-10">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">

                    <select name="desa" class="border px-4 py-2 rounded-lg w-full sm:w-60">
                        <option value="">Semua Desa</option>
                        @foreach (['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'] as $desa)
                            <option value="{{ $desa }}" {{ request('desa') == $desa ? 'selected' : '' }}>
                                {{ $desa }}
                            </option>
                        @endforeach
                    </select>

                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg">
                        Filter
                    </button>

                </div>
            </form>

            {{-- GRID --}}
            <div id="gridContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- SKELETON --}}
                <template id="skeletonTemplate">
                    <div class="bg-white shadow-md rounded-xl overflow-hidden">
                        <div class="h-48 skeleton"></div>
                        <div class="p-5">
                            <div class="h-5 w-40 skeleton mb-3 rounded"></div>
                            <div class="h-4 w-28 skeleton mb-5 rounded"></div>
                            <div class="h-10 skeleton rounded"></div>
                        </div>
                    </div>
                </template>

                {{-- CARD --}}
                @foreach ($items as $item)
                    <div class="bg-white shadow-md rounded-xl overflow-hidden group real-content hidden">

                        <div class="h-48 overflow-hidden bg-gray-200 skeleton-wrapper">
                            <img src="{{ $item['thumbnail'] }}" class="w-full h-full object-cover opacity-0 transition"
                                onload="this.classList.remove('opacity-0'); this.parentNode.classList.remove('skeleton');">
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $item['judul'] }}</h3>

                            <p class="font-semibold text-emerald-600 mb-4">
                                Anggaran: Rp {{ number_format($item['anggaran'], 0, ',', '.') }}
                            </p>

                            <button onclick="openDetailModal(@json($item))"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg">
                                Lihat Detail
                            </button>
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            @if ($totalPages > 1)
                <div class="mt-10 flex justify-center gap-2">

                    @for ($i = 1; $i <= $totalPages; $i++)
                        <a href="?page={{ $i }}{{ $selectedDesa ? '&desa=' . $selectedDesa : '' }}"
                            class="px-4 py-2 border rounded-lg {{ $i == $page ? 'bg-emerald-600 text-white' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                </div>
            @endif

        </div>
    </section>


    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-3xl rounded-xl relative p-6">

            <button onclick="closeDetailModal()"
                class="absolute right-4 top-4 text-gray-600 hover:text-black text-2xl">&times;</button>

            <div id="modalContent"></div>

        </div>
    </div>


    {{-- SCRIPT --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const grid = document.getElementById("gridContainer");
            const skeletonTemplate = document.getElementById("skeletonTemplate");

            // Tambahkan skeleton sebanyak jumlah card asli
            const realCards = document.querySelectorAll(".real-content");
            realCards.forEach(() => {
                grid.appendChild(skeletonTemplate.content.cloneNode(true));
            });

            setTimeout(() => {
                document.querySelectorAll(".skeleton").forEach(s => s.remove());
                realCards.forEach(c => c.classList.remove("hidden"));
            }, 600);
        });


        function openDetailModal(item) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');

            let html = `
        <h2 class="text-2xl font-bold mb-5">${item.judul}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-6">
            <p><strong>Desa:</strong> ${item.desa}</p>
            <p><strong>Lokasi:</strong> ${item.lokasi}</p>
            <p><strong>Anggaran:</strong> Rp ${item.anggaran.toLocaleString('id-ID')}</p>
            <p><strong>Volume:</strong> ${item.volume}</p>
            <p><strong>Sumber Dana:</strong> ${item.sumber_dana}</p>
            <p><strong>Tahun:</strong> ${item.tahun}</p>
            <p class="col-span-2"><strong>Pelaksana:</strong> ${item.pelaksana}</p>
            <p class="col-span-2"><strong>Keterangan:</strong> ${item.keterangan}</p>
        </div>

        <h3 class="font-semibold mb-3">Foto Kegiatan:</h3>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            ${item.foto.map(img => `
                    <img src="${img}" onclick="zoomImage('${img}')"
                    class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80">
                `).join('')}
        </div>
    `;

            content.innerHTML = html;
            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function zoomImage(src) {
            const overlay = document.createElement('div');
            overlay.className = "fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[999]";
            overlay.innerHTML = `<img src="${src}" class="max-w-full max-h-full rounded-lg shadow-2xl">`;

            overlay.onclick = () => overlay.remove();
            document.body.appendChild(overlay);
        }
    </script>

@endsection
