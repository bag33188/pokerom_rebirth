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
    $tableRowClasses = [
        'border',
        'light:border-gray-700',
        'odd:bg-white',
        'even:bg-gray-50',
        'odd:light:bg-gray-800',
        'even:light:bg-gray-700'
    ];
@endphp
<tr data-rom-id="{{$rom->getKey()}}" class="{{ implode(_SPACE, $tableRowClasses) }}">
    <td class="px-6 py-4">{{$rom->rom_name}}</td>
    <td class="px-6 py-4">{{RomRepo::getFormattedRomSize($rom->rom_size)}}</td>
    <td class="px-6 py-4">.{{strtolower($rom->rom_type)}}</td>
    <td class="px-6 py-4" {!! empty($rom->game_id) ? 'title="this ROM does not have a game"' : '' !!}>
        {{ $rom->has_game ? $rom->game->game_name : 'N/A' }}
    </td>
    <td class="px-6 py-4">
        @if($rom->has_file)
            <x-rom-file-download :rom-file="$rom->romFile">
                <x-slot:button>
                    <button type="submit" class="{{ join(_SPACE, $downloadBtnClasses) }}">
                        <span class="order-0">@include('partials._download-icon')</span>
                        <span class="order-1 ml-2">Download!</span>
                    </button>
                </x-slot:button>
            </x-rom-file-download>
        @else
            <p class="font-normal text-lg"
                {!! empty($rom->file_id) ? 'title="this ROM does not yet have a file"' : '' !!}>
                No ROM File yet :(
            </p>
        @endif
    </td>
    <td class="px-6 py-4">
        <button type="button"
                class="{{ implode(_SPACE, $getInfoBtnClasses) }}"
                wire:click="getInfo({{$rom->id}})">
            Get Info
        </button>
    </td>
</tr>
