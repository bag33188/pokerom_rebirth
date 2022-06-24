<div>
    <x-slot name="header">
        <h2>Edit {{$rom->getRomFileName()}}</h2>
    </x-slot>
    <x-jet-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{route("roms.update", $romId)}}">
        @csrf
        @method('PUT')

        <div>
            <x-jet-label for="romName" value="{{ __('Rom Name') }}" />
            <x-jet-input id="romName" class="block mt-1 w-full" type="text" name="rom_name" :value="old('rom_name')"
                         required autofocus />
        </div>
        <div>
            <x-jet-label for="romType" value="{{ __('Rom Type') }}" />
            <select name="rom_type" id="romType" required>
                @foreach(ROM_TYPES as $romType)
                    <option
                        value="{{$romType}}" {{strtolower($rom->rom_type) == $romType ? 'selected' : ''}}>{{strtoupper($romType)}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-jet-label for="romSize" value="{{ __('Rom Size') }}" />
            <x-jet-input id="romSize" name="rom_size" class="block mt-1 w-full" type="number" min="{{MIN_ROM_SIZE}}"
                         max="{{MAX_ROM_SIZE}}"
                         :value="old('rom_size')"
                         required></x-jet-input>
        </div>
        <x-jet-button class="ml-4">
            {{ __('Update!') }}
        </x-jet-button>
    </form>
</div>
