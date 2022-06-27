<div>
    <form action="{{route('files.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div>
            <label for="romFile">RomFile</label>
            <input id="romFile" name="file" type="file">
        </div>

        <button type="submit">Upload!</button>
    </form>
</div>
