@push('styles')
    <style <?php echo 'type="text/css"'; ?>>
        [x-cloak] {
            display: none;
        }
    </style>
@endpush
<div class="inline-flex flex-row">
    <p class="inline">
        @php
            $displayStates = [
              'show'=>\App\Enums\DisplayStatesEnum::SHOW,
              'hide'=>\App\Enums\DisplayStatesEnum::HIDE
            ];
        @endphp
        <span x-show="open" {!!$initialState == $displayStates['hide']->value ? 'x-cloak' : ''!!}>Hide</span>
        <span x-show="!open" {!!$initialState == $displayStates['show']->value ? 'x-cloak' : ''!!}>Show</span>
    </p>
    <span>{!! "&nbsp;" !!}</span>
    <p class="inline">{{$text}}</p>
</div>
