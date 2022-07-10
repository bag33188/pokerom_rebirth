<?php

namespace App\Http\Validators;

use App\Rules\ValidRomFilename;
use JetBrains\PhpStorm\Pure;

trait RomFileValidationRulesTrait
{
    #[Pure]
    protected function romFilenameRules(array $rules = ['required']): array
    {
        return [...$rules, new ValidRomFilename];
    }
}
