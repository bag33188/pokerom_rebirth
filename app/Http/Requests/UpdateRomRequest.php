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
    private RequiredIfPutRequest $requiredIfPut;
    public function __construct(RequiredIfPutRequest $requiredIfPut)
    {
        $this->requiredIfPut = $requiredIfPut;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $rom = Rom::findOrFail($this->getParameterValue());
        return $this->user()->can('update', $rom);
    }

    private function getParameterName()
    {
        return $this->route()->parameterNames[0];
    }

    private function getParameterValue(): object|string|null
    {
        return $this->route()->parameter($this->getParameterName());
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
            'rom_name' => [$this->requiredIfPut, 'min:3', 'max:30', new ValidRomName],
            'rom_type' => [$this->requiredIfPut, 'min:2', 'max:4', new ValidRomType],
            'rom_size' => [$this->requiredIfPut, 'int', 'min:1020', 'max:17825792'],
        ];
    }
}
