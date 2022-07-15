@push('styles')
    <style <?= 'type="text/css"'; ?>>
        [x-cloak] {
            display: none;
        }
    </style>
@endpush
{{-- variables: text, initialState --}}
<div class="inline-flex flex-row">
    <p class="inline">
        @php
            $displayStates = [
              'show'=>\App\Enums\DisplayStateEnum::SHOW->value,
              'hide'=>\App\Enums\DisplayStateEnum::HIDE->value
            ];
        @endphp
        <span x-show="open" {!!$initialState == $displayStates['hide'] ? 'x-cloak' : ''!!}>Hide</span>
        <span x-show="!open" {!!$initialState == $displayStates['show'] ? 'x-cloak' : ''!!}>Show</span>
    </p>
    <span>{!! "&nbsp;" !!}</span>
    <p class="inline">{{$text}}</p>
</div>
