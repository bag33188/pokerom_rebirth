<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApplicationException extends Exception
{
    private static string $defaultView = 'errors.generic';

    abstract protected function status(): int;

    abstract protected function viewName(): ?string;

    abstract protected function errorMessage(): string;

    protected final function makeCustomMessageIfDefaultIsNull(string $customMessage): string
    {
        return (strlen($this->getMessage()) != 0) ? $this->getMessage() : $customMessage;
    }

    public final function render(Request $request): Response|JsonResponse
    {
        $message = $this->errorMessage() ?: $this->getMessage();
        $statusCode = $this->status() ?: $this->getCode();
        if ($request->is('api/*')) {
            $error = new JsonError($message);
            return response()->json($error, $statusCode);
        } else {
            return response()->view($this->viewName() ?: self::$defaultView, ['message' => $message], $statusCode);
        }
    }
}
