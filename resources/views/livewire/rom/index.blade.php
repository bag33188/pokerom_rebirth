<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon ROMs Library</h2>
    </x-slot>
    <div x-data="{ open: true }">
        <div class="w-full flex justify-center">
            @php
                $romsTableInitDispState=\App\Enums\DisplayStatesEnum::SHOW->value;
            @endphp
            <button type="button" @click="open = !open"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 my-4 shadow-md rounded">
                @include("ui.show-hide", ['text'=>'ROMs', 'initialState'=>$romsTableInitDispState])
            </button>
        </div>
        <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" x-show="open" x-cloak>
            <thead class="bg-gray-50">
            <tr class="text-xs text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                @for($i = 0; $i < count($romsTableColumns); $i++)
                    <th scope="col" class="px-6 py-3">{{$romsTableColumns[$i]}}</th>
                @endfor
            </tr>
            </thead>
            <tbody class="light:bg-gray-800">
            @foreach($roms as $rom)
                <tr data-rom-id="{{$rom->id}}"
                    class="border-b light:border-gray-700 odd:bg-white even:bg-gray-50 odd:light:bg-gray-800 even:light:bg-gray-700">
                    <td class="px-6 py-4">{{$rom->rom_name}}</td>
                    <td class="px-6 py-4">{{RomRepo::getReadableRomSize($rom->rom_size)}}</td>
                    <td class="px-6 py-4">.{{strtolower($rom->rom_type)}}</td>
                    <td class="px-6 py-4">{{$rom->has_game ? $rom->game->game_name : 'N/A'}}</td>
                    <td class="px-6 py-4">
                        @if($rom->has_file)
                            <a class="inline-flex items-center py-2 px-4 bg-blue-500 hover:bg-blue-400 text-white font-bold
                                    p-0 border-b-4 border-blue-700 hover:border-blue-500 rounded active:border-t-4
                                    active:border-b-0 active:bg-blue-400"
                               href="{{$this->getRomDownloadUrl($rom->romFile->_id, dev: true)}}"
                               target="_blank"
                               title="{{$rom->getRomFileName()}}">
                                @include('partials._download-icon')
                                <span>download!</span></a>
                        @else
                            <p class="font-normal text-lg">No File yet :(</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" class="inline-flex items-center py-2 px-4 bg-red-500 hover:bg-red-400 text-white font-bold
                                    p-0 border-b-4 border-red-700 hover:border-red-500 rounded active:border-t-4
                                    active:border-b-0 active:bg-red-400" wire:click="show({{$rom->id}})">Get Info
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="text-sm text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                <td class="px-6 py-3">Total Count:&nbsp;<span class="font-semibold">{{count($roms)}}</span></td>
                <td class="px-6 py-3">Total Size:&nbsp;<span class="font-semibold">{{$roms_total_size}}</span></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
