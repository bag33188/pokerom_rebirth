<form action="{{route('rom-files.delete', $romFile)}}" method="POST">
    @method('DELETE')
    @csrf

    <x-jet-danger-button type="submit">
        Delete {{$romFile->filename}}
    </x-jet-danger-button>
</form>
