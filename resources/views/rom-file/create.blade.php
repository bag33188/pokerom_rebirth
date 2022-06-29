<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">Upload a ROM File</h2>
    </x-slot>
    <div class="p-6">
        @php
            $files = Storage::disk('local')->files('rom_files');
        @endphp
        <x-jet-validation-errors class="mb-4"/>
        <form action="{{route('rom-files.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="flex flex-col">
                <label for="romFile">Rom File</label>
                <select name="filename" id="romFile">
                    @foreach($files as $file)
                        <option value="{{$file}}">{{$file}}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-4">
                <button type="submit" class="punch">Upload!</button>
            </div>
        </form>
    </div>
</x-app-layout>
