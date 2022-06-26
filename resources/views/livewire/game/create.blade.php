<div class="container mx-auto w-full">
    <x-slot name="header">
        <h2 class="text-center">Add Game</h2>
    </x-slot>
    <div class="mt-3.5">
        @if($availableRomsCount > 0)
            <form action="{{route('games.store')}}" method="POST">
                @method('POST')
                @csrf

                <label for="availableRoms">Select ROM</label>
                <x-form-select html-id="availableRoms" element-name="rom_id" autofocus required>
                    @php
                        for($i = 0; $i < $availableRomsCount; $i++) {
                            $rom = $availableRoms[$i];
                            $html = /** @lang HTML */ "<option value='$rom->id'>$rom->rom_name</option>";
                            print $html;
                        }
                    @endphp
                </x-form-select>
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
                    <x-form-select element-name="game_type" html-id="gameType"
                                   required autofocus>
                        @foreach(GAME_TYPES as $gameType)
                            <option
                                value="{{$gameType}}">
                                {{ str_capitalize($gameType, true, 2, '-') }}</option>
                        @endforeach
                    </x-form-select>
                </div>
                <div class="mt-2.5">
                    <label for="gameRegion" class="block font-medium text-sm text-gray-700">{{__('Region')}}</label>
                    <x-form-select
                        element-name="region" html-id="gameRegion"
                        required autofocus>
                        @foreach(REGIONS as $region)
                            <option value="{{$region}}">{{ ucfirst($region) }}</option>
                        @endforeach
                    </x-form-select>
                </div>
                <div class="mt-2.5">
                    <x-jet-label for="dateReleased" value="{{__('Date Released')}}"/>
                    <x-jet-input type="date"
                                 class="block mt-1 w-full"
                                 id="dateReleased" name="date_released" required autofocus/>
                </div>
                <div class="mt-2.5">
                    <x-jet-label for="generation" value="{{__('Generation')}}"/>
                    <x-jet-input type="number" id="generation" name="generation"
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
            <h2 class="text-center text-lg mt-3">Sorry, there are no available roms to add a game to :(</h2>
        @endif
    </div>
</div>
