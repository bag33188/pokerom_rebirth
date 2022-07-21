@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/punch.css') }}"/>
@endpush
@php
    $romFilesDirCount = count($romFilesList);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">
            Upload a ROM File <span class="font-semibold">({{$romFilesDirCount}} found in directory)</span>
        </h2>
    </x-slot>
    <div class="p-6">
        @unless($romFilesDirCount > 0)
            <h2 class="text-center text-lg mt-7">No ROM Files found in <samp>{{ROM_FILES_DIRNAME}}</samp> folder</h2>
        @else
            <x-jet-validation-errors class="mb-4"/>
            <form action="{{route('rom-files.store')}}" id="rom-file-create-form" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="flex flex-col">
                    <x-jet-label for="romFile" :value="__('ROM Fle')"/>
                    <x-form-select name="rom_filename" id="romFile">
                        @foreach($romFilesList as $index => $romFilename)
                            <option
                                value="{{$romFilename}}"
                                id="rom-file-{{$index + 1}}"
                            >{{$romFilename}}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="my-4">
                    <x-punch-button type="submit" text="Upload!" id="submit-rom-file-btn"/>
                </div>
            </form>
        @endunless
    </div>
    <script>
        let btn;
        Array.prototype.slice.call(document.getElementById('submit-rom-file-btn').childNodes).forEach((e) => {
            if (e.nodeName === 'BUTTON') btn = e;
        })
        console.log(btn)
        document.getElementById('rom-file-create-form').addEventListener('submit', function () {
            a.disabled = true;
            a.textContent = 'PLEASE WAIT... THIS COULD TAKE A WHILE';
        })
    </script>
</x-app-layout>
