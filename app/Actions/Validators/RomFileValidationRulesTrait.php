<?php

namespace App\Actions\Validators;

use App\Rules\ValidRomFilename;
use JetBrains\PhpStorm\Pure;

trait RomFileValidationRulesTrait
{
    #[Pure]
    protected function romFileRules(array $rules = ['required']): array
    {

        return [...$rules, new ValidRomFilename];
    }
}
