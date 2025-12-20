@extends('admin.layouts.main')

@section('title', 'Edit Pembangunan | Admin Panel')

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white flex items-center gap-3">
                    <span
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                        {{-- Icon Pencil/Edit --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </span>
                    Edit Data Pembangunan
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                    Perbarui informasi realisasi kegiatan pembangunan.
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
        {{-- Form Edit: Method PUT --}}
        <form action="{{ route('pembangunan.update', $pembangunan->id) }}" method="POST" enctype="multipart/form-data"
            class="p-8" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">

                {{-- KOLOM KIRI: Identitas Proyek --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-amber-600">#1</span> Identitas Kegiatan
                        </h3>
                    </div>

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama
                            Kegiatan</label>
                        <input type="text" name="judul" value="{{ old('judul', $pembangunan->judul) }}"
                            placeholder="Contoh: Pembangunan Jalan Rabat Beton RT 01"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm transition-all hover:border-amber-400">
                        @error('judul')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Dropdown Search Wilayah --}}
                    <div x-data="dropdownSearch()" x-init="initData('{{ old('desa', $pembangunan->desa) }}')" class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Wilayah /
                            Dusun</label>

                        <input type="hidden" name="desa" :value="selected">

                        <button type="button" @click="toggle" @click.away="close"
                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 text-left shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 hover:border-amber-400 flex justify-between items-center cursor-pointer">
                            <span x-text="selected ? selected : 'Pilih Dusun...'"
                                :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500'"></span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg max-h-60 overflow-hidden flex flex-col">
                            <div class="p-2 border-b border-gray-100 dark:border-gray-700">
                                <input type="text" x-model="search" @click.stop placeholder="Cari nama dusun..."
                                    class="w-full border-gray-300 dark:border-gray-600 rounded-lg text-sm px-3 py-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white placeholder-gray-400">
                            </div>
                            <ul class="overflow-y-auto flex-1 p-1 custom-scroll">
                                <template x-for="item in filteredOptions" :key="item">
                                    <li @click="selectOption(item)"
                                        class="px-3 py-2 hover:bg-amber-50 dark:hover:bg-amber-900/30 text-gray-700 dark:text-gray-200 cursor-pointer rounded-lg text-sm transition-colors"
                                        :class="selected === item ? 'bg-amber-50 text-amber-700 font-medium' : ''">
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
                        <input type="text" name="lokasi" value="{{ old('lokasi', $pembangunan->lokasi) }}"
                            placeholder="Contoh: RT 02 / RW 01"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm transition-all hover:border-amber-400">
                        @error('lokasi')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pelaksana --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pelaksana
                            Kegiatan</label>
                        <input type="text" name="pelaksana" value="{{ old('pelaksana', $pembangunan->pelaksana) }}"
                            placeholder="Nama TPK atau Ketua Pelaksana"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm transition-all hover:border-amber-400">
                    </div>
                </div>

                {{-- KOLOM KANAN: Teknis & Anggaran --}}
                <div class="space-y-6">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-amber-600">#2</span> Teknis & Anggaran
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        {{-- Tahun --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                            <input type="number" name="tahun" value="{{ old('tahun', $pembangunan->tahun) }}"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm hover:border-amber-400">
                        </div>
                        {{-- Volume --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Volume</label>
                            <input type="text" name="volume" value="{{ old('volume', $pembangunan->volume) }}"
                                placeholder="Ex: 200 m"
                                class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm hover:border-amber-400">
                        </div>
                    </div>

                    {{-- Nilai Anggaran --}}
                    <div x-data="numberInput('{{ old('anggaran', $pembangunan->anggaran) }}')">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nilai
                            Anggaran</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                            </div>
                            <input type="text" x-model="displayValue" @input="formatValue" placeholder="0"
                                class="block w-full rounded-xl border-gray-300 pl-14 py-3 focus:border-amber-500 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 hover:border-amber-400 tracking-wide font-mono text-gray-700 dark:text-gray-200">

                            {{-- Input Hidden --}}
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
                                    class="w-full appearance-none rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm cursor-pointer hover:border-amber-400">
                                    <option value="" disabled>Pilih Sumber Dana</option>
                                    @foreach (['PADes', 'ADD', 'Dana Desa', 'BHPRD', 'BanProv', 'Dll'] as $sd)
                                        <option value="{{ $sd }}"
                                            {{ old('sumber_dana', $pembangunan->sumber_dana) == $sd ? 'selected' : '' }}>
                                            {{ $sd }}</option>
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
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <div class="relative">
                                <select name="status"
                                    class="w-full appearance-none rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 py-3 px-4 shadow-sm cursor-pointer hover:border-amber-400">
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Proses"
                                        {{ old('status', $pembangunan->status) == 'Proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="Selesai"
                                        {{ old('status', $pembangunan->status) == 'Selesai' ? 'selected' : '' }}>Selesai
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
                        </div>
                    </div>
                </div>

                {{-- KOLOM BAWAH FULL: Foto & Keterangan --}}
                <div class="col-span-1 lg:col-span-2 space-y-8 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-amber-600">#3</span> Dokumentasi & Keterangan
                        </h3>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Keterangan /
                            Progres</label>
                        <textarea name="keterangan" rows="4" placeholder="Jelaskan detail pengerjaan atau persentase progres..."
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-amber-500 focus:border-amber-500 p-4 shadow-sm hover:border-amber-400 transition-all">{{ old('keterangan', $pembangunan->keterangan) }}</textarea>
                    </div>

                    {{-- 
                         LOGIC IMAGE UPLOADER UNTUK EDIT 
                         Kita passing data foto existing ke init()
                    --}}
                    @php
                        // Format data existing ke bentuk array object JS
                        $existingPhotos = collect($pembangunan->foto)->map(function ($path) {
                            return [
                                'path' => $path, // Path database (untuk dikirim balik jika tidak dihapus)
                                'url' => asset('storage/' . $path), // URL untuk preview
                            ];
                        });
                    @endphp

                    <div x-data="imageUploaderEdit({{ $existingPhotos }})" class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Foto Dokumentasi <span class="text-gray-400 font-normal ml-1">(Maksimal 5 Foto)</span>
                        </label>

                        <div class="flex flex-wrap gap-4 items-start">

                            {{-- 1. Loop Foto LAMA (Existing) --}}
                            <template x-for="(photo, index) in existingFiles" :key="'exist-' + index">
                                <div
                                    class="relative group w-28 h-28 rounded-xl overflow-hidden shadow-md border border-amber-200 bg-white">
                                    <img :src="photo.url" class="w-full h-full object-cover">

                                    {{-- Tombol Hapus Foto Lama --}}
                                    <button type="button" @click.prevent="removeExisting(index)"
                                        class="absolute top-2 right-2 z-10 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md cursor-pointer transition-transform transform hover:scale-110 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    {{-- Input Hidden untuk memberi tahu backend foto ini DIPERTAHANKAN --}}
                                    {{-- Jika dihapus via tombol di atas, input ini juga ikut hilang --}}
                                    <input type="hidden" name="existing_foto[]" :value="photo.path">
                                </div>
                            </template>

                            {{-- 2. Loop Foto BARU (New Upload) --}}
                            <template x-for="(file, index) in newFiles" :key="'new-' + index">
                                <div
                                    class="relative group w-28 h-28 rounded-xl overflow-hidden shadow-md border border-gray-200 bg-white">
                                    <img :src="file.preview" class="w-full h-full object-cover">
                                    {{-- Tombol Hapus Foto Baru --}}
                                    <button type="button" @click.prevent="removeNew(index)"
                                        class="absolute top-2 right-2 z-10 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md cursor-pointer transition-transform transform hover:scale-110 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            {{-- 3. Tombol Tambah --}}
                            {{-- Muncul jika total (lama + baru) < 5 --}}
                            <div x-show="(existingFiles.length + newFiles.length) < 5">
                                <label
                                    class="flex flex-col items-center justify-center w-28 h-28 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-amber-50 hover:border-amber-400 hover:text-amber-600 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-amber-500 mb-1" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span
                                            class="text-xs text-gray-500 group-hover:text-amber-600 font-medium">Tambah</span>
                                    </div>
                                    <input type="file" class="hidden" accept="image/*" multiple
                                        @change="addNewFiles($event)">
                                </label>
                            </div>
                        </div>

                        {{-- Input Hidden untuk Foto Baru --}}
                        <input type="file" name="foto[]" multiple class="hidden" x-ref="newInput">

                        @error('foto')
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
                    class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-white bg-amber-600 rounded-xl hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 transition shadow-lg shadow-amber-500/20 cursor-pointer flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Perbarui Data
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
                    return this.search === '' ? this.options : this.options.filter(i => i.toLowerCase().includes(this
                        .search.toLowerCase()));
                },
                selectOption(item) {
                    this.selected = item;
                    this.close();
                    this.search = '';
                }
            }
        }

        // --- 2. NUMBER FORMATTER ---
        function numberInput(initialValue = '') {
            return {
                rawValue: initialValue,
                displayValue: '',
                init() {
                    if (this.rawValue) this.formatDisplay(this.rawValue);
                },
                formatValue(e) {
                    let val = e.target.value.replace(/[^0-9]/g, '');
                    this.rawValue = val;
                    this.formatDisplay(val);
                },
                formatDisplay(val) {
                    if (!val) {
                        this.displayValue = '';
                        return;
                    }
                    this.displayValue = parseInt(val).toLocaleString('id-ID');
                }
            }
        }

        // --- 3. IMAGE UPLOADER EDIT MODE ---
        function imageUploaderEdit(initialPhotos = []) {
            return {
                existingFiles: initialPhotos, // Data dari DB
                newFiles: [], // Data Upload Baru

                addNewFiles(event) {
                    const files = Array.from(event.target.files);
                    const total = this.existingFiles.length + this.newFiles.length + files.length;

                    if (total > 5) {
                        alert("Maksimal total hanya 5 foto.");
                        return;
                    }

                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.newFiles.push({
                                file: file,
                                preview: e.target.result
                            });
                            this.updateNewInput();
                        };
                        reader.readAsDataURL(file);
                    });
                    event.target.value = '';
                },

                removeExisting(index) {
                    // Hapus dari visual list.
                    // Karena input hidden digenerate di dalam loop x-for, 
                    // begitu item dihapus dari array, input hiddennya otomatis hilang dari DOM.
                    // Controller tidak akan menerima "existing_foto[]" untuk item ini -> Artinya dihapus.
                    this.existingFiles.splice(index, 1);
                },

                removeNew(index) {
                    this.newFiles.splice(index, 1);
                    this.updateNewInput();
                },

                updateNewInput() {
                    const dt = new DataTransfer();
                    this.newFiles.forEach(i => dt.items.add(i.file));
                    this.$refs.newInput.files = dt.files;
                }
            };
        }
    </script>
@endsection
