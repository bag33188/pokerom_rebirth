<?php

use Illuminate\Support\Facades\Date;

if (!function_exists('parseDateAsReadableString')) {
    /**
     * Converts a date/datetime object to a human-readable string
     *
     * Uses the following format as default: `F jS, Y`
     *
     * Ex: `1998-09-28 00:00:00 -> September 28th, 1998`
     *
     * @link https://www.php.net/manual/en/datetime.createfromformat.php
     * @link https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
     * @link https://www.php.net/manual/en/timezones.others.php
     * @param DateTime|Date $dateTime
     * @param string $format php date/datetime format string literal
     * @param bool $addDayName Set to `true` to include the name of day in the date string
     * @return string
     */
    function parseDateAsReadableString(DateTime|Date $dateTime, string $format = 'F jS, Y', bool $addDayName = false): string
    {
        $dtFormatString = $addDayName === true ? 'l, F jS, Y' : $format;
        return date_format($dateTime, $dtFormatString);
    }
}
