<li x-data="{ active: @entangle('active') }" x-init="if (active) { setTimeout(() => { $el.scrollIntoView({ behavior: 'smooth' }); }, 400); }">
    <a href="{{ $link }}" wire:navigate
        @class([
            'flex items-center gap-2.5 px-3 py-2 text-xs font-medium transition-all duration-150 rounded-lg cursor-pointer hover:scale-[1.01]',
            'text-skin-base font-semibold bg-skin-base/10' => $active,
            'text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-100 dark:hover:bg-gray-800/40' => !$active
        ])>
        <span class="w-2 h-2 rounded-full {{ $active ? 'bg-skin-base' : 'bg-gray-400 dark:bg-gray-600' }} shrink-0"></span>
        <span class="truncate flex-1 min-w-0 sidebar-item-name text-[13px] font-semibold">{{ $name }}</span>
    </a>
</li>
