@php
    /** @var string[] */
    $sessionErrorAlertClasses = [
      'bg-white',
      'border-t-4',
      'border-red-500',
      'rounded-b',
      'text-teal-900',
      'px-4',
      'py-3',
      'shadow-md',
      'my-3'
    ];
@endphp
@if (\Session::has('message'))
    <div class="{!! join(_SPACE, $sessionErrorAlertClasses) !!}" role="alert">
        <div class="flex flex-row justify-start">
            <p class="text-sm">{{ session('message') }}</p>
        </div>
    </div>
@endif
