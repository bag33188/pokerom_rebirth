@php
    $moreInfoBtnClasses = [
        'inline-flex', 'flex-row', 'items-center', 'py-2', 'px-3', 'text-sm', 'font-medium',
        'text-center', 'text-white', 'bg-blue-700', 'rounded-lg', 'hover:bg-blue-800', 'focus:ring-4',
        'focus:outline-none', 'focus:ring-blue-300'
    ];
@endphp
<div class="p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md"
     data-game-id="{{$game->getKey()}}" id="card-{{$index + 1}}">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$game->game_name}}</h5>
    <div class="w-full bg-white rounded-lg my-2.5">
        <ul class="divide-y-2 divide-gray-100">
            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                {{$game->game_name}}&nbsp;Version
            </li>
            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                Generation {{$this->parseGenerationIntoRomanWhenNotZero($game->generation)}}
            </li>
            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                {{$game->region}} Region
            </li>
            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                {{GameRepo::getFormattedGameType($game->game_type)}}
            </li>
            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                Released on {{parseDateAsReadableString($game->date_released)}}
            </li>
        </ul>
    </div>
    <button type="button"
            class="{{joinClasses($moreInfoBtnClasses)}}"
            wire:click="$emitUp('show', {{$game->id}})">
        <span class="order-0">More Info</span>
        <span class="order-1">&nbsp;</span>
        <span class="order-2">@include('partials._more-info-icon')</span>
    </button>
</div>
