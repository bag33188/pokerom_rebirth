<?php /** @noinspection PhpDefineCanBeReplacedWithConstInspection */

use Illuminate\Support\Facades\Date;

define('WITH_DAY_NAME', 'l, F jS, Y');
define('WITHOUT_DAY_NAME', 'F jS, Y');

if (!function_exists('parse_date_as_readable_string')) {
    /**
     * Converts a date/datetime object to a human-readable string
     *
     * **standard**: _February 27th, 1996_
     *
     * **with day added** (`$addDayName=true`): _Tuesday, February 27th, 1996_
     *
     * @param DateTime|Date $dateTime
     * @param bool $addDayName Set to `false` to exclude the exact day from the date string
     * @param string|null $customFormat Option to add your own date formatting. (ie. customFormat: "Y/m/d")
     * @return string
     *
     * @see https://www.php.net/manual/en/datetime.createfromformat.php
     */
    function parse_date_as_readable_string(DateTime|Date $dateTime, bool $addDayName = true, string $customFormat = null): string
    {
        $formatString = $customFormat ?? ($addDayName ? WITH_DAY_NAME : WITHOUT_DAY_NAME);
        return date_format($dateTime, $formatString);
    }
}
