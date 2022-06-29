<?php

namespace App\Http\Requests;

use App\Actions\Validators\FileValidationRulesTrait;
use App\Models\RomFile;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Utils\Modules\FileMethods;

class StoreRomFileRequest extends FormRequest
{
    use FileValidationRulesTrait;

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', RomFile::class);
    }

    protected function prepareForValidation(): void
    {
        $filename = $this['filename'];
        FileMethods::normalizeFileName($filename);
        $this->merge([
            'filename' => $filename,
        ]);
    }


    #[ArrayShape(['filename' => "array"])]
    public function rules(): array
    {
        return $this->fileRules();
    }
}
