<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center">Pok&eacute;mon ROM Files</h2>
    </x-slot>
    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 m-4 items-center">
        @foreach($romFiles as $romFile)
            <div
                class="border border-teal-500 bg-white shadow-lg rounded w-full h-full inline-grid grid-cols-1 grid-rows-[auto_auto] gap-y-2 justify-self-center p-2">
                <p title="{{$romFile->_id}}">{{$romFile->filename}}</p>
                <p>{{$romFile->length}} Bytes</p>
                <div class="justify-self-start align-self-end">
                    <a href="{{route('rom-files.show', $romFile)}}" {!! BTN_PRIMARY_CLASSES !!}>Actions</a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
