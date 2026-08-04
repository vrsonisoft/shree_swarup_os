<li>
    <a
        href="{{ $link }}"
        @if($navigate) wire:navigate @endif
        @class([
            // Base styles
            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium cursor-pointer w-full transition-all duration-200 group hover:scale-[1.01]',
            // Active state: Outlined cyan/emerald box
            'border border-skin-base bg-skin-base/10 text-skin-base font-semibold shadow-sm' => $active,
            // Inactive state: Muted text
            'border border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-800/60' => !$active,
        ])
    >
        <span
            @class([
                'w-5 h-5 flex items-center justify-center text-sm shrink-0 transition-colors [&>svg]:w-5 [&>svg]:h-5',
                'text-skin-base [&_svg]:!text-skin-base [&_svg_*]:!fill-current' => $active,
                'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200' => !$active
            ])
        >
            {!! $customIcon ?? $icon !!}
        </span>
        <span class="truncate flex-1 min-w-0 sidebar-item-name text-[13.5px] font-semibold">{{ $name }}</span>
    </a>
</li>
