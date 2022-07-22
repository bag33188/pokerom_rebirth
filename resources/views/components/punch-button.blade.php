@props(['type', 'text'])
<button {{ $attributes->merge(['class' => 'inline-block punch']) }} type="{{ $type }}">{{ $text }}</button>
