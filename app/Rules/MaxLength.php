<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxLength implements Rule
{
    private readonly int $length;

    /**
     * Create a new rule instance.
     *
     * @param int $length Maximum length value
     * @return void
     */
    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return strlen($value) <= $this->length;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        //            "The rom name must not be greater than 4 characters."
        return "The :attribute must not be greater than {$this->length} characters.";
    }
}
