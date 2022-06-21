<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MethodNotAllowedExceptionAbstract extends AbstractApplicationException
{

    protected function status(): int
    {
        return ResponseAlias::HTTP_METHOD_NOT_ALLOWED;
    }

    protected function viewName(): ?string
    {
        return null;
    }

    protected function errorMessage(): string
    {
        return $this->getMessage();
    }
}
