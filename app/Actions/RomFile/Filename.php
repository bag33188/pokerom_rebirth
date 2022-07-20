<?php

namespace App\Actions\RomFile;

trait Filename
{
    /**
     * # Normalize RomFile Filename
     *
     * ```
     * trim name
     * lower case ext
     *
     * name.ext
     *```
     *
     * @param string $romFilename
     * @return void
     */
    public function normalize(string &$romFilename): void
    {
        list($name, $ext) = explode('.', $romFilename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $romFilename = "$name.$ext";
    }
}
