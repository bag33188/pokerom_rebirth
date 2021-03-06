<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinLength implements Rule
{
    private readonly int $length;

    /**
     * Create a new rule instance.
     *
     * @param int $length Minimum length value
     * @return void
     */
    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return strlen($value) >= $this->length;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute must be at least {$this->length} characters.";
    }
}
