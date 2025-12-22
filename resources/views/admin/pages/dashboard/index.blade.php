@extends('admin.layouts.main')

@section('title', 'Dashboard | Admin Panel')

@section('content')
    {{-- DEFINISI STATE ALPINE JS DISINI --}}
    <div x-data="{
        detailModalOpen: false,
        detail: { name: '', date: '', email: '', phone: '', subject: '', message: '' },
        showDetail(data) {
            this.detail = data;
            this.detailModalOpen = true;
        }
    }">

        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Overview</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Halo Ridho, inilah ringkasan aktivitas hari ini.</p>
                </div>
            </div>

            <a href="{{ route('admin.berita.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-all shadow-lg shadow-emerald-200 dark:shadow-none flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Berita Baru
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Berita</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_berita'] }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-gray-500">Terpublikasi di website</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pesan</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['total_pesan'] }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-blue-600 font-medium">Interaksi Warga</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Aktif Hari Ini</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $stats['admin_online'] }}</h3>
                    </div>
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-xs text-gray-500">Total User System: {{ $stats['total_user'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        Trafik Pengunjung
                    </h3>
                    <span class="text-xs text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">14 Hari
                        Terakhir</span>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col justify-center">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">Ringkasan Trafik</h3>
                    <p class="text-xs text-gray-500 mt-1">Akumulasi data pengunjung.</p>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div
                        class="p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                    {{ $stats['pengunjung_hari_ini'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Bulan Ini</p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                    {{ $stats['pengunjung_bulan_ini'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wide">Tahun Ini</p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-white">
                                    {{ $stats['pengunjung_tahun_ini'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        Berita Terakhir
                    </h3>
                    <a href="{{ route('admin.berita.index') }}"
                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua &rarr;</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($terbaru['berita'] as $berita)
                        <div
                            class="px-6 py-3 flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            @if ($berita->thumbnail)
                                <img src="{{ asset('storage/' . $berita->thumbnail) }}"
                                    class="w-10 h-10 rounded object-cover" alt="">
                            @else
                                <div
                                    class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                    No IMG</div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $berita->title }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $berita->created_at->diffForHumans() }} • <span
                                        class="text-emerald-600">{{ $berita->views ?? 0 }} Views</span></p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-500">Belum ada berita.</div>
                    @endforelse
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        Pesan Masuk Terbaru
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($terbaru['pesan'] as $pesan)
                        <div @click="showDetail({{ json_encode([
                            'name' => $pesan->nama_lengkap,
                            'date' => $pesan->created_at->translatedFormat('d F Y H:i'),
                            'email' => $pesan->email,
                            'phone' => $pesan->nomor_telepon ?? $pesan->nomor_hp, // Cek nama field DB kamu
                            'subject' => $pesan->subject,
                            'message' => $pesan->isi_pesan,
                        ]) }})"
                            class="px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer group">

                            <div class="flex justify-between mb-1">
                                <p
                                    class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                                    {{ $pesan->nama_lengkap }}</p>
                                <span class="text-xs text-gray-400">{{ $pesan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $pesan->subject }} -
                                {{ Str::limit($pesan->isi_pesan, 40) }}</p>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-500">Belum ada pesan masuk.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                        </svg>
                        Berita Paling Populer
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3">Judul Berita</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3 text-right">Views</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($terbaru['berita_populer'] as $populer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-3 font-medium text-gray-900 dark:text-white truncate max-w-xs">
                                        {{ $populer->title }}</td>
                                    <td class="px-6 py-3 text-gray-500">{{ $populer->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-3 text-right font-bold text-emerald-600">{{ $populer->views ?? 0 }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Data belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Login Aktivitas
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($terbaru['user_login'] as $log)
                        <div class="px-6 py-3 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($log->causer->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $log->causer->name ?? 'Sistem' }}</p>
                                <p class="text-xs text-gray-500">{{ $log->description }} •
                                    {{ $log->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-500">Belum ada log aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL PESAN (POPUP) --}}
        <div x-show="detailModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                @click="detailModalOpen = false">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="detailModalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">

                    <div class="flex justify-between items-center p-6 border-b dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pesan</h3>
                        <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Pengirim</label>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="detail.name"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Tanggal</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.date"></p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">Email</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.email"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase">No HP</label>
                                <p class="text-sm text-gray-700 dark:text-gray-300" x-text="detail.phone || '-'"></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase">Subject</label>
                            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400" x-text="detail.subject">
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase mb-2">Isi Pesan</label>
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed"
                                x-text="detail.message">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end">
                        <button type="button" @click="detailModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer shadow-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- END X-DATA --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('visitorChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pengunjung',
                    data: {!! json_encode($chartValues) !!},
                    borderWidth: 3,
                    borderColor: '#10b981',
                    backgroundColor: (context) => {
                        const bg = context.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        bg.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                        bg.addColorStop(1, 'rgba(16, 185, 129, 0)');
                        return bg;
                    },
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 13
                        },
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>
@endsection
