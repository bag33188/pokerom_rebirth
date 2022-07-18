@push('scripts')
    <script type="text/javascript" src="{{mix('assets/js/pages/roms.index.js')}}" defer></script>
@endpush
@php
    $alpineInitialDisplayState = \App\Enums\DisplayStateEnum::SHOW;
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon ROMs Library</h2>
    </x-slot>
    <div x-data="{ open: true }" id="roms-container">
        @if($totalRomsCount < 1)
            <h2 class="text-center text-lg mt-7">No ROMs Exist in database</h2>
        @else
            <x-show-hide-button text="ROMs" :initial-state="$alpineInitialDisplayState" />
            <table class="w-full text-sm text-left text-gray-800 light:text-gray-400"
                   x-show="{{$alpineInitialDisplayState->value}}" x-cloak>
                <thead class="bg-gray-50">
                <tr class="text-xs text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                    @for($i = 0; $i < count($romsTableColumns); $i++)
                        <th scope="col" class="px-6 py-3" id="column-{{ $i + 1 }}">{{ $romsTableColumns[$i] }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody class="light:bg-gray-800">
                @foreach($roms as $i => $rom)
                    <livewire:rom.table-row :rom="$rom" :index="$i" :wire:key="$rom->getKey()" />
                @endforeach
                </tbody>
                <tfoot>
                <tr class="text-sm text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                    <td class="px-6 py-3">
                        <p>Total Count:&nbsp;<span class="font-semibold">{{$totalRomsCount}}&nbsp;ROMs</span></p>
                    </td>
                    <td class="px-6 py-3">
                        <p>Total ROMs Size:&nbsp;<span class="font-semibold">{{$romFileSizeSum}}&nbsp;Bytes</span></p>
                    </td>
                </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
