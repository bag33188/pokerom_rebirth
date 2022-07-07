<?php

namespace Utils\Classes\_Static;

/**
 * This class contains a variety of methods that are useful when dealing with files and file metadata.
 */
class FileMethods
{
    /**
     * _Note: by default this uses `gridfs.fileUploadPath` from `config` as path prefix._
     *
     * @param string $filename
     * @param string|null $storagePathPrefix Specify custom app-storage filepath prefix
     * @return string
     */
    public static function makeFilepathFromFilename(string $filename, ?string $storagePathPrefix = null): string
    {
        $storagePath = $storagePathPrefix ? storage_path($storagePathPrefix) : config('gridfs.fileUploadPath');
        return "$storagePath/{$filename}";
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
        // destructure
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
