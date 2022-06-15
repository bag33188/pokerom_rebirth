<?php

namespace App\Http\Requests;

use App\Models\Rom;
use App\Rules\ValidRomName;
use App\Rules\ValidRomType;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Rom
 */
class StoreRomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Rom::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['rom_name' => "array", 'rom_type' => "array", 'rom_size' => "string[]"])]
    public function rules(): array
    {
        return [
            'rom_name' => ['required', 'min:3', 'max:30', new ValidRomName],
            'rom_type' => ['required', 'min:2', 'max:4', new ValidRomType],
            'rom_size' => ['required', 'int', 'min:1020', 'max:' . 17825792 /* KiB = 17 Gibibytes */]
        ];
    }
}
