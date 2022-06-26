<div>
    @foreach($games as $game)
        <div class="p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{$game->game_name}}</h5>
            </a>
            <div class="w-full bg-white rounded-lg shadow-lg lg:w-1/3">
                <ul class="divide-y-2 divide-gray-100">
                    <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                       {{$game->generation}}
                    </li>
                    <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                        {{$game->region}}
                    </li>
                    <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                        {{$game->game_type}}
                    </li>
                    <li class="p-3 hover:bg-blue-600 hover:text-blue-200">
                        {{$game->date_released}}
                    </li>
                </ul>
            </div>
{{--            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>--}}
            <a href="#" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Read more
                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
    @endforeach

</div>
