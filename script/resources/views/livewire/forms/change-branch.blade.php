<div class="mb-1.5">

    @if (!in_array('Change Branch', restaurant_modules()))
    <button wire:click="$dispatch('showUpgradeLicense')" class="flex items-center gap-2 p-1.5 px-2.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 border border-gray-150 dark:border-gray-800 text-left transition-all duration-200 cursor-pointer" type="button">
        <div class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 shrink-0">
            <i class="ti ti-building-store text-base"></i>
        </div>
        <div class="flex flex-col min-w-0">
            <span class="text-[9px] font-medium text-gray-400 dark:text-gray-500 leading-none">Branch</span>
            <span class="text-[11.5px] font-semibold text-gray-800 dark:text-gray-200 truncate pr-1 mt-0.5 leading-none">Add Branch</span>
        </div>
        <i class="ti ti-rocket text-gray-400 text-xs ml-auto"></i>
    </button>
    @else
    <button id="changeBranchButton" data-dropdown-toggle="changeBranchDropdown" class="flex items-center gap-2 p-1.5 px-2.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 border border-transparent text-left transition-all duration-200 cursor-pointer" type="button">
        <div class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 shrink-0">
            <i class="ti ti-building-store text-base"></i>
        </div>
        <div class="flex flex-col min-w-0">
            <span class="text-[9px] font-medium text-gray-400 dark:text-gray-500 leading-none">Branch</span>
            <span class="text-[11.5px] font-semibold text-gray-800 dark:text-gray-200 truncate pr-1 mt-0.5 leading-none">{{ branch()->name }}</span>
        </div>
        <i class="ti ti-chevron-down text-gray-400 text-xs ml-auto"></i>
    </button>

    <!-- Dropdown menu -->
    <div id="changeBranchDropdown" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100 w-52 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="changeBranchButton">
            @foreach (branches() as $item)
            <li>
                <a href="javascript:;" wire:key='branch-{{ $item->id . microtime() }}' wire:click='updateBranch({{ $item->id }})' class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 dark:hover:text-white transition-colors duration-150">{{ $item->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

</div>
