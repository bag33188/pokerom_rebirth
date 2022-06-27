<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name', 'Pok' . _EACUTE .'ROM') }}</title>
        <link rel="stylesheet" <?= 'type="text/css"' ?> href="{{asset('css/app.css')}}" />
    </head>
    <body class="h-full">
        <div class="bg-white">
            <div class="flex h-full flex-col justify-center items-center">
                {{$slot}}
            </div>
        </div>
    </body>
</html>
