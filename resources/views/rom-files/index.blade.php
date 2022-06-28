<x-app-layout>
    @foreach($romFiles as $romFile)
        <div>
            <p>{{$romFile->filename}}</p>
            <a href="{{route('files.show', $romFile->_id)}}" {!! JETSTREAM_BTN_CLASSES !!}>Actions</a>
        </div>
    @endforeach
</x-app-layout>
