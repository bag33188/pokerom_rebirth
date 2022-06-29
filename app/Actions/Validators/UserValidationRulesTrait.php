<?php

namespace App\Actions\Validators;

use App\Rules\MaxLength;
use App\Rules\MinLength;

trait UserValidationRulesTrait
{
    protected function userNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_USER_NAME), new MaxLength(MAX_USER_NAME)];
    }

    protected function userEmailRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', 'email', new MaxLength(MAX_USER_EMAIL)];
    }

    protected function userPasswordRules(array $rules = ['required']): array
    {
        return [...$rules, new MaxLength(MAX_USER_PASSWORD), new MinLength(MIN_USER_PASSWORD)];
    }
}
