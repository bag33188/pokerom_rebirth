<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ValidFilename implements Rule
{
    private string $filename;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $value = null)
    {
        $this->filename = $value;
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
        return preg_match(FILENAME_PATTERN, $this->filename ??
            ($value ?: new NotAcceptableHttpException("ERR_CANNOT_GET_FILENAME")));
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
