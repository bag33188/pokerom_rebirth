@props(['type', 'text'])
<button type="{{$type}}" {{$attributes->merge(['class'=>'punch'])}}>{{$text}}</button>
