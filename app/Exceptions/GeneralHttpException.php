<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException as ApplicationException;

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
