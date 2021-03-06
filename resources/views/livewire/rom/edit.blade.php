<div>
    <x-slot name="header">
        <h2 class="text-center text-lg">Edit {{$rom->getRomFileName()}}</h2>
    </x-slot>
    <div class="p-3">
        @include('ui.session-message')
        <x-jet-validation-errors class="mb-4" />

        <form wire:submit.prevent="update">
            <div class="mt-2.5">
                <x-jet-label for="romName" :value="__('Rom Name')" />
                <x-jet-input id="romName"
                             wire:model="rom_name"
                             class="block mt-1 w-full"
                             type="text"
                             name="rom_name"
                             minlength="{{MIN_ROM_NAME_LENGTH}}"
                             maxlength="{{MAX_ROM_NAME_LENGTH}}"
                             required autofocus />
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romType" :value="__('Rom Type')" />
                <x-form-select
                    wire:model.lazy="rom_type"
                    name="rom_type" id="romType"
                    required autofocus>
                    @foreach(ROM_TYPES as $index => $romType)
                        <option
                            value="{{$romType}}"
                            wire:key="rom-type-{{$index + 1}}">
                            {{ strtoupper($romType) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romSize" :value="__('Rom Size')" />
                <x-jet-input id="romSize"
                             wire:model="rom_size"
                             name="rom_size"
                             class="block mt-1 w-full"
                             type="number" min="{{MIN_ROM_SIZE}}"
                             max="{{MAX_ROM_SIZE}}"
                             required autofocus />
            </div>
            <div class="mt-4">
                <div class="float-right">
                    <x-jet-button wire:click="update">
                        {{ __('Save!') }}
                    </x-jet-button>
                </div>
                <div class="float-left">
                    <x-jet-secondary-button type="button" wire:click="cancel({{$romId}})">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </form>
    </div>
</div>
