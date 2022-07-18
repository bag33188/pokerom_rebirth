@ECHO ON

REM script only works with admin privileges

:OPEN_XAMPP_FILES

	SET SUBLIME_TEXT="C:\Program Files\Sublime Text\sublime_text.exe"

	%SUBLIME_TEXT% C:\xampp\apache\conf\extra\httpd-vhosts.conf C:\xampp\apache\conf\httpd.conf C:\xampp\php\php.ini C:\xampp\apache\conf\extra\httpd-xampp.conf C:\xampp\apache\conf\extra\httpd-ssl.conf C:\Windows\System32\drivers\etc\hosts

EXIT /B 0
