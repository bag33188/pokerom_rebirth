<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinSize implements Rule
{
    private readonly int $size;

    /**
     * Create a new rule instance.
     *
     * @param int $size Minimum size value
     * @return void
     */
    public function __construct(int $size)
    {
        $this->size = $size;
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
        return $value >= $this->size;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute must be at least $this->size.";
    }
}
