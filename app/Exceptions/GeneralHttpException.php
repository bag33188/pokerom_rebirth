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
        return self::DEFAULT_ERROR_VIEW;
    }

    protected function errorMessage(): string
    {
        return $this->getMessage();
    }
}
