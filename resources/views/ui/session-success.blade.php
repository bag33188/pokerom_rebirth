@php
    /** @var string[] $sessionSuccessAlertClasses */
    $sessionSuccessAlertClasses = [
      'bg-white',
      'border-t-8',
      'border-green-500',
      'rounded',
      'text-teal-900',
      'px-4',
      'py-3',
      'shadow-md',
      'my-3'
    ];
    /** @var string $sessionKeyName */
    $sessionKeyName = 'success-message';
@endphp
{{-- Session Key: success-message --}}
@if (\Session::has($sessionKeyName))
    <div class="{!! join(_SPACE, $sessionSuccessAlertClasses) !!}" role="alert">
        <div class="flex flex-row justify-start">
            <p class="font-medium">{{ \Session::get($sessionKeyName) }}</p>
        </div>
    </div>
@endif
