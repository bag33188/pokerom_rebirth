<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\MaxLength;
use App\Rules\MinLength;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', new MaxLength(MAX_USER_NAME), new MinLength(MIN_USER_NAME)],
            'email' => ['required', 'string', 'email', new MaxLength(MAX_USER_EMAIL), 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'] # Hash::make($input['password']),
        ]);
    }
}
