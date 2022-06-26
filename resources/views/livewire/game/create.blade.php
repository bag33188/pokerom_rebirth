@php
    $formSelectClasses = <<<EOS
    class="border-gray-300 focus:border-indigo-300
    focus:ring focus:ring-indigo-200 focus:ring-opacity-50
    rounded-md shadow-sm block mt-1 w-full"
    EOS;
    $btnPrimaryClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-blue-700 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-blue-800 active:bg-blue-800
    focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-300
    disabled:opacity-25 transition"
    EOS;
@endphp
<div class="container">
    @if($availableRoms > 0)

        <form action="{{route('games.store')}}" method="POST">
            @method('POST')
            @csrf

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
            <div class="mt-2.5">
                <x-jet-label for="gameName" value="{{__('Game Name')}}"/>
                <x-jet-input id="gameName" class="block mt-1 w-full" type="text" name="game_name"
                             minlength="{{MIN_GAME_NAME}}"
                             maxlength="{{MAX_GAME_NAME}}"
                             required autofocus
                />
            </div>
            <div class="mt-2.5">
                <label for="gameType" class="block font-medium text-sm text-gray-700">{{__('Game Type')}}</label>
                <select
                    {!! $formSelectClasses !!}
                    name="game_type" id="gameType"
                    required autofocus>
                    @foreach(GAME_TYPES as $gameType)
                        <option
                            value="{{$gameType}}">
                            {{ str_capitalize($gameType, true, 2, '-') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2.5">
                <label for="gameRegion" class="block font-medium text-sm text-gray-700">{{__('Region')}}</label>
                <select
                    {!! $formSelectClasses !!}
                    name="region" id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $region)
                        <option value="{{$region}}">{{ ucfirst($region) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="dateReleased" value="{{__('Date Released')}}"/>
                <x-jet-input type="date"
                             class="block mt-1 w-full"
                             id="dateReleased" name="date_released" required autofocus/>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="generation" value="{{__('Generation')}}"/>
                <x-jet-input type="number"  id="generation" name="generation"
                             class="block mt-1 w-full"
                             min="{{MIN_GAME_GENERATION}}" max="{{MAX_GAME_GENERATION}}" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-button class="float-right">
                    {{ __('Save!') }}
                </x-jet-button>
            </div>
        </form>

    @else
        <h3>No available roms to add a game to :(</h3>
    @endif

</div>
