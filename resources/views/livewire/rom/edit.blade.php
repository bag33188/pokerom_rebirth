<div>
    <x-slot name="header">
        <h2 class="text-center">Edit {{$rom->getRomFileName()}}</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" wire:submit.prevent="update">
            @csrf
            @method('PUT')

            <div class="mt-2.5">
                <x-jet-label for="romName" value="{{ __('Rom Name') }}"/>
                <x-jet-input id="romName"
                             wire:model="rom_name"
                             class="block mt-1 w-full"
                             type="text"
                             name="rom_name"
                             minlength="{{MIN_ROM_NAME}}"
                             maxlength="{{MAX_ROM_NAME}}"
                             required autofocus/>
            </div>
            <div class="mt-2.5">
                <label for="romType" class="block font-medium text-sm text-gray-700">{{__('Rom Type')}}</label>
                <x-form-select
                    wire:model="rom_type"
                    element-name="rom_type" html-id="romType"
                    required autofocus>
                    @foreach(ROM_TYPES as $romType)
                        <option
                            value="{{$romType}}"
                            {!! (strtolower($rom->rom_type) == $romType)
                                  ? 'selected' : '' !!}>
                            {{ strtoupper($romType) }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romSize" value="{{ __('Rom Size') }}"/>
                <x-jet-input id="romSize"
                             wire:model="rom_size"
                             name="rom_size"
                             class="block mt-1 w-full"
                             type="number" min="{{MIN_ROM_SIZE}}"
                             max="{{MAX_ROM_SIZE}}"
                             required autofocus/>
            </div>
            <div class="mt-4">
                <x-jet-button class="float-right">
                    {{ __('Save!') }}
                </x-jet-button>
                <div class="float-left">
                    <a href="{{route('roms.show', ['romId'=>$romId])}}" {!! BTN_PRIMARY_CLASSES !!}>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
