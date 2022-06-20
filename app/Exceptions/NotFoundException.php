<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Throwable;

# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundException extends Exception
{
    use ExceptionRender;

    private string $notFoundMessage;

    public function __construct(string $message = "", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->notFoundMessage = $this->generateNotFoundMessage();
    }

    private function generateNotFoundMessage(): string
    {
        return self::makeCustomMessage($this, "Error: requested endpoint not found.");
    }

    public function render(Request $request): View|Factory|JsonResponse|Application
    {
        return self::renderException($this, $request, 'errors.404', $this->notFoundMessage);
    }
}
