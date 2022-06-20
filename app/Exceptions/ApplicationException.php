<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApplicationException extends Exception
{
    use ExceptionRender;
    abstract public function status(): int;

    abstract public function viewName(): ?string;

    abstract public function apiMessage(): ?string;

    public function render(Request $request): Response|JsonResponse
    {
        return self::renderException($this, $request, $this->viewName(), $this->apiMessage());
    }
}
