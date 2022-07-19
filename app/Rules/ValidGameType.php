<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidGameType implements Rule
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
        return in_array(strtolower($value), GAME_TYPES);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $validGameTypesStr = implode(', ', GAME_TYPES);
        return "Invalid game type. Must be one of: ${validGameTypesStr}.";
    }
}
