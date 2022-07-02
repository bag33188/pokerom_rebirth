<?php

namespace Utils\Classes;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Utils\Modules\JsonDataResponse;

abstract class AbstractApplicationException extends Exception
{
    protected final const DEFAULT_ERROR_VIEW = 'errors.generic';

    /**
     * Return desired http status code (if none, default inherited error status code will be used)
     *
     * @return int
     */
    abstract protected function status(): int;

    /**
     * Return name of view to be rendered.
     * If returning null, previous page will be used and rendered with banner containing error message
     *
     * @return string|null
     */
    abstract protected function viewName(): ?string;

    /**
     * Return desired error message (if none, default inherited error message will be used)
     *
     * @return string
     */
    abstract protected function errorMessage(): string;

    /**
     * Set custom message in case default inherited error message's string length is 0
     *
     * @param string $customMessage
     * @return string
     */
    protected final function makeCustomMessageIfDefaultIsNull(string $customMessage): string
    {
        return ($this->lengthOfMessageIsNotZero()) ? $this->getMessage() : $customMessage;
    }

    private function lengthOfMessageIsNotZero(): bool
    {
        return strlen($this->getMessage()) != 0;
    }

    private function getErrorMessageIfNotNull(): string
    {
        return $this->errorMessage() ?: $this->getMessage();
    }

    private function getStatusCodeIfNotNull(): int
    {
        return $this->status() ?: (int)$this->getCode();
    }

    public final function render(Request $request): Response|bool|JsonResponse|RedirectResponse
    {
        $message = $this->getErrorMessageIfNotNull();
        $code = $this->getStatusCodeIfNotNull();
        $viewName = $this->viewName();
        if ($request->is('api/*') || $request->expectsJson()) {
            $response = new JsonDataResponse(['message' => $message], $code);
            return $response->renderResponse();
        } else {
            $isLivewire = $request->header('X-Livewire');
            if (!$isLivewire) {
                if (isset($viewName)) {
                    return response()->view($this->viewName(), ['message' => $message], $code);
                } else {
                    return redirect()->to(url()->previous())->dangerBanner($message);
                }
            }
            return false;
        }
    }
}
