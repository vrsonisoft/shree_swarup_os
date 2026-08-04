<div class="relative">
    <a @if(pusherSettings()->is_enabled_pusher_broadcast) wire:poll.15s @else wire:poll.10s @endif
    href="{{ route('waiter-requests.index') }}" wire:navigate
    class="inline-flex relative w-10 h-10 items-center justify-center rounded-xl bg-[#F3EBFF] dark:bg-purple-950/20 hover:bg-[#E8DAFF] dark:hover:bg-purple-950/40 transition cursor-pointer"
    data-tooltip-target="active-waiter-requests-tooltip-toggle"
    >
    <span class="w-5 h-5 bg-[#8F3DFF] dark:bg-purple-400 inline-block" style="-webkit-mask-image: url('{{ asset('img/icons/waiter_request.png') }}'); -webkit-mask-size: contain; -webkit-mask-repeat: no-repeat; -webkit-mask-position: center; mask-image: url('{{ asset('img/icons/waiter_request.png') }}'); mask-size: contain; mask-repeat: no-repeat; mask-position: center;"></span>

    <span
        class="absolute -top-1 -right-1 inline-flex min-w-5 h-5 items-center justify-center px-1 text-[10px] font-bold leading-none text-white bg-emerald-500 rounded-full ring-2 ring-white dark:ring-[#0B0F19]">
        {{ $count }}
    </span>
</a>
<div id="active-waiter-requests-tooltip-toggle" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
    @lang('modules.waiterRequest.newWaiterRequests')
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
</div>

@push('scripts')

    @if(pusherSettings()->is_enabled_pusher_broadcast)
        @script
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                const channel = PUSHER.subscribe('active-waiter-requests');
                channel.bind('active-waiter-requests.created', function(data) {
                    @this.call('refreshActiveWaiterRequests');
                    console.log('✅ Pusher received data for active waiter requests!. Refreshing...');
                    });
                    PUSHER.connection.bind('connected', () => {
                    console.log('✅ Pusher connected for Active Waiter Requests!');
                    });
                    channel.bind('pusher:subscription_succeeded', () => {
                    console.log('✅ Subscribed to active-waiter-requests channel!');
                    });
                });
            </script>
        @endscript
    @endif

    <script>
        // Listen for custom event to play sound - setup immediately
        document.addEventListener('livewire:init', () => {
            console.log('🔧 Setting up waiter request event listeners...');

            // Listen for the play-waiter-sound event
            window.addEventListener('play-waiter-sound', (event) => {
                console.log('🔔 Playing waiter request sound! (window event)', event);
                const audio = new Audio("{{ asset('sound/new_order.wav')}}");
                audio.play().then(() => {
                    console.log('✅ Sound played successfully!');
                }).catch(error => {
                    console.error('❌ Error playing sound:', error);
                });
            });

            // Also listen via Livewire events
            Livewire.on('play-waiter-sound', (event) => {
                console.log('🔔 Playing waiter request sound! (Livewire event)', event);
                const audio = new Audio("{{ asset('sound/new_order.wav')}}");
                audio.play().then(() => {
                    console.log('✅ Sound played successfully!');
                }).catch(error => {
                    console.error('❌ Error playing sound:', error);
                });
            });

            // Listen for waiterRequestCreated event
            Livewire.on('waiterRequestCreated', (data) => {
                console.log('✅ Livewire event received for waiter request!', data);
                // Refresh the component to show new count and popup
                @this.call('refreshActiveWaiterRequests');
            });

            console.log('🔧 Waiter request component event listeners ready!');
        });
    </script>
@endpush
