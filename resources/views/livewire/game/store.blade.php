<div class="container">
    @if($availableRoms > 0)
        @for($i = 0; $i < $availableRomsCount; $i++)
            @php
                $rom = $availableRoms[$i];
                echo $rom->rom_name;
            @endphp
        @endfor
        {!! "<br/>" !!}
        {{var_export(GameRepo::getAllRomsWithNoGame())}}
    @else
        <h3>No available roms to add a game to :(</h3>
    @endif
</div>
