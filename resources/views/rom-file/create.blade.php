@push('styles')
    <style {!! 'type="text/css"'; !!}>
        .white-space-pre {
            white-space: pre;
        }

        .no-pointer-events {
            pointer-events: none;
        }

        .bg-html-white-smoke {
            background-color: #F5F5F5;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        let handleCreateRomFileForm = function () {
            let uploadBtn = document.querySelector("button[data-name=submit-rom-file]");
            const romFilenameField =
                document.forms["create-rom-file-form"]["rom_filename"];
            document.forms["create-rom-file-form"].addEventListener(
                "submit",
                function () {
                    const _CRLF = "\r\n";
                    uploadBtn.classList.add("white-space-pre");
                    uploadBtn.disabled = true;
                    uploadBtn.textContent =
                        `PLEASE WAIT....${_CRLF}THIS COULD TAKE A WHILE`;
                    romFilenameField.classList.add(
                        "no-pointer-events",
                        "bg-html-white-smoke"
                    );
                }
            );
        };
    </script>
    <script type="text/javascript">
        handleCreateRomFileForm();
    </script>
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
            <form action="{{route('rom-files.store')}}" name="create-rom-file-form" method="POST"
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
                    <x-punch-button type="submit" text="Upload!" data-name="submit-rom-file"/>
                </div>
            </form>
        @endunless
    </div>
</x-app-layout>
