@props(['button'])
<form {{ $attributes->merge(['class' => 'inline-block']) }}
      action="{{ route('rom-files.download', ['romFile' => $romFile]) }}"
      method="POST">
    @method('POST')
    @csrf

    {{ $button }}
</form>
