<?php

use Illuminate\Support\Facades\Date;

if (!function_exists('parseDateAsReadableString')) {
    /**
     * ## Parse Date As Readable String
     *
     * Converts a date/datetime object to a human-readable string
     *
     * Uses the following format as default: `F jS, Y`
     *
     * Ex: `1998-09-28 00:00:00 -> September 28th, 1998`
     * <br/><br/>
     *
     * ## Notes
     * Set's the default timezone to Pacific Standard Time (`PST`, `GMT - 7`)
     *
     * @link https://www.php.net/manual/en/datetime.createfromformat.php
     * @link https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
     * @link https://www.php.net/manual/en/timezones.others.php
     * @param DateTime|Date $dateTime
     * @param string $format php date/datetime format string literal
     * @param bool $addDayName Set to `true` to include the name of day in the date string
     * @return string
     */
    function parseDateAsReadableString(DateTime|Date $dateTime,
                                       string        $format = DATE_FORMATS['readable_date_format'],
                                       bool          $addDayName = false): string
    {
        // set time zone
        date_default_timezone_set(TIME_ZONE_PST);

        $dtFormatString = $addDayName === true
            ? DATE_FORMATS['readable_date_format_with_day']
            : $format;
        return date_format($dateTime, $dtFormatString);
    }
}
