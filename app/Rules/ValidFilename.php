<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidFilename implements Rule
{
    private string $filename;

    private const __NO_FILENAME__ = 'ERR_NO_FILENAME';

    /**
     * Create a new rule instance.
     *
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
    public function passes($attribute, $value = self::__NO_FILENAME__): bool
    {
        return preg_match(FILENAME_PATTERN, $this->filename ?? $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid file name.';
    }
}
