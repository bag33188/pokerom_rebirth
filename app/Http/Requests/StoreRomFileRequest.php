<?php

namespace App\Http\Requests;

use App\Actions\Validators\FileValidationRulesTrait;
use App\Models\RomFile;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Utils\Classes\AbstractGridFsFile;
use Utils\Modules\FileMethods;

/** @mixin AbstractGridFsFile */
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
        FileMethods::normalizeFileName($this->filename);
        $this->merge([
            'filename' => $this->filename,
        ]);
    }


    #[ArrayShape(['filename' => "array"])]
    public function rules(): array
    {
        return $this->fileRules();
    }
}
