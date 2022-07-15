@push('scripts')
    <script <?= 'type="text/javascript"'; ?> src="{{mix('js/roms.index.js')}}" defer></script>
@endpush
@php
    $downloadBtnClasses = [
        'inline-flex', 'items-center', 'py-2', 'px-4', 'bg-blue-500', 'hover:bg-blue-400',
        'text-white', 'font-bold', 'p-0', 'border-b-4', 'border-blue-700',
        'hover:border-blue-500', 'rounded', 'active:border-t-4', 'active:border-b-0', 'active:bg-blue-400'
    ];
    $getInfoBtnClasses = [
        'inline-flex', 'items-center', 'py-2', 'px-4', 'bg-red-500', 'hover:bg-red-400',
        'text-white', 'font-bold', 'p-0', 'border-b-4', 'border-red-700', 'hover:border-red-500',
        'rounded', 'active:border-t-4', 'active:border-b-0', 'active:bg-red-400'
    ];
    $alpineInitialDisplayState = \App\Enums\DisplayStateEnum::SHOW;
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon ROMs Library</h2>
    </x-slot>
    <div x-data="{ open: true }" id="roms-container">
        @if(count($roms) < 1)
            <h2 class="text-center text-lg mt-7">No ROMs Exist in database</h2>
        @else
            <x-show-hide-button text="ROMs" :initial-state="$alpineInitialDisplayState"/>
            <table class="w-full text-sm text-left text-gray-800 light:text-gray-400"
                   x-show="{{$alpineInitialDisplayState->value}}" x-cloak>
                <thead class="bg-gray-50">
                <tr class="text-xs text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                    @for($i = 0; $i < count($romsTableColumns); $i++)
                        <th scope="col" class="px-6 py-3" id="column-{{ $i+1 }}">{{ $romsTableColumns[$i] }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody class="light:bg-gray-800">
                @foreach($roms as $rom)
                    <tr data-rom-id="{{$rom->id}}"
                        class="border light:border-gray-700 odd:bg-white even:bg-gray-50 odd:light:bg-gray-800 even:light:bg-gray-700">
                        <td class="px-6 py-4">{{$rom->rom_name}}</td>
                        <td class="px-6 py-4">{{RomRepo::getFormattedRomSize($rom->rom_size)}}</td>
                        <td class="px-6 py-4">.{{strtolower($rom->rom_type)}}</td>
                        <td class="px-6 py-4">{{$rom->has_game ? $rom->game->game_name : 'N/A'}}</td>
                        <td class="px-6 py-4">
                            @if($rom->has_file)
                                <x-rom-file-download :rom-file="$rom->romFile">
                                    <x-slot:submitButton>
                                        <button type="submit" class="{!! join(_SPACE, $downloadBtnClasses) !!}">
                                            <span class="order-0">@include('partials._download-icon')</span>
                                            <span class="order-1 ml-2">Download!</span>
                                        </button>
                                    </x-slot:submitButton>
                                </x-rom-file-download>
                            @else
                                <p class="font-normal text-lg">No File yet :(</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" class="{{implode(_SPACE, $getInfoBtnClasses)}}"
                                    wire:click="show({{$rom->id}})">Get Info
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class="text-sm text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                    <td class="px-6 py-3">
                        <p>Total Count:&nbsp;<span class="font-semibold">{{count($roms)}}&nbsp;ROMs</span></p>
                    </td>
                    <td class="px-6 py-3">
                        <p>Total Size:&nbsp;<span class="font-semibold">{{$roms_total_size}}&nbsp;Bytes</span></p>
                    </td>
                </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
