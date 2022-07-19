<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRomType implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return in_array(strtolower($value), ROM_TYPES);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $validRomTypeStr = implode(', ', ROM_TYPES);
        return "Invalid rom type. Must be one of: ${validRomTypeStr}.";
    }
}
