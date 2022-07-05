<?php

namespace Utils\Modules;

/**
 * This class contains a variety of methods that are useful when dealing with files and file metadata.
 */
class FileMethods
{
    /**
     * _Note: by default this uses `gridfs.fileUploadPath` from `config` as path prefix._
     *
     * @param string $filename
     * @param string|null $prefix Specify custom filepath prefix
     * @return string
     */
    public static function makeFilepathFromFilename(string $filename, ?string $prefix = null): string
    {
        return sprintf("%s/%s", $prefix ?? config('gridfs.fileUploadPath'), $filename);
    }

    /**
     * Procedure:
     * + Converts file ext. to lowercase
     * + Trims filename
     *
     * @param string $filename
     * @return void
     */
    public static function normalizeFileName(string &$filename): void
    {
        list($name, $ext) = self::splitFilenameIntoParts($filename);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }

    /**
     * Separates a file name and file extension within a `filename` string
     *
     * @param string $filename
     * @return string[]
     */
    public static function splitFilenameIntoParts(string $filename): array
    {
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        return explode('.', $filename, 2);
    }
}
