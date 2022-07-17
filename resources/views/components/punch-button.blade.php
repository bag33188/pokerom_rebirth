@props(['type', 'text'])
<div {{ $attributes->merge(['class' => 'inline-block']) }}>
    <button type="{{ $type }}" class="punch">{{ $text }}</button>
</div>
