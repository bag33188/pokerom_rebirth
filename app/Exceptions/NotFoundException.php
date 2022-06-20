<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;


# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundException extends Exception
{
    use ExceptionRender {
        ExceptionRender::makeCustomMessage as makeMessage;
    }

    private string $notFoundMessage;
    private static string $viewName = 'errors.404';
    private const NOT_FOUND = 404;

    public function __construct(string $message = "", int $code = self::NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->notFoundMessage = $this->generateNotFoundMessage();
    }

    private function generateNotFoundMessage(): string
    {
        return self::makeMessage($this, "Error: requested endpoint not found.");
    }

    public function render(Request $request): View|Factory|JsonResponse|Application
    {
        return self::renderException($this, $request, self::$viewName, $this->notFoundMessage);
    }
}
