<x-app-layout>
    <ul>
        <li>{{$romFile->filename}}</li>
        <li>{{$romFile->length}}</li>
        <li>{{$romFile->_id}}</li>
        <li>@include('rom-files.delete', $romFile)</li>
    </ul>
</x-app-layout>
