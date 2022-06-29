<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$game->game_name}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <x-list-group>
            <x-list-item>{{$game->game_name}} Version</x-list-item>
            <x-list-item>Generation {{number_to_roman($game->generation)}}</x-list-item>
            <x-list-item>{{$game->region}} Region</x-list-item>
            <x-list-item>{{GameRepo::getProperGameTypeString($game->game_type)}}</x-list-item>
            <x-list-item>Released on: {{parse_date_as_readable_string($game->date_released)}}</x-list-item>
        </x-list-group>
        @if(Auth::user()->isAdmin())
            <div class="row-start-2 row-end-2 ml-1 col-start-2 col-end-2 justify-self-end">
                <livewire:game.delete :gameId="$gameId" />
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start">
                <x-jet-button type="button" wire:click="edit({{$gameId}})">Edit!</x-jet-button>
            </div>
        @endif
    </div>
</div>
