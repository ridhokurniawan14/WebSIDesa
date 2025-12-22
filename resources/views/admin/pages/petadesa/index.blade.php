@extends('admin.layouts.main')
@section('title', 'Peta Wilayah Desa | Admin Panel')

@section('content')
    {{-- CSS Leaflet & Geoman --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        #desaMap {
            height: 500px;
            width: 100%;
            z-index: 1;
            border-radius: 0.75rem;
        }

        .leaflet-pane {
            z-index: 1 !important;
        }

        .leaflet-top,
        .leaflet-bottom {
            z-index: 2 !important;
        }
    </style>

    <div class="w-full pb-12">
        {{-- HEADER --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Profil</span> <span class="mx-2 text-gray-300">/</span> <span class="text-gray-400">Peta Desa</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    {{ $peta ? 'Edit Peta Wilayah' : 'Buat Peta Wilayah' }}
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 shadow-sm cursor-pointer">
                    Reset
                </button>
                {{-- Tombol Simpan --}}
                @can($peta ? 'peta.update' : 'peta.create')
                    <button form="peta-form" type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-lg cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Peta
                    </button>
                @endcan
            </div>
        </div>

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        {{-- Action kita arahkan ke store() saja karena logic Single Row sudah dihandle disana --}}
        <form id="peta-form" method="POST" action="{{ route('admin.peta.store') }}" class="space-y-8">
            @csrf

            {{-- Hidden Inputs untuk Data Peta --}}
            <input type="hidden" name="koordinat_kantor" id="input_koordinat_kantor"
                value="{{ old('koordinat_kantor', $peta->koordinat_kantor ?? '') }}">
            <textarea name="polygon_wilayah" id="input_polygon_wilayah" class="hidden">{{ old('polygon_wilayah', json_encode($peta->polygon_wilayah ?? [])) }}</textarea>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Data Text --}}
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm">Data Wilayah</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            {{-- Input Luas dengan format angka --}}
                            <div x-data="{ val: '{{ number_format(old('luas_wilayah', $peta->luas_wilayah ?? 0), 0, ',', '.') }}', format(e) { let num = e.target.value.replace(/\D/g, '');
                                    this.val = new Intl.NumberFormat('id-ID').format(num ? num : 0); } }">
                                <label class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Luas
                                    Wilayah (m²)</label>
                                <input type="text" name="luas_wilayah" x-model="val" @input="format"
                                    class="block w-full text-sm border-gray-200 rounded-lg px-4 py-3 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                            </div>
                            <hr class="border-gray-100 dark:border-gray-700">
                            {{-- Input Batas --}}
                            <div class="grid grid-cols-1 gap-4">
                                @foreach (['utara', 'timur', 'selatan', 'barat'] as $arah)
                                    <div>
                                        <label class="block mb-1 text-xs font-bold text-gray-500 uppercase">Batas
                                            {{ ucfirst($arah) }}</label>
                                        <input type="text" name="batas_{{ $arah }}"
                                            value="{{ old('batas_' . $arah, $peta->{'batas_' . $arah} ?? '') }}"
                                            class="block w-full text-sm border-gray-200 rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Map Section --}}
                <div class="lg:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full flex flex-col">
                        <div
                            class="p-6 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm">Peta Interaktif</h3>
                            <span class="text-[10px] bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Tips: Gambar polygon
                                lalu klik simpan.</span>
                        </div>
                        <div class="p-4 relative flex-grow bg-gray-100 dark:bg-gray-900">
                            <div id="desaMap" class="shadow-inner border border-gray-300 dark:border-gray-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- SCRIPTS JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. SETUP MAP ---
            const defaultCenter = [-8.36770, 114.18542];
            const inputKantor = document.getElementById('input_koordinat_kantor');
            const inputPolygon = document.getElementById('input_polygon_wilayah');
            const formPeta = document.getElementById('peta-form');

            // Set Center Awal
            let centerMap = defaultCenter;
            if (inputKantor.value && inputKantor.value.includes(',')) {
                const split = inputKantor.value.split(',').map(item => parseFloat(item.trim()));
                if (split.length === 2 && !isNaN(split[0])) centerMap = split;
            }

            var map = L.map('desaMap').setView(centerMap, 15);
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 20
                }).addTo(map);

            // --- 2. MARKER KANTOR ---
            var marker = L.marker(centerMap, {
                draggable: true
            }).addTo(map);
            marker.bindPopup("Lokasi Kantor Desa").openPopup();

            // --- 3. GEOMAN SETUP (TOOLS GAMBAR) ---
            map.pm.addControls({
                position: 'topleft',
                drawCircle: false,
                drawCircleMarker: false,
                drawTextMessage: false,
                drawMarker: false,
                drawPolyline: false,
                drawRectangle: true,
                drawPolygon: true,
                editMode: true,
                dragMode: false,
                cutPolygon: false,
                removalMode: true
            });

            // --- 4. LOAD POLYGON EXISTING (HIJAU) ---
            const existingVal = inputPolygon.value;
            // Validasi string JSON sederhana
            if (existingVal && existingVal.length > 5 && existingVal !== 'null' && existingVal !== '""') {
                try {
                    // Bersihkan quote tambahan jika ada
                    let cleanJson = existingVal.replace(/^"|"$/g, '');
                    const latlngs = JSON.parse(cleanJson);

                    if (Array.isArray(latlngs) && latlngs.length > 0) {
                        let poly = L.polygon(latlngs, {
                            color: "#16a34a",
                            weight: 3
                        }).addTo(map);
                        map.fitBounds(poly.getBounds());

                        // Jika user menggambar polygon BARU, hapus yang lama (biar gak numpuk)
                        map.on('pm:create', (e) => {
                            map.removeLayer(poly);
                        });
                    }
                } catch (e) {
                    console.error("Error load polygon:", e);
                }
            }

            // --- 5. LOGIC SIMPAN (SCAN & FLIP KOORDINAT) ---
            formPeta.addEventListener('submit', function(e) {
                // A. Simpan Marker
                var mPos = marker.getLatLng();
                inputKantor.value = mPos.lat + ", " + mPos.lng;

                // B. Simpan Polygon
                let foundPolygon = null;

                // Cari layer polygon di peta
                map.eachLayer(function(layer) {
                    if (layer instanceof L.Polygon && !(layer instanceof L.Rectangle) && layer !==
                        marker) {
                        if (layer._latlngs) foundPolygon = layer;
                    }
                });

                if (foundPolygon) {
                    // 1. Ambil format GeoJSON (Standar: [Lng, Lat])
                    const geojson = foundPolygon.toGeoJSON();
                    const geoCoords = geojson.geometry.coordinates[0];

                    // 2. FLIP Koordinat jadi [Lat, Lng] sesuai DB
                    const finalData = geoCoords.map(pt => [pt[1], pt[0]]);

                    // 3. Masukkan ke Input Hidden
                    inputPolygon.value = JSON.stringify(finalData);
                } else {
                    inputPolygon.value = '';
                }
            });
        });
    </script>
@endsection
