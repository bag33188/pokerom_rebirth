<?php

namespace Utils\Classes;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractApplicationException extends Exception
{
    private static string $defaultView = 'errors.generic';

    abstract protected function status(): int;

    abstract protected function viewName(): ?string;

    abstract protected function errorMessage(): string;

    protected final function makeCustomMessageIfDefaultIsNull(string $customMessage): string
    {
        return ($this->lengthOfMessageIsNotZero()) ? $this->getMessage() : $customMessage;
    }

    private function lengthOfMessageIsNotZero(): bool
    {
        return strlen($this->getMessage()) != 0;
    }

    public final function render(Request $request): Response|JsonResponse
    {
        $message = $this->errorMessage() ?: $this->getMessage();
        $statusCode = $this->status() ?: $this->getCode();
        $responseView = $this->viewName() ?: self::$defaultView;
        if ($request->is('api/*')) {
            $response = new JsonDataResponse(['message' => $message], $statusCode);
            return $response->renderResponse();
        } else {
            return response()->view($responseView, ['message' => $message], $statusCode);
        }
    }
}
