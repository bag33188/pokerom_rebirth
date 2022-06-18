<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxSize implements Rule
{
    private int $size;

    /**
     * Create a new rule instance.
     *
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
    public function passes($attribute, $value)
    {
        return $value <= $this->size;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must not be greater than {$this->size}.";
    }
}
