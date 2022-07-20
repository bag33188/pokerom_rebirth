<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidGameRegion implements Rule
{
    protected final const FIELD_NAME = 'region';

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
        return in_array(strtolower($value), REGIONS);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $validGameRegionsStr = join(', ', REGIONS);
        return "Invalid `:attribute`. Game Region must be one of: `" . $validGameRegionsStr . "`.";
    }
}
