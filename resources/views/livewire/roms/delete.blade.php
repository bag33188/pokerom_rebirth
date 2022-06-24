<div>
    <form action="{{route('roms.delete', $romId)}}" method="POST">
        @csrf
        @method('DELETE')

        <x-jet-button>
            {{ __('Delete!') }}
        </x-jet-button>
    </form>
</div>
