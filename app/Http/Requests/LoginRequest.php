<?php

namespace App\Http\Requests;

use App\Http\Validators\UserValidationRulesTrait as UserValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;


class LoginRequest extends FormRequest
{
    use UserValidationRules;

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
    #[ArrayShape(['email' => "array", 'password' => "array"])]
    public function rules(): array
    {
        return [
            'email' => $this->userEmailRules(),
            'password' => $this->userPasswordRules()
        ];
    }
}
