@push('scripts')
    <script type="text/javascript" src="{{asset('js/modules/capitalize.js')}}"></script>
@endpush
<div>
    <x-slot name="header">
        <h2 class="text-center">Edit {{$game->game_name}} Version</h2>
    </x-slot>
    <div class="p-3">
        @include('ui.session-error')

        <x-jet-validation-errors class="mb-4"/>

        <form wire:submit.prevent="update">

            <div class="mt-2.5">
                <x-jet-label for="gameName" value="{{__('Game Name')}}"/>
                <x-jet-input id="gameName" class="block mt-1 w-full" type="text" name="game_name"
                             wire:model="game_name"
                             minlength="{{MIN_GAME_NAME}}"
                             maxlength="{{MAX_GAME_NAME}}"
                             required autofocus
                />
            </div>
            <div class="mt-2.5">
                <label for="gameType" class="block font-medium text-sm text-gray-700">{{__('Game Type')}}</label>
                <x-form-select
                    wire:model="game_type"
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
                    wire:model="region"
                    element-name="region" html-id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $gameRegion)
                        <option
                            value="{{$gameRegion}}"
                            {!! (strtolower($game->region) == $gameRegion)
                                  ? 'selected' : '' !!}>
                            {{ ucfirst($gameRegion) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="dateReleased" value="{{__('Date Released')}}"/>
                <x-jet-input type="date"
                             wire:model="date_released"
                             class="block mt-1 w-full"
                             id="dateReleased" name="date_released" required autofocus/>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="generation" value="{{__('Generation')}}"/>
                <x-jet-input type="number" :value="$game->generation" id="generation" name="generation"
                             class="block mt-1 w-full"
                             wire:model="generation"
                             min="{{MIN_GAME_GENERATION}}" max="{{MAX_GAME_GENERATION}}" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-button class="float-right" wire:click="update">
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
