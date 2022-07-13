@ECHO OFF

:: ======================
:: Compile Project Script
:: ======================

REM.||(
  Windows Batchfile
  -----------------
  This script cannot be run on a Unix machine.
  Batch is a scripting language invented for DOS.
  It has no compatibility with OSX or Linux.
  This file can only be run on a Windows machine.
)


:COMPILE

    REM assumes working directory is project directory
    REM %USERPROFILE%\PhpstormProjects\pokerom_rebirth
    REM CD %PKR%

    composer install & composer update & npm install & npm update & npm run dev & git status & git add . & git commit -m "update code base" & git push

    ECHO Finished!

    PAUSE

EXIT /B 0
