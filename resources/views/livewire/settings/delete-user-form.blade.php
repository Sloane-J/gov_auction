<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Suspend account') }}</flux:heading>
        <flux:subheading>{{ __('Temporarily deactivate your account and pause access') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-suspension">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-suspension')">
            {{ __('Suspend account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-suspension" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="suspendUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Are you sure you want to suspend your account?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Once your account is suspended, you will be logged out and lose access to your account features until reactivated. Please enter your password to confirm.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('Password')" type="password" viewable />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Suspend account') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
