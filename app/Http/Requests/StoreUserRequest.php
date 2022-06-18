<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\MaxLength;
use App\Rules\MinLength;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin User */
class StoreUserRequest extends FormRequest
{
    // protected $redirectRoute = 'dashboard';


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
    #[ArrayShape(['name' => "array", 'email' => "array", 'password' => "array"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', new MinLength(MIN_USER_NAME), new MaxLength(MAX_USER_NAME)],
            'email' => ['required', 'string', 'email', new MaxLength(MAX_USER_EMAIL), Rule::unique("users", "email")],
            'password' => ['required', 'confirmed', new MaxLength(MAX_USER_PASSWORD), Password::defaults(function () {
                return Password::min(MIN_USER_PASSWORD)->uncompromised();
            })]
        ];
    }
}
