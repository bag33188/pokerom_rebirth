<div>
    <ul>
        <li>{{$rom->rom_name}}</li>
        <li>{{RomRepo::getRomReadableSize($rom->rom_size)}}</li>
        <li>{{@$rom->game->game_name . ' Version' ?? 'no game'}}</li>
        <li>{{@$rom->file->filename ?? 'no file'}}</li>
        <li></li>
    </ul>
</div>
