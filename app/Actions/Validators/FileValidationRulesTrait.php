<?php

namespace App\Actions\Validators;

use App\Exceptions\UnsupportedRomTypeException;
use App\Rules\ValidFilename;

trait FileValidationRulesTrait
{

    protected function fileRules( array $rules = ['required']): array
    {

        return [
            'filename'=>['required', new ValidFilename]
        ];
    }
}
