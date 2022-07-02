@ECHO OFF

:OPEN_PAGES
    SET FIREFOX=C:\Program Files\Mozilla Firefox\firefox.exe
    SET REPO_URL=https://github.com/bag33188/pokerom_rebirth
    START "" "%FIREFOX%" %REPO_URL%
    START "" "%FIREFOX%" https://jetstream.laravel.com/2.x/building-your-app.html
    START "" "%FIREFOX%" https://laravel-livewire.com/docs/2.x/making-components
    START "" "%FIREFOX%" https://laravel.com/docs/9.x/eloquent-resources
    START "" "%FIREFOX%" https://laravel.com/docs/9.x/eloquent-serialization
    START "" "%FIREFOX%" https://www.sitepoint.com/laravel-livewire-getting-started/
EXIT /B 0
