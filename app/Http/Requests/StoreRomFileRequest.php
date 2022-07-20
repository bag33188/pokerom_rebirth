<?php

namespace App\Http\Requests;

use App\Http\Validators\RomFileValidationRulesTrait;
use App\Models\RomFile;
use GridFS\Support\FilenameHandler;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin RomFile */
class StoreRomFileRequest extends FormRequest
{
    use RomFileValidationRulesTrait;

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

 /*   protected function prepareForValidation(): void
    {
        $filenameUtil = new FilenameHandler($this->filename);
        $filenameUtil->normalizeFileName();
        $romFilename = $filenameUtil->filename;
        $this->merge([
            'filename' => $romFilename,
        ]);
    } */

    #[ArrayShape(['filename' => "array"])]
    public function rules(): array
    {
        return [
            'filename' => $this->romFilenameRules()
        ];
    }
}
