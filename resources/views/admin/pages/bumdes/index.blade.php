@extends('admin.layouts.main')
@section('title', 'Kelola Profil BUMDes | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi halus dark mode */
        input,
        textarea,
        button,
        select,
        div,
        span,
        label,
        h1,
        h3 {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Hilangkan spinner di input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    {{-- PHP Logic --}}
    @php
        $pengurus = $bumdes?->pengurus ?? [['jabatan' => 'Direktur', 'nama' => '']];
        $unitUsaha = $bumdes?->unit_usaha ?? [['nama' => '', 'deskripsi' => '']];
        $misi = $bumdes?->misi ?? [''];

        if (empty($pengurus)) {
            $pengurus = [['jabatan' => '', 'nama' => '']];
        }
        if (empty($unitUsaha)) {
            $unitUsaha = [['nama' => '', 'deskripsi' => '']];
        }
        if (empty($misi)) {
            $misi = [''];
        }
    @endphp

    <div class="w-full pb-12" x-data="{
        pengurus: {{ \Illuminate\Support\Js::from($pengurus) }},
        unitUsaha: {{ \Illuminate\Support\Js::from($unitUsaha) }},
        misi: {{ \Illuminate\Support\Js::from($misi) }},
    
        addItem(type) {
            if (type === 'pengurus') this.pengurus.push({ jabatan: '', nama: '' });
            if (type === 'unitUsaha') this.unitUsaha.push({ nama: '', deskripsi: '' });
            if (type === 'misi') this.misi.push('');
        },
    
        removeItem(type, index) {
            if (this[type].length > 1) {
                this[type].splice(index, 1);
            } else {
                alert('Minimal satu data harus tersedia!');
            }
        }
    }" x-cloak>

        {{-- HEADER --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg text-white shadow-lg shadow-blue-200 dark:shadow-blue-900/50">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    Profil BUMDes
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">Kelola identitas, struktur pengurus, dan unit
                    usaha.</p>
            </div>

            <div class="flex items-center gap-3">
                @can('bumdes.update')
                    <button form="bumdes-form" type="submit"
                        class="cursor-pointer px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-200 dark:shadow-blue-900/50 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                @endcan
            </div>
        </div>

        {{-- FORM START (Autocomplete OFF Global) --}}
        <form id="bumdes-form" method="POST" action="{{ route('admin.bumdes.update', $bumdes?->id ?? 0) }}"
            class="space-y-8" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- CARD 1: IDENTITAS --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex items-center gap-4">
                            <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Identitas
                                Umum</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama
                                        BUMDes</label>
                                    <input type="text" name="nama" value="{{ old('nama', $bumdes->nama ?? '') }}"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                        placeholder="Contoh: BUMDes Maju Jaya">
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Slogan</label>
                                    <input type="text" name="slogan" value="{{ old('slogan', $bumdes->slogan ?? '') }}"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                        placeholder="Motto BUMDes...">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Tentang
                                    / Deskripsi</label>
                                <textarea name="tentang" rows="3"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                    placeholder="Deskripsi singkat profil...">{{ old('tentang', $bumdes->tentang ?? '') }}</textarea>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Visi</label>
                                <textarea name="visi" rows="2"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                    placeholder="Visi BUMDes...">{{ old('visi', $bumdes->visi ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: PENGURUS --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Struktur Pengurus</h3>
                            </div>
                            <button type="button" @click="addItem('pengurus')"
                                class="cursor-pointer text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-200 px-4 py-2 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <template x-for="(item, index) in pengurus" :key="index">
                                <div
                                    class="flex flex-col md:flex-row gap-4 items-start group bg-gray-50 dark:bg-gray-900/30 p-4 rounded-xl border border-transparent hover:border-indigo-200 dark:hover:border-indigo-900 transition-colors">
                                    <div class="flex-1 w-full">
                                        <input type="text" :name="`pengurus[${index}][jabatan]`" x-model="item.jabatan"
                                            class="block w-full px-4 py-3 text-sm font-semibold text-indigo-600 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-indigo-400"
                                            placeholder="Jabatan (ex: Direktur)">
                                    </div>
                                    <div class="flex-[2] w-full">
                                        <input type="text" :name="`pengurus[${index}][nama]`" x-model="item.nama"
                                            class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                            placeholder="Nama Lengkap Pejabat">
                                    </div>
                                    <button type="button" @click="removeItem('pengurus', index)"
                                        class="cursor-pointer p-3 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- CARD 3: UNIT USAHA --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-6 bg-green-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">Unit
                                    Usaha</h3>
                            </div>
                            <button type="button" @click="addItem('unitUsaha')"
                                class="cursor-pointer text-xs font-bold text-green-600 bg-green-50 border border-green-200 px-4 py-2 rounded-lg hover:bg-green-100 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800 transition-all">
                                + Unit
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <template x-for="(item, index) in unitUsaha" :key="index">
                                <div
                                    class="bg-gray-50 dark:bg-gray-900/30 p-5 rounded-xl border border-gray-200 dark:border-gray-700 flex gap-4 items-start group">
                                    <div class="flex-grow space-y-3">
                                        <input type="text" :name="`unit_usaha[${index}][nama]`" x-model="item.nama"
                                            class="block w-full px-4 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                            placeholder="Nama Unit Usaha">
                                        <textarea :name="`unit_usaha[${index}][deskripsi]`" x-model="item.deskripsi" rows="2"
                                            class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                            placeholder="Deskripsi layanan..."></textarea>
                                    </div>
                                    <button type="button" @click="removeItem('unitUsaha', index)"
                                        class="cursor-pointer text-gray-400 hover:text-red-500 mt-3 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="space-y-8">

                    {{-- CARD 4: KONTAK (With Prefix) --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest">Kontak &
                                Alamat</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Alamat
                                    Lengkap</label>
                                <textarea name="kontak[alamat]" rows="4"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('kontak.alamat', $bumdes->kontak['alamat'] ?? '') }}</textarea>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Email</label>
                                <input type="email" name="kontak[email]"
                                    value="{{ old('kontak.email', $bumdes->kontak['email'] ?? '') }}"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                            </div>

                            {{-- NOMOR TELEPON WITH PREFIX --}}
                            <div>
                                <label
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Telepon
                                    / WA</label>
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-gray-500 bg-gray-100 border border-r-0 border-gray-200 rounded-l-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 select-none">
                                        +
                                    </span>
                                    <input type="number" name="kontak[telepon]"
                                        value="{{ old('kontak.telepon', $bumdes->kontak['telepon'] ?? '') }}"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-r-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                        placeholder="62812345678">
                                </div>
                                <p class="mt-1 text-[10px] text-gray-400">Gunakan kode negara (Contoh: 628...)</p>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 5: MISI --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-6 bg-orange-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Daftar Misi</h3>
                            </div>
                            <button type="button" @click="addItem('misi')"
                                class="cursor-pointer text-xs font-bold text-orange-600 bg-orange-50 border border-orange-200 px-4 py-2 rounded-lg hover:bg-orange-100 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-800 transition-all">+
                                Item</button>
                        </div>
                        <div class="p-6 space-y-3">
                            <template x-for="(item, index) in misi" :key="index">
                                <div class="flex gap-2 items-center group">
                                    <span class="text-gray-400 text-xs font-mono w-6 text-center"
                                        x-text="index+1+'.'"></span>
                                    <input type="text" name="misi[]" x-model="misi[index]"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                                        placeholder="Poin misi...">
                                    <button type="button" @click="removeItem('misi', index)"
                                        class="cursor-pointer text-gray-400 hover:text-red-500 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
