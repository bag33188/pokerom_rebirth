## Other

### Phone Number Regex

```regexp
/^(?:([2-9]1{2})|(?:(\+?1\s*(?:[.-]\s*)?)?\(?\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)?\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?(\d{4})(?:\s*(\x20|#|x\.?|ext\.?|extension)\s*(\d+))?)$/i
```


### allow node and php to run together

```apacheconf
# For Windows, XAMPP

# C:/Windows/System32/drivers/etc/hosts (as admin)
127.0.0.1 localhost:8080

# C:/xampp/apache/conf/httpd.conf
Listen 5000

# C:/xampp/apache/conf/extra/httpd-vhosts.conf
<VirtualHost *:5000>
    DocumentRoot "C:\Users\Brock\Projects\PokeROM\www"
    ServerName localhost:8080
    <Directory "C:\Users\Brock\Projects\PokeROM\www">
        Allow from all
        Require all granted
    </Directory>
    ProxyPreserveHost on
    ProxyPass / http://localhost:8080/
    ProxyPassReverse / http://localhost:8080/
</VirtualHost>

```
