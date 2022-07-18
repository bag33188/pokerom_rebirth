@push('scripts')
    <script type="text/javascript" src="{{ mix('assets/js/dashboard.index.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(() => {
            loadWelcomeContent('{{ $username }}');
            loadCopyrightYear();
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex flex-row w-full justify-between">
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
                        <span class="block h-12 w-auto">@include('ui.app-logo')</span>
                    </div>
                    <div class="mt-3 text-2xl">
                        <p>
                            <span
                                class="font-semibold">{!! str_replace('Poke', "Pok&eacute;", config('app.name')) !!}</span>
                            <span class="font-bold">&nbsp;-&nbsp;</span>
                            <span class="italic">One Stop for all your ROMs</span>
                        </p>
                    </div>
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-rows-3 grid-cols-2 md:grid-rows-2">
                    <div class="p-6 border-b border-gray-200 col-span-2 row-span-1">
                        <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold">About</div>
                        <div class="ml-12">
                            <div class="mt-2 text-md text-gray-500">
                                <!-- about description -->
                                This web app is a databank of Pok&eacute;mon ROMs.
                                It contains 40 ROMs, including all 33 core Pok&eacute;mon ROMs.
                                <br />
                                <p class="italic mt-2 inline-flex flex-row text-sm">
                                    <span>&copy; Pok&eacute;mon Company</span>
                                    <span>&nbsp;</span>
                                    <span id="copyright-year"><!-- js content insert --></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 border-r border-gray-200 row-start-2 row-end-2 col-span-full md:col-start-1 md:col-end-1">
                        <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold">Roms</div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                <!-- roms description -->
                                Here you will find all your Core Pok&eacute;mon ROMs, as well as some spin-offs and
                                ROM hacks.<br />Feel free to download them for use with an emulator.
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 md:row-start-2 md:row-end-2 row-start-3 row-end-3 col-span-full md:col-start-2 md:col-end-2">
                        <div class="ml-12 text-lg text-gray-600 leading-7 font-semibold">Games</div>
                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                <!-- games description -->
                                You can also navigate through the Games that are associated with the ROMs.
                                <br />
                                You will find more information about each one.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
