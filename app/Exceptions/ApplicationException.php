<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApplicationException extends Exception
{
    private static string $defaultView = 'errors.generic';
    private static string $defaultMsg = 'An error occurred.';

    abstract public function status(): int;

    abstract public function viewName(): ?string;

    abstract public function apiMessage(): ?string;

    protected function makeCustomMessage(string $customMessage): string
    {
        return (strlen($this->getMessage()) != 0) ? $this->getMessage() : $customMessage;
    }

    public function render(Request $request): Response|JsonResponse
    {
        if ($request->is('api/*')) {
            $error = new Error(error: $this->apiMessage() ?? self::$defaultMsg);
            return response()->json($error, $this->status());
        } else {
            return response()->view($viewName ?? self::$defaultView,
                ['message' => $this->getMessage()], $this->status());
        }
    }
}
