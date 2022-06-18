<?php

namespace App\Actions;

use App\Rules\ValidFilename;

trait FileValidationRules {
    protected function fileRules(string $filename): array
    {
        $fileRules = [];
        $fileRules[FILE_FORM_KEY] = array(
            'required',
            new ValidFilename($filename),
        );
        return $fileRules;
    }
}
