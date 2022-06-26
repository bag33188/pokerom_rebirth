<div class="container">
    @if($availableRoms > 0)
        <label for="availableRoms">Select ROM</label>
        <select id="availableRoms" name="rom_id"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1">
            @php
                for($i = 0; $i < $availableRomsCount; $i++) {
                    $rom = $availableRoms[$i];
                    $html = /** @lang HTML */ "<option value='$rom->id'>$rom->rom_name</option>";
                    print $html;
                }
            @endphp
        </select>
        @php
            echo "<br />";
            var_dump(@GameRepo::getAllRomsWithNoGame()[0]);
            echo "<br />";
            var_export(GameRepo::getAllRomsWithNoGame())
        @endphp
    @else
        <h3>No available roms to add a game to :(</h3>
    @endif
</div>
