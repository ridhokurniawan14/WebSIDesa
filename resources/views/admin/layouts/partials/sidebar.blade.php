<aside
    class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700
           flex flex-col transition-all duration-300 z-20 overflow-hidden"
    :class="sidebarOpen ? 'w-64' : 'w-20'">

    {{-- LOGO --}}
    <div class="h-16 flex items-center justify-center border-b border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-2 text-emerald-600 font-bold text-xl overflow-hidden whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 flex-shrink-0">
                <path
                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path
                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
            </svg>
            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap">
                Admin Desa
            </span>

        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
        @include('admin.layouts.partials.sidebar-menu')
    </nav>
</aside>
