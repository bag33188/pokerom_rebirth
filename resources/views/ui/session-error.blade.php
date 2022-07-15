@php
    /** @var string[] $sessionErrorAlertClasses */
    $sessionErrorAlertClasses = [
      'bg-white',
      'border-t-8',
      'border-red-500',
      'rounded',
      'text-teal-900',
      'px-4',
      'py-3',
      'shadow-md',
      'my-3'
    ];
    /** @var string $sessionKeyName */
    $sessionKeyName = 'error-message';
@endphp
{{-- Session Key: error-message --}}
@if (\Session::has($sessionKeyName))
    <div class="{!! join(_SPACE, $sessionErrorAlertClasses) !!}" role="alert">
        <div class="flex flex-row justify-start">
            <p class="font-medium">{{ \Session::get($sessionKeyName) }}</p>
        </div>
    </div>
@endif
