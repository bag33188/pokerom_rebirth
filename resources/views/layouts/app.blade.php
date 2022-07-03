<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <title>{{ unicode_eacute(config('app.name', 'PokeROM')) }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"/>

        <!-- Styles -->
        <link rel="stylesheet" <?= 'type="text/css"'; ?> href="{{ mix('css/app.css') }}"/>
        <link rel="stylesheet" <?= 'type="text/css"'; ?> href="{{ mix('css/punch.css') }}"/>
        @stack('styles')

        @livewireStyles

        <!-- Scripts -->
        <script <?= 'type="text/javascript"'; ?> src="{{ mix('js/app.js') }}" defer></script>
        <script <?= 'type="text/javascript"'; ?> src="{{ mix('js/modules/ready.js') }}"></script>
        @stack('scripts')
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner/>

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
