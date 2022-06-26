@php
    $availableRoms=$this->getAvailableRoms();
    $availableRomsCount = count($availableRoms);
@endphp
<div>
    @for($i = 0; $i < $availableRomsCount; $i++)
        @php
            $rom=$availableRoms[$i];
            echo $rom->rom_name;
        @endphp
    @endfor
    {!! "<br/>" !!}
    {{var_export($this->getAvailableRoms())}}
</div>
