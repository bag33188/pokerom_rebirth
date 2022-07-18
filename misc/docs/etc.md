## Other

```sql
CREATE USER 'bag33188'@'%' IDENTIFIED VIA mysql_native_password USING '***';GRANT ALL PRIVILEGES ON *.* TO 'bag33188'@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;CREATE DATABASE IF NOT EXISTS `bag33188`;GRANT ALL PRIVILEGES ON `bag33188`.* TO 'bag33188'@'%';GRANT ALL PRIVILEGES ON `bag33188\_%`.* TO 'bag33188'@'%';
set autocommit = 1; -- {0|1}
```
### Phone Number Regex

```regexp
/^(?:([2-9]1{2})|(?:(\+?1\s*(?:[.-]\s*)?)?\(?\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)?\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?(\d{4})(?:\s*(\x20|#|x\.?|ext\.?|extension)\s*(\d+))?)$/i
```

### MongoExport ObjectID Replace Regexp
```regexp
/("_id":)([\s\t\n\v]*)(\{[\s\t\n\v]*)("\$oid":)([\s\t\n\v]*)("[\da-fA-F]+")([\s\t\n\v]*)(})([\s\t\n\v]*)(,?)/gim
```

### Sql detection auto increment fix regexp
```regexp
/ALTER\sTABLE\s`(roms|games)`[\r\n]\s+MODIFY\s`id`\sbigint\(20\)\sUNSIGNED\sNOT\sNULL\sAUTO_INCREMENT,\sAUTO_INCREMENT=(\d+);/gi
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


# mariadb triggers for games table

```mysql
--
-- Triggers `games`
--
DROP TRIGGER IF EXISTS `games_after_delete`;
DELIMITER $$
CREATE TRIGGER `games_after_delete` AFTER DELETE ON `games` FOR EACH ROW BEGIN
  UPDATE `roms`
  SET `roms`.`has_game` = FALSE, `roms`.`game_id` = NULL
  WHERE `roms`.`id` = OLD.`rom_id`;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `games_after_insert`;
DELIMITER $$
CREATE TRIGGER `games_after_insert` AFTER INSERT ON `games` FOR EACH ROW BEGIN
  DECLARE `rom_already_has_game` BOOL;
  SELECT `has_game`
  INTO @`rom_already_has_game`
  FROM `roms`
  WHERE `roms`.`id` = NEW.`rom_id`;
  IF @`rom_already_has_game` = FALSE
  THEN
    UPDATE `roms`
    SET `roms`.`has_game` = TRUE, `roms`.`game_id` = NEW.`id`
    WHERE `roms`.`id` = NEW.`rom_id`;
  END IF;
END
$$
DELIMITER ;
```

### query builder

```php
list($romName, $romExtension) =
    FileUtils::splitFilenameIntoParts($this->findRomFileIfExists($romFileId)->filename);
return Rom::where([
    ['rom_name', '=', $romName, 'and'],
    ['rom_type', '=', $romExtension, 'and']
])->where(function (\Jenssegers\Mongodb\Helpers\EloquentBuilder $query) {
    $query
        ->where('has_file', '=', FALSE)
        ->orWhere('file_id', '=', NULL);
})->limit(1)->first();
```
