<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinLength implements Rule
{
    private int $length;

    /**
     * Create a new rule instance.
     *
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
    public function passes($attribute, $value)
    {
        return strlen($value) >= $this->length;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be at least {$this->length} characters.";
    }
}
