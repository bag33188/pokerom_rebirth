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
    private RequiredIfPutRequest $requiredIfPutRequest;

    public function __construct(RequiredIfPutRequest $requiredIfPutRequest)
    {
        $this->requiredIfPutRequest = $requiredIfPutRequest;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $rom = Rom::findOrFail($this->getRomIdParamValue());
        return $this->user()->can('update', $rom);
    }

    private function getRomIdParamValue(): object|string|null
    {
        return $this->route()->parameter('rom');
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
            'rom_name' => [$this->requiredIfPutRequest, 'min:3', 'max:30', new ValidRomName],
            'rom_type' => [$this->requiredIfPutRequest, 'min:2', 'max:4', new ValidRomType],
            'rom_size' => [$this->requiredIfPutRequest, 'int', 'min:1020', 'max:' . MAX_ROM_SIZE],
        ];
    }
}
