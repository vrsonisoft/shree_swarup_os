<div>
    @if ($variant === 'menu')
        <p class="px-3 pb-1 pt-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
            @lang('modules.settings.languageSettings')
        </p>
        <ul class="space-y-0.5 px-1 pb-0.5" role="none">
            @foreach (languages() as $item)
                <li wire:key="pos-menu-language-{{ $item->id }}">
                    <button
                        type="button"
                        wire:click="setLanguage('{{ $item->language_code }}')"
                        @class([
                            'flex w-full items-center gap-2.5 rounded-md px-3 py-2 text-left text-sm transition-colors',
                            'bg-gray-100 font-medium text-gray-900 dark:bg-gray-700 dark:text-white' => $activeLanguage->id === $item->id,
                            'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700' => $activeLanguage->id !== $item->id,
                        ])
                        role="menuitem">
                        <img class="h-4 w-4 shrink-0 rounded-full object-cover ring-1 ring-gray-200 dark:ring-gray-600" src="{{ $item->flagUrl }}" alt="">
                        <span class="min-w-0 flex-1 truncate">
                            {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$item->language_code] ?? $item->language_name }}
                        </span>
                        @if ($activeLanguage->id === $item->id)
                            <svg class="h-4 w-4 shrink-0 text-skin-base" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                            </svg>
                        @endif
                    </button>
                </li>
            @endforeach
        </ul>
    @else
        <button type="button" data-dropdown-toggle="language-dropdown"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-blue-50/80 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100/60 dark:hover:bg-blue-950/50 transition-colors duration-150 text-xs font-semibold cursor-pointer">
            <img class="h-4 w-4 shrink-0 rounded-full object-cover ring-1 ring-blue-200 dark:ring-blue-800" src="{{ $activeLanguage->flagUrl }}" alt="">
            <span class="hidden md:inline-flex">{{ isset(\App\Models\LanguageSetting::LANGUAGES_TRANS[$activeLanguage->language_code]) ? \App\Models\LanguageSetting::LANGUAGES_TRANS[$activeLanguage->language_code] : $activeLanguage->language_name }}</span>
            <i class="ti ti-chevron-down text-blue-400 text-[10px] ms-0.5"></i>
        </button>
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100 w-44 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700"
            id="language-dropdown">
            <ul class="py-1" role="none">
                @foreach (languages() as $item)
                    <li wire:key='language-{{ $item->id }}'>
                        <a href="javascript:;" wire:click="setLanguage('{{ $item->language_code }}')"
                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white transition-colors duration-150"
                            role="menuitem">
                            <div class="inline-flex items-center gap-2">
                                <img class="h-4 w-4 rounded-full object-cover" src="{{ $item->flagUrl }}" alt="">
                                {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$item->language_code] ?? $item->language_name }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
