@push('scripts')
    <script type="text/javascript" src="{{asset('js/modules/capitalize.js')}}"></script>
@endpush
<div>
    <x-slot name="header">
        <h2 class="text-center">Edit {{$game->game_name}} Version</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{route('games.update', ['gameId'=>$gameId])}}">
            @csrf
            @method('PUT')

            <div class="mt-2.5">
                <x-jet-label for="gameName" value="{{__('Game Name')}}"/>
                <x-jet-input id="gameName" class="block mt-1 w-full" type="text" name="game_name"
                             minlength="{{MIN_GAME_NAME}}"
                             maxlength="{{MAX_GAME_NAME}}"
                             :value="ununicode_poke($game->game_name)"
                             required autofocus
                />
            </div>
            <div class="mt-2.5">
                <label for="gameType" class="block font-medium text-sm text-gray-700">{{__('Game Type')}}</label>
                <x-form-select
                    element-name="game_type" html-id="gameType"
                    required autofocus>
                    @foreach(GAME_TYPES as $gameType)
                        <option
                            value="{{$gameType}}"
                            id="game-type-{{array_search($gameType, GAME_TYPES) + 1}}"
                            {!! (strtolower($game->game_type) == $gameType)
                                  ? 'selected' : '' !!}>
                            {{ $gameType }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <label for="gameRegion" class="block font-medium text-sm text-gray-700">{{__('Region')}}</label>
                <x-form-select
                    element-name="region" html-id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $region)
                        <option
                            value="{{$region}}"
                            {!! (strtolower($game->region) == $region)
                                  ? 'selected' : '' !!}>
                            {{ ucfirst($region) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="dateReleased" value="{{__('Date Released')}}"/>
                <x-jet-input type="date"
                             class="block mt-1 w-full"
                             :value="preg_replace(TIME_STRING, '', $game->date_released)"
                             id="dateReleased" name="date_released" required autofocus/>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="generation" value="{{__('Generation')}}"/>
                <x-jet-input type="number" :value="$game->generation" id="generation" name="generation"
                             class="block mt-1 w-full"
                             min="{{MIN_GAME_GENERATION}}" max="{{MAX_GAME_GENERATION}}" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-button class="float-right">
                    {{ __('Save!') }}
                </x-jet-button>
                <div class="float-left">
                    <a href="{{route('games.show', ['gameId'=>$gameId])}}" {!! BTN_PRIMARY_CLASSES !!}>Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script>
        const gameTypesCount = {{sizeof(GAME_TYPES)}};
        for (let i = 0; i < gameTypesCount; i++) {
            let gameType = document.getElementById(`game-type-${i + 1}`);
            gameType.textContent = gameType.textContent.capitalize(true, 2, '-');
        }
    </script>
</div>
