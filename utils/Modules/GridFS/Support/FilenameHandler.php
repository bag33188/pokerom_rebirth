<?php

namespace GridFS\Support;


class FilenameHandler
{
    public function __construct(public string $filename)
    {
    }

    public function __invoke(): void
    {
        $this->normalizeFileName();
    }

    /**
     * Generates a filepath from a given filename. You may specify an optional `storagePathPrefix`.
     * Otherwise, the gridfs `fileUploadPath` value is used.
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
        list($name, $ext) = $this->getFilenameEntities();
        $name = trim($name);
        $ext = strtolower($ext);
        $this->filename = "${name}.${ext}";
    }

    /**
     * Returns file name and file extension in array
     *
     * @return array
     */
    private function getFilenameEntities(): array
    {
        // split filename string only into 2 parts regardless of how many period (`.`) characters there are
        return explode('.', $this->filename, 2);
    }

    public function filenameIsValid(): bool|int
    {
        return preg_match(FILENAME_PATTERN, $this->filename);
    }
}
