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
        return sprintf("%s/%s", $prefix ?? self::getServerFilesUploadPath(), $filename);
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
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        [$name, $ext] = explode('.', $filename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }

    /**
     * Retrieves the upload path for grid server files
     *
     * @return string
     */
    public static function getServerFilesUploadPath(): string
    {
        return MongoMethods::getGridFSConfig()['fileUploadPath'];
    }
}
