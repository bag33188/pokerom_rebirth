<?php

namespace App\Actions\Validators;

use App\Exceptions\UnsupportedRomTypeException;
use App\Rules\ValidFilename;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

trait FileValidationRules
{
    private static function throwNo(string $filename){
        if(!preg_match("/\.(gba|gbc|gb|nds|xci|3ds)$/i",$filename)){
            throw new UnsupportedRomTypeException('unsupported');
        }
    }
    protected function fileRules(string $filename, array $rules = ['required']): array
    {
        self::throwNo($filename);

        $fileRules = [];
        $fileRules[FILE_FORM_KEY] = array(
            ...$rules,
            new ValidFilename($filename),
        );
        return $fileRules;
    }
}
