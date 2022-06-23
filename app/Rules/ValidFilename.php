<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidFilename implements Rule
{
    private string $filename;


    /**
     * Create a new rule instance.
     *
     * @param string $filename Pass in filename for validation
     * @return void
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value = __NO_FILENAME__): bool
    {
        return preg_match(ROM_FILE_NAME_PATTERN, $this->filename ?? $value);
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
