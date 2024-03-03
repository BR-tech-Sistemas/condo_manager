<div wire:init="openModal">
    <x-filament::modal
            width="5xl"
            icon="heroicon-o-exclamation-triangle"
            icon-color="danger"
            id="announcement-modal">
        <x-slot name="heading">
            Anúncios para seu Condomínio
        </x-slot>
        {{ $this->table }}
    </x-filament::modal>
</div>
