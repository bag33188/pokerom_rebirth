<?php

namespace Utils\Modules;

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
    public static function makeFilepathFromFilename(string $filename, ?string $prefix = null): string
    {
        return sprintf("%s/%s", $prefix ?? GridFsMethods::getGfsUploadFilepath(), $filename);
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


    /**
     * Filters an array of filenames and removes the ones that don't match a given pattern.
     *
     * @param string $pattern Regular Expression pattern
     * @param string[] $files
     * @return string[]
     */
    public static function filterUndesiredFilesFromPattern(string $pattern, array $files): array
    {
        return array_filter($files, function ($var) use ($pattern) {
            return preg_match($pattern, $var);
        });
    }
}
