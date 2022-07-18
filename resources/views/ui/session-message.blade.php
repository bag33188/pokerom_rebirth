@php
    $sessionClasses = [
      'bg-white',
      'border-t-8',
      'rounded',
      'text-teal-900',
      'px-4',
      'py-3',
      'shadow-md',
      'my-3'
    ];
    $messageType = Session::get('message-type', \App\Enums\SessionMessageTypeEnum::ERROR);
    $message = Session::get('message');
@endphp
@if (Session::has('message'))
    {{-- default message type is error --}}
    <div @class([
        ...$sessionClasses,
        'border-red-500' => $messageType === \App\Enums\SessionMessageTypeEnum::ERROR,
        'border-green-500' => $messageType === \App\Enums\SessionMessageTypeEnum::SUCCESS
    ]) role="alert">
        <div class="flex flex-row justify-start">
            <p class="font-medium">{{ $message }}</p>
        </div>
    </div>
@endif
