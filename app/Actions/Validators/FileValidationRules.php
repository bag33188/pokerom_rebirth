<?php

namespace App\Actions\Validators;

use App\Exceptions\UnsupportedRomTypeExceptionAbstract;
use App\Rules\ValidFilename;

trait FileValidationRules
{
    private static string $fileTypesPattern = /** @lang RegExp */
        "/\.(gba|gbc|gb|nds|xci|3ds)$/i";

    /**
     * @throws UnsupportedRomTypeExceptionAbstract
     */
    private static function checkForUnsupportedMediaType(string $filename): void
    {
        if (!preg_match(self::$fileTypesPattern, $filename)) {
            throw new UnsupportedRomTypeExceptionAbstract($filename);
        }
    }

    /**
     * @throws UnsupportedRomTypeExceptionAbstract
     */
    protected function fileRules(string $filename, array $rules = ['required']): array
    {
        self::checkForUnsupportedMediaType($filename);

        $fileRules = [];
        $fileRules[FILE_FORM_KEY] = array(
            ...$rules,
            new ValidFilename($filename),
        );
        return $fileRules;
    }
}
