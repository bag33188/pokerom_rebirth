@push('scripts')
    @if($availableRomsCount > 0)
        <script type="text/javascript" src="{{asset('js/modules/capitalize.js')}}"></script>
    @endif
@endpush
<div class="container mx-auto w-full">
    <x-slot name="header">
        <h2 class="text-center">Add Game</h2>
    </x-slot>
    <div class="mt-3.5">
        @if($availableRomsCount > 0)

            <x-jet-validation-errors class="mb-4"/>

            <form wire:submit.prevent="submit" method="POST">
                @method('POST')
                @csrf

                <label for="availableRoms">Select ROM</label>
                <x-form-select wire:model="rom_id" html-id="availableRoms" element-name="rom_id" autofocus required>
                    @php
                        foreach ($availableRoms as $rom) {
                            echo "<option value='{$rom->id}'>$rom->rom_name</option>";
                        }
                    @endphp
                </x-form-select>
                <div class="mt-2.5">
                    <x-jet-label for="gameName" value="{{__('Game Name')}}"/>
                    <x-jet-input wire:model="game_name" id="gameName" class="block mt-1 w-full" type="text"
                                 name="game_name"
                                 minlength="{{MIN_GAME_NAME}}"
                                 maxlength="{{MAX_GAME_NAME}}"
                                 required autofocus
                    />
                </div>
                <div class="mt-2.5">
                    <label for="gameType" class="block font-medium text-sm text-gray-700">{{__('Game Type')}}</label>
                    <x-form-select wire:model="game_type" element-name="game_type" html-id="gameType"
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
                        wire:model="region"
                        element-name="region" html-id="gameRegion"
                        required autofocus>
                        @for($i = 0; $i < count(REGIONS); $i++)
                            <option value="{{REGIONS[$i]}}" id="region-{{$i + 1}}">{{ REGIONS[$i] }}</option>
                        @endfor
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
                    <x-jet-input type="number" id="generation" name="generation"
                                 wire:model="generation"
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
    @if($availableRomsCount > 0)
        <script type="text/javascript">
            const regionsLength = {{sizeof(REGIONS)}};
            for (let i = 0; i < regionsLength; i++) {
                let regionName = document.getElementById(`region-${i + 1}`);
                regionName.textContent = regionName.textContent.capitalize();
            }
        </script>
    @endif
</div>
