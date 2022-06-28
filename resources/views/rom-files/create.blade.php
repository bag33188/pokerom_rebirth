<x-app-layout>
    <div class="p-6">
        <form action="{{route('files.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="flex flex-col">
                <label for="romFile">RomFile</label>
                <input id="romFile" name="file" type="file" />
            </div>

            <div class="my-4">
                <button type="submit" class="punch">Upload!</button>
            </div>
        </form>
    </div>

</x-app-layout>
