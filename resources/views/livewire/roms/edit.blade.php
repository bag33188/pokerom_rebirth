@php
    $formSelectClasses = <<<EOS
    class="border-gray-300 focus:border-indigo-300
    focus:ring focus:ring-indigo-200 focus:ring-opacity-50
    rounded-md shadow-sm block mt-1 w-full"
    EOS;
    $btnWarnClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-yellow-400 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-600
    focus:outline-none focus:border-yellow-600 focus:ring focus:ring-yellow-300
    disabled:opacity-25 transition"
    EOS;
    $btnDangerClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-red-700 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-red-800 active:bg-red-800
    focus:outline-none focus:border-red-600 focus:ring focus:ring-red-300
    disabled:opacity-25 transition"
    EOS;
        $btnPrimaryClasses = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-blue-700 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-blue-800 active:bg-blue-800
    focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-300
    disabled:opacity-25 transition"
    EOS;
    $btnPrimaryClasses1=['text-white', 'bg-blue-700', 'hover:bg-blue-800', 'focus:ring-4', 'focus:ring-blue-300', 'font-medium', 'rounded-lg', 'text-sm', 'px-5', 'py-2.5', 'mr-2', 'mb-2', 'dark:bg-blue-600', 'dark:hover:bg-blue-700', 'focus:outline-none', 'dark:focus:ring-blue-800'];
    $btnDangerClasses1=[
  'focus:outline-none',
  'text-white',
  'bg-red-700',
  'hover:bg-red-800',
  'focus:ring-4',
  'focus:ring-red-300',
  'font-medium',
  'rounded-lg',
  'text-sm',
  'px-5',
  'py-2.5',
  'mr-2',
  'mb-2',
  'dark:bg-red-600',
  'dark:hover:bg-red-700',
  'dark:focus:ring-red-900'
];

    $btnDander='focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900';
    $btnWarn='focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900';
    $btnPrimary='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800';
@endphp
<div>
    <x-slot name="header">
        <h2 class="text-center">Edit {{$rom->getRomFileName()}}</h2>
    </x-slot>
    <div class="p-3">
        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{route("roms.update", ['romId'=>$romId])}}">
            @csrf
            @method('PUT')

            <div class="mt-2.5">
                <x-jet-label for="romName" value="{{ __('Rom Name') }}"/>
                <x-jet-input id="romName"
                             class="block mt-1 w-full"
                             type="text"
                             name="rom_name"
                             minlength="{{MIN_ROM_NAME}}"
                             maxlength="{{MAX_ROM_NAME}}"
                             :value="$rom->rom_name"
                             required autofocus/>
            </div>
            <div class="mt-2.5">
                <label for="romType" class="block font-medium text-sm text-gray-700">{{__('Rom Type')}}</label>
                <select
                    {!! $formSelectClasses !!}
                    name="rom_type" id="romType"
                    required autofocus>
                    @foreach(ROM_TYPES as $romType)
                        <option
                            value="{{$romType}}"
                            {!! (strtolower($rom->rom_type) == $romType)
                                  ? 'selected="selected"' : '' !!}>
                            {{ strtoupper($romType) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2.5">
                <x-jet-label for="romSize" value="{{ __('Rom Size') }}"/>
                <x-jet-input id="romSize"
                             name="rom_size"
                             class="block mt-1 w-full"
                             type="number" min="{{MIN_ROM_SIZE}}"
                             max="{{MAX_ROM_SIZE}}"
                             :value="$rom->rom_size"
                             required autofocus/>
            </div>
            <div class="mt-4">
                <x-jet-button class="float-right">
                    {{ __('Save!') }}
                </x-jet-button>
                <div class="float-left">
                    <a href="../" {!! $btnPrimaryClasses !!}>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
