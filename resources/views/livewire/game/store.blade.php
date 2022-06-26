@php
    $availableRoms=GameRepo::getAllRomsWithNoGame();
    $availableRomsCount = count($availableRoms);
@endphp
<div class="container">
    @for($i = 0; $i < $availableRomsCount; $i++)
        @php
            $rom=$availableRoms[$i];
            echo $rom->rom_name;
        @endphp
    @endfor
    {!! "<br/>" !!}
    {{var_export(GameRepo::getAllRomsWithNoGame())}}
</div>
