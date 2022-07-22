# Commands

## Angular New Project

```shell
ng new pokerom_rebirth --directory=client --routing --skip-git --style=scss --view-encapsulation=ShadowDom --prefix=pokerom --strict=false --commit=false --package-manager=npm --new-project-root=projects
ng add @angular/pwa
ng add @angular/material
ng lint
```

[comment]: # "dont add nglint since you don't want to replace tslint"

> Error: Using `--collection=@angular-eslint/schematics` is no longer supported.
>
> In previous versions of @angular-eslint we attempted to let developers create Angular CLI workspaces and add ESLint in a single command by providing the `--collection` flag to `ng new`.
>
> This worked for simple scenarios but it was not possible to support all the options of `ng new` this way and it was harder to reason about in many cases.
>
> Instead, simply:
>
> -   Run `ng new` (without `--collection`) and create your Angular CLI workspace with whatever options you prefer.
> -   Change directory to your new workspace and run `ng add @angular-eslint/schematics` to add all relevant ESLint packages.
> -   Run `ng g @angular-eslint/schematics:convert-tslint-to-eslint --remove-tslint-if-no-more-tslint-targets --ignore-existing-tslint-config` to automatically convert your new project from TSLint to ESLint.

### barry ide helper

```shell
# composer.json
"@php artisan ide-helper:generate",
"@php artisan ide-helper:meta"
# "post-update-cmd", "post-autoload-dump"
```

## db

`mysql -u root`

`mysql -u bag33188 -p 3931Sunflower$`

`mongofiles.exe -d music put song.mp3`

`mongofiles.exe -d pokerom_files put POKEMON_SLVAAXE01.gbc`

`mysqldump [options] --result-file=dump.sql`

`mongoexport --collection=events --db=reporting --out=events.json --jsonformat=relaxed`

`mongofiles --verbose -d music -l="05 - Together Forever_01.wav" --type="audio/x-wav" --writeConcern="{w:'majority'}" put "05 - Together Forever_01.wav"`

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
