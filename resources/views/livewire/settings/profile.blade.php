<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your personal information and addresses')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            {{-- Personal Information --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">{{ __('Personal Information') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input wire:model="first_name" :label="__('First Name')" type="text" required autofocus autocomplete="given-name" />
                    <flux:input wire:model="last_name" :label="__('Last Name')" type="text" required autocomplete="family-name" />
                </div>

                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif

                <flux:input wire:model="phone" :label="__('Phone')" type="tel" autocomplete="tel" />
            </div>

            {{-- Billing Address --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">{{ __('Billing Address') }}</h3>

                <flux:input wire:model="address" :label="__('Address')" type="text" autocomplete="street-address" />

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <flux:input wire:model="city" :label="__('City')" type="text" autocomplete="address-level2" />
                    <flux:input wire:model="postal_code" :label="__('Postal Code')" type="text" autocomplete="postal-code" />
                    <flux:input wire:model="country" :label="__('Country')" type="text" autocomplete="country-name" />
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model.live="use_different_shipping" id="use_different_shipping" class="rounded">
                    <label for="use_different_shipping" class="text-sm font-medium">
                        {{ __('Use different shipping address') }}
                    </label>
                </div>

                @if ($use_different_shipping)
                    <div class="space-y-4 pl-4 border-l-2 border-gray-200">
                        <h3 class="text-lg font-semibold">{{ __('Shipping Address') }}</h3>

                        <flux:input wire:model="shipping_address" :label="__('Shipping Address')" type="text" />

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <flux:input wire:model="shipping_city" :label="__('City')" type="text" />
                            <flux:input wire:model="shipping_postal_code" :label="__('Postal Code')" type="text" />
                            <flux:input wire:model="shipping_country" :label="__('Country')" type="text" />
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
