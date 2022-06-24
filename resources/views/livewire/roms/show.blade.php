@php
    $editBtnClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-gray-800 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
    focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300
    disabled:opacity-25 transition"
    EOS;
    $listItemClasses = 'class="px-6 py-2 border-b border-gray-200 w-full"';
    $isAdmin = Auth::user()->isAdmin();
@endphp
<div class="p-2.5">
    <x-slot name="header">
        <h2 class="text-center">{{$rom->getRomFileName()}} Information</h2>
    </x-slot>
    <div class="w-full grid grid-cols-2 grid-rows-{{$isAdmin ? 2 : 1}} gap-y-4">
        <ul class="bg-white rounded-lg border border-gray-200 text-gray-900 col-span-full row-start-1 row-end-1">
            <li {!! $listItemClasses !!}>Rom Name: {{$rom->rom_name}}</li>
            <li {!! $listItemClasses !!}>Rom Size: {{RomRepo::getReadableRomSize($rom->rom_size)}}</li>
            <li {!! $listItemClasses !!}>Rom Type: {{$rom->rom_type}}</li>
            <li {!! $listItemClasses !!}>Game Name: {{@$rom->game->game_name . ' Version' ?? 'no game'}}</li>
            @if($rom->has_game)
                <li {!! $listItemClasses !!}>Game Region: {{$rom->game->region}}</li>
                <li {!! $listItemClasses !!}>Generation: {{number_to_roman($rom->game->generation)}}</li>
                <li {!! $listItemClasses !!}>Date Released: {{parse_date_as_readable_string($rom->game->date_released, addDayName: false)}}</li>
                <li {!! $listItemClasses !!}>Game Type: {{$rom->game->game_type}}</li>
            @endif
        </ul>

        @if($isAdmin)
            <div class="col-start-2 col-end-2 row-start-2 row-end-2 justify-self-end">
                @livewire('roms.delete', ['romId' => $romId])
            </div>
            <div class="col-start-1 col-end-1 row-start-2 row-end-2 justify-self-start">
                <a href="{{route('roms.edit', $this->rom->id)}}" {!! $editBtnClasses !!}>Edit!</a>
            </div>
        @endif
    </div>
</div>
