@php
    $listGroupClasses = [
        'bg-white', 'rounded-lg', 'border',
        'border-gray-200', 'text-gray-900', 'col-span-full',
        'row-start-1', 'row-end-1'
     ];
@endphp
<ul {{ $attributes->merge(['class' => implode(_SPACE, $listGroupClasses)]) }}>
    {{ $slot }}
</ul>
