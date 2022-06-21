<?php

namespace App\Exceptions;

use Classes\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UnsupportedRomTypeException extends ApplicationException
{
    public function status(): int
    {
        return ResponseAlias::HTTP_UNSUPPORTED_MEDIA_TYPE;
    }

    /**
     * Only works if filename is passed into exception constructor as message.
     *
     * @return string
     */
    private function getFileExtension(): string
    {
        return explode('.', $this->getMessage(), 2)[1];
    }

    public function errorMessage(): string
    {
        return "File type is not supported: \"{$this->getFileExtension()}\"";
    }

    public function viewName(): ?string
    {
        return null;
    }
}
