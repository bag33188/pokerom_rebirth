<?php

namespace App\Http\Requests;

use App\Models\Rom;
use App\Rules\RequiredIfPutRequest;
use App\Rules\ValidRomName;
use App\Rules\ValidRomType;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Rom */
class UpdateRomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $rom = Rom::findOrFail($this->rom);
        return $this->user()->can('update', $rom);
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
            'rom_name' => [new RequiredIfPutRequest($this), 'min:3', 'max:30', new ValidRomName],
            'rom_type' => [new RequiredIfPutRequest($this), 'min:2', 'max:4', new ValidRomType],
            'rom_size' => [new RequiredIfPutRequest($this), 'int', 'min:1020', 'max:17825792'],
        ];
    }
}
