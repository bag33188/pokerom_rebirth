<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidGameName implements Rule
{
    protected final const FIELD_NAME = 'game_name';

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
        return preg_match(GAME_NAME_PATTERN, ucfirst($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "Invalid `:attribute`. Game Name must start with the word 'Pokemon'.";
    }
}
