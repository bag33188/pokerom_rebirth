<?php

namespace App\Actions\Validators;

use App\Rules\ValidFilename;
use JetBrains\PhpStorm\ArrayShape;

trait FileValidationRulesTrait
{
    #[ArrayShape(['filename' => "array"])]
    protected function fileRules(array $rules = ['required']): array
    {

        return [
            'filename' => [...$rules, new ValidFilename]
        ];
    }
}
