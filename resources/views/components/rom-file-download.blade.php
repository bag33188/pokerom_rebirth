@props(['submitButton'])
<form {{ $attributes->merge(['class' => 'inline']) }}
      action="{{ route('rom-files.download', array('romFile' => $romFile)) }}"
      method="POST">
    @method('POST')
    @csrf

    {{$submitButton}}
</form>
