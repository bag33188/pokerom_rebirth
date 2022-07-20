<?php

namespace App\Actions\RomFile;

class NormalizeRomFilename
{

    /**
     * Converts the `filename` property's extension to lowercase
     *
     * @param string $romFilename
     * @return void
     */
    public static function normalize(string &$romFilename): void
    {
        list($name, $ext) = explode('.', $romFilename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $romFilename = "$name.$ext";
    }
}
