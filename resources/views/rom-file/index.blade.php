@php
    $alpineInitialDisplayState = \App\Enums\DisplayStateEnum::SHOW;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&#xE9;mon ROM Files (<span
                class="font-semibold">{{$romFilesCount}} ROM Files in Total</span>)</h2>
    </x-slot>
    <div x-data="{ open: true }">
        @unless($romFilesCount > 0)
            <h2 class="text-center text-lg mt-7">No ROM Files Exist in database</h2>
        @else
            <x-show-hide-button text="ROM Files" :initial-state="$alpineInitialDisplayState" />
            <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4 mx-4 mb-4 mt-1 items-center"
                 x-show="{{$alpineInitialDisplayState->value}}" x-cloak>
                @foreach($romFiles as $i => $romFile)
                    @include('rom-file.tile', ['index' => $i, 'romFile' => $romFile])
                @endforeach
            </div>
        @endunless
    </div>
</x-app-layout>
