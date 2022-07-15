<?php

namespace GridFS\Support;


class FilenameHandler
{
    public string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function __invoke(): void
    {
        $this->normalizeFileName();
    }

    /**
     * Generates a filepath from a given filename. You may specify an optional `storagePathPrefix`.
     * Otherwise, the gridfs `fileUploadPath` value is used from gfs configuration.
     *
     * @param string|null $storagePathPrefix
     * @return string
     */
    public function makeFilepathFromFilename(?string $storagePathPrefix = null): string
    {
        $storagePath = isset($storagePathPrefix)
            ? storage_path($storagePathPrefix)
            : config('gridfs.fileUploadPath');
        return "$storagePath/{$this->filename}";
    }

    public function normalizeFileName(): void
    {
        // destructure
        list($name, $ext) = $this->getFileNameAndExtensionAsArray();
        self::trimFileNameEntity($name);
        self::convertFileExtEntityToLowerCase($ext);
        $this->filename = self::parseFilenameFromEntities($name, $ext);
    }

    public function filenameIsValid(): bool|int
    {
        return preg_match(FILENAME_PATTERN, $this->filename);
    }

    /**
     * Returns file name and file extension in array.
     *
     * Splits the string with a period (`.`) delimiter
     *
     * @return string[]
     */
    private function getFileNameAndExtensionAsArray(): array
    {
        // limit: split filename string only on FIRST period character.
        return explode('.', $this->filename, limit: 2);
    }

    private static function trimFileNameEntity(string &$name): void
    {
        $name = trim($name, _SPACE . "\t\n\r\0\x0B");
    }

    private static function convertFileExtEntityToLowerCase(string &$ext): void
    {
        $ext = strtolower($ext);
    }

    /**
     * Joins file's name and extension string entities into a filename string.
     *
     * @param string $f_name
     * @param string $f_ext
     * @return string
     */
    private static function parseFilenameFromEntities(string $f_name, string $f_ext): string
    {
        return "${f_name}.${f_ext}";
    }
}
