<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon Games Library</h2>
    </x-slot>
    <div class="container mx-auto my-3.5">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($games as $game)
                <div class="p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$game->game_name}}</h5>
                    <div class="w-full bg-white rounded-lg my-2.5">
                        <ul class="divide-y-2 divide-gray-100">
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{$game->generation > 0 ? $game->generation : 'N/A'}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{$game->region}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{GameRepo::getProperGameType($game->game_type)}}
                            </li>
                            <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                                {{parse_date_as_readable_string($game->date_released)}}
                            </li>
                        </ul>
                    </div>
                    <a href="{{route('games.show', ['gameId'=>$game->id])}}"
                       class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Read more
                        <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
