<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException;

class GeneralHttpException extends AbstractApplicationException
{

    protected function status(): int
    {
        return $this->getCode();
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
