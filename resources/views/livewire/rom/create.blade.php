<div class="container mx-auto w-full">
    <x-slot name="header">
        <h2 class="text-center text-lg">Add a ROM</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4"/>
        @include('ui.session-error')

        <form wire:submit.prevent="store">

            <div class="mt-2.5">
                <x-jet-label for="romName" :value="__('Rom Name')"/>
                <x-jet-input id="romName"
                             wire:model="rom_name"
                             class="block mt-1 w-full"
                             type="text"
                             name="rom_name"
                             minlength="{{MIN_ROM_NAME_LENGTH}}"
                             maxlength="{{MAX_ROM_NAME_LENGTH}}"
                             required autofocus/>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romType" :value="__('Rom Type')"/>
                <x-form-select
                    wire:model.lazy="rom_type"
                    name="rom_type" id="romType"
                    required autofocus>
                    <option value="" selected>Select ROM Type</option>
                    @foreach(ROM_TYPES as $index => $romType)
                        <option value="{{$romType}}"
                                wire:key="rom-type-{{$index + 1}}">
                            {{ strtoupper($romType) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romSize" :value="__('Rom Size')"/>
                <x-jet-input id="romSize"
                             wire:model="rom_size"
                             name="rom_size"
                             class="block mt-1 w-full"
                             type="number" min="{{MIN_ROM_SIZE}}"
                             max="{{MAX_ROM_SIZE}}"
                             required autofocus/>
            </div>
            <div class="mt-4">
                <x-jet-button class="float-right" wire:click="store">
                    {{ __('Save!') }}
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
