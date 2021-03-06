@php
    function formatRomSize(int $romSize): string {
        return RomRepo::getFormattedRomSize($romSize);
    }
@endphp
<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center text-lg">{{$rom->getRomFileName()}} Information</h2>
    </x-slot>
    @include('ui.session-message')

    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <x-list-group>
            <x-list-item>Rom Name: {{$rom->rom_name}}</x-list-item>
            <x-list-item title="{{($rom->rom_size * DATA_BYTE_FACTOR)}} Bytes">Rom
                Size: {{formatRomSize($rom->rom_size)}}</x-list-item>
            <x-list-item>Rom Type: {{$rom->rom_type}}</x-list-item>
            <x-list-item>Game
                Name: {{$rom->has_game ? "{$rom->game->game_name} Version" : 'No game associated'}}</x-list-item>
            @if($rom->has_game)
                <x-list-item>Region: {{$rom->game->region}}</x-list-item>
                <x-list-item>Generation: {{$rom->game->generation}}</x-list-item>
                <x-list-item>Date Released:
                    {{parseDateAsReadableString($rom->game->date_released)}}</x-list-item>
                <x-list-item>Game Type: {{$rom->game->game_type}}</x-list-item>
            @endif
        </x-list-group>
        @if(auth('web')->user()->isAdmin())
            <div class="col-start-2 col-end-2 row-start-2 row-end-2 justify-self-end h-auto">
                @livewire('rom.delete', ['romId' => $romId])
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start h-auto flex flex-row">
                <x-jet-button class="order-0 mr-2" type="button" wire:click="edit({{$romId}})">Edit!</x-jet-button>
                @unless($rom->has_file)
                    <x-jet-button class="order-1" wire:click="attemptToLinkRomToRomFile">
                        Attempt ROM File Link
                    </x-jet-button>
                @else
                    <x-rom-file-download class="order-1" :rom-file="$rom->romFile">
                        <x-slot:button>
                            <x-jet-button>Download</x-jet-button>
                        </x-slot:button>
                    </x-rom-file-download>
                @endunless
            </div>
        @endif
    </div>
</div>
