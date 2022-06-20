<?php

namespace App\Actions\Validators;

use App\Rules\ValidFilename;

trait FileValidationRules
{
    protected function fileRules(string $filename, array $rules = ['required']): array
    {
        $fileRules = [];
        $fileRules[FILE_FORM_KEY] = array(
            ...$rules,
            new ValidFilename($filename),
        );
        return $fileRules;
    }
}
