<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6 flex items-center gap-3 px-6 py-4 border-t" style="border-color: var(--fi-color-gray-200, rgba(0,0,0,.1))">
            <x-filament::button type="submit" wire:loading.attr="disabled">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
