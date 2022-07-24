<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

trait RomFileActionsTrait
{
    public function listFilesInStorage(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }

    public function normalizeRomFilename(string &$romFilename): void
    {
        list($name, $ext) = explode($romFilename, '.', 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $romFilename = "${name}.${ext}";
    }
}
