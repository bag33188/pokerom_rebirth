<?php

namespace App\Exceptions;

use Classes\ApplicationException;

class GeneralHttpException extends ApplicationException
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
