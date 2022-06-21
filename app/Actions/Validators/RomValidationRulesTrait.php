<?php

namespace App\Actions\Validators;

use App\Rules\MaxLength;
use App\Rules\MaxSize;
use App\Rules\MinLength;
use App\Rules\MinSize;
use App\Rules\ValidRomName;
use App\Rules\ValidRomType;

trait RomValidationRulesTrait
{
    protected function romTypeRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_ROM_TYPE), new MaxLength(MAX_ROM_TYPE), new ValidRomType];
    }

    protected function romNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_ROM_NAME), new MaxLength(MAX_ROM_NAME), new ValidRomName];
    }

    protected function romSizeRules(array $rules = ['required']): array
    {
        return [...$rules, 'int', new MinSize(MIN_ROM_SIZE), new MaxSize(MAX_ROM_SIZE)];
    }
}
