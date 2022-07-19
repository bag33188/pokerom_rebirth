@props(['text'])
@push('styles')
    <style <?= 'type="text/css"'; ?>>
        [x-cloak] {
            display: none;
        }
    </style>
@endpush
@php
    $btnClasses = [
      'bg-emerald-500',
      'hover:bg-emerald-600',
      'text-white',
      'font-bold',
      'py-2',
      'px-4',
      'my-4',
      'shadow-md',
      'rounded'
    ];
@endphp
<div class="w-full flex justify-center">
    <button type="button" @click="open = !open" {{ $attributes->merge(['class' => implode(_SPACE, $btnClasses)]) }}>
        <div class="inline-flex flex-row">
            <div class="inline-block">
                <span x-show="{{ $alpineStates['shown'] }}" {!! $cloakData['initShow'] !!}>Hide</span>
                <span x-show="{{ $alpineStates['hidden'] }}" {!! $cloakData['initHide'] !!}>Show</span>
            </div>
            <span>&#xA0;</span>
            <p class="inline">{{ $text }}</p>
        </div>
    </button>
</div>
