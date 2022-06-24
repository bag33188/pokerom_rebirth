-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2022 at 06:21 AM
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
DROP PROCEDURE IF EXISTS `FindRomsWithNoFile`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `FindRomsWithNoFile` ()   BEGIN
SELECT `id`, `rom_name`, `rom_type`, IF (0 = FALSE, 'false', 'true') AS `has_file`, `file_id` FROM `roms` WHERE `has_file` = FALSE AND `file_id` IS NULL ORDER BY `rom_name` DESC;
END$$

DROP PROCEDURE IF EXISTS `FindRomsWithNoGame`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `FindRomsWithNoGame` ()   BEGIN
SELECT `id`, `rom_name`, `rom_type`, IF (0 = FALSE, 'false', 'true') AS `has_game`, `game_id` FROM `roms` WHERE `has_game` = FALSE AND `game_id` IS NULL ORDER BY `rom_name` DESC;
END$$

DROP PROCEDURE IF EXISTS `GetAllUnlinkedRoms`$$
CREATE DEFINER=`bag33188`@`localhost` PROCEDURE `GetAllUnlinkedRoms` ()  COMMENT 'checks for both unlinked games and/or files' BEGIN
  SELECT `id` AS `rom_id`, `file_id`, `rom_name`, `rom_type`, IF (0 = FALSE, 'false', 'true') AS `has_game`, IF (0 = FALSE, 'false', 'true') AS `has_file`
  FROM `roms`
  WHERE `has_game` = FALSE OR `has_file` = FALSE OR `file_id` IS NULL OR `game_id` IS NULL ORDER BY `rom_size` DESC;
END$$

DROP PROCEDURE IF EXISTS `GetTotalSizeOfAllRoms`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `GetTotalSizeOfAllRoms` ()   BEGIN
  SET @`size_val` = CAST(CalcSumOfAllRomSize() AS VARCHAR(14));
  SELECT CONCAT(@`size_val`, ' ', 'Bytes') AS `total_size`;
/** !important:
Right now the total length of bytes (as a string) is less than 14 (11 currently `82401764352`)

may need to increase varchar limit in the future
*/
END$$

DROP PROCEDURE IF EXISTS `LinkAllRomGameIDsToGames`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `LinkAllRomGameIDsToGames` ()  SQL SECURITY INVOKER BEGIN
START TRANSACTION;
    SET @`game_id_null_count` = (SELECT COUNT(*) FROM `roms` WHERE `game_id` IS NULL);
    IF @`game_id_null_count` = 0 THEN
        SELECT 'All ROM\'s Game IDs are already Linked' AS 'Status Message';
        ROLLBACK WORK;
    ELSE
        UPDATE `roms` LEFT JOIN `games`
        ON `games`.`rom_id` = `roms`.`id`
        SET `roms`.`game_id` = `games`.`id`;
        SELECT COUNT(*) AS 'Linked Game ID ROMs' FROM `roms` WHERE `game_id` IS NOT NULL;
        SELECT COUNT(*) AS 'Total ROMs' FROM `roms`;
    END IF;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `LinkRomToFile`$$
CREATE DEFINER=`bag33188`@`%` PROCEDURE `LinkRomToFile` (IN `FILE_OBJ_ID` CHAR(24), IN `FILE_LENGTH` BIGINT, IN `ROM_ID` BIGINT)  SQL SECURITY INVOKER BEGIN
START TRANSACTION;
  UPDATE `roms`
  SET `file_id` = `FILE_OBJ_ID`,
      `rom_size` = CEIL(`FILE_LENGTH` / 1024), -- get kilobytes value from bytes
      `has_file` = TRUE
  WHERE `id` = `ROM_ID`;
COMMIT;
/** !important:
notes:
 * rom size is stored in kilobytes
 * mongodb uses raw bytes as file length value
*/
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `CalcReadableRomSize`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `CalcReadableRomSize` (`rom_length` INT) RETURNS VARCHAR(9) CHARSET utf8mb4 DETERMINISTIC BEGIN
/** !important:
Note: these calculations and measurements are based on the standard units of data.
Ie. 1 Gigabyte = 1000 MegaBytes = 1000 Kilobytes
Other parts of the app use the Computer Information system
Ie. 1 Gibibyte = 1024 Mebibytes = 1024 Kibibytes = 1024 = 1048576 Standard Bytes
*/
  DECLARE `size_val` FLOAT;
  DECLARE `size_type` CHAR(2);
  IF `rom_length` > 1024 AND `rom_length` < 1000000 THEN
    SET `size_type` = 'MB';
    SET `size_val` = ROUND(CAST(`rom_length` / 1000 AS FLOAT), 2);
  ELSEIF `rom_length` >= 1000000 THEN
    SET `size_type` = 'GB';
    SET `size_val`= ROUND(CAST(`rom_length` / 1000000 AS FLOAT), 2);
  ELSEIF `rom_length` > 1020 AND `rom_length` <= 1024 THEN
    SET `size_type` = 'KB';
    SET `size_val` = CAST(`rom_length` AS FLOAT);
  ELSE
    SET `size_type` = 'B ';
    SET `size_val` = CAST(`rom_length` * 1024 AS FLOAT);
  END IF;
  SET @`size_str` = CAST(`size_val` AS VARCHAR(6));
  RETURN CONCAT(@`size_str`, ' ', `size_type`);
/** !important:
max rounded size value is 5 digits (plus a . character), so 6 (min, 3);
and the fixed string length of size type is 2; .... pluse
the space in between, 6 + 2 + 1 = 9 .....
thus varchar(9)
*/
END$$

DROP FUNCTION IF EXISTS `CalcSumOfAllRomSize`$$
CREATE DEFINER=`bag33188`@`%` FUNCTION `CalcSumOfAllRomSize` () RETURNS BIGINT(14) UNSIGNED DETERMINISTIC BEGIN
    DECLARE `total_value` BIGINT UNSIGNED;
    SET `total_value` = 0;
    SELECT SUM(`rom_size`) INTO `total_value`
    FROM `roms` LIMIT 1;
    SET  @`total_value_bytes` = `total_value` * 1024;
    RETURN @`total_value_bytes`;
/** !important:
Right now the total length of bytes (as a string) is less than 14 (11 currently, `82401763216`)

may need to increase varchar limit in the future
*/
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
-- Creation: Jun 05, 2022 at 04:47 PM
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
-- Creation: Jun 15, 2022 at 04:16 AM
-- Last update: Jun 23, 2022 at 04:19 AM
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rom_id` bigint(20) UNSIGNED NOT NULL,
  `game_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_type` enum('core','spin-off','hack') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_released` date NOT NULL,
  `generation` tinyint(3) UNSIGNED NOT NULL,
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
(1, 1, 'Pokemon Red', 'core', '1998-09-28', 1, 'kanto', 'pokemon-red', '2022-06-04 15:30:44', '2022-06-04 15:30:44'),
(2, 2, 'Pokemon Blue', 'core', '1998-09-28', 1, 'kanto', 'pokemon-blue', '2022-06-04 15:31:29', '2022-06-04 15:31:29'),
(3, 3, 'Pokemon Yellow', 'core', '1999-10-18', 1, 'kanto', 'pokemon-yellow', '2022-06-04 15:31:59', '2022-06-04 15:31:59'),
(4, 4, 'Pokemon Green (JP)', 'core', '1996-02-27', 1, 'kanto', 'pokemon-green-jp', '2022-06-04 15:43:16', '2022-06-04 15:43:16'),
(5, 5, 'Pokemon Gold', 'core', '2000-10-15', 2, 'johto', 'pokemon-gold', '2022-06-04 15:32:16', '2022-06-04 15:32:16'),
(6, 6, 'Pokemon Silver', 'core', '2000-10-15', 2, 'johto', 'pokemon-silver', '2022-06-04 15:32:38', '2022-06-04 15:32:38'),
(7, 7, 'Pokemon Crystal', 'core', '2001-08-29', 2, 'johto', 'pokemon-crystal', '2022-06-04 15:32:49', '2022-06-04 15:32:49'),
(8, 8, 'Pokemon Ruby', 'core', '2003-03-19', 3, 'hoenn', 'pokemon-ruby', '2022-06-04 15:33:10', '2022-06-04 15:33:10'),
(9, 9, 'Pokemon Sapphire', 'core', '2003-03-19', 3, 'hoenn', 'pokemon-sapphire', '2022-06-04 15:33:29', '2022-06-04 15:33:29'),
(10, 10, 'Pokemon FireRed', 'core', '2004-09-09', 3, 'kanto', 'pokemon-firered', '2022-06-04 15:34:05', '2022-06-04 15:34:05'),
(11, 11, 'Pokemon LeafGreen', 'core', '2004-09-09', 3, 'kanto', 'pokemon-leafgreen', '2022-06-04 15:34:19', '2022-06-04 15:34:19'),
(12, 12, 'Pokemon Emerald', 'core', '2005-05-01', 3, 'hoenn', 'pokemon-emerald', '2022-06-04 15:34:48', '2022-06-04 15:34:48'),
(13, 13, 'Pokemon Diamond', 'core', '2007-04-22', 4, 'sinnoh', 'pokemon-diamond', '2022-06-04 15:35:02', '2022-06-04 15:35:02'),
(14, 14, 'Pokemon Pearl', 'core', '2007-04-22', 4, 'sinnoh', 'pokemon-pearl', '2022-06-04 15:35:25', '2022-06-04 15:35:25'),
(15, 15, 'Pokemon Platinum', 'core', '2009-03-22', 4, 'sinnoh', 'pokemon-platinum', '2022-06-04 15:35:39', '2022-06-04 15:35:39'),
(16, 16, 'Pokemon HeartGold', 'core', '2010-03-14', 4, 'johto', 'pokemon-heartgold', '2022-06-04 15:35:56', '2022-06-04 15:35:56'),
(17, 17, 'Pokemon SoulSilver', 'core', '2010-03-14', 4, 'johto', 'pokemon-soulsilver', '2022-06-04 15:36:09', '2022-06-04 15:36:09'),
(18, 18, 'Pokemon Black', 'core', '2011-03-06', 5, 'unova', 'pokemon-black', '2022-06-04 15:36:24', '2022-06-04 15:36:24'),
(19, 19, 'Pokemon White', 'core', '2011-03-06', 5, 'unova', 'pokemon-white', '2022-06-04 15:36:37', '2022-06-04 15:36:37'),
(20, 20, 'Pokemon Black 2', 'core', '2012-10-07', 5, 'unova', 'pokemon-black-2', '2022-06-04 15:37:06', '2022-06-04 15:37:06'),
(21, 21, 'Pokemon White 2', 'core', '2012-10-07', 5, 'unova', 'pokemon-white-2', '2022-06-04 15:37:18', '2022-06-04 15:37:18'),
(22, 22, 'Pokemon X', 'core', '2013-10-12', 6, 'kalos', 'pokemon-x', '2022-06-04 15:37:47', '2022-06-04 15:37:47'),
(23, 23, 'Pokemon Y', 'core', '2013-10-12', 6, 'kalos', 'pokemon-y', '2022-06-04 15:38:29', '2022-06-04 15:38:29'),
(24, 24, 'Pokemon Omega Ruby', 'core', '2014-11-21', 6, 'hoenn', 'pokemon-omega-ruby', '2022-06-04 15:38:47', '2022-06-04 15:38:47'),
(25, 25, 'Pokemon Alpha Sapphire', 'core', '2014-11-21', 6, 'hoenn', 'pokemon-alpha-sapphire', '2022-06-04 15:38:59', '2022-06-04 15:38:59'),
(26, 26, 'Pokemon Sun', 'core', '2016-11-18', 7, 'alola', 'pokemon-sun', '2022-06-04 15:39:28', '2022-06-04 15:39:28'),
(27, 27, 'Pokemon Moon', 'core', '2016-11-18', 7, 'alola', 'pokemon-moon', '2022-06-04 15:39:45', '2022-06-04 15:39:45'),
(28, 28, 'Pokemon Ultra Sun', 'core', '2017-11-17', 7, 'alola', 'pokemon-ultra-sun', '2022-06-04 15:39:59', '2022-06-04 15:39:59'),
(29, 29, 'Pokemon Ultra Moon', 'core', '2017-11-17', 7, 'alola', 'pokemon-ultra-moon', '2022-06-04 15:40:17', '2022-06-04 15:40:17'),
(30, 30, 'Pokemon Sword', 'core', '2019-11-15', 8, 'galar', 'pokemon-sword', '2022-06-04 15:40:51', '2022-06-04 15:40:51'),
(31, 31, 'Pokemon Shield', 'core', '2019-11-15', 8, 'galar', 'pokemon-shield', '2022-06-04 15:41:05', '2022-06-04 15:41:05'),
(32, 32, 'Pokemon Brilliant Diamond', 'core', '2021-11-19', 8, 'sinnoh', 'pokemon-brilliant-diamond', '2022-06-04 15:41:20', '2022-06-04 15:41:20'),
(33, 33, 'Pokemon Shining Pearl', 'core', '2021-11-19', 8, 'sinnoh', 'pokemon-shining-pearl', '2022-06-04 15:41:47', '2022-06-04 15:41:47'),
(34, 34, 'Pokemon Let\'s Go Pikachu', 'spin-off', '2018-11-16', 7, 'kanto', 'pokemon-lets-go-pikachu', '2022-06-04 15:42:24', '2022-06-04 15:42:24'),
(35, 35, 'Pokemon Let\'s Go Eevee', 'spin-off', '2018-11-16', 7, 'kanto', 'pokemon-lets-go-eevee', '2022-06-04 15:42:45', '2022-06-04 15:42:45'),
(36, 36, 'Pokemon Brown', 'hack', '2012-06-15', 0, 'other', 'pokemon-brown', '2022-06-04 15:43:34', '2022-06-04 15:43:34'),
(37, 37, 'Pokemon Genesis', 'hack', '2019-08-23', 0, 'other', 'pokemon-genesis', '2022-06-04 15:43:52', '2022-06-04 15:43:52'),
(38, 38, 'Pokemon Prism', 'hack', '2016-12-25', 0, 'other', 'pokemon-prism', '2022-06-04 15:44:07', '2022-06-04 15:44:07'),
(39, 39, 'Pokemon Ash Gray', 'hack', '2009-05-31', 1, 'kanto', 'pokemon-ash-gray', '2022-06-04 15:44:19', '2022-06-04 15:44:19'),
(40, 40, 'Pokemon Renegade Platinum', 'hack', '2019-04-16', 4, 'sinnoh', 'pokemon-renegade-platinum', '2022-06-04 15:44:32', '2022-06-04 15:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Jun 05, 2022 at 04:47 PM
-- Last update: Jun 23, 2022 at 04:19 AM
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
(6, '2022_06_02_000001_create_files_collection', 1),
(7, '2022_06_05_162238_create_sessions_table', 1),
(8, '2022_06_15_025832_create_roms_table', 1),
(9, '2022_06_15_040939_create_games_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--
-- Creation: Jun 05, 2022 at 04:47 PM
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELATIONSHIPS FOR TABLE `password_resets`:
--

--
-- Truncate table before insert `password_resets`
--

TRUNCATE TABLE `password_resets`;
-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--
-- Creation: Jun 05, 2022 at 04:47 PM
-- Last update: Jun 23, 2022 at 04:21 AM
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
(1, 'App\\Models\\User', 1, 'auth_token', '1662a4096e795ca20c6d5ccee5bd7e9e7933b1a452eabf0d2de0073b2bec7422', '[\"*\"]', '2022-06-23 11:21:35', '2022-06-23 11:21:23', '2022-06-23 11:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `roms`
--
-- Creation: Jun 15, 2022 at 04:16 AM
-- Last update: Jun 23, 2022 at 04:19 AM
--

DROP TABLE IF EXISTS `roms`;
CREATE TABLE `roms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_id` char(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'this unique constraint references a MongoDB GridFS file database which is binded at the API level.',
  `game_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rom_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rom_size` int(10) UNSIGNED NOT NULL DEFAULT 1020 COMMENT 'rom size value measured in kilobytes',
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
(1, '6292fd825a0d65bff6068e71', 1, 'POKEMON_RED01', 1024, 'gb', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:30:44'),
(2, '6292fd79a11b7b48600157a1', 2, 'POKEMON_BLUE01', 1024, 'gb', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:31:29'),
(3, '62929c5483f6032a7d0ceb41', 3, 'POKEMON_YELLOW01', 1024, 'gb', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:31:59'),
(4, '6292fd7d22122e0b5f077bf1', 4, 'POKEMON_GREEN01', 1024, 'gb', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:43:16'),
(5, '6292fdbdc5898918900ec701', 5, 'POKEMON_GLDAAUE01', 2048, 'gbc', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:32:16'),
(6, '6292fe2a569beb5025003291', 6, 'POKEMON_SLVAAXE01', 2048, 'gbc', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:32:38'),
(7, '6292fdc1bd29353d25028ed1', 7, 'PM_CRYSTAL_BYTE01', 2048, 'gbc', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:32:49'),
(8, '629267c77a73cde1d1069071', 8, 'POKEMON_RUBYAXVE01', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:33:10'),
(9, '629050d19bc398a16c0f75f1', 9, 'POKEMON_SAPPAXPE01', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:33:29'),
(10, '6292fdd4cc6a265115018231', 10, 'POKEMON_FIREBPRE01', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:34:05'),
(11, '6292fdda7b76e3ef190b4641', 11, 'POKEMON_LEAFBPGE01', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:34:19'),
(12, '6292e893aaf3f70dae0bf6a1', 12, 'POKEMON_EMERBPEE01', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:34:48'),
(13, '6292fd72f6ebc3e28103afe1', 13, 'POKEMON_D_ADAE01', 65536, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:35:02'),
(14, '6292dba9766f34b73a0ed961', 14, 'POKEMON_P_APAE', 65536, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:35:25'),
(15, '6291268c1b9fd763720ba8e1', 15, 'POKEMON_PL_CPUE01', 131072, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:35:39'),
(16, '6292fd6ad36bee9ff60473e1', 16, 'POKEMON_HG_IPKE01', 131072, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:35:56'),
(17, '6292fd5350ce2367dd0f43c1', 17, 'POKEMON_SS_IPGE01', 131072, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:36:09'),
(18, '6292fdaf9a1544e094007e81', 18, 'POKEMON_B_IRBO01', 262144, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:36:24'),
(19, '6292fd88999fc3ecbe0f6ae1', 19, 'POKEMON_W_IRAO01', 262144, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:36:37'),
(20, '6292fd3f9719292277008401', 20, 'POKEMON_B2_IREO01', 524288, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:37:06'),
(21, '6292fd3422dd3caf81007701', 21, 'POKEMON_W2_IRDO01', 524288, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:37:18'),
(22, '6292fbe7107e168f5b0cc581', 22, '0004000000055D00_v00', 2097152, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:37:47'),
(23, '6292fbaec5d2d71b000e37b1', 23, '0004000000055E00_v00', 2097152, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:38:29'),
(24, '6292f7bf421c4ebbfc0aa251', 24, '000400000011C400_v00', 2097152, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:38:47'),
(25, '6292f7821c5a67f637028e51', 25, '000400000011C500_v00', 2097152, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:38:59'),
(26, '6292fb1c0332b9f7de073871', 26, '0004000000164800_v00', 4194304, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:39:28'),
(27, '6292f9709fad08ca500a7271', 27, '0004000000175E00_v00', 4194304, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:39:45'),
(28, '6292661b96ecb348db04b5b1', 28, '00040000001B5000_v00', 4194304, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:39:59'),
(29, '62904b8a7a67066776014901', 29, '00040000001B5100_v00', 4194304, '3ds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:40:17'),
(30, '62912766c7beff061c0e75d1', 30, '0100ABF008968000', 15597568, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:40:51'),
(31, '629264b1c00b0492df0ea2a1', 31, '01008DB008C2C000', 15597568, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:41:05'),
(32, '62904ead5f9bd647b1001111', 32, '0100000011D90000', 4880601, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:41:20'),
(33, '6292f8f0308be34f36025401', 33, '010018E011D92000', 7798784, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:41:47'),
(34, '6292fc660d54f4a3a70e05b1', 34, '010003F003A34000', 4737727, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:42:24'),
(35, '629266bd4da5ece47e0fcba1', 35, '0100187003A36000', 4363761, 'xci', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:42:45'),
(36, '62af59c78253e5fb360a27a1', 36, 'pokemon_brown_2014-red_hack', 2048, 'gb', 1, 1, '2022-06-04 08:20:25', '2022-06-20 07:15:51'),
(37, '6292fdffad6b83da060e9b91', 37, 'genesis-final-2019-08-23', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:43:52'),
(38, '6292fde23bcc58a48f0cc451', 38, 'pokeprism', 2048, 'gbc', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:44:07'),
(39, '6292fdb85c7bfd3e3903dd71', 39, 'Pokemon_Ash_Gray_4-5-3', 16384, 'gba', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:44:19'),
(40, '6292fd925630ef3ecf06f0b1', 40, 'RenegadePlatinum', 102464, 'nds', 1, 1, '2022-06-04 08:20:25', '2022-06-04 15:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--
-- Creation: Jun 05, 2022 at 04:47 PM
-- Last update: Jun 23, 2022 at 04:20 AM
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
--

--
-- Truncate table before insert `sessions`
--

TRUNCATE TABLE `sessions`;
--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YrR0iWuEs9GssHmMk86AMSJRgwaeqTfdWmiKuBs8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSUlEMHNPOHZPSk5EQTFReDZQbmZLc3hRZWgwOERRN0didThNU2lWSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODI6Imh0dHA6Ly9wb2tlcm9tX3JlYmlydGgudGVzdC9wdWJsaWMvYXBpL2Rldi9maWxlcy82MjkyZmRmZmFkNmI4M2RhMDYwZTliOTEvZG93bmxvYWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFRjOWhHNk5aMmI2S2hYZzdOZVhlak9nV0pTRE1rMVJ1NkxKZjEzVjJ0NkpzN0ZzdnlxdmoyIjt9', 1655958026);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Jun 05, 2022 at 04:47 PM
-- Last update: Jun 23, 2022 at 04:21 AM
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
(1, 'Brock', 'bglatman@outlook.com', NULL, '$2y$10$Tc9hG6NZ2b6KhXg7NeXejOgWJSDMk1Ru6LJf13V2t6Js7Fsvyqvj2', NULL, NULL, NULL, 'admin', NULL, NULL, NULL, '2022-06-23 11:20:17', '2022-06-23 11:20:17');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roms`
--
ALTER TABLE `roms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_rom_id_foreign` FOREIGN KEY (`rom_id`) REFERENCES `roms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
