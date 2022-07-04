<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Edit {{$game->game_name}} Version</h2>
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
                    name="game_type" id="gameType"
                    required autofocus>
                    @foreach(GAME_TYPES as $gameType)
                        <option
                            value="{{$gameType}}"
                            id="game-type-{{array_search($gameType, GAME_TYPES) + 1}}">
                            {{ str_capitalize($gameType, true, 2, '-') }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <label for="gameRegion" class="block font-medium text-sm text-gray-700">{{__('Region')}}</label>
                <x-form-select
                    wire:model="region"
                    name="region" id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $gameRegion)
                        <option
                            value="{{$gameRegion}}">
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
                <div class="float-right">
                    <x-jet-button wire:click="update">
                        {{ __('Save!') }}
                    </x-jet-button>
                </div>
                <div class="float-left">
                    <x-jet-secondary-button type="button" wire:click="cancel({{$gameId}})">Cancel</x-jet-secondary-button>
                </div>
            </div>
        </form>
    </div>
</div>
