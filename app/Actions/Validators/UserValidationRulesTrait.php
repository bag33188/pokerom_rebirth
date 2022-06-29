<?php

namespace App\Actions\Validators;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait UserValidationRulesTrait
{
    protected function userNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_USER_NAME), new MaxLength(MAX_USER_NAME)];
    }

    protected function userEmailRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', 'email', new MaxLength(MAX_USER_EMAIL), Rule::unique("users", "email")];
    }

    protected function userPasswordRules(array $rules = ['required']): array
    {
        return [...$rules, new MaxLength(MAX_USER_PASSWORD), Password::defaults(function () {
            return Password::min(MIN_USER_PASSWORD)->uncompromised();
        })];
    }
}
