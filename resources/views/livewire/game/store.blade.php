<div class="container">
    @if($availableRoms > 0)
        <label for="romId">Select ROM</label>
        <select id="romId" name="rom_id">
            @for($i = 0; $i < $availableRomsCount; $i++)
                @php
                    $rom = $availableRoms[$i];
                    echo "<option value='$rom->id'>$rom->rom_name</option>"
                @endphp
            @endfor
        </select>
        {!! "<br/>" !!}
        {{var_export(GameRepo::getAllRomsWithNoGame())}}
    @else
        <h3>No available roms to add a game to :(</h3>
    @endif
</div>
