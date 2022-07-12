@props(['submitButton'])
<form {{$attributes->merge(['class'=>'inline'])}}
      action="{{ route('rom-files.download', $romFile) }}"
      method="POST">
    @method('POST')
    @csrf

    {{$submitButton}}
</form>
