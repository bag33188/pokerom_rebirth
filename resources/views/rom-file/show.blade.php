<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">{{$romFile->filename}} Information</h2>
    </x-slot>
    <div class="m-2.5">
        <x-list-group>
            <x-list-item>BSON Object ID: {{$romFile->_id}}</x-list-item>
            <x-list-item>Filename: {{$romFile->filename}}</x-list-item>
            <x-list-item>Filesize: {{$romFile->length}} Bytes</x-list-item>
            <x-list-item>Chunk Size: {{$romFile->chunkSize * 8}} Bits</x-list-item>
            <x-list-item>MD5 Hash: {{$romFile->md5}}</x-list-item>
            <x-list-item>
                @php
                    function getRomFileDownloadUrl(string $fileId): string
                    {
                       $baseUrl = "/public/api";
                       $baseFilesEndpoint = "rom-files/grid/$fileId/download";
                       if (App::isLocal()) return "$baseUrl/dev/$baseFilesEndpoint";
                       return "$baseUrl/$baseFilesEndpoint";
                    }
                @endphp
                <div class="inline-flex flex-row justify-between w-full">
                    <span class="order-0">
                        <a
                            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-teal-600 rounded-lg hover:bg-teal-500 focus:ring-4 focus:outline-none focus:ring-teal-400"
                            href="{{getRomFileDownloadUrl($romFile->_id)}}"
                            target="_self"
                            title="{{$romFile->filename}}">
                                <span>DOWNLOAD</span>
                                @include('partials._download-icon')
                        </a>
                    </span>
                    <span class="order-1">@include('rom-file.delete', $romFile)</span>
                </div>
            </x-list-item>
        </x-list-group>
    </div>
</x-app-layout>
