@extends('admin.layouts.main')

@section('title', 'Tambah Pembangunan | Admin Panel')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-3">
                    <span
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Tambah Data Pembangunan
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Input data realisasi kegiatan pembangunan desa baru.
                </p>
            </div>
            <a href="{{ route('pembangunan.index') }}"
                class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors shadow-sm cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{-- REVISI 2: Autocomplete Off Global --}}
        <form action="{{ route('pembangunan.store') }}" method="POST" enctype="multipart/form-data" class="p-8"
            autocomplete="off">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">

                {{-- KOLOM KIRI: Identitas Proyek --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-emerald-600">#1</span> Identitas Kegiatan
                        </h3>
                    </div>

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama
                            Kegiatan</label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            placeholder="Contoh: Pembangunan Jalan Rabat Beton RT 01"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm transition-all hover:border-emerald-400">
                        @error('judul')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- REVISI 1: Dropdown Search Fix (Click Stop) --}}
                    <div x-data="dropdownSearch()" x-init="initData('{{ old('desa') }}')" class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Wilayah /
                            Dusun</label>

                        <input type="hidden" name="desa" :value="selected">

                        <button type="button" @click="toggle" @click.away="close"
                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 text-left shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 hover:border-emerald-400 flex justify-between items-center cursor-pointer">
                            <span x-text="selected ? selected : 'Pilih Dusun...'"
                                :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500'"></span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg max-h-60 overflow-hidden flex flex-col">

                            {{-- Input Search dengan @click.stop agar tidak menutup dropdown --}}
                            <div class="p-2 border-b border-gray-100 dark:border-gray-700">
                                <input type="text" x-model="search" @click.stop placeholder="Cari nama dusun..."
                                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg text-sm px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white placeholder-gray-400">
                            </div>

                            <ul class="overflow-y-auto flex-1 p-1 custom-scroll">
                                <template x-for="item in filteredOptions" :key="item">
                                    <li @click="selectOption(item)"
                                        class="px-3 py-2 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-gray-700 dark:text-gray-200 cursor-pointer rounded-lg text-sm transition-colors"
                                        :class="selected === item ? 'bg-emerald-50 text-emerald-700 font-medium' : ''">
                                        <span x-text="item"></span>
                                    </li>
                                </template>
                                <li x-show="filteredOptions.length === 0"
                                    class="px-3 py-2 text-gray-400 text-sm text-center">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                        @error('desa')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi Detail --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Lokasi
                            Detail</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: RT 02 / RW 01"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm transition-all hover:border-emerald-400">
                        @error('lokasi')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pelaksana --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pelaksana
                            Kegiatan</label>
                        <input type="text" name="pelaksana" value="{{ old('pelaksana') }}"
                            placeholder="Nama TPK atau Ketua Pelaksana"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm transition-all hover:border-emerald-400">
                    </div>
                </div>

                {{-- KOLOM KANAN: Teknis & Anggaran --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-emerald-600">#2</span> Teknis & Anggaran
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        {{-- Tahun --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                            <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm hover:border-emerald-400">
                        </div>
                        {{-- Volume --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Volume</label>
                            <input type="text" name="volume" value="{{ old('volume') }}"
                                placeholder="Ex: 200 m / 1 Paket"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm hover:border-emerald-400">
                        </div>
                    </div>

                    {{-- REVISI 3: Input Anggaran dengan Format Rupiah (AlpineJS) --}}
                    <div x-data="numberInput('{{ old('anggaran') }}')">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nilai
                            Anggaran</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                            </div>

                            {{-- Input Visual (Untuk User mengetik dengan titik) --}}
                            <input type="text" x-model="displayValue" @input="formatValue" placeholder="0"
                                class="block w-full rounded-xl border-gray-300 pl-14 py-3 focus:border-emerald-500 focus:ring-emerald-500 dark:bg-gray-700 dark:border-gray-600 hover:border-emerald-400 tracking-wide font-mono text-gray-700 dark:text-gray-200">

                            {{-- Input Hidden (Untuk dikirim ke Database, murni angka) --}}
                            <input type="hidden" name="anggaran" :value="rawValue">
                        </div>
                        @error('anggaran')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        {{-- Sumber Dana --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sumber
                                Dana</label>
                            <div class="relative">
                                <select name="sumber_dana"
                                    class="w-full appearance-none rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm cursor-pointer hover:border-emerald-400">
                                    <option value="" disabled {{ old('sumber_dana') ? '' : 'selected' }}>Pilih
                                        Sumber Dana</option>
                                    @foreach (['PADes', 'ADD', 'Dana Desa', 'BHPRD', 'BanProv', 'Dll'] as $sd)
                                        <option value="{{ $sd }}"
                                            {{ old('sumber_dana') == $sd ? 'selected' : '' }}>{{ $sd }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('sumber_dana')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <div class="relative">
                                <select name="status"
                                    class="w-full appearance-none rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 shadow-sm cursor-pointer hover:border-emerald-400">
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status
                                    </option>
                                    <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- KOLOM BAWAH FULL: Foto & Keterangan --}}
                <div class="col-span-1 lg:col-span-2 space-y-8 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-emerald-600">#3</span> Dokumentasi & Keterangan
                        </h3>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan /
                            Progres</label>
                        <textarea name="keterangan" rows="4" placeholder="Jelaskan detail pengerjaan atau persentase progres..."
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-emerald-500 focus:border-emerald-500 p-4 shadow-sm hover:border-emerald-400 transition-all">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Upload Foto --}}
                    <div x-data="imageUploader()" class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Foto Dokumentasi <span class="text-gray-400 font-normal ml-1">(Maksimal 5 Foto)</span>
                        </label>

                        <div class="flex flex-wrap gap-4 items-start">
                            <template x-for="(file, index) in files" :key="index">
                                <div
                                    class="relative group w-28 h-28 rounded-xl overflow-hidden shadow-md border border-gray-200 bg-white">
                                    <img :src="file.preview" class="w-full h-full object-cover">
                                    <button type="button" @click.prevent="removeFile(index)"
                                        class="absolute top-2 right-2 z-10 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md cursor-pointer transition-transform transform hover:scale-110 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <div x-show="files.length < 5">
                                <label
                                    class="flex flex-col items-center justify-center w-28 h-28 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-emerald-50 hover:border-emerald-400 hover:text-emerald-600 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span
                                            class="text-xs text-gray-500 group-hover:text-emerald-600 font-medium">Tambah</span>
                                    </div>
                                    <input type="file" class="hidden" accept="image/*" multiple
                                        @change="addFiles($event)">
                                </label>
                            </div>
                        </div>

                        <input type="file" name="foto[]" multiple class="hidden" x-ref="mainInput">

                        @error('foto')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        @error('foto.*')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div
                class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('pembangunan.index') }}"
                    class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition cursor-pointer">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 transition shadow-lg shadow-emerald-500/20 cursor-pointer flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // --- 1. SEARCHABLE DROPDOWN ---
        function dropdownSearch() {
            return {
                open: false,
                search: '',
                selected: '',
                options: ['Krajan Satu', 'Krajan Dua', 'Kaliputih', 'Temurejo', 'Pandan', 'Cendono', 'Ringinsari'],

                initData(oldValue) {
                    if (oldValue) this.selected = oldValue;
                },
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                },
                get filteredOptions() {
                    return this.search === '' ?
                        this.options :
                        this.options.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                },
                selectOption(item) {
                    this.selected = item;
                    this.close();
                    this.search = '';
                }
            }
        }

        // --- 2. NUMBER FORMATTER (RUPIAH) ---
        function numberInput(initialValue = '') {
            return {
                rawValue: initialValue, // Nilai murni (untuk DB)
                displayValue: '', // Nilai tampilan (ada titiknya)

                init() {
                    if (this.rawValue) {
                        this.formatDisplay(this.rawValue);
                    }
                },

                // Saat user mengetik
                formatValue(e) {
                    let val = e.target.value.replace(/[^0-9]/g, ''); // Hapus non-angka
                    this.rawValue = val;
                    this.formatDisplay(val);
                },

                // Format angka jadi ada titiknya
                formatDisplay(val) {
                    if (!val) {
                        this.displayValue = '';
                        return;
                    }
                    this.displayValue = parseInt(val).toLocaleString('id-ID');
                }
            }
        }

        // --- 3. IMAGE UPLOADER ---
        function imageUploader() {
            return {
                files: [],
                addFiles(event) {
                    const newFiles = Array.from(event.target.files);
                    if (this.files.length + newFiles.length > 5) {
                        alert("Maksimal hanya 5 foto yang diperbolehkan.");
                        return;
                    }
                    newFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.files.push({
                                file: file,
                                preview: e.target.result
                            });
                            this.updateMainInput();
                        };
                        reader.readAsDataURL(file);
                    });
                    event.target.value = '';
                },
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateMainInput();
                },
                updateMainInput() {
                    const dt = new DataTransfer();
                    this.files.forEach(i => dt.items.add(i.file));
                    this.$refs.mainInput.files = dt.files;
                }
            };
        }
    </script>
@endsection
