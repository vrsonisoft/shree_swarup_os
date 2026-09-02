<div class="w-full mx-auto p-0 bg-transparent shadow-none border-0">

    @if ($showUserForm)
        <form wire:submit="submitForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Row 1: Restaurant Name & Your Full Name -->
                <div>
                    <x-label for="restaurantName" value="{{ __('modules.restaurant.name') }}" />
                    <x-input id="restaurantName" class="block mt-1 w-full" type="text" wire:model='restaurantName' placeholder="Restaurant Name" />
                    <x-input-error for="restaurantName" class="mt-2" />
                </div>

                <div>
                    <x-label for="fullName" value="{{ __('app.fullName') }}" />
                    <x-input id="fullName" class="block mt-1 w-full" type="text" wire:model='fullName' placeholder="Your Full Name" />
                    <x-input-error for="fullName" class="mt-2" />
                </div>

                @includeIf('subdomain::include.register-subdomain')

                <!-- Row 2: Enter your email & Phone -->
                <div>
                    <x-label for="email" value="{{ __('app.email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" wire:model='email' placeholder="Enter your email" />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <div>
                    <x-label for="restaurantPhoneNumber" value="{{ __('modules.settings.phone') }}" />
                    <div class="flex gap-2 mt-1">
                        <!-- Phone Code Dropdown -->
                        <div x-data="{ isOpen: @entangle('phoneCodeIsOpen').live }" @click.away="isOpen = false" class="relative w-28 shrink-0">
                            <div @click="!{{ $phoneVerified ? 'true' : 'false' }} && (isOpen = !isOpen)"
                                class="p-2.5 bg-gray-100 border rounded-xl dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 flex items-center justify-between" :class="{ 'cursor-pointer': !{{ $phoneVerified ? 'true' : 'false' }}, 'opacity-50 cursor-not-allowed': {{ $phoneVerified ? 'true' : 'false' }} }">
                                <span class="text-sm font-medium">
                                    @if($restaurantPhoneCode)
                                        +{{ $restaurantPhoneCode }}
                                    @else
                                        {{ __('modules.settings.select') }}
                                    @endif
                                </span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>

                            <!-- Search Input and Options -->
                            <ul x-show="isOpen && !{{ $phoneVerified ? 'true' : 'false' }}" x-transition class="absolute z-50 w-48 mt-1 overflow-auto bg-white rounded-xl shadow-xl max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none text-sm dark:border-gray-700 dark:bg-[#152922] dark:text-gray-200">
                                <li class="sticky top-0 px-3 py-2 bg-white dark:bg-[#152922] z-10">
                                    <x-input wire:model.live.debounce.300ms="phoneCodeSearch" class="block w-full text-xs" type="text" placeholder="{{ __('placeholders.search') }}" />
                                </li>
                                @forelse ($phonecodes as $phonecode)
                                    <li @click="$wire.selectPhoneCode('{{ $phonecode }}')"
                                        wire:key="phone-code-{{ $phonecode }}"
                                        class="relative py-2 pl-3 text-gray-900 transition-colors duration-150 cursor-pointer select-none pr-9 hover:bg-gray-100 dark:hover:bg-gray-800 dark:text-gray-300" role="option">
                                        <div class="flex items-center">
                                            <span class="block ml-3 text-sm whitespace-nowrap">+{{ $phonecode }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="relative py-2 pl-3 text-gray-500 cursor-default select-none pr-9 dark:text-gray-400">
                                        {{ __('modules.settings.noPhoneCodesFound') }}
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Phone Number Input -->
                        <x-input id="restaurantPhoneNumber" class="block w-full" type="tel"
                            wire:model='restaurantPhoneNumber' placeholder="1234567890" :disabled="$phoneVerified" />
                    </div>

                    <x-input-error for="restaurantPhoneCode" class="mt-1" />
                    <x-input-error for="restaurantPhoneNumber" class="mt-1" />
                </div>

                <!-- Row 3: Password & Confirm Password -->
                <div>
                    <x-label for="password" value="{{ __('modules.staff.password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" autocomplete="new-password"
                        wire:model='password' placeholder="Enter password" />
                    <x-input-error for="password" class="mt-2" />
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" autocomplete="new-password"
                        wire:model='password_confirmation' placeholder="Confirm password" />
                    <x-input-error for="password_confirmation" class="mt-2" />
                </div>
            </div>

            <!-- Terms & Conditions and Privacy Policy Checkbox -->
            @if(global_setting()->show_privacy_consent_checkbox)
            <div class="mt-4">
                <x-label for="termsAndPrivacy">
                    <div class="flex items-center">
                        <x-checkbox name="termsAndPrivacy" id="termsAndPrivacy" wire:model.live="termsAndPrivacy" />
                        <div class="ms-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('I accept the Terms & Conditions and') }}
                                @if(global_setting()->privacy_policy_link)
                                    <a href="{{ global_setting()->privacy_policy_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ __('Privacy Policy') }}
                                    </a>
                                @else
                                    {{ __('Privacy Policy') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </x-label>
                <x-input-error for="termsAndPrivacy" class="mt-2" />
            </div>
            <!-- Marketing Emails Checkbox -->
            <div class="mt-4">
                <x-label for="marketingEmails">
                    <div class="flex items-center">
                        <x-checkbox name="marketingEmails" id="marketingEmails" wire:model.live="marketingEmails" />
                        <div class="ms-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('I agree to receive marketing emails.') }}
                            </span>
                        </div>
                    </div>
                </x-label>
                <x-input-error for="marketingEmails" class="mt-2" />
            </div>
            @endif

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        (global_setting()->privacy_policy_link ?: route('policy.show')) .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="grid items-center grid-cols-1 mt-4 gap-2">
                <x-button wire:target="submitForm" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed">
                    <span wire:loading.remove wire:target="submitForm">@lang('modules.restaurant.nextBranchDetails')</span>
                    <span wire:loading wire:target="submitForm">@lang('app.loading')...</span>
                </x-button>
            </div>

        </form>
    @endif

    @if ($showBranchForm)
        <form wire:submit="submitForm2">
            @csrf

            <h2 class="text-xl font-medium mb-6 mt-3 dark:text-white">@lang('modules.restaurant.restaurantBranchDetails')</h2>

            <div>
                <x-label for="branchName" value="{{ __('modules.settings.branchName') }}" />
                <x-input id="branchName" class="block mt-1 w-full" type="text" wire:model='branchName' />
                <x-input-error for="branchName" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="country" value="{{ __('modules.settings.restaurantCountry') }}" />
                <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model.live="country">
                    @foreach ($countries as $item)
                        <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="country" class="mt-2" />
            </div>


            <div class="mt-4">
                <x-label for="address" value="{{ __('modules.settings.branchAddress') }}" />
                <x-textarea id="address" class="block mt-1 w-full" rows="3" wire:model='address' />
                <x-input-error for="address" class="mt-2" />
            </div>


            <div class="lg:grid items-center grid-cols-1 mt-4 gap-2">
                <x-button type="submit" wire:target="submitForm2" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed">
                    <span wire:loading.remove wire:target="submitForm2">{{ __('auth.signup') }}</span>
                    <span wire:loading wire:target="submitForm2">
                        <svg class="animate-spin -ml-1 mr-1 h-4 w-4 inline-flex text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('app.submitting') }}...
                    </span>
                </x-button>
            </div>
        </form>
    @endif

</div>
