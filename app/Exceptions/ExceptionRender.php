<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

trait ExceptionRender
{
    private static string $defaultView = 'errors.generic';
    private static string $defaultMsg = 'An error occurred.';

    protected function renderApiException(string $apiMessage, int $status): JsonResponse
    {
        $error = new Error(error: $apiMessage ?? self::$defaultMsg);
        return response()->json($error, $status);
    }

    protected function renderViewException(string $viewName, string $message, int $status): Response
    {
        return response()->view($viewName ?? self::$defaultView,
            ['message' => $message], $status);
    }

    #[Pure]
    protected static function makeCustomMessage(Exception $exception, string $customMessage): string
    {
        return (strlen($exception->getMessage()) != 0) ? $exception->getMessage() : $customMessage;
    }
}
