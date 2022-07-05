<?php

namespace Utils\Classes;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

abstract class AbstractApplicationException extends Exception
{
    public function __construct(protected readonly Request $request, string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    protected function isApiRequest(): bool
    {
        return $this->request->is("api/*");
    }

    protected function isLivewireRequest(): bool
    {
        $livewireHttpHeader = $this->request->header('X-Livewire');
        return isset($livewireHttpHeader);
    }

    abstract public function render(Request $request): bool|JsonResponse|RedirectResponse;
}
