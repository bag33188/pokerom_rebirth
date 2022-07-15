@php
    $alpineInitialDisplayState = \App\Enums\DisplayStateEnum::SHOW;
    $moreInfoBtnClasses = [
        'inline-flex', 'items-center', 'py-2', 'px-3', 'text-sm', 'font-medium',
        'text-center', 'text-white', 'bg-blue-700', 'rounded-lg', 'hover:bg-blue-800', 'focus:ring-4',
        'focus:outline-none', 'focus:ring-blue-300'
    ];
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon Games Library</h2>
        <h5 class="text-center text-gray-700">{{$gamesCount}} Games in Total</h5>
    </x-slot>
    <div class="container mx-auto" x-data="{ open: true }">
        @if(count($games) < 1)
            <h2 class="text-center text-lg mt-7">No Games Exist in database</h2>
        @else
            <x-show-hide-button text="Games" :initial-state="$alpineInitialDisplayState"/>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 justify-items-center my-1.5 pb-4"
                 x-show="{{$alpineInitialDisplayState->value}}" x-cloak>
                @foreach($games as $game)
                    <div class="p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md"
                         data-game-id="{{$game->getKey()}}">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$game->game_name}}</h5>
                        <div class="w-full bg-white rounded-lg my-2.5">
                            <ul class="divide-y-2 divide-gray-100">
                                <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                    {{$game->game_name . ' Version'}}
                                </li>
                                <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                    Generation {{$game->generation > 0 ? numberToRoman($game->generation) : 'N/A'}}
                                </li>
                                <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                    {{$game->region}} Region
                                </li>
                                <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                    {{GameRepo::getFormattedGameType($game->game_type)}}
                                </li>
                                <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                    Released on {{parseDateAsReadableString($game->date_released, false)}}
                                </li>
                            </ul>
                        </div>
                        <button type="button"
                                class="{{implode(_SPACE, $moreInfoBtnClasses)}}"
                                wire:click="show({{$game->id}})">More Info @include('partials._more-info-icon')</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
