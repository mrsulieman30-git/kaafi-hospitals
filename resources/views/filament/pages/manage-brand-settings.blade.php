<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="mt-4 text-right">
            <x-filament::button type="submit" size="lg">
                Save & Publish
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
