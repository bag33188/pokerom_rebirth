<?php

namespace App\Http\Requests;

use App\Models\Rom;
use App\Rules\MaxLength;
use App\Rules\MaxSize;
use App\Rules\MinLength;
use App\Rules\MinSize;
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
            'rom_name' => ['required', new MinLength(MIN_ROM_NAME), new MaxLength(MAX_ROM_NAME), new ValidRomName],
            'rom_type' => ['required', new MinLength(MIN_ROM_TYPE), new MaxLength(MAX_ROM_TYPE), new ValidRomType],
            'rom_size' => ['required', 'int', new MinSize(MIN_ROM_SIZE), new MaxSize(MAX_ROM_SIZE)]
        ];
    }
}
