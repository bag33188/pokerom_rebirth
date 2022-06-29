<?php

namespace App\Actions\Validators;

use App\Rules\ValidRomFilename;
use JetBrains\PhpStorm\ArrayShape;

trait RomFileValidationRulesTrait
{
    #[ArrayShape(['filename' => "array"])]
    protected function romFileRules(array $rules = ['required']): array
    {

        return [
            'filename' => [...$rules, new ValidRomFilename]
        ];
    }
}
