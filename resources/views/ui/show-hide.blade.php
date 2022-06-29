@push('styles')
    <style <?php echo 'type="text/css"'; ?>>
        [x-cloak] {
            display: none;
        }
    </style>
@endpush
<div class="inline-flex flex-row">
    <p class="inline">
        <span x-show="open" {!!$initialState == 'hide' ? 'x-cloak' : ''!!}>Hide</span>
        <span x-show="!open" {!!$initialState == 'show' ? 'x-cloak' : ''!!}>Show</span>
    </p>
    <span>{!! "&nbsp;" !!}</span>
    <p class="inline">{{$text}}</p>
</div>
