@push('scripts')
    <script <?= 'type="text/javascript"'; ?> src="{{ mix('js/dashboard.index.js') }}"></script>
    <script <?= 'type="text/javascript"'; ?>>
        $(document).ready(() => {
            loadWelcomeContent('{{ $username }}');
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="inline-flex flex-row w-full justify-between">
                <span class="order-0">{{ __('Dashboard') }}</span>
                <span class="order-1" id="welcome-username"><!-- js content insert --></span>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{--<x-jet-welcome/>--}}

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div>
                        <span class="block h-12 w-auto">@include('partials._app-logo')</span>
                    </div>
                    <div class="mt-3 text-2xl">
                        {!! str_replace('Poke', "Pok&eacute;", config('app.name')) !!}
                    </div>
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-rows-3 grid-cols-2 md:grid-rows-2">
                    <div class="p-6 border-b border-gray-200 col-span-2 row-span-1">
                        <div class="flex items-center">
                            <div class="order-0 w-8 h-8 text-gray-400"><!-- insert icon --></div>
                            <div class="ml-4 text-lg order-1 text-gray-600 leading-7 font-semibold">About</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. A accusantium cupiditate delectus,
                                dicta ducimus eveniet, fuga ipsum maxime minus nostrum nulla officiis possimus quod
                                tempore
                                temporibus? Facilis molestias nostrum tenetur!
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 border-r border-gray-200 row-start-2 row-end-2 col-span-full md:col-start-1 md:col-end-1">
                        <div class="flex items-center">
                            <div class="order-0 w-8 h-8 text-gray-400"><!-- insert icon --></div>
                            <div class="ml-4 text-lg order-1 text-gray-600 leading-7 font-semibold">Roms</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. A accusantium cupiditate delectus,
                                dicta ducimus eveniet, fuga ipsum maxime minus nostrum nulla officiis possimus quod
                                tempore
                                temporibus? Facilis molestias nostrum tenetur!
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 md:row-start-2 md:row-end-2 row-start-3 row-end-3 col-span-full md:col-start-2 md:col-end-2">
                        <div class="flex items-center">
                            <div class="order-0 w-8 h-8 text-gray-400"><!-- insert icon --></div>
                            <div class="ml-4 text-lg order-1 text-gray-600 leading-7 font-semibold">Games</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit. A accusantium cupiditate delectus,
                                dicta ducimus eveniet, fuga ipsum maxime minus nostrum nulla officiis possimus quod
                                tempore
                                temporibus? Facilis molestias nostrum tenetur!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
