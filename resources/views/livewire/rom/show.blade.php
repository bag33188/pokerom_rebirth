<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$rom->getRomFileName()}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <ul class="bg-white rounded-lg border border-gray-200 text-gray-900 col-span-full row-start-1 row-end-1">
            <li {!! LIST_ITEM_CLASSES !!}>Rom Name: {{$rom->rom_name}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>Rom Size: {{RomRepo::getReadableRomSize($rom->rom_size)}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>Rom Type: {{$rom->rom_type}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>Game Name: {{@$rom->game->game_name . ' Version' ?? 'no game'}}</li>
            @if($rom->has_game)
                <li {!! LIST_ITEM_CLASSES !!}>Game Region: {{$rom->game->region}}</li>
                <li {!! LIST_ITEM_CLASSES !!}>Generation: {{number_to_roman($rom->game->generation)}}</li>
                <li {!! LIST_ITEM_CLASSES !!}>Date
                    Released: {{parse_date_as_readable_string($rom->game->date_released, addDayName: false)}}</li>
                <li {!! LIST_ITEM_CLASSES !!}>Game Type: {{$rom->game->game_type}}</li>
            @endif
        </ul>

        @if(Auth::user()->isAdmin())
            <div class="col-start-2 col-end-2 row-start-2 row-end-2 justify-self-end h-auto">
                @livewire('rom.delete', ['romId' => $romId])
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start h-auto">
                <x-jet-button type="button" wire:click="edit({{$romId}})">Edit!</x-jet-button>
            </div>
        @endif
    </div>
</div>
