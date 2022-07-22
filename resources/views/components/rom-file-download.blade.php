@props(['button'])
<form {{ $attributes->merge(['class' => 'inline-block']) }}
      action="{{ route('rom-files.download', ['romFile' => $romFile]) }}"
      method="GET">
    @method('GET')
    @csrf
    {{-- component-defined download button slot --}}
    {{ $button }}
</form>
