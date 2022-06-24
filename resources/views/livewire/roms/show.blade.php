<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$rom->getRomFileName()}} Information</h2>
    </x-slot>
    <div class="flex justify-center flex-col w-full">
        <ul class="bg-white rounded-lg border border-gray-200 text-gray-900">
            <li class="px-6 py-2 border-b border-gray-200 w-full">{{$rom->rom_name}}</li>
            <li class="px-6 py-2 border-b border-gray-200 w-full">{{RomRepo::getRomReadableSize($rom->rom_size)}}</li>
            <li class="px-6 py-2 border-b border-gray-200 w-full">{{$rom->rom_type}}</li>
            <li class="px-6 py-2 border-b border-gray-200 w-full">{{@$rom->game->game_name . ' Version' ?? 'no game'}}</li>
            @if($rom->has_game)
                <li class="px-6 py-2 border-b border-gray-200 w-full">{{number_to_roman($rom->game->generation)}}</li>
                <li class="px-6 py-2 border-b border-gray-200 w-full">{{parse_date_as_readable_string($rom->game->date_released)}}</li>
                <li class="px-6 py-2 border-b border-gray-200 w-full">{{$rom->game->game_type}}</li>
            @endif
        </ul>

        @if(Auth::user()->isAdmin())
            <div class="w-full inline-flex justify-end">
                <a href="{{route('roms.edit', $this->rom->id)}}"
                   class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit!</a>
            </div>
        @endif
    </div>

</div>
