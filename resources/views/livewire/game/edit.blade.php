@php
    $formSelectClasses = <<<EOS
    class="border-gray-300 focus:border-indigo-300
    focus:ring focus:ring-indigo-200 focus:ring-opacity-50
    rounded-md shadow-sm block mt-1 w-full"
    EOS;
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center">Edit {{$game->game_name . ' Version'}}</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{route('games.update', ['gameId'=>$gameId])}}">
            @csrf
            @method('PUT')

            <div class="mt-2.5">
                <x-jet-label for="gameName" value="{{__('Game Name')}}"/>
                <x-jet-input id="gameName" class="block mt-1 w-full" type="text" name="game_name"
                             minlength="{{MIN_GAME_NAME}}"
                             maxlength="{{MAX_GAME_NAME}}"
                             :value="$game->game_name"
                             required autofocus
                />
            </div>
            <div class="mt-2.5">
                <label for="gameType" class="block font-medium text-sm text-gray-700">{{__('Game Type')}}</label>
                <select
                    {!! $formSelectClasses !!}
                    name="game_type" id="gameType"
                    required autofocus>
                    @foreach(GAME_TYPES as $gameType)
                        <option
                            value="{{$gameType}}"
                            {!! (strtolower($game->game_type) == $gameType)
                                  ? 'selected="selected"' : '' !!}>
                            {{ $gameType }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2.5">
                <label for="gameRegion" class="block font-medium text-sm text-gray-700">{{__('Region')}}</label>
                <select
                    {!! $formSelectClasses !!}
                    name="region" id="gameRegion"
                    required autofocus>
                    @foreach(REGIONS as $region)
                        <option
                            value="{{ucfirst($region)}}"
                            {!! (strtolower($game->region) == $region)
                                  ? 'selected="selected"' : '' !!}>
                            {{ ucfirst($region) }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>
