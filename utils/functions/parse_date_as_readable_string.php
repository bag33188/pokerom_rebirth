<?php

use Illuminate\Support\Facades\Date;

if (!function_exists('parseDateAsReadableString')) {
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
     * @link https://www.php.net/manual/en/datetime.createfromformat.php
     * @link https://www.php.net/manual/en/timezones.others.php
     */
    function parseDateAsReadableString(DateTime|Date $dateTime, bool $addDayName = true, string $customFormat = null): string
    {
        $_formatString = $customFormat ?? ($addDayName ? 'l, F jS, Y' : 'F jS, Y');
        return date_format($dateTime, $_formatString);
    }
}
