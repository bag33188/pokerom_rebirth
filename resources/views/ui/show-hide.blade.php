@push('styles')
    <style type="text/css">
        [x-cloak] {
            display: none;
        }
    </style>
@endpush
<div class="inline-block">
    <p class="inline">
        <span x-show="open">Hide</span>
        <span x-show="!open" x-cloak>Show</span>
    </p>
    <p class="inline">
        <span>{{$text}}</span>
    </p>
</div>
