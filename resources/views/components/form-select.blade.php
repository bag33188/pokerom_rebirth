@php
    $formSelectClasses = [
      'border-gray-300',
      'focus:border-indigo-300',
      'focus:ring',
      'focus:ring-indigo-200',
      'focus:ring-opacity-50',
      'rounded-md',
      'shadow-sm',
      'block',
      'mt-1',
      'w-full'
    ];
@endphp
<select {{ $attributes->merge(['class' => join(_SPACE, $formSelectClasses)]) }}>
    {{ $slot }}
</select>
