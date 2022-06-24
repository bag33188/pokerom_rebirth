<div>
    <form action="{{route('roms.delete', $romId)}}" method="POST">
        @csrf
        @method('DELETE')

        <x-jet-button class="mt-4">
            {{ __('Delete!') }}
        </x-jet-button>
    </form>
</div>
