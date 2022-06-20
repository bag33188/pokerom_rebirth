<?php

namespace App\Http\Requests;

use App\Actions\Validators\RomValidationRules;
use App\Models\Rom;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @mixin Rom
 */
class StoreRomRequest extends FormRequest
{
    use RomValidationRules;

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
    #[ArrayShape(['rom_name' => "array", 'rom_type' => "array", 'rom_size' => "array"])]
    public function rules(): array
    {
        return [
            'rom_name' => $this->romNameRules(),
            'rom_type' => $this->romTypeRules(),
            'rom_size' => $this->romSizeRules(),
        ];
    }
}
