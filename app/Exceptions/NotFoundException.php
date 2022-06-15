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
    public function __construct(string $message = "", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): View|Factory|JsonResponse|Application
    {
        $notFoundApiMessage = strlen($this->getMessage()) !== 0 ?
            $this->getMessage() : "Error: requested endpoint not found.";
        if ($request->is('api/*')) {
            return response()
                ->json(['message' => $notFoundApiMessage], $this->getCode());
        } else {
            return view('errors.404', ['message' => $this->getMessage()]);
        }
    }
}
