{{-- parameters:
    romFile (RomFile)
--}}
<form action="{{route('rom-files.delete', ['romFile' => $romFile])}}" method="POST">
    @method('DELETE')
    @csrf

    <div class="flex justify-end">
        <x-jet-danger-button type="submit">
            <span>Delete{!! "&#160;" !!}<span class="font-bold">{{$romFile->filename}}</span></span>
        </x-jet-danger-button>
    </div>
</form>
