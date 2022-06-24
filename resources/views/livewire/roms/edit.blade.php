@php
    $formSelectClasses = <<<EOS
    border-gray-300 focus:border-indigo-300
    focus:ring focus:ring-indigo-200
    focus:ring-opacity-50 rounded-md shadow-sm
    block mt-1 w-full
    EOS;
@endphp
<div>
    <x-slot name="header">
        <h2>Edit {{$rom->getRomFileName()}}</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{route("roms.update", $romId)}}">
            @csrf
            @method('PUT')

            <div class="mt-2.5">
                <x-jet-label for="romName" value="{{ __('Rom Name') }}" />
                <x-jet-input id="romName" class="block mt-1 w-full" type="text" name="rom_name" :value="$rom->rom_name"
                             required autofocus />
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romType" value="{{ __('Rom Type') }}" />
                <select
                    class="{{ $formSelectClasses }}"
                    name="rom_type" id="romType"
                    required autofocus>
                    @foreach(ROM_TYPES as $romType)
                        <option
                            value="{{$romType}}"
                            {{strtolower($rom->rom_type) == $romType ? 'selected' : ''}}
                        >{{ strtoupper($romType) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romSize" value="{{ __('Rom Size') }}" />
                <x-jet-input id="romSize"
                             name="rom_size"
                             class="block mt-1 w-full"
                             type="number" min="{{MIN_ROM_SIZE}}"
                             max="{{MAX_ROM_SIZE}}"
                             :value="$rom->rom_size"
                             required autofocus />
            </div>
            <x-jet-button class="mt-4">
                {{ __('Update!') }}
            </x-jet-button>
        </form>
    </div>
</div>
