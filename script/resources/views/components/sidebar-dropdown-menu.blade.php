<li>
    <button type="button"
        @class([
            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium cursor-pointer w-full transition-all duration-200 group hover:scale-[1.01]',
            'border border-skin-base bg-skin-base/10 text-skin-base font-semibold shadow-sm' => $active,
            'border border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-800/60' => !$active
        ])
        aria-controls="dropdown-{{ \Str::slug($name, '-', app()->getLocale()) }}" data-collapse-toggle="dropdown-{{ \Str::slug($name, '-', app()->getLocale()) }}">
        
        <span @class([
            'w-5 h-5 flex items-center justify-center text-sm shrink-0 transition-colors [&>svg]:w-5 [&>svg]:h-5',
            'text-skin-base [&_svg]:!text-skin-base [&_svg_*]:!fill-current' => $active,
            'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200' => !$active
        ])>
            {!! $customIcon ?? $icon !!}
        </span>
        
        @if ($isAddon && app()->environment('demo'))
            <span class="flex-1 ltr:text-left rtl:text-right whitespace-nowrap truncate min-w-0 sidebar-item-name text-[13.5px] font-semibold" sidebar-toggle-item>{{ $name }}
                <span class="bg-yellow-400 text-white px-1.5 py-0.5 rounded text-xs inline-flex cursor-help">
                    @lang('app.addon')
                </span>
            </span>
        @else
            <span class="flex-1 ltr:text-left rtl:text-right whitespace-nowrap truncate min-w-0 sidebar-item-name text-[13.5px] font-semibold" sidebar-toggle-item>{{ $name }}</span>
        @endif

        <svg sidebar-toggle-item class="w-4 h-4 transition-transform duration-200 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    
    <ul id="dropdown-{{ \Str::slug($name, '-', app()->getLocale()) }}" @class(['mt-1.5 ml-4 pl-3.5 border-l border-gray-200 dark:border-gray-700/60 space-y-1.5', 'hidden' => !$active])>
        {{ $slot }}
    </ul>
</li>
