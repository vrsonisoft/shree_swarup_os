<nav @class([
    'fixed w-full border-b border-gray-250/80 dark:border-gray-800/80 bg-white dark:bg-[#0B0F19] transition-all duration-150',
    'z-50' => request()->routeIs('pos.*'),
    'z-30' => !request()->routeIs('pos.*'),
])>
  @if (request()->routeIs('pos.*'))
    <div class="pointer-events-none absolute inset-x-0 top-0 bottom-0 z-0 hidden lg:block" aria-hidden="true">
      <div class="absolute inset-y-0 start-0 w-8/12 bg-white dark:bg-[#0B0F19] border-b border-gray-250 dark:border-gray-850"></div>
    </div>
  @endif
  
  <div @class([
    'px-4 lg:px-6 py-2 relative z-10',
  ])>
    <div class="flex items-center justify-between">

      <!-- Left Section: Logo & Mobile Toggle -->
      <div class="flex items-center gap-2">
        @if (!request()->routeIs('pos.*'))
          <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
            class="p-2 text-gray-500 rounded-xl lg:hidden hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-850 cursor-pointer">
            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
        @endif

        <a href="{{ route('dashboard') }}" class="flex items-center app-logo gap-2.5 min-w-fit">
          <x-restaurant-logo class="h-8 w-8 object-contain rounded-lg" />

          @if (restaurant()->show_logo_text)
          <span class="self-center text-base font-bold whitespace-nowrap dark:text-white hidden lg:block tracking-wide nav-brand-text">{{ Str::limit(restaurant()->name, 24) }}</span>
          @endif
        </a>

        @if (!request()->routeIs('pos.*'))
        <button id="btn-collapse-sidebar" onclick="window.toggleAdminSidebar(event)" type="button" class="lg:inline-flex items-center justify-center p-1.5 rounded-xl border border-gray-250 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 transition mx-1.5 hidden shadow-sm cursor-pointer" title="Toggle Sidebar">
          <!-- Menu expand icon (shows when sidebar is collapsed) -->
          <svg id="toggle-sidebar-open" class="hidden w-4 h-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
          </svg>
          <!-- Menu collapse icon (shows when sidebar is expanded) -->
          <svg id="toggle-sidebar-close" class="w-4 h-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7M19 19l-7-7 7-7"/>
          </svg>
         </button>
         @endif
      </div>

      <!-- Right Section: Toolbar Options -->
      <div class="flex items-center gap-1.5 sm:gap-2.5 w-fit justify-end">

        <!-- Branch Selector -->
        @if (branches() && count(branches()) > 1)
          @livewire('forms.change-branch')
        @else
          <div class="flex items-center gap-2 p-1 px-1.5 rounded-xl border border-transparent text-left">
              <div class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 shrink-0">
                  <i class="ti ti-building-store text-lg"></i>
              </div>
              <div class="flex flex-col min-w-0">
                  <span class="text-[8.5px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 leading-tight">Branch</span>
                  <span class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate pr-2 mt-0.5">{{ branch()->name }}</span>
              </div>
          </div>
        @endif

        <!-- Language Selector -->
        @if (languages()->count() > 1)
          @livewire('settings.languageSwitcher')
        @endif

        <!-- Upgrade & Trial Notices -->
        @if (restaurant()->package->package_type == \App\Enums\PackageType::DEFAULT)
            @php $upgradeText = __('modules.settings.upgradeLicense'); @endphp
            <a href="{{ route('pricing.plan') }}" wire:navigate class="hidden md:block inline-flex" data-tooltip-target="upgrade-tooltip-toggle" data-tooltip-placement="bottom">
                <x-secondary-button class="inline-flex items-center gap-2 shadow-sm text-skin-base dark:text-skin-base hover:origin-center group px-3" aria-label="{{ $upgradeText }}">
                    <i class="ti ti-rocket text-lg group-hover:scale-110 duration-500"></i>
                    <span class="hidden sm:inline">{{ $upgradeText }}</span>
                </x-secondary-button>
            </a>
            <div id="upgrade-tooltip-toggle" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                {{ $upgradeText }}
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        @elseif (restaurant()->package->package_type == \App\Enums\PackageType::TRIAL)
            @php
                $daysLeftInTrial = floor(now(timezone())->diffInDays(\Carbon\Carbon::parse(restaurant()->trial_ends_at)->addDays(1)));
                $trialText = $daysLeftInTrial > 0 ? $daysLeftInTrial .' ' . __('modules.package.daysLeftTrial') : __('modules.package.trialExpired');
            @endphp
            <a href="{{ route('pricing.plan') }}" wire:navigate class="hidden md:block inline-flex" data-tooltip-target="trial-tooltip-toggle" data-tooltip-placement="bottom">
                <button aria-label="{{ $trialText }}" class="cursor-pointer">
                    <span class="hidden sm:inline text-xs px-3 py-1.5 rounded-full font-semibold bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900/30">{{ $trialText }}</span>
                </button>
            </a>
            <div id="trial-tooltip-toggle" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                {{ $trialText }}
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        @endif

        <!-- Shortcut Buttons Group (Sequence: Orders, Reservations, Waiter Requests, Recent Orders, Tables, POS) -->
        <div class="flex items-center gap-1.5 md:gap-2">
          
          <!-- 1. Today's Orders -->
          @if (in_array('Order', restaurant_modules()) && (request()->routeIs('pos.*') || (user_can('Show Order') && restaurant()->hide_new_orders == 0)))
            @livewire('dashboard.todayOrders')
          @endif

          <!-- 2. Today's Reservations -->
          @if (in_array('Reservation', restaurant_modules()) && user_can('Show Reservation') && restaurant()->hide_new_reservations == 0 && in_array('Table Reservation', restaurant_modules()))
            @livewire('dashboard.todayReservations')
          @endif

          <!-- 3. Active Waiter Requests -->
          @if (in_array('Waiter Request', restaurant_modules()) && user_can('Manage Waiter Request') && restaurant()->hide_new_waiter_request == 0)
            @livewire('dashboard.activeWaiterRequests')
          @endif

          <!-- 4. Recent Orders (Orange Custom Masked Icon Button) -->
          @if (in_array('Table', restaurant_modules()) && user_can('Create Order'))
            <div x-data="recentOrdersModal()" @keydown.escape.window="closeRecentOrdersModal()">
              <button type="button" @click="openRecentOrdersModal()" data-tooltip-target="recent-orders-tooltip-toggle" class="inline-flex w-10 h-10 items-center justify-center rounded-xl bg-orange-50 dark:bg-orange-950/20 hover:bg-orange-100/50 transition cursor-pointer">
                <span class="w-5 h-5 bg-orange-600 dark:bg-orange-400 inline-block" style="-webkit-mask-image: url('{{ asset('img/icons/recent_order.png') }}'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; -webkit-mask-position: center; mask-image: url('{{ asset('img/icons/recent_order.png') }}'); mask-size: contain; mask-repeat: no-repeat; mask-position: center;"></span>
              </button>
              
              <!-- Flowbite Dark Tooltip -->
              <div id="recent-orders-tooltip-toggle" role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                  @lang('modules.dashboard.recentOrders')
                  <div class="tooltip-arrow" data-popper-arrow></div>
              </div>

              <!-- Recent Orders Modal -->
              <div x-show="showRecentOrdersModal" x-cloak x-transition.opacity class="fixed inset-0 z-[70] flex items-center justify-center p-4" style="display: none;">
                <div class="absolute inset-0 bg-black/50" @click="closeRecentOrdersModal()"></div>

                <div class="relative w-full max-w-3xl overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-800">
                  <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <div>
                      <h3 class="text-lg font-medium text-gray-900 dark:text-white">@lang('modules.dashboard.recentOrders')</h3>
                      <p class="text-xs text-gray-500 dark:text-gray-400">Showing latest 10 of <span x-text="recentOrders.length"></span> orders.</p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">
                        To view all orders, <a href="{{ route('orders.index') }}" wire:navigate class="text-skin-base hover:underline" @click="closeRecentOrdersModal()">click here</a>. You will be redirected to the Orders page.
                      </p>
                    </div>
                    <a href="{{ route('orders.index') }}" wire:navigate class="inline-flex items-center rounded-md border border-skin-base px-4 py-1.5 text-sm font-medium text-skin-base hover:bg-skin-base hover:text-white" @click="closeRecentOrdersModal()">
                      {{ __('app.view') }} {{ __('menu.orders') }}
                    </a>
                  </div>

                  <div class="max-h-[60vh] overflow-y-auto">
                    <template x-if="loadingRecentOrders">
                      <div class="space-y-2 p-4">
                        <div class="h-11 animate-pulse rounded-md bg-gray-100 dark:bg-gray-700"></div>
                        <div class="h-11 animate-pulse rounded-md bg-gray-100 dark:bg-gray-700"></div>
                        <div class="h-11 animate-pulse rounded-md bg-gray-100 dark:bg-gray-700"></div>
                      </div>
                    </template>

                    <template x-if="!loadingRecentOrders && recentOrdersError">
                      <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400" x-text="recentOrdersError"></p>
                    </template>

                    <template x-if="!loadingRecentOrders && !recentOrdersError && recentOrders.length === 0">
                      <p class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">@lang('messages.noRecordFound')</p>
                    </template>

                    <template x-if="!loadingRecentOrders && !recentOrdersError && recentOrders.length > 0">
                      <div>
                        <template x-for="order in recentOrders" :key="order.uuid">
                          <div class="border-b border-gray-200 dark:border-gray-700">
                            <button type="button" class="flex w-full items-center gap-3 px-6 py-3 text-left hover:bg-gray-50 dark:hover:bg-gray-700/40" @click="toggleRecentOrderDetails(order.uuid)">
                              <svg class="h-3 w-3 shrink-0 text-gray-500 transition-transform duration-200" :class="expandedOrderUuid === order.uuid ? 'rotate-90' : ''" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 5l6 5-6 5V5z"/>
                              </svg>
                              <span class="min-w-[90px] text-sm font-medium text-gray-900 dark:text-white" x-text="order.order_number"></span>
                              <span class="flex-1 truncate text-xs text-gray-500 dark:text-gray-400" x-text="order.customer_name"></span>
                              <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[11px] font-medium" :class="order.status_badge_class" x-text="order.status_label"></span>
                              <span class="min-w-[74px] text-right text-sm font-medium text-gray-900 dark:text-white" x-text="order.total"></span>
                              <span class="min-w-[72px] text-right text-xs text-gray-500 dark:text-gray-400" x-text="order.date_label"></span>
                              <span class="min-w-[44px] text-right">
                                <span class="text-sm text-skin-base hover:underline" @click.stop="handleRecentOrderView(order)">@lang('app.view')</span>
                              </span>
                            </button>

                            <div x-show="expandedOrderUuid === order.uuid" style="display: none;" class="grid grid-cols-1 gap-x-3 gap-y-2 bg-gray-50 px-11 py-3 text-xs sm:grid-cols-3 dark:bg-gray-900/30">
                              <p><span class="text-gray-500 dark:text-gray-400">@lang('modules.order.orderTypeLabel')</span><br><span class="text-gray-900 dark:text-white" x-text="order.order_type_label"></span></p>
                              <p><span class="text-gray-500 dark:text-gray-400">@lang('modules.order.paymentStatus')</span><br><span class="text-gray-900 dark:text-white" x-text="order.payment_status_label"></span></p>
                              <p><span class="text-gray-500 dark:text-gray-400">@lang('modules.order.totalItem')</span><br><span class="text-gray-900 dark:text-white" x-text="order.items_count"></span></p>
                              <p x-show="order.order_type !== 'delivery' && order.order_type !== 'pickup'" x-cloak><span class="text-gray-500 dark:text-gray-400">@lang('modules.settings.tableNumber')</span><br><span class="text-gray-900 dark:text-white" x-text="order.table_label"></span></p>
                              <p><span class="text-gray-500 dark:text-gray-400">@lang('modules.order.waiter')</span><br><span class="text-gray-900 dark:text-white" x-text="order.waiter_name"></span></p>
                              <p x-show="order.order_type === 'delivery'" x-cloak><span class="text-gray-500 dark:text-gray-400">@lang('modules.order.deliveryExecutive')</span><br><span class="text-gray-900 dark:text-white" x-text="order.delivery_executive_name"></span></p>
                              <p><span class="text-gray-500 dark:text-gray-400">@lang('app.date')</span><br><span class="text-gray-900 dark:text-white" x-text="order.created_at_label"></span></p>
                            </div>
                          </div>
                        </template>
                      </div>
                    </template>
                  </div>

                  <div class="flex items-center justify-between border-t border-gray-200 px-6 py-3 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">@lang('modules.order.totalOrder'): <span class="font-semibold text-gray-900 dark:text-white" x-text="recentOrders.length"></span></p>
                    <button type="button" @click="closeRecentOrdersModal()" class="inline-flex items-center rounded-md border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                      @lang('app.close')
                    </button>
                  </div>
                </div>
              </div>

            </div>
          @endif

          <!-- 5. Tables (Blue Custom Masked Icon Button) -->
          @if (in_array('Table', restaurant_modules()) && user_can('Show Table') && !request()->routeIs('tables.*'))
            <a href="{{ route('tables.index') }}" wire:navigate data-tooltip-target="tables-tooltip-toggle" class="inline-flex w-10 h-10 items-center justify-center rounded-xl border border-blue-250 dark:border-blue-900/60 bg-blue-50 dark:bg-blue-950/30 hover:bg-blue-100/50 transition cursor-pointer">
                <span class="w-5 h-5 bg-blue-600 dark:bg-blue-400 inline-block" style="-webkit-mask-image: url('{{ asset('img/icons/table.png') }}'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; -webkit-mask-position: center; mask-image: url('{{ asset('img/icons/table.png') }}'); mask-size: contain; mask-repeat: no-repeat; mask-position: center;"></span>
            </a>
            
            <!-- Flowbite Dark Tooltip -->
            <div id="tables-tooltip-toggle" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                @lang('menu.tables')
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          @endif

          <!-- 6. POS Button -->
          @if (!request()->routeIs('pos.*'))
            @livewire('dashboard.posShortCut')
          @endif
        </div>

        @if (request()->routeIs('pos.*'))
          <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex w-9.5 h-9.5 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100/50 transition cursor-pointer" title="@lang('menu.dashboard')">
              <i class="ti ti-layout-dashboard text-lg"></i>
          </a>
          @include('pos.partials.header-more-dropdown')
        @endif

        <!-- Fullscreen, Darkmode Theme Toggles -->
        <div class="hidden sm:flex items-center gap-1">
          <button onclick="openFullscreen();" type="button" data-tooltip-target="fullscreen-tooltip-toggle"
            class="text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/40 focus:outline-none rounded-xl p-2 cursor-pointer">
            <i class="ti ti-maximize text-lg"></i>
          </button>
          <div id="fullscreen-tooltip-toggle" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
            Fullscreen
            <div class="tooltip-arrow" data-popper-arrow></div>
          </div>

          <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
            class="text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/40 focus:outline-none rounded-xl p-2 cursor-pointer">
            <i id="theme-toggle-dark-icon" class="hidden ti ti-moon text-lg"></i>
            <i id="theme-toggle-light-icon" class="hidden ti ti-sun text-lg"></i>
          </button>
          <div id="tooltip-toggle" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
            @lang('app.toggleDarkMode')
            <div class="tooltip-arrow" data-popper-arrow></div>
          </div>
        </div>

        @livewire('restaurant.stop-impersonate-restaurant')
        @livewire('restaurant.restaurantOpenCloseToggle')

        <!-- User Profile Dropdown Button -->
        <div class="flex items-center gap-2 border-l border-gray-200 dark:border-gray-800 pl-3 relative" x-data="{ open: false }" @click.outside="open = false">
          <button type="button" @click="open = !open"
            class="flex items-center gap-2 text-left hover:bg-gray-50 dark:hover:bg-gray-800/40 p-1 px-1.5 rounded-xl transition duration-150 cursor-pointer"
            id="user-menu-button-2" aria-expanded="false">
            <img class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-800" src="{{ auth()->user()->profile_photo_path ? asset_url_local_s3(auth()->user()->profile_photo_path):auth()->user()->profile_photo_url }}" alt="user photo">
            
            <div class="hidden md:flex flex-col min-w-0 pr-1">
              <span class="text-[8.5px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-tight">Hello</span>
              <span class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate mt-0.5">{{ auth()->user()->name }}</span>
            </div>
            <i class="ti ti-chevron-down text-gray-400 text-[10px] hidden md:block"></i>
          </button>

          <!-- Dropdown menu -->
          <div x-show="open" x-cloak x-transition.opacity
            class="absolute right-0 top-full mt-2 z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700 w-52"
            id="dropdown-2">
            <div class="px-4 py-3" role="none">
              <p class="text-sm font-semibold text-gray-900 dark:text-white" role="none">
                {{ auth()->user()->name }}
              </p>
              <p class="text-xs text-gray-500 truncate dark:text-gray-400 mt-0.5" role="none">
                {{ auth()->user()->email }}
              </p>
            </div>
            <ul class="py-1" role="none">
              <li>
                <a href="{{ route('profile.show') }}" wire:navigate @click="open = false"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors"
                  role="menuitem">@lang('menu.profile')</a>
              </li>

              @if (user_can('Manage Settings') && in_array('Settings', restaurant_modules()))
              <li>
                <a href="{{ route('settings.index') }}" wire:navigate @click="open = false"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors"
                  role="menuitem">@lang('menu.settings')</a>
              </li>
              @endif

              <li>
                <form method="POST" action="{{ route('logout') }}" x-data>
                  @csrf
                  <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                    class="block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/20 transition-colors font-semibold"
                    role="menuitem">@lang('menu.signOut')</a>
                </form>
              </li>
            </ul>
          </div>
        </div>

        <!-- TV Screen / Kiosk / Customer Display Dropdown -->
        <div class="hidden sm:flex items-center relative" x-data="{ open: false }" @click.outside="open = false">
          <button type="button" @click="open = !open"
            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700/50 rounded-xl transition duration-150 cursor-pointer"
            id="user-menu-button-3" aria-expanded="false">
            <i class="ti ti-device-tv text-lg"></i>
          </button>
          
          <!-- Dropdown menu -->
          <div x-show="open" x-cloak x-transition.opacity
            class="absolute right-0 top-full mt-2 z-50 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700 w-52"
            id="dropdown-3">
            <ul class="py-1" role="none">
              @if (in_array('Customer Display', restaurant_modules()))
              <li>
                <a href="{{ route('customer.display') }}" target="_blank" @click="open = false"
                  class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors"
                  role="menuitem">@lang('menu.customerDisplay')</a>
              </li>
              <li>
                <a href="{{ route('customer.order-board') }}" target="_blank" @click="open = false"
                  class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors"
                  role="menuitem">@lang('modules.order.customerOrderBoard')</a>
              </li>
              @endif

              @if (module_enabled('Kiosk') && in_array('Kiosk', restaurant_modules()))
                <li>
                    <a href="{{ route('kiosk.restaurant', restaurant()->hash). '?branch=' . branch()->unique_hash }}" target="_blank" @click="open = false"
                    class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700/50 transition-colors"
                    role="menuitem">@lang('kiosk::modules.menu.kiosk')</a>
                </li>
              @endif
            </ul>
          </div>
        </div>

      </div>

    </div>
  </div>
</nav>
