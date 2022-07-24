@push('scripts')
    <script type="text/javascript">
        const checkIfNodeIsComment = (node) => {
            const COMMENT_NODE_TYPE = 8;
            return node.nodeType === COMMENT_NODE_TYPE;
        };

        let loadWelcomeContent = (username) => {
            const welcomeUsername = document.getElementById("welcome-username");
            const jsInsertHtmlComment = welcomeUsername.childNodes[0];
            const welcomeMessage = `Welcome, ${username}!`;
            const welcomeText = document.createTextNode(welcomeMessage);
            if (checkIfNodeIsComment(jsInsertHtmlComment)) {
                welcomeUsername.replaceChild(welcomeText, jsInsertHtmlComment);
            } else {
                welcomeUsername.appendChild(welcomeText);
            }
        };

        let loadCopyrightYear = () => {
            const copyrightYearElement = document.getElementById("copyright-year");
            const now = new Date();
            let currentYear = now.getFullYear();
            copyrightYearElement.textContent = currentYear.toString();
        };

        let loadEmulatorLinks = () => {
            let emulatorLinksList = document.getElementById("emulator-links");
            const anchorClasses = ["underline", "text-blue-400", "hover:text-blue-500"];
            const emulators = [
                {
                    href: "https://desmume.org/",
                    text: "DeSmuME",
                    name: "desmume",
                    target: "_blank",
                },
                {
                    href: "https://www.emulator-zone.com/doc.php/gba/vboyadvance.html",
                    text: "Visual Boy Advanced",
                    name: "vba",
                    target: "_blank",
                },
                {
                    href: "https://citra-emu.org/",
                    text: "Citra",
                    name: "citra",
                    target: "_blank",
                },
            ];
            emulators.forEach((emulator, index) => {
                let listItemElement = document.createElement("li");
                listItemElement.id = `emulator-${index + 1}`;
                let emulatorLinkElement = document.createElement("a");
                emulatorLinkElement.id = `${emulator.name}-emu`;
                emulatorLinkElement.href = emulator.href;
                emulatorLinkElement.text = emulator.text;
                emulatorLinkElement.target = emulator.target;
                emulatorLinkElement.classList.add(...anchorClasses);
                emulatorLinkElement.setAttribute("rel", "noreferrer");
                listItemElement.appendChild(emulatorLinkElement);
                emulatorLinksList.appendChild(listItemElement);
            });
        };
    </script>
    <script type="text/javascript">
        loadWelcomeContent({{ Js::from($username) }});
        loadCopyrightYear();
        loadEmulatorLinks();
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

    <div data-name="dashboard-container" class="py-6 my-6 sm:py-8 sm:my-8 md:py-12 md:my-12 lg:py-16 lg:my-16">
        <div data-name="dash-content-card" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{--<x-jet-welcome/>--}}

                <section
                    data-name="heading"
                    class="p-4 sm:px-20 md:p-6 bg-white border-b-2 border-gray-200 flex flex-col md:flex-row justify-start md:justify-between">
                    <div class="mb-3 md:mb-auto">
                        <span class="h-12 w-auto">@include('ui.app-logo')</span>
                    </div>
                    <p class="text-lg sm:text-xl md:text-2xl">
                        <span class="font-semibold">
                            {!! str_replace('Poke', "Pok&eacute;", config('app.name')) !!}
                        </span>
                        <span class="font-bold">&#160;&#8209;&#xA0;</span>
                        <span class="italic">One Stop for all your Pok&eacute;mon ROMs</span>
                    </p>
                </section>
                <div
                    class="bg-gray-200 bg-opacity-25 grid grid-rows-[repeat(3,auto)] grid-cols-1 md:grid-cols-2 md:grid-rows-[auto_auto]">
                    <section data-name="about" class="p-6 border-b border-gray-200 col-span-2 row-span-1">
                        <h3 class="ml-12 text-lg text-gray-600 leading-7 font-semibold">About</h3>
                        <div class="ml-12">
                            <div id="about-description" class="mt-2 text-md text-gray-500">
                                <!-- about description -->
                                <p class="inline-block">
                                    This web app is a databank of Pok&#xE9;mon ROMs.
                                    <wbr/>
                                    This databank contains
                                    <span id="adv-count"><!--more than-->{{(RomRepo::getRomsCount() - 3) . '+'}}</span>
                                    ROMs, including all 33 core Pok&#233;mon ROMs.
                                </p>
                                <br/>
                                <p class="italic mt-3 mb-0 pb-0 inline-flex flex-row text-sm">
                                    <span>&copy; Pok&eacute;mon Company</span>
                                    <span>&nbsp;</span>
                                    <span id="copyright-year"><!-- js content insert --></span>
                                </p>
                            </div>
                        </div>
                    </section>
                    <section
                        data-name="roms"
                        class="p-6 border-r border-t border-gray-200 row-start-2 row-end-2 col-span-full md:col-start-1 md:col-end-1">
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
                        class="p-6 border-l border-t border-gray-200 md:row-start-2 md:row-end-2 row-start-3 row-end-3 col-span-full md:col-start-2 md:col-end-2">
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
