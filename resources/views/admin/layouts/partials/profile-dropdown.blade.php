{{-- Profile Dropdown --}}
<div class="relative" x-data="{ dropdownOpen: false }">
    <button @click="dropdownOpen = !dropdownOpen" @click.outside="dropdownOpen = false"
        class="flex items-center gap-2 focus:outline-none text-left">

        {{-- AVATAR DINAMIS --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff"
            alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full border border-gray-300 dark:border-gray-600">

        <div class="hidden md:block">
            {{-- NAMA USER DINAMIS (Top Bar) --}}
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                {{ explode(' ', auth()->user()->name)[0] }}
            </p>
            {{-- ROLE USER DINAMIS (Top Bar - Opsional, ditampilkan kecil di bawah nama) --}}
            <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                {{ auth()->user()->roles->pluck('name')->implode(', ') ?? 'User' }}
            </p>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-4 h-4 text-gray-500 transition-transform"
            :class="dropdownOpen ? 'rotate-180' : ''">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    {{-- DROPDOWN MENU --}}
    <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 border border-gray-100 dark:border-gray-700 z-50"
        style="display: none;">

        {{-- User Info Header --}}
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400">Signed in as</p>

            {{-- NAMA LENGKAP --}}
            <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate mt-1">
                {{ auth()->user()->name }}
            </p>

            {{-- ROLE LABEL (Badge Style) --}}
            {{-- <div class="mt-1">
                <span
                    class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20 capitalize">
                    {{ auth()->user()->roles->pluck('name')->implode(', ') ?? 'No Role' }}
                </span>
            </div> --}}

            {{-- EMAIL --}}
            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">
                {{ auth()->user()->email }}
            </p>
        </div>

        <div class="py-1">
            {{-- Menu Profile --}}
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-400 group-hover:text-emerald-500 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Profile Saya
            </a>

            {{-- Menu Settings --}}
            <a href="#"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 text-gray-400 group-hover:text-emerald-500 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.42 24.42 0 010 3.46" />
                </svg>
                Pengaturan
            </a>
        </div>

        <form action="/admin/logout" method="POST" class="border-t border-gray-100 dark:border-gray-700 pt-1">
            @csrf
            {{-- Menu Logout --}}
            <button type="submit"
                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 group text-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 group-hover:text-red-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>
