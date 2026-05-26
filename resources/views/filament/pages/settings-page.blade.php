<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6 flex items-center gap-3 justify-end">
            <x-filament::button
                color="gray"
                wire:click="testR2Connection"
                wire:loading.attr="disabled"
                type="button"
            >
                Test R2 Connection
            </x-filament::button>

            <x-filament::button type="submit" wire:loading.attr="disabled">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
