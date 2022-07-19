<?php

namespace App\Http\Validators;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\ValidRomFilename;
use JetBrains\PhpStorm\Pure;

trait RomFileValidationRulesTrait
{
    #[Pure]
    protected function romFilenameRules(array $rules = ['required']): array
    {
        return [
            ...$rules,
            new ValidRomFilename,
            new MaxLength(MAX_ROM_FILENAME_LENGTH),
            new MinLength(MIN_ROM_FILENAME_LENGTH)
        ];
    }
}
