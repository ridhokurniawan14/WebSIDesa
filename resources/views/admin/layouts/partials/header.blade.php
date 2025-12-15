<header
    class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 z-10">

    {{-- Toggle Sidebar --}}
    <button @click="sidebarOpen = !sidebarOpen"
        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <div class="flex items-center gap-4">

        <div
            class="relative flex items-center bg-gray-100 dark:bg-gray-900 rounded-full p-1 border border-gray-200 dark:border-gray-700">

            <!-- System Option -->
            <button @click="setTheme('system')"
                :class="theme === 'system' ? 'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-white' :
                    'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'"
                class="rounded-full p-1.5 focus:outline-none transition-all duration-200" title="System Theme">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </button>

            <!-- Light Option -->
            <button @click="setTheme('light')"
                :class="theme === 'light' ? 'bg-white text-yellow-500 shadow-sm dark:bg-gray-700 dark:text-yellow-400' :
                    'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'"
                class="rounded-full p-1.5 focus:outline-none transition-all duration-200" title="Light Mode">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>

            <!-- Dark Option -->
            <button @click="setTheme('dark')"
                :class="theme === 'dark' ? 'bg-white text-indigo-500 shadow-sm dark:bg-gray-600 dark:text-indigo-400' :
                    'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'"
                class="rounded-full p-1.5 focus:outline-none transition-all duration-200" title="Dark Mode">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>

        {{-- Profile --}}
        @include('admin.layouts.partials.profile-dropdown')

    </div>
</header>
