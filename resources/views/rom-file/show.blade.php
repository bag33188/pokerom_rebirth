<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">{{$romFile->filename}} Information</h2>
    </x-slot>
    <div class="m-2.5">
        <x-list-group>
            <x-list-item>BSON Object ID: {{$romFile->_id}}</x-list-item>
            <x-list-item>Filename: {{$romFile->filename}}</x-list-item>
            <x-list-item>Filesize: {{$romFile->length}} Bytes</x-list-item>
            <x-list-item>Chunk Size: {{$romFile->chunkSize}}</x-list-item>
            <x-list-item>MD5 Hash: {{$romFile->md5}}</x-list-item>
            <x-list-item>@include('rom-file.delete', $romFile)</x-list-item>
        </x-list-group>
    </div>
</x-app-layout>
