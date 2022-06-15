<div x-data="{ open: true }">
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&eacute;mon ROMs library</h2>
    </x-slot>
    <div class="w-full flex justify-center">
        <button type="button" @click="open = !open" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 my-4 shadow rounded">
            @include("ui.show-hide", ['txt'=>'ROMs'])
        </button>
    </div>
    <table class="w-full text-sm text-left text-gray-500 light:text-gray-400" x-show="open">
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
                <td class="px-6 py-4">{{$this->getRomReadableSize($rom->rom_size)}}</td>
                <td class="px-6 py-4">.{{strtolower($rom->rom_type)}}</td>
                <td class="px-6 py-4">{{$rom->has_game ? $rom->game->game_name : 'N/A'}}</td>
                <td class="px-6 py-4">
                    @if($rom->has_file)
                        <a class="inline-flex items-center py-2 px-4 bg-blue-500 hover:bg-blue-400 text-white font-bold
                                    p-0 border-b-4 border-blue-700 hover:border-blue-500 rounded active:border-t-4
                                    active:border-b-0 active:bg-blue-400"
                           href="{{$this->getRomDownloadUrl($rom->file->_id, dev: true)}}"
                           target="_blank"
                           title="{{$rom->getRomFileName()}}">
                            @include('ui.download-icon')
                            <span>download!</span></a>
                    @else
                        <p class="font-normal text-lg">No File yet :(</p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr class="text-sm text-gray-700 uppercase light:bg-gray-700 light:text-gray-400">
                <td class="px-6 py-4 font-semibold">Total ROMs: {{sizeof($roms)}}</td>
                <td class="px-6 py-4 font-semibold">Total file size of all ROMs: {{$roms_total_size}}</td>
            </tr>
        </tfoot>
    </table>
</div>
