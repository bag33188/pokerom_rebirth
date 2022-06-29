<?php

namespace Utils\Modules;

use Illuminate\Support\Facades\Config;
use Storage;

class FileMethods
{
    /**
     * _Note: by default this uses `gridfs.fileUploadPath` from `config` as path prefix._
     *
     * @param string $filename
     * @param string|null $prefix Specify custom filepath prefix
     * @return string
     */
    public static function makeFilepathFromFilename(string $filename, ?string $prefix): string
    {
        return sprintf("%s/%s", $prefix ?? Config::get('gridfs.fileUploadPath'), $filename);
    }

    public static function normalizeFileName(string &$filename): void
    {
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        [$name, $ext] = explode('.', $filename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }

    public static function getAllFilesInDirectoryAsArray(string $dirname): array
    {
        self::removeSlashesFromDirname($dirname);
        return str_replace($dirname . '/', '', Storage::disk('local')->files($dirname));
    }

    private static function removeSlashesFromDirname(string &$dirname): void
    {
        $dirname = preg_replace("/\//", '', $dirname);
    }
}
