<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'PokeROM') }}</title>
    <link rel="stylesheet" <?= 'type="text/css"' ?> href="{{mix('css/app.css')}}"/>
</head>
<body class="h-full">
<div class="bg-white">
    <div class="flex h-full flex-col justify-center items-center">
        {{$slot}}
    </div>
</div>
</body>
</html>
