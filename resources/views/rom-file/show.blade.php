@php
    $downloadBtnClasses = [
        'inline-flex', 'items-center', 'py-2', 'px-3', 'text-sm', 'font-medium',
        'text-center', 'text-white', 'bg-teal-600', 'rounded-lg', 'hover:bg-teal-500',
        'focus:ring-4', 'focus:outline-none', 'focus:ring-teal-400'
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">{{ $romFile->filename }} Information</h2>
    </x-slot>
    <div class="m-2.5">
        <x-list-group>
            <x-list-item>BSON Object ID: {{ $romFile->_id }}</x-list-item>
            <x-list-item>Filename: {{ $romFile->filename }}</x-list-item>
            <x-list-item>Filesize: {{ $romFile->length }} Bytes</x-list-item>
            <x-list-item>Chunk Size: {{ $romFile->chunkSize * 0x08 }} Bits</x-list-item>
            <x-list-item>MD5 Hash: {{ $romFile->md5 }}</x-list-item>
            <x-list-item>
                <span class="w-full"
                    {!! empty($romFile->rom) ? 'title="this ROM File does not have an associated ROM"': '' !!}>
                    Assoc. ROM ID: {{ $romFile->rom->id ?? 'N/A' }}
                </span>
            </x-list-item>
            <x-list-item>
                <div class="inline-flex flex-row justify-between w-full">
                    <span class="order-0">
                        <x-rom-file-download :rom-file="$romFile">
                            <x-slot name="button">
                                <button type="submit" class="{!! join(_SPACE, $downloadBtnClasses) !!}">
                                    <span class="order-1">@include('partials._download-icon')</span>
                                    <span class="order-0 mr-2">Download!</span>
                                </button>
                            </x-slot>
                        </x-rom-file-download>
                    </span>
                    <span class="order-1">@include('rom-file.delete', ['romFile' => $romFile])</span>
                </div>
            </x-list-item>
        </x-list-group>
    </div>
</x-app-layout>
