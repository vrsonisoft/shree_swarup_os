<div wire:id="rest-api-settings">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <div class="mx-4 p-6 mb-6 bg-white border border-gray-200/80 rounded-2xl shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800 transition-all duration-200">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-blue-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 shrink-0">
                    <svg class="w-6 h-6 text-white drop-shadow-md transition-transform duration-300 hover:scale-110 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 14.25V9.75M16.5 14.25V9.75M5.25 7.5H18.75C19.9926 7.5 21 8.50736 21 9.75V14.25C21 15.4926 19.9926 16.5 18.75 16.5H5.25C4.00736 16.5 3 15.4926 3 14.25V9.75C3 8.50736 4.00736 7.5 5.25 7.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.25 7.5V5.25C8.25 4.42157 8.92157 3.75 9.75 3.75H14.25C15.0784 3.75 15.75 4.42157 15.75 5.25V7.5M12 16.5V20.25M8.25 20.25H15.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="1.5" fill="white"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                        {{ __('applicationintegration::messages.fcmTitle') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ __('applicationintegration::messages.fcmDescription') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 mt-6 border-b border-gray-200 dark:border-gray-700">
            <button type="button" wire:click="switchTab('api_integration')"
                class="flex items-center gap-2.5 pb-3 px-4 border-b-2 text-sm font-semibold transition-all duration-150 {{ $activeTab === 'api_integration' ? 'border-skin-base text-skin-base bg-skin-base/5 dark:bg-skin-base/10 rounded-t-lg' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                <i class="fa fa-code text-base {{ $activeTab === 'api_integration' ? 'text-skin-base' : 'text-gray-400' }}"></i>
                <span>{{ __('applicationintegration::messages.tabApiIntegration') }}</span>
            </button>

            <button type="button" wire:click="switchTab('mobile_push')"
                class="flex items-center gap-2.5 pb-3 px-4 border-b-2 text-sm font-semibold transition-all duration-150 {{ $activeTab === 'mobile_push' ? 'border-skin-base text-skin-base bg-skin-base/5 dark:bg-skin-base/10 rounded-t-lg' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                <i class="fa fa-bell text-base {{ $activeTab === 'mobile_push' ? 'text-skin-base' : 'text-gray-400' }}"></i>
                <span>{{ __('applicationintegration::messages.tabMobilePush') }}</span>
            </button>
        </div>

        @if ($activeTab === 'api_integration')
        <div class="space-y-6 mt-6" x-data>
            
            <div class="bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200/80 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa fa-book text-lg"></i>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 mb-1">
                                <i class="fa fa-link text-[10px]"></i> {{ __('applicationintegration::messages.breadcrumb') }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('applicationintegration::messages.api_docs') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                {{ __('applicationintegration::messages.api_docs_help') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <a href="{{ $docUrl }}" target="_blank" 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-skin-base text-white shadow-sm shadow-skin-base/20 hover:opacity-90 active:scale-95 transition duration-150">
                            <i class="fa fa-external-link"></i>
                            <span>{{ __('applicationintegration::messages.open_docs') }}</span>
                        </a>
                        <button wire:click="copyDocs" onclick="window.aiInstantCopy('{{ $docUrl }}')" data-copy-link="{{ $docUrl }}" type="button" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 active:scale-95 transition duration-150">
                            <i class="fa fa-copy text-gray-400 dark:text-gray-300"></i>
                            <span>{{ __('applicationintegration::messages.copy_link') }}</span>
                        </button>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-between gap-3 text-sm font-mono text-gray-700 dark:text-gray-200 break-all shadow-inner">
                    <span class="truncate pl-1">{{ $docUrl }}</span>
                    <i class="fa fa-terminal text-gray-400 shrink-0 pr-1"></i>
                </div>
            </div>

            {{-- Card: Public Link --}}
            <div class="bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200/80 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa fa-globe text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('applicationintegration::app.public_link') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                {{ __('applicationintegration::messages.public_link_help') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <button wire:click="generatePublicLink" type="button" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-skin-base text-white shadow-sm shadow-skin-base/20 hover:opacity-90 active:scale-95 transition duration-150">
                            <i class="fa fa-bolt"></i>
                            <span>{{ __('applicationintegration::messages.generate_link') }}</span>
                        </button>

                        @if($publicLink)
                            <button wire:click="copyPublic" onclick="window.aiInstantCopy('{{ $publicLink }}')" data-copy-link="{{ $publicLink }}" type="button" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 active:scale-95 transition duration-150">
                                <i class="fa fa-copy text-gray-400"></i>
                                <span>{{ __('applicationintegration::messages.copy_link') }}</span>
                            </button>
                            <button wire:click="revokePublicLink" type="button" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-rose-200 dark:border-rose-800/60 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 active:scale-95 transition duration-150">
                                <i class="fa fa-trash"></i>
                                <span>{{ __('applicationintegration::messages.revoke_link') }}</span>
                            </button>
                        @endif
                    </div>
                </div>

                @if($publicLink)
                    <div class="mt-4 p-3 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800/50 rounded-xl flex items-center justify-between gap-3 text-sm font-mono text-emerald-700 dark:text-emerald-300 break-all shadow-inner">
                        <span class="truncate pl-1">{{ $publicLink }}</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-sans px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-md shrink-0">
                            <i class="fa fa-check-circle"></i> Active
                        </span>
                    </div>
                @else
                    <div class="mt-4 p-4 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 bg-white/50 dark:bg-gray-800/30 flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fa fa-info-circle text-gray-400 text-base"></i>
                        <span>{{ __('applicationintegration::messages.public_link_empty') }}</span>
                    </div>
                @endif
            </div>

            <div class="bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200/80 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4 flex-wrap pb-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa fa-stethoscope text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ __('applicationintegration::messages.tester_title') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                {{ __('applicationintegration::messages.tester_help') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-xs font-medium bg-white dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm">
                        <span class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                            <i class="fa fa-check-circle text-sm"></i> {{ __('applicationintegration::messages.status_ok') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-amber-600 dark:text-amber-400">
                            <i class="fa fa-exclamation-triangle text-sm"></i> {{ __('applicationintegration::messages.status_permission') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-rose-600 dark:text-rose-400">
                            <i class="fa fa-times-circle text-sm"></i> {{ __('applicationintegration::messages.status_fail') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
                    <div class="md:col-span-4 space-y-4 bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm h-fit">
                        <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 pb-2.5">
                            <i class="fa fa-user-shield text-skin-base"></i> Authentication
                        </h4>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase mb-1">
                                {{ __('applicationintegration::messages.username') }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa fa-envelope text-xs"></i>
                                </span>
                                <input type="text" wire:model.defer="email" 
                                    class="w-full pl-9 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm focus:ring-skin-base focus:border-skin-base transition" 
                                    placeholder="admin@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase mb-1">
                                {{ __('applicationintegration::messages.password') }}
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa fa-lock text-xs"></i>
                                </span>
                                <input type="password" wire:model.defer="password" 
                                    class="w-full pl-9 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm focus:ring-skin-base focus:border-skin-base transition" 
                                    placeholder="{{ __('applicationintegration::messages.password_placeholder') }}">
                            </div>
                        </div>

                        <button wire:click="runDiagnostics" wire:loading.attr="disabled" type="button" 
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold bg-skin-base text-white shadow-md shadow-skin-base/25 hover:opacity-95 active:scale-[0.98] disabled:opacity-50 transition duration-150">
                            <i class="fa fa-play" wire:loading.remove></i>
                            <i class="fa fa-spinner fa-spin" wire:loading></i>
                            <span wire:loading.remove>{{ __('applicationintegration::messages.run_test') }}</span>
                            <span wire:loading>{{ __('applicationintegration::messages.testing') }}</span>
                        </button>
                    </div>

                    <div class="md:col-span-8">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700/60 max-h-[500px] overflow-y-auto">
                            @forelse($results as $result)
                                <div class="flex items-center justify-between p-3.5 hover:bg-gray-50/80 dark:hover:bg-gray-700/40 transition">
                                    <div class="pr-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-xs font-bold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900 px-2 py-0.5 rounded">
                                                {{ $result['label'] }}
                                            </span>
                                            @if(!empty($result['http_status']))
                                                <span class="text-[11px] font-semibold text-gray-400">
                                                    HTTP {{ $result['http_status'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 leading-relaxed">
                                            {{ $result['message'] }}
                                        </p>
                                    </div>

                                    @php
                                        $color = $result['status'] === 'ok' ? 'bg-emerald-500 shadow-emerald-500/20' : ($result['status'] === 'permission' ? 'bg-amber-500 shadow-amber-500/20' : ($result['status'] === 'warn' ? 'bg-amber-500 shadow-amber-500/20' : 'bg-rose-500 shadow-rose-500/20'));
                                        $icon = $result['status'] === 'ok' ? 'fa-check' : ($result['status'] === 'permission' || $result['status'] === 'warn' ? 'fa-exclamation-triangle' : 'fa-times');
                                        $text = $result['status'] === 'ok' ? __('applicationintegration::messages.status_ok') : ($result['status'] === 'permission' ? __('applicationintegration::messages.status_permission') : ($result['status'] === 'warn' ? 'Warning' : __('applicationintegration::messages.status_fail')));
                                    @endphp
                                    
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full text-white shrink-0 shadow-sm {{ $color }}">
                                        <i class="fa {{ $icon }} text-[10px]"></i>
                                        <span>{{ $text }}</span>
                                    </span>
                                </div>
                            @empty
                                <div class="p-12 text-center text-gray-400 dark:text-gray-500">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-gray-700/50 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa fa-vial text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium">{{ __('applicationintegration::messages.no_tests') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Enter your account details on the left and click Run test to view the diagnostic results.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($activeTab === 'mobile_push')
        <div class="space-y-6 mt-6">

            <div class="bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200/80 dark:border-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    
                    <div class="lg:col-span-8 p-6 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-purple-500/20 shrink-0">
                                <i class="fa fa-truck text-xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                        {{ __('applicationintegration::messages.fcmDeliveryPartnerTitle') }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300">
                                        <i class="fa fa-motorcycle text-[10px]"></i> {{ __('applicationintegration::messages.deliveryPartner') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    {{ __('applicationintegration::messages.fcmDeliveryPartnerDescription') }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm">
                            <label class="flex items-center gap-3 cursor-pointer select-none">
                                <x-checkbox wire:model="deliveryPartnerEnabled" class="w-5 h-5 text-skin-base rounded border-gray-300" />
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                    {{ __('applicationintegration::messages.enableFirebaseNotifications') }}
                                </span>
                            </label>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm space-y-3">
                            <label class="block text-xs font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                <i class="fa fa-file-code-o text-purple-500"></i>
                                <span>{{ __('applicationintegration::messages.serviceAccountJsonFile') }}</span>
                            </label>
                            
                            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">
                                <label class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white text-sm font-semibold rounded-xl cursor-pointer shadow-sm active:scale-95 transition whitespace-nowrap">
                                    <i class="fa fa-upload text-gray-300"></i>
                                    <span>{{ __('applicationintegration::messages.chooseFile') }}</span>
                                    <input type="file" wire:model="deliveryPartnerJsonFile" accept="application/json" class="hidden">
                                </label>
                                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 w-full truncate">
                                    <i class="fa fa-file-text-o text-gray-400 shrink-0"></i>
                                    <span class="text-sm font-mono text-gray-600 dark:text-gray-300 truncate">
                                        {{ $deliveryPartnerJsonFile ? $deliveryPartnerJsonFile->getClientOriginalName() : ($deliveryPartnerFileName ?? __('applicationintegration::messages.noFileChosen')) }}
                                    </span>
                                </div>
                            </div>
                            <x-input-error for="deliveryPartnerJsonFile" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa fa-info-circle"></i> {{ __('applicationintegration::messages.uploadServiceAccountHelp') }}
                            </p>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center gap-1.5">
                                    <i class="fa fa-paper-plane text-skin-base"></i> {{ __('applicationintegration::messages.sendTestPush') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Send a test notification to the most recently accessed driver device.</p>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <button type="button" wire:click="sendTestPush('delivery_partner', 'android')" wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-emerald-300 dark:border-emerald-700/60 bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 active:scale-95 transition shadow-sm">
                                    <i class="fa fa-android text-sm"></i>
                                    <span>{{ __('applicationintegration::messages.testAndroidPush') }}</span>
                                </button>
                                <button type="button" wire:click="sendTestPush('delivery_partner', 'ios')" wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 dark:border-gray-600 bg-gray-100/60 dark:bg-gray-700/40 rounded-xl text-xs font-bold text-gray-800 dark:text-gray-200 hover:bg-gray-200 active:scale-95 transition shadow-sm">
                                    <i class="fa fa-apple text-sm"></i>
                                    <span>{{ __('applicationintegration::messages.testIosPush') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="button" wire:click="saveFcmSettings('delivery_partner')" wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-purple-500/25 hover:opacity-95 active:scale-95 transition duration-150">
                                <i class="fa fa-save text-base"></i>
                                <span>{{ __('applicationintegration::messages.saveDeliveryPartnerFcmSettings') }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="lg:col-span-4 bg-purple-50/70 dark:bg-purple-900/10 p-6 border-t lg:border-t-0 lg:border-l border-purple-100 dark:border-purple-900/30">
                        <div class="flex items-center gap-2 text-sm font-bold text-purple-900 dark:text-purple-300 mb-3">
                            <i class="fa fa-question-circle text-purple-600 dark:text-purple-400 text-base"></i>
                            <span>{{ __('applicationintegration::messages.generateServiceAccountJson') }}</span>
                        </div>
                        <ol class="text-xs text-purple-800 dark:text-purple-300/90 space-y-2.5 list-decimal list-inside leading-relaxed">
                            <li>{!! __('applicationintegration::messages.fcmStep1') !!}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep2') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep3') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep4') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep5') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep6') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep7') }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50/50 dark:bg-gray-900/60 border border-gray-200/80 dark:border-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    
                    <div class="lg:col-span-8 p-6 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 shrink-0">
                                <i class="fa fa-cutlery text-xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                        {{ __('applicationintegration::messages.fcmWaiterPosTitle') }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300">
                                        <i class="fa fa-tablet text-[10px]"></i> {{ __('applicationintegration::messages.waiterPos') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    {{ __('applicationintegration::messages.fcmWaiterPosDescription') }}
                                </p>
                            </div>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm">
                            <label class="flex items-center gap-3 cursor-pointer select-none">
                                <x-checkbox wire:model="waiterPosEnabled" class="w-5 h-5 text-skin-base rounded border-gray-300" />
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                    {{ __('applicationintegration::messages.enableFirebaseNotifications') }}
                                </span>
                            </label>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm space-y-3">
                            <label class="block text-xs font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                <i class="fa fa-file-code-o text-emerald-500"></i>
                                <span>{{ __('applicationintegration::messages.serviceAccountJsonFile') }}</span>
                            </label>
                            
                            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">
                                <label class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white text-sm font-semibold rounded-xl cursor-pointer shadow-sm active:scale-95 transition whitespace-nowrap">
                                    <i class="fa fa-upload text-gray-300"></i>
                                    <span>{{ __('applicationintegration::messages.chooseFile') }}</span>
                                    <input type="file" wire:model="waiterPosJsonFile" accept="application/json" class="hidden">
                                </label>
                                <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 w-full truncate">
                                    <i class="fa fa-file-text-o text-gray-400 shrink-0"></i>
                                    <span class="text-sm font-mono text-gray-600 dark:text-gray-300 truncate">
                                        {{ $waiterPosJsonFile ? $waiterPosJsonFile->getClientOriginalName() : ($waiterPosFileName ?? __('applicationintegration::messages.noFileChosen')) }}
                                    </span>
                                </div>
                            </div>
                            <x-input-error for="waiterPosJsonFile" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa fa-info-circle"></i> {{ __('applicationintegration::messages.uploadServiceAccountHelp') }}
                            </p>
                        </div>

                        <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center gap-1.5">
                                    <i class="fa fa-paper-plane text-skin-base"></i> {{ __('applicationintegration::messages.sendTestPush') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Send a test notification to the most recently connected waiter POS device.</p>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <button type="button" wire:click="sendTestPush('waiter_pos', 'android')" wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-emerald-300 dark:border-emerald-700/60 bg-emerald-50/50 dark:bg-emerald-900/20 rounded-xl text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 active:scale-95 transition shadow-sm">
                                    <i class="fa fa-android text-sm"></i>
                                    <span>{{ __('applicationintegration::messages.testAndroidPush') }}</span>
                                </button>
                                <button type="button" wire:click="sendTestPush('waiter_pos', 'ios')" wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 dark:border-gray-600 bg-gray-100/60 dark:bg-gray-700/40 rounded-xl text-xs font-bold text-gray-800 dark:text-gray-200 hover:bg-gray-200 active:scale-95 transition shadow-sm">
                                    <i class="fa fa-apple text-sm"></i>
                                    <span>{{ __('applicationintegration::messages.testIosPush') }}</span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="button" wire:click="saveFcmSettings('waiter_pos')" wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/25 hover:opacity-95 active:scale-95 transition duration-150">
                                <i class="fa fa-save text-base"></i>
                                <span>{{ __('applicationintegration::messages.saveWaiterPosFcmSettings') }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="lg:col-span-4 bg-emerald-50/70 dark:bg-emerald-900/10 p-6 border-t lg:border-t-0 lg:border-l border-emerald-100 dark:border-emerald-900/30">
                        <div class="flex items-center gap-2 text-sm font-bold text-emerald-900 dark:text-emerald-300 mb-3">
                            <i class="fa fa-question-circle text-emerald-600 dark:text-emerald-400 text-base"></i>
                            <span>{{ __('applicationintegration::messages.generateServiceAccountJson') }}</span>
                        </div>
                        <ol class="text-xs text-emerald-800 dark:text-emerald-300/90 space-y-2.5 list-decimal list-inside leading-relaxed">
                            <li>{!! __('applicationintegration::messages.fcmStep1') !!}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep2') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep3') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep4') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep5') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep6') }}</li>
                            <li>{{ __('applicationintegration::messages.fcmStep7') }}</li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

<script>
    if (!window.aiInstantCopy) {
        window.aiInstantCopy = (text) => {
            if (!text) return;
            const fallback = (t) => {
                const el = document.createElement('textarea');
                el.value = t;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                try { document.execCommand('copy'); } catch (e) {}
                document.body.removeChild(el);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).catch(() => fallback(text));
            } else {
                fallback(text);
            }
        };
    }

    document.addEventListener('livewire:load', () => {
        if (window.Livewire) {
            Livewire.on('ai-doc-link', (payload) => {
                const value = payload?.value ?? payload;
                if (!value) return;

                const copyFallback = (text) => {
                    const el = document.createElement('textarea');
                    el.value = text;
                    el.setAttribute('readonly', '');
                    el.style.position = 'absolute';
                    el.style.left = '-9999px';
                    document.body.appendChild(el);
                    el.select();
                    try { document.execCommand('copy'); } catch (e) {}
                    document.body.removeChild(el);
                };

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(value).catch(() => copyFallback(value));
                } else {
                    copyFallback(value);
                }

                if (window.toast) {
                    window.toast('{{ __('applicationintegration::messages.copy_link') }}', { type: 'success' });
                }
            });
            Livewire.on('ai-test-finished', () => {
                // UI feedback hook
            });
        }

        const directCopy = (text) => {
            if (!text) return;
            const fallback = (t) => {
                const el = document.createElement('textarea');
                el.value = t;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                try { document.execCommand('copy'); } catch (e) {}
                document.body.removeChild(el);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).catch(() => fallback(text));
            } else {
                fallback(text);
            }
        };

        const attachCopyHandlers = () => {
            document.querySelectorAll('[data-copy-link]').forEach(btn => {
                btn.onclick = () => {
                    const val = btn.getAttribute('data-copy-link') || btn.innerText;
                    directCopy(val);
                };
            });
        };

        attachCopyHandlers();
        if (window.Livewire) {
            Livewire.hook('message.processed', () => {
                attachCopyHandlers();
            });
        }
    });
</script>
