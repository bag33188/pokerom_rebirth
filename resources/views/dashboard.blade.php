@push('scripts')
    <script type="text/javascript" src="{{ mix('assets/js/pages/dashboard.index.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(() => {
            loadWelcomeContent({{ Js::from($username) }});
            loadCopyrightYear();
            loadEmulatorLinks();
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex flex-row w-full justify-between">
                <span class="order-0" id="home-page-name">{{ $home_page_name }}</span>
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
                    <p class="mt-3 text-2xl">
                        <span class="font-semibold">
                            {!! str_replace('Poke', "Pok&eacute;", config('app.name')) !!}
                        </span>
                        <span class="font-bold">&#160;&#8209;&#xA0;</span>
                        <span class="italic">One Stop for all your Pok&eacute;mon ROMs</span>
                    </p>
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-rows-3 grid-cols-2 md:grid-rows-2">
                    <section data-name="about" class="p-6 border-b border-gray-200 col-span-2 row-span-1">
                        <h3 class="ml-12 text-lg text-gray-600 leading-7 font-semibold">About</h3>
                        <div class="ml-12">
                            <div id="about-description" class="mt-2 text-md text-gray-500">
                                <!-- about description -->
                                <p class="inline-block">
                                    This web app is a databank of Pok&#xE9;mon ROMs.
                                    <wbr/>
                                    It contains 40 ROMs, including all 33 core Pok&#233;mon ROMs.
                                </p>
                                <br/>
                                <p class="italic mt-2 inline-flex flex-row text-sm">
                                    <span>&copy; Pok&eacute;mon Company</span>
                                    <span>&nbsp;</span>
                                    <span id="copyright-year"><!-- js content insert --></span>
                                </p>
                            </div>
                        </div>
                    </section>
                    <section
                        data-name="roms"
                        class="p-6 border-r border-gray-200 row-start-2 row-end-2 col-span-full md:col-start-1 md:col-end-1">
                        <h3 class="ml-12 text-lg text-gray-600 leading-7 font-semibold">Roms</h3>
                        <div class="ml-12">
                            <div id="roms-description" class="mt-2 text-sm text-gray-500">
                                <!-- roms description -->
                                <p class="inline-block">
                                    Here you will find all your <strong>Core Pok&#xE9;mon ROMs</strong>,
                                    <wbr/>
                                    as well as some <b>Spin-Off Games</b>,
                                    <wbr/>
                                    and even some <b>Pok&#233;mon ROM hacks</b>.
                                    <wbr/>
                                    <br/>
                                    Feel free to download them for use with an emulator.
                                </p>
                            </div>
                        </div>
                    </section>
                    <section
                        data-name="games"
                        class="p-6 md:row-start-2 md:row-end-2 row-start-3 row-end-3 col-span-full md:col-start-2 md:col-end-2">
                        <h3 class="ml-12 text-lg text-gray-600 leading-7 font-semibold">Games</h3>
                        <div class="ml-12">
                            <div id="games-description" class="mt-2 text-sm text-gray-500">
                                <!-- games description -->
                                <p class="inline-block">Feel free to play these amazing Games on your emulators!!</p>
                                <ul class="list-disc" id="emulator-links">
                                    <!-- js content insert -->
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
