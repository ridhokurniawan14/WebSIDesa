@extends('admin.layouts.main')
@section('title', 'Profile Saya | Admin Panel')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Transisi halus global */
        input,
        button,
        div,
        span,
        label,
        a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    {{-- Alpine Data: Handle Password Visibility --}}
    <div class="w-full pb-12" x-data="{ showPassword: false }" x-cloak>

        {{-- HEADER SECTION --}}
        <div
            class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-indigo-500">
                    <span>Admin</span>
                    <span class="mx-2 text-gray-300 dark:text-gray-500">/</span>
                    <span class="text-gray-400">Pengaturan Akun</span>
                </nav>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white flex items-center gap-3">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-lg text-white shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50">
                        {{-- User Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    Profile Saya
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ml-1">
                    Kelola informasi pribadi dan keamanan akun Anda di sini.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-6 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-all shadow-sm cursor-pointer">
                    Batal
                </button>

                <button form="profile-form" type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 transition-all cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        {{-- FORM START --}}
        <form id="profile-form" method="POST" action="{{ route('admin.profile.update') }}" autocomplete="off"
            class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: IDENTITAS (1 Kolom) --}}
                <div class="lg:col-span-1 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-6">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center gap-4 bg-gray-50 dark:bg-gray-800">
                            <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                            <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                Biodata Diri
                            </h3>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Input Nama --}}
                            <div>
                                <label for="name"
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input Email --}}
                            <div>
                                <label for="email"
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Alamat Email
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    required
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: PASSWORD (2 Kolom) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden h-full">
                        <div
                            class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-900 dark:text-white uppercase text-sm tracking-widest">
                                    Keamanan (Ganti Password)
                                </h3>
                            </div>

                            {{-- Toggle Password Button --}}
                            <button type="button" @click="showPassword = !showPassword"
                                class="text-xs font-bold text-gray-500 hover:text-indigo-600 flex items-center gap-2 cursor-pointer transition-colors">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                                <span x-text="showPassword ? 'Sembunyikan' : 'Lihat Password'"></span>
                            </button>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                            Kosongkan kolom password jika Anda tidak ingin mengubah password saat ini.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label for="password"
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Password Baru
                                </label>
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="Minimal 6 karakter">
                                @error('password')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label for="password_confirmation"
                                    class="block mb-2 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Ulangi Password Baru
                                </label>
                                <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                    name="password_confirmation"
                                    class="block w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="Ketik ulang password baru">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
