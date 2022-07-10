<?php

namespace App\Http\Requests;

use App\Actions\Validators\UserValidationRulesTrait;
use App\Rules\RequiredIfPutRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class UpdateUserRequest extends FormRequest
{
    use UserValidationRulesTrait;

    public function __construct(private readonly RequiredIfPutRequest $requiredIfPutRequest)
    {
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->user());
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
            'name' => $this->userNameRules(),
            'email' => $this->userEmailRules([$this->requiredIfPutRequest, Rule::unique("users", "email")]),
            'password' => $this->userPasswordRules([$this->requiredIfPutRequest, 'confirmed', Password::defaults(function () {
                return Password::min(MIN_USER_PASSWORD)->uncompromised();
            })])
        ];
    }
}
