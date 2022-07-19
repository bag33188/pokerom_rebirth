<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRomFilename implements Rule
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
        $validRomFileExtensionsStr = implode(', ', ROM_FILE_EXTENSIONS);
        return 'Invalid file name. Filename must: ' .
            'only contain letters, numbers, hyphens and/or underscores. ' .
            "File extension must be one of: $validRomFileExtensionsStr.";
    }
}
