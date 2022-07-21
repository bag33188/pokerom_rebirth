<?php

namespace App\Actions\RomFile;

use App\Models\RomFile;

trait NormalizeFilenameTrait
{
    /**
     * ## Normalize RomFile Filename
     *
     * Does some string manipulations on a given {@see RomFile::$filename `filename property`} value.
     *
     * 1. Splits `filename` into _`$name`_ and _`$ext`_.
     * 2. Trims **spaces, tabs, linefeed, carriage returns, vertical tabs, fullstops, null byte(s)** from _`$name`_
     * 3. Converts _`$ext`_ to **lowercase** (for use with database validation schema)
     *
     * @param string $romFilename
     * @return void Changes semantics of (&)$romFilename parameter, has no return value.
     */
    public function normalize(string &$romFilename): void
    {
        list($name, $ext) = $this->splitRomFilename($romFilename);
        $this->trimFileName($name);
        $this->lowercaseFileExtension($ext);
        $romFilename = "${name}.${ext}";
    }

    private function splitRomFilename(string $romFilename): array
    {
        return explode('.', $romFilename, 2);
    }

    private function trimFileName(string &$name): void
    {
        $name = trim($name, characters: (_SPACE . "\t\n\r\v\x2E\0"));
    }

    private function lowercaseFileExtension(string &$ext): void
    {
        $ext = strtolower(string: $ext);
    }
}
