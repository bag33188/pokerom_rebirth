<?php

namespace App\Http\Requests;

use App\Models\User;
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
    #[ArrayShape(['name' => "string[]", 'email' => "array", 'password' => "array"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:45', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:35', Rule::unique("users", "email")],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }
}