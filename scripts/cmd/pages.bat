@ECHO OFF


CD %PKR%

composer install & composer update & npm install & npm update & npm run dev & git add . & git commit -m "update code base" & git push

ECHO Finished!

PAUSE
