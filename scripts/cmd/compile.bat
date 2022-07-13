@ECHO OFF

:COMPILE

    composer install & composer update & npm install & npm update & npm run dev & git status & git add . & git commit -m "update code base" & git push

    ECHO Finished!

    PAUSE

EXIT /B 0
