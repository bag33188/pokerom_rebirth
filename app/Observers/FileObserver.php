<?php

namespace App\Observers;

use App\Models\File;

class FileObserver
{
    public bool $afterCommit = false;

    public function deleted(File $file): void
    {
        $rom = $file->rom()->first();
        if (isset($rom)) {
            $rom['has_file'] = false;
            $rom['file_id'] = null;
            $rom->saveQuietly();
        }
    }
}
