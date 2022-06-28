<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center">{{$romFile->filename}} Information</h2>
    </x-slot>
    <div class="m-2.5">
        <ul class="bg-white rounded-lg shadow-lg border border-gray-200 text-gray-900 col-span-full row-start-1 row-end-1">
            <li {!! LIST_ITEM_CLASSES !!}>{{$romFile->filename}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>{{$romFile->length}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>{{$romFile->_id}}</li>
            <li {!! LIST_ITEM_CLASSES !!}>@include('rom-files.delete', $romFile)</li>
        </ul>
    </div>
</x-app-layout>
