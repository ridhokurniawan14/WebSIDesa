@props(['title'])

<div class="relative group">
    <button class="mantine-font-size-lg flex items-center gap-1 px-2 py-1 text-white">
        {{ $title }}
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 9l6 6 6-6" />
        </svg>
    </button>

    <div
        class="hidden group-hover:block absolute left-0 top-full mt-0 z-50 w-52 bg-white text-gray-800 shadow-lg rounded">
        {{ $slot }}
    </div>
</div>
