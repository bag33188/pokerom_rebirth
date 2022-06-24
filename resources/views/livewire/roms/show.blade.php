<div>
    <ul>
        <li>{{$rom->rom_name}}</li>
        <li>{{RomRepo::getRomReadableSize($rom->rom_size)}}</li>
        <li>{{@$rom->game->game_name . ' Version' ?? 'no game'}}</li>
        <li>{{@$rom->file->filename ?? 'no file'}}</li>
        <li></li>
    </ul>
    @if(Auth::user()->isAdmin())
        <a href="{{route('roms.edit', $this->rom->id)}}"
           class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit!</a>
    @endif
</div>
