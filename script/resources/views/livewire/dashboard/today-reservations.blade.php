<div class="relative">
    <a @if(pusherSettings()->is_enabled_pusher_broadcast) wire:poll.60s @endif
    href="{{ route('reservations.index') }}" wire:navigate
    class="inline-flex relative w-10 h-10 items-center justify-center rounded-xl bg-[#EBF3FF] dark:bg-blue-950/20 hover:bg-[#DCE9FF] dark:hover:bg-blue-950/40 transition cursor-pointer"
    data-tooltip-target="today-reservations-tooltip-toggle"
    >
    <span class="w-5 h-5 bg-[#3D8FFF] dark:bg-blue-400 inline-block" style="-webkit-mask-image: url('{{ asset('img/icons/reservation.png') }}'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; -webkit-mask-position: center; mask-image: url('{{ asset('img/icons/reservation.png') }}'); mask-size: contain; mask-repeat: no-repeat; mask-position: center;"></span>
    
    <span
        class="absolute -top-1 -right-1 inline-flex min-w-5 h-5 items-center justify-center px-1 text-[10px] font-bold leading-none text-white bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#0B0F19]">
        {{ $count }}
    </span>
</a>
<div id="today-reservations-tooltip-toggle" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
    @lang('modules.reservation.newReservations')
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
</div>

@push('scripts')

    @if(pusherSettings()->is_enabled_pusher_broadcast)
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const channel = PUSHER.subscribe('today-reservations');
                channel.bind('today-reservations.created', function(data) {
                    @this.call('refreshReservations');
                    console.log('✅ Pusher received data for today reservations!. Refreshing...');
                });
                PUSHER.connection.bind('connected', () => {
                    console.log('✅ Pusher connected for Today Reservations!');
                });
                channel.bind('pusher:subscription_succeeded', () => {
                    console.log('✅ Subscribed to today-reservations channel!');
                });
            });
        </script>
    @endif
@endpush
