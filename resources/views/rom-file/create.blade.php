<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-lg">Upload a ROM File</h2>
    </x-slot>
    <div class="p-6">
        <form action="{{route('rom-files.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="flex flex-col">
                @php
                    function parse_accepted_file_types(): string {
                      // full stop (period)
                      $initialChar ="\x2E";
                      // comma
                      $separator = "\x2C" . $initialChar; // ,.
                      // filetype1,.filetype2,.filetype3,.....
                      $joinedFileTypes = join($separator, ROM_TYPES);
                      // add initial full stop char
                      // .filetype1,.filetype2,.filetype3,.....
                      return $initialChar . $joinedFileTypes;
                    }
                @endphp
                <label for="romFile">Rom File</label>
                <input id="romFile" name="{{FILE_FORM_KEY}}" type="file" accept="{{parse_accepted_file_types()}}"
                       required />
            </div>

            <div class="my-4">
                <button type="submit" class="punch">Upload!</button>
            </div>
        </form>
    </div>
</x-app-layout>
