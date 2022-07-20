<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRomName implements Rule
{
    protected final const FIELD_NAME = 'rom_name';

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
        return preg_match(ROM_NAME_PATTERN, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "Invalid `:attribute`. Rom Name can only contain words, numbers, underscores, and/or hyphens";
    }
}
