<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('更新密碼') }}
    </x-slot>

    <x-slot name="description">
        {{ __('確保您的帳戶使用的是隨機的長密碼，以確保安全。') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('當前密碼') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full"
                wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('新密碼') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password"
                autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('確認密碼') }}" />
            <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full"
                wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('已更新') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('更新') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
