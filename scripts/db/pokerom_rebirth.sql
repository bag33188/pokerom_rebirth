-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2022 at 04:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

--
-- CREATE USER 'bag33188'@'%' IDENTIFIED VIA mysql_native_password USING '***';GRANT ALL PRIVILEGES ON *.* TO 'bag33188'@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;CREATE DATABASE IF NOT EXISTS `bag33188`;GRANT ALL PRIVILEGES ON `bag33188`.* TO 'bag33188'@'%';GRANT ALL PRIVILEGES ON `bag33188\_%`.* TO 'bag33188'@'%';
-- set autocommit = {0|1}
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokerom_rebirth`
--
CREATE DATABASE IF NOT EXISTS `pokerom_rebirth` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pokerom_rebirth`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `spSelectMatchingRomFromRomFilename`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `spSelectMatchingRomFromRomFilename` (IN `ROM_FILENAME` VARCHAR(32))  READS SQL DATA BEGIN
    DECLARE `fullstop` CHAR(1) DEFAULT '.'; -- delimiter
    SELECT * FROM `roms`
    WHERE `rom_name` = SPLIT_STRING(`ROM_FILENAME`, `fullstop`, 1) -- file name
      AND `rom_type` = LCASE(SPLIT_STRING(`ROM_FILENAME`, `fullstop`, 2)) -- file extension
      AND (`has_file` = FALSE OR `file_id` IS NULL) -- no previous rom-file data
    LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `spSelectRomsWithNoGame`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `spSelectRomsWithNoGame` ()  READS SQL DATA BEGIN
    SELECT
        `id`, `rom_name`, `rom_type`,
        `has_game`, `game_id`
    FROM `roms`
    WHERE `has_game` = FALSE OR `game_id` IS NULL
    ORDER BY CHAR_LENGTH(`rom_name`) DESC;
END$$

DROP PROCEDURE IF EXISTS `spUpdateRomFromRomFileData`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `spUpdateRomFromRomFileData` (IN `ROM_FILE_ID` CHAR(24), IN `ROM_FILE_SIZE` BIGINT UNSIGNED, IN `ROM_ID` BIGINT UNSIGNED)   BEGIN
    DECLARE `base_bytes_unit` INTEGER(4) UNSIGNED DEFAULT POW(32, 2); -- 1024
    DECLARE `_rollback` BOOLEAN DEFAULT FALSE;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET `_rollback` = TRUE;
    START TRANSACTION;
    UPDATE `roms`
    SET `file_id` = `ROM_FILE_ID`,
        `rom_size` = CEIL(`ROM_FILE_SIZE` / `base_bytes_unit`), -- get Kibibytes value from bytes
        `has_file` = TRUE
    WHERE `id` = `ROM_ID`;
    IF `_rollback` = 1 THEN
        ROLLBACK;
    ELSE
        COMMIT;
    END IF;
/* !important
rom size is stored as Kibibytes (base 1024)
mongodb stored as bytes
*/
END$$

DROP PROCEDURE IF EXISTS `uspSelectAllPokeROMData`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `uspSelectAllPokeROMData` ()  READS SQL DATA SQL SECURITY INVOKER COMMENT 'Gathers all PokeROM Data in the database.' BEGIN
    SELECT
        `roms`.`id` AS "rom_id",
        `roms`.`rom_name` AS "rom_name",
        `roms`.`rom_type` AS "rom_type",
        (`roms`.`rom_size` * 1024) AS "rom_size", -- convert kibibytes to bytes
        CONCAT(`roms`.`rom_name`, '.', UCASE(`roms`.`rom_type`)) AS "rom_filename",
        `roms`.`file_id` AS "rom_file_id",
        `games`.`id` AS "game_id",
        `games`.`game_name` AS "game_name",
        `games`.`game_type` AS "game_type",
        `games`.`region` AS "region",
        `games`.`generation` AS "generation",
        `games`.`date_released` AS "date_released"
    FROM
        `roms`
            RIGHT JOIN
        `games`
        ON `roms`.`id` = `games`.`rom_id`
    WHERE
            `roms`.`has_game` = TRUE
      AND `roms`.`has_file` = TRUE
      AND `roms`.`game_id` IS NOT NULL
      AND `roms`.`file_id` IS NOT NULL
   	ORDER BY `game_id` DESC, `rom_id` DESC;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `BOOL_TO_STRING`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `BOOL_TO_STRING` (`BOOL_VAL` TINYINT(1) UNSIGNED) RETURNS VARCHAR(5) CHARSET utf8mb4 DETERMINISTIC BEGIN
    IF `BOOL_VAL` = 0 THEN RETURN 'false';
    ELSEIF `BOOL_VAL` = 1 THEN RETURN 'true';
    ELSE RETURN NULL;
    END IF;
END$$

DROP FUNCTION IF EXISTS `FORMAT_GAME_TYPE`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `FORMAT_GAME_TYPE` (`GAME_TYPE` ENUM('core','hack','spin-off')) RETURNS VARCHAR(21) CHARSET utf8mb4 SQL SECURITY INVOKER BEGIN
    SET @`eacute` = CAST(CONVERT(x'E9' USING ucs2) AS char(1));
    CASE `GAME_TYPE`
        WHEN 'core' THEN RETURN CONCAT('Core Pok', @`eacute`, 'mon Game'); -- Core Pokemon Game
        WHEN 'hack' THEN RETURN CONCAT('Pok', @`eacute`, 'mon ROM Hack'); -- Pokemon ROM Hack
        WHEN 'spin-off' THEN RETURN CONCAT('Spin-Off Pok', @`eacute`, 'mon Game'); -- Spin-Off Pokemon Game
        ELSE RETURN 'N/A';
        END CASE;
/* !important
return value length = 21;
'Spin-Off Pokemon Game'.length = 21;
MAX_GAME_TYPE_LENGTH = 21;
*/
END$$

DROP FUNCTION IF EXISTS `FORMAT_ROM_SIZE`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `FORMAT_ROM_SIZE` (`ROM_SIZE` BIGINT UNSIGNED) RETURNS VARCHAR(9) CHARSET utf8mb4 SQL SECURITY INVOKER COMMENT 'conversion issues get fixed in this function' BEGIN
    -- size entity values
    DECLARE `size_num` FLOAT UNSIGNED;
    DECLARE `size_unit` CHAR(2);
    DECLARE `size_str` VARCHAR(6);
    -- size calculation values
    DECLARE `one_kibibyte` SMALLINT UNSIGNED DEFAULT 1024;
    DECLARE `one_kilobyte` SMALLINT UNSIGNED DEFAULT 1000;
    DECLARE `one_gigabyte` MEDIUMINT UNSIGNED DEFAULT POWER(`one_kilobyte`, 2);

    -- MEGABYTES
    IF `ROM_SIZE` > `one_kibibyte` AND `ROM_SIZE` < `one_gigabyte` THEN
        SET `size_unit` = 'MB';
        SET `size_num` = ROUND(`ROM_SIZE` / `one_kilobyte`, 2);
        -- GIGABYTES
    ELSEIF `ROM_SIZE` >= `one_gigabyte` THEN
        SET `size_unit` = 'GB';
        SET `size_num`= ROUND(`ROM_SIZE` / `one_gigabyte`, 2);
        -- KILOBYTES
    ELSEIF `ROM_SIZE` > 1020 AND `ROM_SIZE` <= `one_kibibyte` THEN
        SET `size_unit` = 'KB';
        SET `size_num` = CAST(`ROM_SIZE` AS FLOAT);
        -- BYTES
    ELSE
        SET `size_unit` = 'B ';
        SET `size_num` = CAST((`ROM_SIZE` * `one_kibibyte`) AS FLOAT);
    END IF;
    SET `size_str` = CONVERT(`size_num`, VARCHAR(6));
    RETURN CONCAT(`size_str`, ' ', `size_unit`);
/* !important
return value length = 9;
'262.14 MB'.length = 9;
MAX_ROM_SIZE_LENGTH = 9; // ex. '164.28 MB'
*/
END$$

DROP FUNCTION IF EXISTS `SPLIT_STRING`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `SPLIT_STRING` (`STR_VAL` VARCHAR(256), `SEPARATOR` VARCHAR(1) CHARSET utf8, `POSITION` SMALLINT) RETURNS VARCHAR(128) CHARSET utf8mb4 DETERMINISTIC COMMENT 'splits a string based on delimiter ' BEGIN
    DECLARE `max_results` SMALLINT;

    -- get max number of items
    SET `max_results` = LENGTH(`STR_VAL`) - LENGTH(REPLACE(`STR_VAL`, `SEPARATOR`, '')) + 1;

    IF `POSITION` > `max_results` THEN
        RETURN NULL;
    ELSE
        RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(`STR_VAL`, `SEPARATOR`, `POSITION`), `SEPARATOR`, -1);
    END IF;
/* !important
keep SEPARATOR as VARCHAR since if CHAR is used
then a SPACE character will not work as a SEPARATOR
*/
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `failed_jobs`:
--

--
-- Truncate table before insert `failed_jobs`
--

TRUNCATE TABLE `failed_jobs`;
-- --------------------------------------------------------

--
-- Table structure for table `games`
--
-- Creation: Jul 12, 2022 at 09:23 AM
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rom_id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_type` enum('core','spin-off','hack') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_released` date NOT NULL,
  `generation` tinyint(2) UNSIGNED NOT NULL,
  `region` enum('kanto','johto','hoenn','sinnoh','unova','kalos','alola','galar','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(42) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'only the slug is a unique key. since the game name can be remotely similar through novelty character encodings.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `games`:
--   `rom_id`
--       `roms` -> `id`
--

--
-- Truncate table before insert `games`
--

TRUNCATE TABLE `games`;
--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `rom_id`, `game_name`, `game_type`, `date_released`, `generation`, `region`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pokemon Red', 'core', '1998-09-28', 1, 'kanto', 'pokemon-red', '2022-07-04 03:31:25', '2022-07-04 03:31:25'),
(2, 2, 'Pokemon Blue', 'core', '1998-09-28', 1, 'kanto', 'pokemon-blue', '2022-07-04 03:31:32', '2022-07-04 03:31:32'),
(3, 3, 'Pokemon Green (JP)', 'core', '1996-02-27', 1, 'kanto', 'pokemon-green-jp', '2022-07-04 03:31:52', '2022-07-04 03:31:52'),
(4, 4, 'Pokemon Yellow', 'core', '1999-10-18', 1, 'kanto', 'pokemon-yellow', '2022-07-04 03:32:14', '2022-07-04 03:32:14'),
(5, 5, 'Pokemon Gold', 'core', '2000-10-15', 2, 'johto', 'pokemon-gold', '2022-07-04 03:32:40', '2022-07-04 03:32:40'),
(6, 6, 'Pokemon Silver', 'core', '2000-10-15', 2, 'johto', 'pokemon-silver', '2022-07-04 03:32:49', '2022-07-04 03:32:49'),
(7, 7, 'Pokemon Crystal', 'core', '2001-08-29', 2, 'johto', 'pokemon-crystal', '2022-07-04 03:33:03', '2022-07-04 03:33:03'),
(8, 8, 'Pokemon Ruby', 'core', '2003-03-19', 3, 'hoenn', 'pokemon-ruby', '2022-07-04 03:34:07', '2022-07-04 03:34:07'),
(9, 9, 'Pokemon Sapphire', 'core', '2003-03-19', 3, 'hoenn', 'pokemon-sapphire', '2022-07-04 03:34:23', '2022-07-04 03:34:23'),
(10, 10, 'Pokemon Emerald', 'core', '2005-05-01', 3, 'hoenn', 'pokemon-emerald', '2022-07-04 03:34:51', '2022-07-04 03:34:51'),
(11, 11, 'Pokemon FireRed', 'core', '2004-09-09', 3, 'kanto', 'pokemon-firered', '2022-07-04 03:35:20', '2022-07-04 03:35:20'),
(12, 12, 'Pokemon LeafGreen', 'core', '2004-09-09', 3, 'kanto', 'pokemon-leafgreen', '2022-07-04 03:35:32', '2022-07-04 03:35:32'),
(13, 13, 'Pokemon Diamond', 'core', '2007-04-22', 4, 'sinnoh', 'pokemon-diamond', '2022-07-04 03:36:11', '2022-07-04 03:36:11'),
(14, 14, 'Pokemon Pearl', 'core', '2007-04-22', 4, 'sinnoh', 'pokemon-pearl', '2022-07-04 03:36:17', '2022-07-04 03:36:17'),
(15, 15, 'Pokemon Platinum', 'core', '2009-03-22', 4, 'sinnoh', 'pokemon-platinum', '2022-07-04 03:36:44', '2022-07-04 03:36:44'),
(16, 16, 'Pokemon HeartGold', 'core', '2010-03-14', 4, 'johto', 'pokemon-heartgold', '2022-07-04 03:37:11', '2022-07-04 03:37:11'),
(17, 17, 'Pokemon SoulSilver', 'core', '2010-03-14', 4, 'johto', 'pokemon-soulsilver', '2022-07-04 03:37:19', '2022-07-04 03:37:19'),
(18, 18, 'Pokemon Black', 'core', '2011-03-06', 5, 'unova', 'pokemon-black', '2022-07-04 03:37:53', '2022-07-04 03:37:53'),
(19, 19, 'Pokemon White', 'core', '2011-03-06', 5, 'unova', 'pokemon-white', '2022-07-04 03:38:01', '2022-07-04 03:38:01'),
(20, 20, 'Pokemon Black 2', 'core', '2012-10-07', 5, 'unova', 'pokemon-black-2', '2022-07-04 03:38:27', '2022-07-04 03:38:27'),
(21, 21, 'Pokemon White 2', 'core', '2012-10-07', 5, 'unova', 'pokemon-white-2', '2022-07-04 03:38:36', '2022-07-04 03:38:36'),
(22, 22, 'Pokemon X', 'core', '2013-10-12', 6, 'kalos', 'pokemon-x', '2022-07-04 03:39:02', '2022-07-04 03:39:02'),
(23, 23, 'Pokemon Y', 'core', '2013-10-12', 6, 'kalos', 'pokemon-y', '2022-07-04 03:39:08', '2022-07-04 03:39:08'),
(24, 24, 'Pokemon Omega Ruby', 'core', '2014-11-21', 6, 'hoenn', 'pokemon-omega-ruby', '2022-07-04 03:39:36', '2022-07-04 03:39:36'),
(25, 25, 'Pokemon Alpha Sapphire', 'core', '2014-11-21', 6, 'hoenn', 'pokemon-alpha-sapphire', '2022-07-04 03:40:04', '2022-07-04 03:40:04'),
(26, 26, 'Pokemon Sun', 'core', '2016-11-18', 7, 'alola', 'pokemon-sun', '2022-07-04 03:40:40', '2022-07-04 03:40:40'),
(27, 27, 'Pokemon Moon', 'core', '2016-11-18', 7, 'alola', 'pokemon-moon', '2022-07-04 03:40:51', '2022-07-04 03:40:51'),
(28, 28, 'Pokemon Ultra Sun', 'core', '2017-11-17', 7, 'alola', 'pokemon-ultra-sun', '2022-07-04 03:41:14', '2022-07-04 03:41:14'),
(29, 29, 'Pokemon Ultra Moon', 'core', '2017-11-17', 7, 'alola', 'pokemon-ultra-moon', '2022-07-04 03:41:20', '2022-07-04 03:41:20'),
(30, 30, 'Pokemon Sword', 'core', '2019-11-15', 8, 'galar', 'pokemon-sword', '2022-07-04 03:42:01', '2022-07-04 03:42:01'),
(31, 31, 'Pokemon Shield', 'core', '2019-11-15', 8, 'galar', 'pokemon-shield', '2022-07-04 03:42:13', '2022-07-04 03:42:13'),
(32, 32, 'Pokemon Brilliant Diamond', 'core', '2021-11-19', 8, 'sinnoh', 'pokemon-brilliant-diamond', '2022-07-04 03:42:46', '2022-07-04 03:42:46'),
(33, 33, 'Pokemon Shining Pearl', 'core', '2021-11-19', 8, 'sinnoh', 'pokemon-shining-pearl', '2022-07-04 03:42:58', '2022-07-04 03:42:58'),
(34, 34, 'Pokemon Let\'s Go Pikachu', 'spin-off', '2018-11-16', 7, 'kanto', 'pokemon-lets-go-pikachu', '2022-07-04 03:43:32', '2022-07-04 03:43:32'),
(35, 35, 'Pokemon Let\'s Go Eevee', 'spin-off', '2018-11-16', 7, 'kanto', 'pokemon-lets-go-eevee', '2022-07-04 03:43:38', '2022-07-04 03:43:38'),
(36, 36, 'Pokemon Prism', 'hack', '2016-12-25', 0, 'other', 'pokemon-prism', '2022-07-04 03:44:25', '2022-07-04 03:44:25'),
(37, 37, 'Pokemon Brown', 'hack', '2012-06-15', 0, 'other', 'pokemon-brown', '2022-07-04 03:44:50', '2022-07-04 03:44:50'),
(38, 38, 'Pokemon Genesis', 'hack', '2019-08-23', 0, 'other', 'pokemon-genesis', '2022-07-04 03:47:31', '2022-07-04 03:47:31'),
(39, 39, 'Pokemon Ash Gray', 'hack', '2009-05-31', 1, 'kanto', 'pokemon-ash-gray', '2022-07-04 03:48:07', '2022-07-04 03:48:07'),
(40, 40, 'Pokemon Renegade Platinum', 'hack', '2019-04-16', 4, 'sinnoh', 'pokemon-renegade-platinum', '2022-07-04 03:48:37', '2022-07-04 03:48:37');

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
  INTO `rom_already_has_game`
  FROM `roms`
  WHERE `roms`.`id` = NEW.`rom_id`;
  IF `rom_already_has_game` = FALSE
  THEN
    UPDATE `roms`
    SET `roms`.`has_game` = TRUE, `roms`.`game_id` = NEW.`id`
    WHERE `roms`.`id` = NEW.`rom_id`;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `migrations`:
--

--
-- Truncate table before insert `migrations`
--

TRUNCATE TABLE `migrations`;
--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_06_02_000001_create_rom_files_collection', 1),
(7, '2022_06_05_162238_create_sessions_table', 1),
(8, '2022_06_15_025832_create_roms_table', 1),
(9, '2022_06_15_040939_create_games_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `password_resets`:
--   `email`
--       `users` -> `email`
--

--
-- Truncate table before insert `password_resets`
--

TRUNCATE TABLE `password_resets`;
-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'used to be 15 in pokerom_v3, may want to look into that',
  `token` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `personal_access_tokens`:
--

--
-- Truncate table before insert `personal_access_tokens`
--

TRUNCATE TABLE `personal_access_tokens`;
--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\User', 4, 'auth_token', '3c29f68438c5d82dd86c2bf79b64221047f32046e349cf87493598b7f8d90717', '[\"*\"]', '2022-07-15 14:11:30', '2022-07-15 13:40:41', '2022-07-15 14:11:30'),
(8, 'App\\Models\\User', 1, 'auth_token', 'f17804702643fdbbbeefbc42a3e379772d15a8656d0ccb2e1ce10281f2ccb0e8', '[\"*\"]', '2022-07-18 04:42:23', '2022-07-17 01:57:22', '2022-07-18 04:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `roms`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `roms`;
CREATE TABLE `roms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_id` char(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'this unique constraint references a MongoDB GridFS file database which is binded at the API level.',
  `game_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rom_name` varchar(28) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rom_size` mediumint(10) UNSIGNED NOT NULL DEFAULT 1020 COMMENT 'rom size value measured in kilobytes',
  `rom_type` enum('gb','gbc','gba','nds','3ds','xci') COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_game` tinyint(1) NOT NULL DEFAULT 0,
  `has_file` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `roms`:
--

--
-- Truncate table before insert `roms`
--

TRUNCATE TABLE `roms`;
--
-- Dumping data for table `roms`
--

INSERT INTO `roms` (`id`, `file_id`, `game_id`, `rom_name`, `rom_size`, `rom_type`, `has_game`, `has_file`, `created_at`, `updated_at`) VALUES
(1, '62c1f859f80501a0830fdd51', 1, 'POKEMON_RED01', 1024, 'gb', 1, 1, '2022-07-04 03:15:17', '2022-07-15 13:10:13'),
(2, '62c1f8553fc0765cf90218b1', 2, 'POKEMON_BLUE01', 1024, 'gb', 1, 1, '2022-07-04 03:15:28', '2022-07-04 03:15:28'),
(3, '62c1f85078ebd701720e71b1', 3, 'POKEMON_GREEN01', 1024, 'gb', 1, 1, '2022-07-04 03:15:39', '2022-07-04 03:15:39'),
(4, '62c1f84857a678cc7d0e2b51', 4, 'POKEMON_YELLOW01', 1024, 'gb', 1, 1, '2022-07-04 03:15:44', '2022-07-04 03:15:44'),
(5, '62c1f83543c584b6e3008491', 5, 'POKEMON_GLDAAUE01', 2048, 'gbc', 1, 1, '2022-07-04 03:15:56', '2022-07-04 03:15:56'),
(6, '62c1f83ad868d1a2d40692b1', 6, 'POKEMON_SLVAAXE01', 2048, 'gbc', 1, 1, '2022-07-04 03:16:03', '2022-07-04 03:16:03'),
(7, '62c1f83010c6d73c6908c841', 7, 'PM_CRYSTAL_BYTE01', 2048, 'gbc', 1, 1, '2022-07-04 03:16:10', '2022-07-04 03:16:10'),
(8, '62c1f822e6d1f33ef20719d1', 8, 'POKEMON_RUBYAXVE01', 16384, 'gba', 1, 1, '2022-07-04 03:16:22', '2022-07-04 03:16:22'),
(9, '62c1f827f6e3ba8d990035d1', 9, 'POKEMON_SAPPAXPE01', 16384, 'gba', 1, 1, '2022-07-04 03:16:27', '2022-07-04 03:16:27'),
(10, '62c1f80c199b08211c0e0b91', 10, 'POKEMON_EMERBPEE01', 16384, 'gba', 1, 1, '2022-07-04 03:16:32', '2022-07-04 03:16:32'),
(11, '62c1f81672b9730b0704c171', 11, 'POKEMON_FIREBPRE01', 16384, 'gba', 1, 1, '2022-07-04 03:16:38', '2022-07-04 03:16:38'),
(12, '62c1f81cebac46eb8c087c51', 12, 'POKEMON_LEAFBPGE01', 16384, 'gba', 1, 1, '2022-07-04 03:16:44', '2022-07-04 03:16:44'),
(13, '62c1f7f7032feb564f0014e1', 13, 'POKEMON_D_ADAE01', 65536, 'nds', 1, 1, '2022-07-04 03:16:55', '2022-07-04 03:16:55'),
(14, '62c1f7fdb7e80025ec04af01', 14, 'POKEMON_P_APAE', 65536, 'nds', 1, 1, '2022-07-04 03:17:01', '2022-07-04 03:17:01'),
(15, '62c1f7ee7debe6e99e028611', 15, 'POKEMON_PL_CPUE01', 131072, 'nds', 1, 1, '2022-07-04 03:17:09', '2022-07-04 03:17:09'),
(16, '62c1f7db235ab0b7e405b001', 16, 'POKEMON_HG_IPKE01', 131072, 'nds', 1, 1, '2022-07-04 03:17:15', '2022-07-04 03:17:15'),
(17, '62c1f7e4146b9ad6a9064351', 17, 'POKEMON_SS_IPGE01', 131072, 'nds', 1, 1, '2022-07-04 03:17:19', '2022-07-04 03:17:19'),
(18, '62c1f7b9e373f2f86f0fbbe1', 18, 'POKEMON_B_IRBO01', 262144, 'nds', 1, 1, '2022-07-04 03:17:24', '2022-07-04 03:17:24'),
(19, '62c1f7cdf92a4a0a14075881', 19, 'POKEMON_W_IRAO01', 262144, 'nds', 1, 1, '2022-07-04 03:17:28', '2022-07-04 03:17:28'),
(20, '62c1f7a69e801668070cba11', 20, 'POKEMON_B2_IREO01', 524288, 'nds', 1, 1, '2022-07-04 03:17:34', '2022-07-04 03:17:34'),
(21, '62c1f7b02b2fe7984b0af731', 21, 'POKEMON_W2_IRDO01', 524288, 'nds', 1, 1, '2022-07-04 03:17:38', '2022-07-04 03:17:38'),
(22, '62c1f730345182b6c0067e41', 22, '0004000000055D00_v00', 2097152, '3ds', 1, 1, '2022-07-04 03:18:06', '2022-07-04 03:18:06'),
(23, '62c1f767449aa5235402b601', 23, '0004000000055E00_v00', 2097152, '3ds', 1, 1, '2022-07-04 03:18:15', '2022-07-04 03:18:15'),
(24, '62c1f6890903d19032057d61', 24, '000400000011C400_v00', 2097152, '3ds', 1, 1, '2022-07-04 03:18:24', '2022-07-04 03:18:24'),
(25, '62c1f6f541d4a0bb3d0ee5e1', 25, '000400000011C500_v00', 2097152, '3ds', 1, 1, '2022-07-04 03:18:29', '2022-07-04 03:18:29'),
(26, '62c1f5b3c1565ea1660e89a1', 26, '0004000000164800_v00', 4194304, '3ds', 1, 1, '2022-07-04 03:18:40', '2022-07-04 03:18:40'),
(27, '62c1f53f3a9494578d0b1161', 27, '0004000000175E00_v00', 4194304, '3ds', 1, 1, '2022-07-04 03:18:48', '2022-07-04 03:18:48'),
(28, '62c1f44459a40296ea057eb1', 28, '00040000001B5000_v00', 4194304, '3ds', 1, 1, '2022-07-04 03:18:54', '2022-07-04 03:18:54'),
(29, '62c1f4c0e4946f662b0452e1', 29, '00040000001B5100_v00', 4194304, '3ds', 1, 1, '2022-07-04 03:18:59', '2022-07-04 03:18:59'),
(30, '62c1f0b3124383f348009521', 30, '0100ABF008968000', 15597568, 'xci', 1, 1, '2022-07-04 03:19:32', '2022-07-04 03:19:32'),
(31, '62c1f17fab8651d95f0013c1', 31, '01008DB008C2C000', 15597568, 'xci', 1, 1, '2022-07-04 03:19:38', '2022-07-04 03:19:38'),
(32, '62c1f2feee76382f4702d5c1', 32, '0100000011D90000', 4880601, 'xci', 1, 1, '2022-07-04 03:19:59', '2022-07-04 03:19:59'),
(33, '62c1f28977ab05bb03073041', 33, '010018E011D92000', 7798784, 'xci', 1, 1, '2022-07-04 03:20:06', '2022-07-04 03:20:06'),
(34, '62c1f35f048436717d0219e1', 34, '010003F003A34000', 4737727, 'xci', 1, 1, '2022-07-04 03:20:28', '2022-07-04 03:20:28'),
(35, '62c1f3cb17c7e0692e0e3101', 35, '0100187003A36000', 4363761, 'xci', 1, 1, '2022-07-04 03:20:38', '2022-07-12 15:41:56'),
(36, '62c1f860f8ff95e09f094bf1', 36, 'pokeprism', 2048, 'gbc', 1, 1, '2022-07-04 03:21:13', '2022-07-04 03:21:13'),
(37, '62c1f866133b94ba3a0ccc91', 37, 'pokemon_brown_2014-red_hack', 2048, 'gb', 1, 1, '2022-07-04 03:21:42', '2022-07-04 03:21:42'),
(38, '62c1f86e73d95a1cf70f7bd1', 38, 'genesis-final-2019-08-23', 16384, 'gba', 1, 1, '2022-07-04 03:21:58', '2022-07-04 03:21:58'),
(39, '62c1f874529b5091fb0e5481', 39, 'Pokemon_Ash_Gray_4-5-3', 16384, 'gba', 1, 1, '2022-07-04 03:22:16', '2022-07-04 03:22:16'),
(40, '62c1f87d2c665156bd0f3071', 40, 'RenegadePlatinum', 102464, 'nds', 1, 1, '2022-07-04 03:22:28', '2022-07-04 03:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` char(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '45 characters because of ipv6',
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `sessions`:
--   `user_id`
--       `users` -> `id`
--

--
-- Truncate table before insert `sessions`
--

TRUNCATE TABLE `sessions`;
--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CrJH5RHmcFKnPGyRXWKACpN8pbvvoLtHs6ksyBCn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiamMzTkIyeXlQbElSOXlvdUxvMEFNekdqNjFrQzNybFpSZkZKc0JCaiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjc0OiJodHRwOi8vcG9rZXJvbV9yZWJpcnRoLnRlc3QvcHVibGljL3JvbS1maWxlcy9pbmZvLzYyYzFmODU5ZjgwNTAxYTA4MzBmZGQ1MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkd2lwM3F4OTFQbFhEa3JqLnpFam9DLi93bEludGdJSzNRLnJBSmdnd1FoZlhSRmlJbm1EWm0iO30=', 1658093216);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jul 08, 2022 at 12:34 AM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '60 chars for bcrypt hashing specification',
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin','guest') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `role`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Brock', 'bglatman@outlook.com', NULL, '$2y$10$wip3qx91PlXDkrj.zEjoC./wlIntgIK3Q.rAJggwQhfXRFiInmDZm', NULL, NULL, NULL, 'admin', 's2Sx7zKdJzhExXdIAJGNyMHUrC8n3nGxCjOjUF4ew4gsrDWEnUlYnCj6hb8a', NULL, NULL, '2022-07-04 02:35:33', '2022-07-10 23:32:39'),
(4, 'John Doe', 'jdoe123@gmail.com', NULL, '$2y$10$TzzNPZc0JrCcsUyJB4FhQ.khUwfmikQwxpM1ZKneb/QloOTmcFnX2', NULL, NULL, NULL, 'user', NULL, NULL, NULL, '2022-07-08 13:10:55', '2022-07-08 13:10:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `games_rom_id_unique` (`rom_id`),
  ADD UNIQUE KEY `games_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roms`
--
ALTER TABLE `roms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roms_rom_name_unique` (`rom_name`),
  ADD UNIQUE KEY `roms_file_id_unique` (`file_id`),
  ADD UNIQUE KEY `roms_game_id_unique` (`game_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roms`
--
ALTER TABLE `roms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_rom_id_foreign` FOREIGN KEY (`rom_id`) REFERENCES `roms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_email_foreign` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
