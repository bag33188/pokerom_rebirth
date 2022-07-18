# Commands

## Angular New Project

> `ng new pokerom_rebirth --directory=client --routing --skip-git --style=scss --view-encapsulation=ShadowDom --prefix=pokerom --strict=false`
> `ng add @angular/pwa`
> `ng add @angular/material`
> `ng lint` 

[comment]: # "dont add nglint since you don't want to replace tslint"

## db

`mysql -u root`

`mysql -u bag33188 -p 3931Sunflower$`

`mongofiles.exe -d gridfs put song.mp3`

`mongofiles.exe -d pokerom_files put POKEMON_SLVAAXE01.gbc`

`mysqldump [options] --result-file=dump.sql`

`mongoexport --collection=events --db=reporting --out=events.json --jsonformat=relaxed`

`!!! php artisan migrate:rollback`

> _**MAKE SURE IT HAS THE REFRESH OPTION OR ELSE WILL ERASE EVERYTHING!!!**_

`php artisan migrate:rollback`


> press _`F5`_ to insert timestamp in windows `notepad.exe`

# mariadb triggers for games table

```mysql
--
-- Triggers `games`
--
DROP TRIGGER IF EXISTS `games_after_delete`;
DELIMITER $$
CREATE TRIGGER `games_after_delete`
    AFTER DELETE
    ON `games`
    FOR EACH ROW
BEGIN
    UPDATE `roms`
    SET `roms`.`has_game` = FALSE,
        `roms`.`game_id`  = NULL
    WHERE `roms`.`id` = OLD.`rom_id`;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `games_after_insert`;
DELIMITER $$
CREATE TRIGGER `games_after_insert`
    AFTER INSERT
    ON `games`
    FOR EACH ROW
BEGIN
    DECLARE `rom_already_has_game` BOOL;
    SELECT `has_game`
    INTO @`rom_already_has_game`
    FROM `roms`
    WHERE `roms`.`id` = NEW.`rom_id`;
    IF @`rom_already_has_game` = FALSE
    THEN
        UPDATE `roms`
        SET `roms`.`has_game` = TRUE,
            `roms`.`game_id`  = NEW.`id`
        WHERE `roms`.`id` = NEW.`rom_id`;
    END IF;
END
$$
DELIMITER ;
```
