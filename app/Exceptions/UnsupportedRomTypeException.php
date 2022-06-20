<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UnsupportedRomTypeException extends ApplicationException
{
    protected int $statusCode = ResponseAlias::HTTP_UNSUPPORTED_MEDIA_TYPE;

    public function errorMessage(): string
    {
        $fileType = explode('.', $this->getMessage(), 2)[1];
        return "File type is not supported: $fileType";
    }

    public function viewName(): ?string
    {
        return null;
    }
}
