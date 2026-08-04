<div>
    <aside id="sidebar"
        class="fixed top-0 ltr:left-0 rtl:right-0 z-20 flex flex-col flex-shrink-0 hidden w-56 min-w-[224px] bg-white dark:bg-[#0B0F19] text-gray-700 dark:text-gray-300 h-full pt-16 md:pt-12 lg:pt-16 font-normal duration-150 lg:flex transition-all border-r border-gray-200 dark:border-gray-800/80 shadow-md dark:shadow-xl"
        aria-label="Sidebar">
        
        <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white dark:bg-[#0B0F19]">
            
            <!-- Branch Switcher moved to Header Toolbar -->

            <!-- Scrollable Navigation Items -->
            <div class="flex flex-col flex-1 pt-2 pb-24 overflow-y-auto px-2.5 [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-gray-800 [&::-webkit-scrollbar-thumb]:rounded-full">
                <ul class="py-1 space-y-0.5">

                    <!-- ── Overview ── -->
                    <li>
                        <p class="px-3 pt-3 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Overview</p>
                    </li>

                    @livewire('sidebar-menu-item', ['name' => __('menu.dashboard'), 'icon' => 'dashboard', 'link' => route('dashboard'), 'active' => request()->routeIs('dashboard')])

                    <!-- ── Management ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Management</p>
                    </li>

                    @if ($this->hasModule('Menu') || $this->hasModule('Menu Item') || $this->hasModule('Item Category'))
                        @if (user_can('Show Menu') || user_can('Show Menu Item') || user_can('Show Item Category'))
                            <x-sidebar-dropdown-menu :name='__("menu.menu")' icon='menu' :active='request()->routeIs(["menus.*", "menu-items.*", "item-categories.*", "item-modifiers.*", "modifier-groups.*"])'>
                                @if($this->hasModule('Menu'))
                                    @if(user_can('Show Menu'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.menus'), 'link' => route('menus.index'), 'active' => request()->routeIs('menus.index')])
                                    @endif
                                @endif

                                @if($this->hasModule('Menu Item'))
                                    @if(user_can('Show Menu Item'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.menuItem'), 'link' => route('menu-items.index'), 'active' => request()->routeIs(['menu-items.index', 'menu-items.bulk-import', 'menu-items.entities.sort', 'menu-items.create', 'menu-items.edit'])])
                                    @endif
                                @endif

                                @if($this->hasModule('Item Category'))
                                    @if(user_can('Show Item Category'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemCategories'), 'link' => route('item-categories.index'), 'active' => request()->routeIs('item-categories.index')])
                                    @endif
                                @endif

                                @if($this->hasModule('Menu Item'))
                                    @if(user_can('Show Menu Item'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.modifierGroups'), 'link' => route('modifier-groups.index'), 'active' => request()->routeIs('modifier-groups.index', 'modifier-groups.create', 'modifier-groups.edit')])
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemModifiers'), 'link' => route('item-modifiers.index'), 'active' => request()->routeIs('item-modifiers.index')])
                                    @endif
                                @endif
                            </x-sidebar-dropdown-menu>
                        @endif
                    @endif

                    @if ($this->hasModule('Area') || $this->hasModule('Table'))
                        @if (user_can('Show Area') || user_can('Show Table'))
                            <x-sidebar-dropdown-menu :name='__("menu.tables")' icon='table' :active='request()->routeIs(["areas.*", "tables.*", "qrcodes.index"])'>
                                @if ($this->hasModule('Area'))
                                    @if(user_can('Show Area'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.areas'), 'link' => route('areas.index'), 'active' => request()->routeIs('areas.index')])
                                    @endif
                                @endif

                                @if ($this->hasModule('Table'))
                                    @if(user_can('Show Table'))
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.tables'), 'link' => route('tables.index'), 'active' => request()->routeIs('tables.index')])
                                        @livewire('sidebar-dropdown-menu', ['name' => __('menu.qrCodes'), 'link' => route('qrcodes.index'), 'active' => request()->routeIs('qrcodes.index')])
                                    @endif
                                @endif
                            </x-sidebar-dropdown-menu>
                        @endif
                    @endif

                    @if ($this->hasModule('Waiter Request') && user_can('Manage Waiter Request'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.waiterRequest'), 'icon' => 'waiterRequest', 'link' => route('waiter-requests.index'), 'active' => request()->routeIs('waiter-requests.*')])
                    @endif

                    @if ($this->hasModule('Reservation') && user_can('Show Reservation'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.reservations'), 'icon' => 'reservations', 'link' => route('reservations.index'), 'active' => request()->routeIs('reservations.index')])
                    @endif

                    @if ($this->hasModule('Order') && user_can('Create Order'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.pos'), 'icon' => 'pos', 'link' => route('pos.index'), 'active' => request()->routeIs('pos.*'), 'navigate' => false])
                    @endif

                    @if ($this->hasModule('Kitchen') && in_array('kitchen', custom_module_plugins()))
                        @if ($this->hasModule('Order') && user_can('Show Order'))
                            @livewire('sidebar-menu-item', ['name' => __('menu.orders'), 'icon' => 'orders', 'link' => route('orders.index'), 'active' => request()->routeIs('orders.*')])
                        @endif
                    @else
                        @if ($this->hasModule('Order') || $this->hasModule('KOT'))
                            @if (user_can('Show Order') || user_can('Manage KOT'))
                                <x-sidebar-dropdown-menu :name='__("menu.orders")' icon='orders' :active='request()->routeIs(["orders.*", "kots.*"])'>
                                    @if($this->hasModule('KOT'))
                                        @if (user_can('Manage KOT'))
                                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.kot'), 'link' => route('kots.index'), 'active' => request()->routeIs('kots.*')])
                                        @endif
                                    @endif

                                    @if($this->hasModule('Order'))
                                        @if (user_can('Show Order'))
                                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.orders'), 'link' => route('orders.index'), 'active' => request()->routeIs('orders.*')])
                                        @endif
                                    @endif
                                </x-sidebar-dropdown-menu>
                            @endif
                        @endif
                    @endif

                    @if($this->hasModule('Customer'))
                        @if (user_can('Show Customer'))
                            @livewire('sidebar-menu-item', ['name' => __('menu.customers'), 'icon' => 'customers', 'link' => route('customers.index'), 'active' => request()->routeIs('customers.index')])
                        @endif
                    @endif

                    @if($this->hasModule('Staff'))
                        @if (user_can('Show Staff Member'))
                            @livewire('sidebar-menu-item', ['name' => __('menu.staff'), 'icon' => 'staff', 'link' => route('staff.index'), 'active' => request()->routeIs('staff.index')])
                        @endif
                    @endif

                    @if($this->hasModule('Delivery Executive'))
                        @if (user_can('Show Delivery Executive'))
                            <x-sidebar-dropdown-menu :name='__("menu.deliveryExecutive")' icon='delivery' :active='request()->routeIs(["delivery-executives.*"])'>
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.deliveryExecutive'), 'link' => route('delivery-executives.index'), 'active' => request()->routeIs('delivery-executives.index')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.codMonitoring'), 'link' => route('delivery-executives.cash-monitoring'), 'active' => request()->routeIs('delivery-executives.cash-monitoring')])
                            </x-sidebar-dropdown-menu>
                        @endif
                    @endif

                    <!-- ── Financials ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Financials</p>
                    </li>

                    @if ($this->hasModule('Expense') && user_can('Show Expense'))
                        <x-sidebar-dropdown-menu :name='__("menu.expenses")' icon='expenses' :active='request()->routeIs(["payments.expenses", "payments.recurring-expenses", "payments.expenseCategory"])'>
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.expenses'), 'link' => route('payments.expenses'), 'active' => request()->routeIs('payments.expenses')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.recurringExpenses'), 'link' => route('payments.recurring-expenses'), 'active' => request()->routeIs('payments.recurring-expenses')])
                            @livewire('sidebar-dropdown-menu', ['name' => __('menu.expensesCategory'), 'link' => route('payments.expenseCategory'), 'active' => request()->routeIs('payments.expenseCategory')])
                        </x-sidebar-dropdown-menu>
                    @endif

                    @if ($this->hasModule('Payment'))
                        @if (user_can('Show Payments'))
                            <x-sidebar-dropdown-menu :name='__("menu.payments")' icon='payments' :active='request()->routeIs(["payments.index", "payments.due"])'>
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.payments'), 'link' => route('payments.index'), 'active' => request()->routeIs('payments.index')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.duePayments'), 'link' => route('payments.due'), 'active' => request()->routeIs('payments.due')])
                            </x-sidebar-dropdown-menu>
                        @endif
                    @endif

                    <!-- ── Analytics ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Analytics</p>
                    </li>

                    @if ($this->hasModule('Report'))
                        @if (user_can('Show Reports'))
                            <x-sidebar-dropdown-menu :name='__("menu.reports")' icon='reports' :active='request()->routeIs(["reports.*", "multi-pos.reports.*", "loyalty.reports.*"])'>
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.salesReport'), 'link' => route('reports.sales'), 'active' => request()->routeIs('reports.sales')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.itemReport'), 'link' => route('reports.item'), 'active' => request()->routeIs('reports.item')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.categoryReport'), 'link' => route('reports.category'), 'active' => request()->routeIs('reports.category')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.deliveryAppReport'), 'link' => route('reports.delivery'), 'active' => request()->routeIs('reports.delivery')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.codReport'), 'link' => route('reports.cod'), 'active' => request()->routeIs('reports.cod')])
                                @if ($this->hasModule('Expense'))
                                    @livewire('sidebar-dropdown-menu', ['name' => __('menu.expenseReports'), 'link' => route('reports.expenseReports'), 'active' => request()->routeIs('reports.expenseReports')])
                                @endif
                                @if (module_enabled('MultiPOS') && in_array('MultiPOS', restaurant_modules()))
                                    @livewire('sidebar-dropdown-menu', ['name' => __('multipos::messages.reports.title'), 'link' => route('multi-pos.reports.sales-summary'), 'active' => request()->routeIs('multi-pos.reports.sales-summary')])
                                @endif
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.cancelledOrderReport'), 'link' => route('reports.cancelledOrder'), 'active' => request()->routeIs('reports.cancelledOrder')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.removedKotItemReport'), 'link' => route('reports.removedKotItem'), 'active' => request()->routeIs('reports.removedKotItem')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.taxReport'), 'link' => route('reports.tax'), 'active' => request()->routeIs('reports.tax')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.refundReport'), 'link' => route('reports.refund'), 'active' => request()->routeIs('reports.refund')])
                                @if (module_enabled('Loyalty'))
                                    @includeIf('loyalty::sections.reports-sidebar')
                                @endif
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.duePaymentsReceivedReport'), 'link' => route('reports.duePaymentReceived'), 'active' => request()->routeIs('reports.duePaymentReceived')])

                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.orderReport'), 'link' => route('reports.orderReport'), 'active' => request()->routeIs('reports.orderReport')])
                                @livewire('sidebar-dropdown-menu', ['name' => __('menu.deleteOrderReport'), 'link' => route('reports.deletedOrder'), 'active' => request()->routeIs('reports.deletedOrder')])

                            </x-sidebar-dropdown-menu>
                        @endif
                    @endif

                    @foreach (custom_module_plugins() as $item)
                        @includeIf(strtolower($item) . '::sections.sidebar')
                    @endforeach

                    <!-- ── Account ── -->
                    <li>
                        <p class="px-3 pt-4 pb-1 text-[10.5px] font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-600 sidebar-item-name">Account</p>
                    </li>

                    @if ($this->hasModule('Settings') && user_can('Manage Settings'))
                        @livewire('sidebar-menu-item', ['name' => __('menu.settings'), 'icon' => 'settings', 'link' => route('settings.index'), 'active' => request()->routeIs('settings.index')])
                    @endif

                </ul>
            </div>

            <!-- Bottom Section (Log Out & Customer Site) -->
            <div class="absolute bottom-0 left-0 w-full p-2 bg-white/95 dark:bg-[#0B0F19]/95 backdrop-blur-md border-t border-gray-200 dark:border-gray-800/80 space-y-1">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-2 py-1.5 rounded-xl border border-red-500/30 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 text-xs font-semibold transition cursor-pointer">
                        <i class="ti ti-logout-2 text-base"></i>
                        <span class="sidebar-item-name truncate">Log Out</span>
                    </button>
                </form>

                <a href="{{ module_enabled('Subdomain') ? 'https://'.restaurant()->sub_domain : route('shop_restaurant', [restaurant()->hash]) }}" target="_blank"
                   class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-xl border border-skin-base/30 bg-skin-base/5 text-skin-base hover:bg-skin-base/10 text-xs font-semibold transition cursor-pointer sidebar-item-name">
                    <span class="sidebar-item-name truncate">@lang('menu.customerSite')</span>
                    <i class="ti ti-external-link text-sm shrink-0"></i>
                </a>
            </div>

        </div>
    </aside>

    <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
</div>
