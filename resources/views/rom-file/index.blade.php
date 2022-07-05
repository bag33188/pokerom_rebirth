@php
    $btnClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-blue-700 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-blue-800 active:bg-blue-800
    focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-300
    disabled:opacity-25 transition"
    EOS;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">Pok&#xE9;mon ROM Files</h2>
    </x-slot>
    @unless(sizeof($romFiles) > 0)
        <h2 class="text-center text-lg mt-7">No ROM Files Exist in database</h2>
    @else
        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4 m-4 items-center">
            @foreach($romFiles as $romFile)
                <div
                    data-rom-file-id="{{$romFile->_id}}"
                    class="border border-gray-200 bg-white shadow-md rounded w-full h-full inline-grid grid-cols-1 grid-rows-[auto_auto] gap-y-2 justify-self-center p-2">
                    <p>{{$romFile->filename}}</p>
                    <p>{{$romFile->length}} Bytes</p>
                    <div class="justify-self-start align-self-end">
                        <a href="{{route('rom-files.show', $romFile)}}" {!! $btnClasses !!}>Actions</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endunless
</x-app-layout>
