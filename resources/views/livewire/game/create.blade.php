@php
    /**
     * Converts single quotes to double quotes in a given string
     * @param string $data
     * @return void
     */
    function convertSingleToDoubleQuotes(string &$data): void {
        list($singleQuote, $doubleQuote) = array("\u{0027}", "\u{0022}");
        $data = str_replace($singleQuote, $doubleQuote, $data);
    }
@endphp
<div class="container mx-auto w-full">
    <x-slot name="header">
        <h2 class="text-center text-lg">Add Game</h2>
    </x-slot>
    <div class="mt-3.5">
        @include('ui.session-error')

        @if($romsAreAvailable)

            <x-jet-validation-errors class="mb-4"/>

            <form wire:submit.prevent="store">
                <x-jet-label for="availableRoms" :value="__('Select ROM')"/>
                <x-form-select wire:model.lazy="rom_id" id="availableRoms" name="rom_id" autofocus required>
                    @php
                        $placeholder = "<option value='' selected>Select ROM</option>";
                        convertSingleToDoubleQuotes($placeholder);
                        print $placeholder;
                        foreach ($availableRoms as $rom) {
                            normalizeClassObject($rom);
                            $html = "<option value='{$rom->id}' wire:key='{$rom->id}'>{$rom->rom_name}</option>";
                            convertSingleToDoubleQuotes($html);
                            print $html . "\n";
                        }
                    @endphp
                </x-form-select>
                <div class="mt-2.5">
                    <x-jet-label for="gameName" :value="__('Game Name')"/>
                    <x-jet-input wire:model="game_name" id="gameName" class="block mt-1 w-full" type="text"
                                 name="game_name"
                                 minlength="{{MIN_GAME_NAME_LENGTH}}"
                                 maxlength="{{MAX_GAME_NAME_LENGTH}}"
                                 required autofocus
                    />
                </div>
                <div class="mt-2.5">
                    <x-jet-label for="gameType" :value="__('Game Type')"/>
                    <x-form-select wire:model="game_type" name="game_type" id="gameType" required autofocus>
                        <option value="" selected>Select Game Type</option>
                        @foreach(GAME_TYPES as $gameType)
                            <option value="{{$gameType}}">{{str_capitalize($gameType, true, 2, '-')}}</option>
                        @endforeach
                    </x-form-select>
                </div>
                <div class="mt-2.5">
                    <x-jet-label for="gameRegion" :value="__('Region')"/>
                    <x-form-select
                        wire:model="region"
                        name="region" id="gameRegion"
                        required autofocus>
                        <option value="" selected>Select Game Region</option>
                        @foreach(REGIONS as $gameRegion)
                            <option value="{{$gameRegion}}">{{ucfirst($gameRegion)}}</option>
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
                    <x-jet-input type="number" id="generation" name="generation"
                                 wire:model="generation"
                                 class="block mt-1 w-full"
                                 min="{{MIN_GAME_GENERATION_VALUE}}" max="{{MAX_GAME_GENERATION_VALUE}}" required
                                 autofocus/>
                </div>
                <div class="mt-4">
                    <x-jet-button class="float-right" wire:click="store">
                        {{ __('Save!') }}
                    </x-jet-button>
                </div>
            </form>
        @else
            <h2 class="text-center text-lg mt-7">Sorry, there are no available roms to add a game to :(</h2>
        @endif
    </div>
</div>
