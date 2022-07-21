<?php

namespace App\Actions\RomFile;

trait NormalizeFilenameActionTrait
{
    /**
     * # Normalize RomFile Filename
     *
     * ```js
     * // javascript-interpretation logic //
     *
     * // split romFilename with fullstop as delimiter
     * [name, ext] = romFilename.split('.');
     *
     * // trim the name part of `romFilename`:
     * // spaces, tabs, linefeed, carriage returns, fullstops, vertical tabs, null byte(s)
     * name = name.trim();
     *
     * // convert the ext part of `romFilename` to lower case,
     * // for use with database schema validation
     * ext = ext.toLowerCase();
     *
     * // concat result
     * return `${name}.${ext}`;
     * ```
     *
     * @param string $romFilename
     * @return void Changes semantics of (&)$romFilename parameter, has no return value.
     */
    public function normalize(string &$romFilename): void
    {
        list($name, $ext) = explode('.', $romFilename, 2);
        $name = trim($name, characters: (_SPACE . "\t\n\r\v\0\x2E"));
        $ext = strtolower($ext);
        $romFilename = "${name}.${ext}";
    }
}
