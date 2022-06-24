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
        @method('PATCH')

        <div>
            <x-jet-label for="romName" value="{{ __('Rom Name') }}" />
            <x-jet-input id="romName" class="block mt-1 w-full" type="text" name="rom_name" :value="old('rom_name')"
                         required autofocus />
        </div>

        <x-jet-button class="ml-4">
            {{ __('Update!') }}
        </x-jet-button>
    </form>
</div>
