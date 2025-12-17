@php
    $isActive = function ($path) {
        return request()->is($path . '*') || request()->is('*/' . $path . '*');
    };

    $menus = [
        [
            'label' => 'Dashboard',
            'icon' =>
                'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z',
            'url' => 'admin/dashboard',
            'submenu' => [],
        ],
        [
            'label' => 'Profil Desa',
            'icon' =>
                'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75m-.75 3h.75m-.75 3h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
            'url' => 'admin/profil',
            'submenu' => [
                ['label' => 'Visi Misi', 'url' => 'admin/profil/visi-misi'],
                ['label' => 'Sejarah Desa', 'url' => 'admin/profil/sejarah'],
                ['label' => 'Perangkat Desa', 'url' => 'admin/profil/perangkat'],
                ['label' => 'Peta Desa', 'url' => 'admin/profil/peta'],
            ],
        ],
        [
            'label' => 'Informasi',
            'icon' =>
                'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z',
            'url' => 'admin/informasi',
            'submenu' => [
                ['label' => 'Syarat Administrasi', 'url' => 'admin/informasi/syarat'],
                ['label' => 'Berita', 'url' => 'admin/informasi/berita'],
                ['label' => 'Produk Hukum', 'url' => 'admin/informasi/hukum'],
            ],
        ],
        [
            'label' => 'Lembaga Desa',
            'icon' =>
                'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 5.223m0 0a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
            'url' => 'admin/lembaga',
            'submenu' => [
                ['label' => 'LPMD', 'url' => 'admin/lembaga/lpmd'],
                ['label' => 'Posyandu', 'url' => 'admin/lembaga/posyandu'],
                ['label' => 'PKK', 'url' => 'admin/lembaga/pkk'],
                ['label' => 'BUMDes', 'url' => 'admin/lembaga/bumdes'],
                ['label' => 'Karang Taruna', 'url' => 'admin/lembaga/karang-taruna'],
                ['label' => 'Koperasi Desa', 'url' => 'admin/lembaga/koperasi'],
            ],
        ],
        [
            'label' => 'Transparansi',
            'icon' =>
                'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
            'url' => 'admin/transparansi',
            'submenu' => [
                ['label' => 'APBDes', 'url' => 'admin/transparansi/apbdes'],
                ['label' => 'Pembangunan', 'url' => 'admin/transparansi/pembangunan'],
            ],
        ],
        [
            'label' => 'Galeri',
            'icon' =>
                'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
            'url' => 'admin/galeri',
            'submenu' => [],
        ],
        [
            'label' => 'Kontak',
            'icon' =>
                'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z',
            'url' => 'admin/kontak',
            'submenu' => [],
        ],
        [
            'label' => 'Setting',
            'icon' =>
                'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.212 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
            'url' => 'admin/setting',
            'submenu' => [
                ['label' => 'Aplikasi', 'url' => 'admin/setting/aplikasi'],
                ['label' => 'User', 'url' => 'admin/setting/user'],
                ['label' => 'Roles', 'url' => 'admin/setting/roles'],
                ['label' => 'Permission', 'url' => 'admin/setting/permissions'],
            ],
        ],
        [
            'label' => 'Log Activity',
            'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            'url' => 'admin/logactivity',
            'submenu' => [],
        ],
    ];

    $initialActiveAccordion = null;
    foreach ($menus as $menu) {
        if (!empty($menu['submenu'])) {
            // Cek Parent
            if ($isActive($menu['url'])) {
                $initialActiveAccordion = $menu['url'];
                break;
            }
            // Cek Children (Jaga-jaga jika parent URL tidak cocok secara prefix)
            foreach ($menu['submenu'] as $sub) {
                if (
                    request()->is($sub['url']) ||
                    request()->is($sub['url'] . '*') ||
                    request()->is('*/' . $sub['url'] . '*')
                ) {
                    $initialActiveAccordion = $menu['url'];
                    break 2;
                }
            }
        }
    }
@endphp

<div class="space-y-1" x-data="{ activeAccordion: '{{ $initialActiveAccordion }}', search: '' }">

    {{-- SEARCH INPUT (Hanya muncul saat sidebar Open) --}}
    <div class="px-3 mb-4 transition-all duration-300" x-show="sidebarOpen">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <input type="text" x-model="search" placeholder="Cari menu..."
                class="w-full bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-200 text-sm rounded-lg pl-9 pr-3 py-2
                       focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white dark:focus:bg-gray-700
                       border border-gray-200 dark:border-gray-700 placeholder-gray-400 transition-colors">
        </div>
    </div>

    @foreach ($menus as $menu)
        @php
            $childKeywords = !empty($menu['submenu']) ? collect($menu['submenu'])->pluck('label')->implode(' ') : '';
            $allKeywords = strtolower($menu['label'] . ' ' . $childKeywords);
        @endphp

        @if (empty($menu['submenu']))
            {{-- SINGLE MENU --}}
            @php $active = $isActive($menu['url']); @endphp

            <div class="relative group" x-data="{ top: 0 }" @mouseenter="top = $el.getBoundingClientRect().top"
                data-keywords="{{ $allKeywords }}"
                x-show="search === '' || $el.dataset.keywords.includes(search.toLowerCase())">

                <a href="{{ url($menu['url']) }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-lg transition-colors
                    {{ $active
                        ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                        : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}" />
                    </svg>
                    <span class="whitespace-nowrap font-medium transition-opacity duration-300" x-show="sidebarOpen">
                        {{ $menu['label'] }}
                    </span>
                </a>

                {{-- Hover Bridge (Single) --}}
                {{-- FIX: Gunakan left-60 dan pl-8 untuk overlap dan jembatan hover yang solid --}}
                <div x-show="!sidebarOpen" class="fixed left-[60px] pl-8 z-[9999] pointer-events-none hidden"
                    :class="!sidebarOpen ? 'group-hover:block' : ''" :style="'top: ' + (top + 10) + 'px'">
                    <div class="bg-gray-800 text-white text-xs rounded shadow-lg px-2 py-1 whitespace-nowrap">
                        {{ $menu['label'] }}
                    </div>
                </div>
            </div>
        @else
            {{-- DROPDOWN MENU --}}
            @php
                // Parent Active Logic: Check Parent OR Any Children
                $parentActive = $isActive($menu['url']);
                if (!$parentActive) {
                    foreach ($menu['submenu'] as $sub) {
                        if (
                            request()->is($sub['url']) ||
                            request()->is($sub['url'] . '*') ||
                            request()->is('*/' . $sub['url'] . '*')
                        ) {
                            $parentActive = true;
                            break;
                        }
                    }
                }
            @endphp

            <div class="relative group" x-data="{ top: 0 }" @mouseenter="top = $el.getBoundingClientRect().top"
                data-keywords="{{ $allKeywords }}"
                x-show="search === '' || $el.dataset.keywords.includes(search.toLowerCase())">

                <button
                    @click="
                        if (sidebarOpen) {
                            activeAccordion = (activeAccordion === '{{ $menu['url'] }}' ? null : '{{ $menu['url'] }}');
                        } else {
                            sidebarOpen = true;
                            activeAccordion = '{{ $menu['url'] }}';
                        }
                    "
                    class="w-full flex items-center justify-between px-3 py-3 rounded-lg transition-colors
                    {{ $parentActive
                        ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                        : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}" />
                        </svg>
                        <span class="whitespace-nowrap font-medium" x-show="sidebarOpen">{{ $menu['label'] }}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 transition-transform duration-200"
                        :class="(activeAccordion === '{{ $menu['url'] }}' || (search !== '' && $el.closest(
                            '[data-keywords]').dataset.keywords.includes(search.toLowerCase()))) ? 'rotate-180' : ''"
                        x-show="sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div x-show="sidebarOpen && (activeAccordion === '{{ $menu['url'] }}' || search !== '')" x-collapse
                    class="space-y-1 mt-1">
                    @foreach ($menu['submenu'] as $sub)
                        @php $subActive = request()->is($sub['url']) || request()->is('*/'.$sub['url']); @endphp
                        <a href="{{ url($sub['url']) }}" data-label="{{ strtolower($sub['label']) }}"
                            x-show="search === '' || $el.dataset.label.includes(search.toLowerCase())"
                            class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors pl-11
                            {{ $subActive
                                ? 'text-emerald-600 bg-emerald-50/50 font-medium dark:text-emerald-400 dark:bg-emerald-900/20'
                                : 'text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-300' }}">
                            <svg class="w-2 h-2 flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span>{{ $sub['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Hover Bridge (Dropdown) - Saat Sidebar Tertutup --}}
                {{-- FIX: Gunakan left-60 dan pl-8 untuk overlap dan jembatan hover yang solid --}}
                <div x-show="!sidebarOpen" class="fixed left-[60px] w-auto pl-8 z-[9999] hidden"
                    :class="!sidebarOpen ? 'group-hover:block' : ''" :style="'top: ' + top + 'px'">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 py-1 w-48">
                        <div
                            class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 mb-1">
                            {{ $menu['label'] }}
                        </div>
                        @foreach ($menu['submenu'] as $sub)
                            @php $subActive = request()->is($sub['url']) || request()->is('*/'.$sub['url']); @endphp
                            <a href="{{ url($sub['url']) }}"
                                class="block px-4 py-2 text-sm transition-colors
                                {{ $subActive
                                    ? 'text-emerald-600 bg-emerald-50 dark:text-emerald-400 dark:bg-emerald-900/20'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-emerald-600 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                                {{ $sub['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif
    @endforeach

    <div x-show="search !== '' && $el.parentElement.querySelectorAll('[data-keywords]:not([style*=\'display: none\'])').length === 0"
        class="px-4 py-4 text-center text-sm text-gray-400" style="display: none;">
        Menu tidak ditemukan
    </div>
</div>
