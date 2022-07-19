@php
    function formatGameType(string $gameType): string {
      return GameRepo::getFormattedGameType($gameType);
    }
@endphp
<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center text-lg">{{$game->game_name}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <x-list-group>
            <x-list-item>{{$game->game_name}} Version</x-list-item>
            <x-list-item title="{{$game->generation}}">Generation {{numberToRoman($game->generation)}}</x-list-item>
            <x-list-item>{{$game->region}} Region</x-list-item>
            <x-list-item>{{formatGameType($game->game_type)}}</x-list-item>
            <x-list-item>Released on {{parseDateAsReadableString($game->date_released, 'l, F jS, Y')}}</x-list-item>
        </x-list-group>
        @if(auth()->user()->isAdmin())
            <div class="row-start-2 row-end-2 ml-1 col-start-2 col-end-2 justify-self-end">
                @livewire('game.delete', ['gameId' => $gameId])
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start">
                <x-jet-button type="button" wire:click="edit({{$gameId}})">Edit!</x-jet-button>
            </div>
        @endif
    </div>
</div>
