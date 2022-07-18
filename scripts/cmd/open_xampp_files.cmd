@ECHO ON

:: =======================
:: Open Xampp Files Script
:: =======================

REM.||(
  Windows Batchfile
  -----------------
  This script cannot be run on a Unix machine.
  Batch is a scripting language invented for DOS.
  It has no compatibility with OSX or Linux.
  This file can only be run on a Windows machine.
)



REM Note: script only works with ADMINISTRATIVE privileges

:OPEN_XAMPP_FILES

    REM Assumes Sublime Text is installed on machine

	SET SUBLIME_TEXT="C:\Program Files\Sublime Text\sublime_text.exe"

	%SUBLIME_TEXT% C:\xampp\apache\conf\extra\httpd-vhosts.conf C:\xampp\apache\conf\httpd.conf C:\xampp\php\php.ini C:\xampp\apache\conf\extra\httpd-xampp.conf C:\xampp\apache\conf\extra\httpd-ssl.conf C:\Windows\System32\drivers\etc\hosts

EXIT /B 0
