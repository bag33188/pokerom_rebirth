<div class="inline-block">
    <x-jet-danger-button wire:click="destroy({{$gameId}})" wire:key="{{$gameId}}">
        {{ __('Delete!') }}
    </x-jet-danger-button>
</div>
