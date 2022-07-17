<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Edit {{$game->game_name}} Version</h2>
    </x-slot>
    <div class="p-3">
        @include('ui.session-message')

        <x-jet-validation-errors class="mb-4"/>

        <form wire:submit.prevent="update">

            <div class="mt-2.5">
                <x-jet-label for="gameName" :value="__('Game Name')"/>
                <x-jet-input id="gameName" class="block mt-1 w-full" type="text" name="game_name"
                             wire:model="game_name"
                             minlength="{{MIN_GAME_NAME_LENGTH}}"
                             maxlength="{{MAX_GAME_NAME_LENGTH}}"
                             required autofocus
                />
            </div>
            <div class="mt-2.5">
                <x-jet-label for="gameType" :value="__('Game Type')"/>
                <x-form-select
                    wire:model.lazy="game_type"
                    name="game_type" id="gameType"
                    required autofocus>
                    @foreach(GAME_TYPES as $index => $gameType)
                        <option
                            value="{{$gameType}}"
                            wire:key="game-type-{{$index + 1}}">
                            {{ str_capitalize($gameType, true, 2, '-') }}
                        </option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="gameRegion" :value="__('Region')"/>
                <x-form-select
                    wire:model.lazy="region"
                    name="region" id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $index => $gameRegion)
                        <option value="{{$gameRegion}}"
                                wire:key="game-region-{{$index + 1}}"
                        >{{ ucfirst($gameRegion) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="dateReleased" :value="__('Date Released')"/>
                <x-jet-input type="date"
                             wire:model="date_released"
                             class="block mt-1 w-full"
                             id="dateReleased" name="date_released" required autofocus/>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="generation" :value="__('Generation')"/>
                <x-jet-input type="number" :value="$game->generation" id="generation" name="generation"
                             class="block mt-1 w-full"
                             wire:model="generation"
                             min="{{MIN_GAME_GENERATION_VALUE}}" max="{{MAX_GAME_GENERATION_VALUE}}" required
                             autofocus/>
            </div>

            <div class="mt-4">
                <div class="float-right">
                    <x-jet-button wire:click="update">
                        {{ __('Save!') }}
                    </x-jet-button>
                </div>
                <div class="float-left">
                    <x-jet-secondary-button type="button" wire:click="cancel({{$gameId}})">
                        {{__('Cancel')}}
                    </x-jet-secondary-button>
                </div>
            </div>
        </form>
    </div>
</div>
