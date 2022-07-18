@php
    function getStringValueFromKey(mixed $keyVal): string {
      if ($keyVal instanceof \MongoDB\BSON\ObjectId) {
        return strval($keyVal);
      } else if (!is_string($keyVal) || gettype($keyVal) !== "string") {
        return (string)$keyVal;
      } else {
        return $keyVal;
      }
    }
@endphp
{{-- parameters:
    romFile (RomFile)
    key (ObjectId|string)
--}}
<form action="{{route('rom-files.delete', ['romFile' => $romFile])}}"
      method="POST" data-form-key="{{ getStringValueFromKey($key) }}">
    @method('DELETE')
    @csrf

    <div class="flex justify-end">
        <x-jet-danger-button type="submit">
            <p class="inline">Delete{!! "&#160;" !!}<span class="font-bold">{{$romFile->filename}}</span></p>
        </x-jet-danger-button>
    </div>
</form>
