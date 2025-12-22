@extends('admin.layouts.main')
@section('title', 'Pengaturan Sistem | Admin Panel')

@section('content')
    <div class="w-full pb-12" x-data="{
        maintenance: {{ $isMaintenance ? 'true' : 'false' }},
        secret: '{{ $data['secret'] ?? 'admin-access' }}'
    }" x-cloak>

        {{-- HEADER --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Pengaturan</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">Sistem</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Maintenance Mode
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Aktifkan mode ini saat website sedang diperbaiki agar pengunjung tidak melihat error.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.system.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: STATUS SWITCH --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest mb-6">Status
                            Sistem</h3>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                x-text="maintenance ? 'Sedang Maintenance' : 'Website Online'"></span>

                            <button type="button" @click="maintenance = !maintenance"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                :class="maintenance ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'">
                                {{-- Tambah dark:bg-gray-600 --}}

                                <span class="sr-only">Use setting</span>

                                <span aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    :class="maintenance ? 'translate-x-5' : 'translate-x-0'">
                                </span>
                            </button>

                            <input type="checkbox" name="maintenance_mode" class="hidden" :checked="maintenance">
                        </div>

                        <p class="text-xs text-gray-500 leading-relaxed">
                            Jika <strong>ON</strong>, pengunjung akan melihat halaman 503 (Under Maintenance). Admin tetap
                            bisa mengakses lewat link khusus.
                        </p>

                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit"
                                class="w-full px-4 py-2 cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-lg transition-all">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KONFIGURASI --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 h-full"
                        x-show="maintenance" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100">

                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="w-1.5 h-8 bg-yellow-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Konfigurasi Tampilan
                            </h3>
                        </div>

                        {{-- Pesan Maintenance --}}
                        {{-- <div class="mb-6">
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase">Pesan Untuk
                                Pengunjung</label>
                            <input type="text" name="message"
                                value="{{ $data['message'] ?? 'Mohon maaf, sistem sedang dalam pemeliharaan dan peningkatan performa.' }}"
                                class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-colors"
                                placeholder="Contoh: Kami akan kembali dalam 1 jam.">
                        </div> --}}

                        {{-- Secret Key --}}
                        <div class="mb-6">
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase">Kode Akses Rahasia
                                (Bypass)</label>
                            <div class="flex gap-2">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    {{ url('/') }}/
                                </span>
                                <input type="text" name="secret" x-model="secret"
                                    class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-indigo-500 focus:border-indigo-500 block flex-1 min-w-0 w-full text-sm p-2.5"
                                    placeholder="kode-rahasia">
                            </div>
                            <p class="mt-2 text-[11px] text-gray-400">
                                *Link ini digunakan agar Anda tetap bisa mengakses website saat maintenance aktif.
                            </p>
                        </div>

                        {{-- Preview Link Bypass --}}
                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 mt-4">
                            <p class="text-xs font-bold text-indigo-800 mb-1">Link Akses Anda:</p>
                            <code class="text-xs text-indigo-600 break-all select-all block">
                                {{ url('/') }}/<span x-text="secret"></span>
                            </code>
                        </div>

                    </div>

                    {{-- Empty State kalau OFF --}}
                    <div x-show="!maintenance"
                        class="flex flex-col items-center justify-center h-full text-gray-400 py-12 border-2 border-dashed border-gray-200 rounded-xl">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                        <p class="text-sm">Maintenance Mode tidak aktif.</p>
                        <p class="text-xs mt-1">Website dapat diakses oleh publik secara normal.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
