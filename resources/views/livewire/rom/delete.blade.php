<div class="inline-block">
    <x-jet-danger-button wire:click="destroy({{$romId}})" wire:key="{{$romId}}">
        {{ __('Delete!') }}
    </x-jet-danger-button>
</div>
