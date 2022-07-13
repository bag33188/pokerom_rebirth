@ECHO OFF

:COMPILE

    REM assumes working directory is project directory

    composer install & composer update & npm install & npm update & npm run dev & git status & git add . & git commit -m "update code base" & git push

    ECHO Finished!

    PAUSE

EXIT /B 0
