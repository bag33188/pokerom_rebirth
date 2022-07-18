@php
    $alpineInitialDisplayState = \App\Enums\DisplayStateEnum::SHOW;
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon Games Library</h2>
        <h5 class="text-center text-gray-700">{{$gamesCount}} Games in Total</h5>
    </x-slot>
    <div class="container mx-auto" x-data="{ open: true }">
        @if($gamesCount < 1)
            <h2 class="text-center text-lg mt-7">No Games Exist in database</h2>
        @else
            <x-show-hide-button text="Games" :initial-state="$alpineInitialDisplayState" />
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 justify-items-center my-1.5 pb-4"
                 x-show="{{$alpineInitialDisplayState->value}}"
                 x-cloak>
                @foreach($games as $i => $game)
                    <livewire:game.card :game="$game" :index="$i" :wire:key="$game->getKey()" />
                @endforeach
            </div>
        @endif
    </div>
</div>
