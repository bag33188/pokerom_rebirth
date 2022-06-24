<div>
    <ul>
        <li>{{$rom->rom_name}}</li>
        <li>{{RomRepo::getRomReadableSize($rom->rom_size)}}</li>
        <li>{{@$rom->game->game_name ?? 'no game'}}</li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
