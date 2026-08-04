<div class="relative">
    <a href="{{ route('orders.index') }}" wire:navigate wire:key="today-orders-link"
        class="inline-flex relative w-10 h-10 items-center justify-center rounded-xl bg-[#FFF3EB] dark:bg-orange-950/20 text-[#FF8F3D] hover:bg-[#FFE8DA] dark:hover:bg-orange-950/40 transition cursor-pointer"
        data-tooltip-target="today-orders-tooltip-toggle"
        >
        <i class="ti ti-receipt text-lg"></i>

        <span @if(!pusherSettings()->is_enabled_pusher_broadcast) wire:poll.15s.keep-alive="refreshOrders" wire:key="today-orders-count" @endif
            class="absolute -top-1 -right-1 inline-flex min-w-5 h-5 items-center justify-center px-1 text-[10px] font-bold leading-none text-white bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#0B0F19]">
            {{ $count }}
        </span>

    </a>
    <div id="today-orders-tooltip-toggle" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
        @lang('modules.order.todayOrder')
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
@push('scripts')

    @if(pusherSettings()->is_enabled_pusher_broadcast)
        @script
            <script>
                document.addEventListener('livewire:initialized', function () {
                    const channel = PUSHER.subscribe('today-orders');
                    channel.bind('today-orders.updated', function(data) {
                        @this.call('refreshOrders');
                        new Audio("{{ asset('sound/new_order.wav')}}").play();
                        console.log('✅ Pusher received data for today orders!. Refreshing...');
                    });
                    PUSHER.connection.bind('connected', () => {
                        console.log('✅ Pusher connected for Today Orders!');
                    });
                    channel.bind('pusher:subscription_succeeded', () => {
                        console.log('✅ Subscribed to today-orders channel!');
                    });
                });
            </script>
        @endscript
    @elseif($playSound)
        @script
            <script>
                console.log('✅ Playing sound for today orders!', "{{ asset('sound/new_order.wav')}}");
                new Audio("{{ asset('sound/new_order.wav')}}").play();
            </script>
        @endscript
    @endif
@endpush
