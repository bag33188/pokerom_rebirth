@ECHO OFF

:COMPILE

    CD %PKR% REM %USERPROFILE%\PhpstormProjects\pokerom_rebirth

    composer install & composer update & npm install & npm update & npm run dev & git status & git add . & git commit -m "update code base" & git push

    ECHO Finished!

    PAUSE

EXIT /B 0
