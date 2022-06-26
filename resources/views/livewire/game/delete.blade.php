<div class="inline-block">
    <form action="{{route('games.delete', ['gameId'=>$gameId])}}" method="POST">
        @csrf
        @method('DELETE')

        <x-jet-button>
            {{ __('Delete!') }}
        </x-jet-button>
    </form>
</div>
