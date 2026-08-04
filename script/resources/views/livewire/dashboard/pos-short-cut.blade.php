<div>
    <div class="relative">
        <a href="{{ route('pos.index') }}"
          class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#00B692] text-white hover:bg-[#009e7e] transition duration-150 text-xs font-bold shadow-sm cursor-pointer">
          <i class="ti ti-device-desktop text-base"></i>
          <span class="hidden lg:block uppercase tracking-wider">@lang('menu.pos')</span>
        </a>
        <div id="pos-shortcut-tooltip-toggle" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
            @lang('menu.pos')
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</div>
