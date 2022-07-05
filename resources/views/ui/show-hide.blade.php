@push('styles')
    <style <?php echo 'type="text/css"'; ?>>
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
              'show'=>\App\Enums\DisplayStatesEnum::SHOW->value,
              'hide'=>\App\Enums\DisplayStatesEnum::HIDE->value
            ];
        @endphp
        <span x-show="open" {!!$initialState == $displayStates['hide'] ? 'x-cloak' : ''!!}>Hide</span>
        <span x-show="!open" {!!$initialState == $displayStates['show'] ? 'x-cloak' : ''!!}>Show</span>
    </p>
    <span>{!! "&nbsp;" !!}</span>
    <p class="inline">{{$text}}</p>
</div>
