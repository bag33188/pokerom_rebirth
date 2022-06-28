<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$game->game_name}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <ul class="bg-white rounded-lg border border-gray-200 text-gray-900 col-span-full row-start-1 row-end-1">
            <li {!! LIST_ITEM_CLASSES !!}>{{$game->game_name}} Version</li>
            <li {!! LIST_ITEM_CLASSES !!}>Generation {{number_to_roman($game->generation)}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>{{$game->region}} Region</li>
            <li {!! LIST_ITEM_CLASSES !!}>{{GameRepo::getProperGameTypeString($game->game_type)}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>Released on: {{parse_date_as_readable_string($game->date_released)}}</li>
        </ul>
        @if(Auth::user()->isAdmin())
            <div class="row-start-2 row-end-2 ml-1 col-start-2 col-end-2 justify-self-end">
                @livewire('game.delete', ['gameId'=>$gameId])
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start">
                <x-jet-secondary-button wire:click="edit({{$gameId}})">Edit!</x-jet-secondary-button>
            </div>
        @endif
    </div>
</div>
