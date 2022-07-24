@php
    /**
     * Form Key will usually be an {@see \MongoDB\BSON\ObjectId `ObjectID`} or a `string`.
     * This function will determine its instance and/or type and convert/cast the value accordingly.
     * The returned value is expected be of-type `string`.
     *
     * @param mixed $keyVal
     * @return string
     */
    function getStringValueFromKey(mixed $keyVal): string {
      if ($keyVal instanceof \MongoDB\BSON\ObjectId) {
        return $keyVal->__toString();
      } else if (!is_string($keyVal) || gettype($keyVal) !== "string") {
        return strval($keyVal);
      } else {
        return $keyVal;
      }
    }

    $romFileKey = getStringValueFromKey($key);
@endphp
@push('scripts')
    <script type="text/javascript">
        const disableDownloadFunctions = (romFileKey) => {
            const downloadRomFileBtn = document.getElementById(
                `download-${romFileKey}-btn`
            );
            downloadRomFileBtn.disabled = true;
            downloadRomFileBtn.classList.add("not-allowed", "bg-html-silver");
        };

        function loadDeleteButtonSafeguards(romFileKey) {
            const deleteRomFileBtn = document.getElementById(
                `delete-${romFileKey}-btn`
            );
            document.forms[`delete-${romFileKey}-form`].addEventListener(
                "submit",
                function () {
                    deleteRomFileBtn.firstElementChild.textContent =
                        "please wait!".toUpperCase();
                    deleteRomFileBtn.disabled = true;
                    deleteRomFileBtn.classList.add("not-allowed");
                    // needs to its own function, logic will not be applied otherwise
                    disableDownloadFunctions(romFileKey);
                }
            );
        }
        loadDeleteButtonSafeguards({{Js::from($romFileKey)}});
    </script>
@endpush
@push('styles')
    <style {!! 'type="text/css"'; !!}>
        .not-allowed {
            cursor: not-allowed;
        }

        .bg-html-silver {
            background-color: #C0C0C0;
        }
    </style>
@endpush
{{-- parameters:
    romFile (RomFile)
    key (ObjectId|string)
--}}
<form
    class="inline-block"
    action="{{route('rom-files.delete', ['romFile' => $romFile])}}"
    method="POST"
    name="delete-{{$romFileKey}}-form"
>
    @method('DELETE')
    @csrf
    <div class="flex justify-end">
        <x-jet-danger-button id="delete-{{$romFileKey}}-btn" type="submit">
            <p class="inline">Delete&#160;<span class="font-bold">{{$romFile->filename}}</span></p>
        </x-jet-danger-button>
    </div>
</form>
