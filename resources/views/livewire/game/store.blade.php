@php
    $availableRoms=$this->getAvailableRoms();
    $availableRomsCount = count($availableRoms);
@endphp
<div>
    @for($i = 0; $i < $availableRomsCount; $i++)
        {{$availableRoms[$i]->rom_name}}
    @endfor
    {!! "<br/>" !!}
    {{var_export($this->getAvailableRoms())}}
</div>
