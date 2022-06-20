<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class ApplicationException extends Exception
{
    private static string $defaultView = 'errors.generic';
    private static string $defaultMsg = 'An error occurred.';
    private static int $defaultCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;

    abstract protected function status(): int;

    abstract protected function viewName(): ?string;

    abstract protected function errorMessage(): string;

    protected final function makeCustomMessageIfDefaultIsNull(string $customMessage): string
    {
        return (strlen($this->getMessage()) != 0) ? $this->getMessage() : $customMessage;
    }

    public final function render(Request $request): Response|JsonResponse
    {
        $message = $this->errorMessage() ?: self::$defaultMsg;
        $statusCode = $this->status() ?: self::$defaultCode;
        if ($request->is('api/*')) {
            $error = new JsonError($message);
            return response()->json($error, $statusCode);
        } else {
            return response()->view($this->viewName() ?: self::$defaultView, ['message' => $message], $statusCode);
        }
    }
}
