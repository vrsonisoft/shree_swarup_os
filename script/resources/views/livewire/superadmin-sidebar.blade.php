<div>
    <aside id="sidebar"
        class="fixed top-0 ltr:left-0 rtl:right-0 z-20 flex flex-col flex-shrink-0 hidden w-56 min-w-[224px] bg-white dark:bg-[#0B0F19] text-gray-700 dark:text-gray-300 h-full pt-16 md:pt-12 lg:pt-16 font-normal duration-150 lg:flex transition-all border-r border-gray-200 dark:border-gray-800/80 shadow-md dark:shadow-xl"
        aria-label="Sidebar">
        
        <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white dark:bg-[#0B0F19]">
            
            <!-- Scrollable Navigation Items -->
            <div class="flex flex-col flex-1 pt-2 pb-24 overflow-y-auto px-2.5 [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-gray-800 [&::-webkit-scrollbar-thumb]:rounded-full">
                <ul class="py-1 space-y-0.5">

                    <!-- ── Overview ── -->
                    <li>
                        <p class="px-3 pt-3 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Overview</p>
                    </li>

                    @livewire('sidebar-menu-item', ['name' => __('menu.dashboard'), 'icon' => 'dashboard', 'link' => route('superadmin.dashboard'), 'active' => request()->routeIs('superadmin.dashboard')])

                    <!-- ── Management ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Management</p>
                    </li>

                    @if (user_can('Show Restaurant'))
                        @livewire('sidebar-menu-item', ['name' => __('superadmin.menu.restaurants'), 'icon' => 'restaurants', 'link' => route('superadmin.restaurants.index'), 'active' => request()->routeIs('superadmin.restaurants.*')])
                        @livewire('sidebar-menu-item', ['name' => __('superadmin.menu.impersonationLogs'), 'icon' => 'staff', 'link' => route('superadmin.impersonation-logs.index'), 'active' => request()->routeIs('superadmin.impersonation-logs.*')])
                    @endif

                    @if (user_can('Show Superadmin Payments'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.payments'), 'icon' => 'payments', 'link' => route('superadmin.restaurant-payments.index'), 'active' => request()->routeIs('superadmin.restaurant-payments.index')])
                    @endif

                    @if (user_can('Show Package'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.packages'), 'icon' => 'packages', 'link' => route('superadmin.packages.index'), 'active' => request()->routeIs('superadmin.packages.*')])
                    @endif

                    @if (user_can('Show Billing'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.billing'), 'icon' => 'billing', 'link' => route('superadmin.invoices.index'), 'active' => request()->routeIs('superadmin.invoices.*')])
                    @endif

                    @if (user_can('Show Offline Request'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.offlineRequest'), 'icon' => 'offline-plan-request', 'link' => route('superadmin.offline-plan-request'), 'active' => request()->routeIs('superadmin.offline-plan-request')])
                    @endif

                    @if (user_can('Show SuperAdmin'))
                        @livewire('sidebar-menu-item', ['name' => __('superadmin.menu.superadmin'), 'icon' => 'staff', 'link' => route('superadmin.users.index'), 'active' => request()->routeIs('superadmin.users.*')])
                    @endif

                    <!-- ── Content ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Content</p>
                    </li>

                    @if (user_can('Show Landing Site'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.landingSites'), 'icon' => 'landing', 'link' => route('superadmin.landing-sites.index'), 'active' => request()->routeIs('superadmin.landing-sites.*')])
                    @endif

                    <x-sidebar-dropdown-menu name="Tutorials" icon="landing" :active='request()->routeIs(["superadmin.tutorial-categories.*", "superadmin.tutorial-sub-categories.*", "superadmin.tutorials.*"])'>
                        @livewire('sidebar-dropdown-menu', ['name' => 'Categories', 'link' => route('superadmin.tutorial-categories.index'), 'active' => request()->routeIs('superadmin.tutorial-categories.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Sub Categories', 'link' => route('superadmin.tutorial-sub-categories.index'), 'active' => request()->routeIs('superadmin.tutorial-sub-categories.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Tutorials', 'link' => route('superadmin.tutorials.index'), 'active' => request()->routeIs('superadmin.tutorials.*')])
                    </x-sidebar-dropdown-menu>

                    @php
                        $inquiriesCount = 0;
                        $subscribesCount = 0;
                        try {
                            if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
                                $inquiriesCount = \App\Models\Contact::count();
                            }
                        } catch (\Throwable $e) {}
                        try {
                            if (\Illuminate\Support\Facades\Schema::hasTable('subscribes')) {
                                $subscribesCount = \DB::table('subscribes')->count();
                            }
                        } catch (\Throwable $e) {}
                    @endphp

                    <x-sidebar-dropdown-menu name="Website Settings" icon="settings" :active='request()->routeIs("superadmin.website-settings.*")'>
                        @livewire('sidebar-dropdown-menu', ['name' => 'Inquiries (' . $inquiriesCount . ')', 'link' => route('superadmin.website-settings.inquiries.index'), 'active' => request()->routeIs('superadmin.website-settings.inquiries.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Subscribes (' . $subscribesCount . ')', 'link' => route('superadmin.website-settings.subscribes.index'), 'active' => request()->routeIs('superadmin.website-settings.subscribes.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Social Settings', 'link' => route('superadmin.website-settings.social-settings.index'), 'active' => request()->routeIs('superadmin.website-settings.social-settings.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Features', 'link' => route('superadmin.website-settings.features.index'), 'active' => request()->routeIs('superadmin.website-settings.features.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'FAQs', 'link' => route('superadmin.website-settings.faqs.index'), 'active' => request()->routeIs('superadmin.website-settings.faqs.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Pricing FAQs', 'link' => route('superadmin.website-settings.pricing-faqs.index'), 'active' => request()->routeIs('superadmin.website-settings.pricing-faqs.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'App Reviews', 'link' => route('superadmin.website-settings.app-reviews.index'), 'active' => request()->routeIs('superadmin.website-settings.app-reviews.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Legal', 'link' => route('superadmin.website-settings.legal.index'), 'active' => request()->routeIs('superadmin.website-settings.legal.*')])
                        @livewire('sidebar-dropdown-menu', ['name' => 'Home Page', 'link' => route('superadmin.website-settings.home-page.index'), 'active' => request()->routeIs('superadmin.website-settings.home-page.*')])
                    </x-sidebar-dropdown-menu>

                    @foreach (custom_module_plugins() as $item)
                        @includeIf(strtolower($item) . '::sections.superadmin-sidebar')
                    @endforeach

                    <!-- ── Account ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Account</p>
                    </li>

                    @if (user_can('Manage Superadmin Settings'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.settings'), 'icon' => 'settings', 'link' => route('superadmin.superadmin-settings.index'), 'active' => request()->routeIs('superadmin.superadmin-settings.index')])
                    @endif

                </ul>
            </div>

            <!-- Bottom Actions Section (Log Out & Support Ticket) -->
            <div class="absolute bottom-0 left-0 w-full p-2 bg-white/95 dark:bg-[#0B0F19]/95 backdrop-blur-md border-t border-gray-200 dark:border-gray-800/80 space-y-1">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-2 py-1.5 rounded-xl border border-red-500/30 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 text-xs font-semibold transition cursor-pointer">
                        <i class="ti ti-logout-2 text-base"></i>
                        <span class="sidebar-item-name truncate">Log Out</span>
                    </button>
                </form>

                @if(global_setting()->show_support_ticket ?? true)
                    <a href="javascript:void(0)" onclick="window.dispatchEvent(new CustomEvent('open-raise-support-ticket'))"
                        class="w-full flex items-center justify-center gap-2 px-2 py-1.5 rounded-xl border border-skin-base/30 bg-skin-base/5 text-skin-base hover:bg-skin-base/10 text-xs font-semibold transition cursor-pointer sidebar-item-name">
                        <i class="ti ti-headset text-base"></i>
                        <span class="sidebar-item-name truncate">Support Ticket</span>
                    </a>
                @endif
            </div>
        </div>
    </aside>
</div>
