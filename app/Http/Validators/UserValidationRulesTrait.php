<?php

namespace App\Http\Validators;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use JetBrains\PhpStorm\Pure;

trait UserValidationRulesTrait
{
    #[Pure]
    protected function userNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_USER_NAME), new MaxLength(MAX_USER_NAME)];
    }

    #[Pure]
    protected function userEmailRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', 'email', new MaxLength(MAX_USER_EMAIL)];
    }

    #[Pure]
    protected function userPasswordRules(array $rules = ['required']): array
    {
        return [...$rules, new MaxLength(MAX_USER_PASSWORD), new MinLength(MIN_USER_PASSWORD)];
    }
}
