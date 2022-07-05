@props(['romFileId'])
<form action="{{route('rom-file.download', ['romFileId' => $romFileId])}}" method="POST">
    @method('POST')
    @csrf

    <x-jet-button>Download! @include('partials._download-icon')</x-jet-button>
</form>
