<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

# use Illuminate\Support\Facades\Hash;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => $input['password'] # Hash::make($input['password']),
        ])->save();
    }
}
