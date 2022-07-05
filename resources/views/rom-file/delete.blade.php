<form action="{{route('rom-files.delete', $romFile)}}" method="POST">
    @method('DELETE')
    @csrf

    <div class="flex justify-end">
        <x-jet-danger-button type="submit">
            Delete <span class="font-bold">{{$romFile->filename}}</span>
        </x-jet-danger-button>
    </div>
</form>
