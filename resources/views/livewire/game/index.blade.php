<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon Games Library</h2>
    </x-slot>
    <div class="container mx-auto" x-data="{ open: true }">
        <div class="w-full flex justify-center">
            <button type="button" @click="open = !open"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 my-4 shadow-md rounded">
                @include("ui.show-hide", ['text'=>'Games'])
            </button>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 justify-items-center my-1.5 pb-4"
             x-show="open">
            @foreach($games as $game)
                <div class="p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$game->game_name}}</h5>
                    <div class="w-full bg-white rounded-lg my-2.5">
                        <ul class="divide-y-2 divide-gray-100">
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{$game->game_name . ' Version'}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{$game->generation > 0 ? $game->generation : 'N/A'}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{$game->region}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{GameRepo::getProperGameTypeString($game->game_type)}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{parse_date_as_readable_string($game->date_released)}}
                            </li>
                        </ul>
                    </div>
                    <x-jet-button wire:click="show({{$game->id}})">More Info @include('ui.more-info-arrow')</x-jet-button>
{{--                    <a href="{{route('games.show', ['gameId'=>$game->id])}}"--}}
{{--                       class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">--}}
{{--                        More Info--}}
{{--                        @include('ui.more-info-arrow')--}}
{{--                    </a>--}}
                </div>
            @endforeach
        </div>
    </div>
</div>
