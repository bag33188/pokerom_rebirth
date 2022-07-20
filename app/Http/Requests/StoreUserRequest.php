<?php

namespace App\Http\Requests;

use App\Actions\Validators\UserValidationRulesTrait;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin User */
class StoreUserRequest extends FormRequest
{
    // protected $redirectRoute = 'dashboard';
    use UserValidationRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "mixed", 'email' => "mixed", 'password' => "mixed"])]
    public function rules(): array
    {
        return [
            'name' => $this->userNameRules(),
            'email' => $this->userEmailRules(['required', Rule::unique("users", "email")]),
            'password' => $this->userPasswordRules([
                'required',
                'confirmed',
                Password::defaults(fn() => Password::min(MIN_USER_PASSWORD_LENGTH)->uncompromised())
            ])
        ];
    }
}
