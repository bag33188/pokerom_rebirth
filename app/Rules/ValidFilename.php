<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidFilename implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match(ROM_FILENAME_PATTERN, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid file name. Filename must be: ' .
            'between 3 and 32 characters and only contain letters, numbers, hyphens and/or underscores. ' .
            'File extension must be one of: ' . implode(', ', FILE_EXTENSIONS) . '.';
    }
}
