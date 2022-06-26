@php
    $listItemClasses = 'class="px-6 py-2 border-b border-gray-200 w-full"';
    $jetstreamBtnClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-gray-800 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
    focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300
    disabled:opacity-25 transition"
    EOS;
@endphp
<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$game->game_name . ' Version'}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-[minmax(0,_1fr)_auto] gap-y-4">
        <ul class="bg-white rounded-lg border border-gray-200 text-gray-900 col-span-full row-start-1 row-end-1">
            <li {!! $listItemClasses !!}>Generation {{number_to_roman($game->generation)}}</li>
            <li {!! $listItemClasses !!}>{{$game->region}} Region</li>
            <li {!! $listItemClasses !!}>{{GameRepo::getProperGameType($game->game_type)}}</li>
            <li {!! $listItemClasses !!}>Released on: {{parse_date_as_readable_string($game->date_released)}}</li>
        </ul>
        <div class="row-start-2 row-end-2 ml-1 col-start-1 col-end-1">
            <a href="{{route('games.index')}}" {!! $jetstreamBtnClasses !!}>Go Back</a>
        </div>
        @if(Auth::user()->isAdmin())
            <div class="col-start-2 col-end-2 row-start-2 row-end-2 justify-self-end">
                <a href="{{route('games.edit', $this->game->id)}}" {!! $jetstreamBtnClasses !!}>Edit!</a>
            </div>
        @endif
    </div>
</div>
