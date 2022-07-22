# Apache XAMPP Configuration

## Configuration

### HTTPD

```apacheconf
# C:/xampp/apache/conf/httpd.conf
Listen 80

LoadModule http2_module modules/mod_http2.so

DocumentRoot "C:/Users/bglat/PhpstormProjects/pokerom_rebirth"
<Directory "C:/Users/bglat/PhpstormProjects/pokerom_rebirth">
    Options Indexes FollowSymLinks Includes ExecCGI
    AllowOverride All
    Require all granted
</Directory>
Include conf/extra/httpd-ssl.conf
```

### PHPMyAdmin

```php
# C:/xampp/phpMyAdmin/config.inc.php

/* Authentication type and info */
$cfg['Servers'][$i]['auth_type'] = 'config'; // http, cookie
$cfg['Servers'][$i]['user'] = 'bag33188';
$cfg['Servers'][$i]['password'] = '3931Sunflower$';
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['AllowNoPassword'] = true;
```

#### test

```mysql
SELECT USER();
SELECT CURRENT_USER;

-- check output
```

### VHOSTS

```apacheconf
# C:/xampp/apache/conf/extra/httpd-vhosts.conf
NameVirtualHost *:80
NameVirtualHost *:443

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
</VirtualHost>
<VirtualHost *:443>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
    SSLEngine on
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
</VirtualHost>
<VirtualHost *:80>
    DocumentRoot "C:/Users/bglat/PhpstormProjects/pokerom_rebirth"
    ServerName pokerom_rebirth.test
</VirtualHost>

<VirtualHost *:443>
    DocumentRoot "C:/Users/bglat/PhpstormProjects/pokerom_rebirth"
    ServerName pokerom_rebirth.test
    SSLEngine on
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
</VirtualHost>

```

### SSL
```apacheconf
# C:/xampp/apache/conf/extra/httpd-ssl.conf

Protocols h2 h2c http/1.1
```

### Win HOSTS

```
# C:/windows/system32/drivers/etc/hosts

127.0.0.1        localhost
::1              localhost
127.0.0.1 pokerom_rebirth.test
```

### PHP Config

```ini
; C:/xampp/php/php.ini
max_input_time=0
max_execution_time=0
post_max_size=0
memory_limit=-1
upload_max_filesize=20G
max_file_uploads=20
default_socket_timeout=-1
file_uploads=On
exit_on_timeout=false
upload_tmp_dir="C:\xampp\tmp"
; the following config options is deprecated
; allow_url_include=On
```

### PHP Fast CGI
```apacheconf
# C:/xampp/apache/conf/extra/httpd-xampp.conf

LoadFile "C:/xampp/php/php8ts.dll"
LoadFile "C:/xampp/php/libpq.dll"
LoadFile "C:/xampp/php/libsqlite3.dll"
LoadModule php_module "C:/xampp/php/php8apache2_4.dll"


#<FilesMatch "\.php$">
#    SetHandler application/x-httpd-php
#</FilesMatch>
#<FilesMatch "\.phps$">
#    SetHandler application/x-httpd-php-source
#</FilesMatch>

# PHP-CGI setup

<FilesMatch "\.php$">
    SetHandler application/x-httpd-php-cgi
</FilesMatch>
<IfModule actions_module>
    Action application/x-httpd-php-cgi "/php-cgi/php-cgi.exe"
</IfModule>

### <IfModule alias_module> .......

    Alias /phpmyadmin "C:/xampp/phpMyAdmin/"
    <Directory "C:/xampp/phpMyAdmin">
       Options ExecCGI # <- add this in order to access phpmyadmin thru https
       AllowOverride AuthConfig
       Require local
       ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
    </Directory>
    
### .....</IfModule>
```

### Mailhog

[download mailhog][mailhog download]

access on: `http://127.0.0.1:8025`

listen on: `http://127.0.0.1:1025`

```dotenv
# .env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@whatever.id"
MAIL_FROM_NAME="${APP_NAME}"
```

### MongoDB

Download **THREAD-SAFE** (_ts_) MongoDB Extension (_v13 for windows_): [PECL mongodb][mongodb-ts-php-ext]

MongoDB PECL Package Page: [MongoDB PHP PECL][mongodb-php-pecl]

```ini
; C:/xampp/php/php.ini

; Dynamic Extensions ... 
extension=php_mongodb.dll
```

### Debug

#### Xdebug

```ini
; C:/xampp/php/php.ini

[xdebug]
zend_extension=xdebug
xdebug.mode=debug
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
xdebug.idekey=phpstorm
```

install: [xdebug installation wizard]

chrome ext: [xdebug chrome extension]

##### Postman

add this cookie to requests: `XDEBUG_SESSION=phpstorm; Path=/; Domain=pokerom_rebirth.test; Expires=Tue, 19 Jan 2038 03:14:07 GMT;`

under domain name: pokerom_rebirth.test

```
https:
name:pokerom_rebirth.test
host: pokerom_rebirth.test
port: 443

debugger: xdebug
```

```
http:
name:pokerom_rebirth.test
host: pokerom_rebirth.test
port: 80

debugger: xdebug
```

[xdebug with postman](https://lukashajdu.com/post/usign-xdebug-with-postman/ "use xdebug with postman")

##### PHPStorm

Links and references

* [php debugging session]
* [zero configuration debugging]
* [debugging a php cli script]
* [debugging quick start]
* [php debugging]

### Install MongoDB

+ [mongodb community edition download][mongodb-community]
+ [download mongodb server tools][mongodb-server-tools]



### Other

> https://httpd.apache.org/docs/2.4/howto/http2.html
> https://www.mongodb.com/docs/drivers/php/

#### lint
install sass-lint in phpstorm

`npm install --save-dev sass-lint`

configure node exec and sass-lint npm cmd exec and config file...

---------


[php debugging session]: https://www.jetbrains.com/help/phpstorm/php-debugging-session.html
[zero configuration debugging]: https://www.jetbrains.com/help/phpstorm/zero-configuration-debugging.html#start-debugging-session
[debugging a php cli script]: https://www.jetbrains.com/help/phpstorm/debugging-a-php-cli-script.html
[debugging quick start]: https://www.jetbrains.com/phpstorm/documentation/debugging/#quick-start
[php debugging]: https://www.jetbrains.com/phpstorm/documentation/debugging
[xdebug chrome extension]: https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc?hl=en
[xdebug installation wizard]: https://xdebug.org/wizard "install xdebug for php"
[mailhog download]: https://github.com/mailhog/MailHog/releases/v1.0.0 "download mailhog"
[mongodb-community]: https://www.mongodb.com/try/download/community?tck=docs_server
[mongodb-server-tools]: https://www.mongodb.com/try/download/database-tools
[mongodb-ts-php-ext]: https://pecl.php.net/package/mongodb/1.13.0/windows "mongodb extension for windows (thread safe)"
[mongodb-php-pecl]: https://pecl.php.net/package/mongodb "php mongodb driver extension page (pecl)"
