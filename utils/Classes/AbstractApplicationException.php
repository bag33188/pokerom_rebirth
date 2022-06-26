<?php

namespace Utils\Classes;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * If request accepts json or is api request, a json response will be returned with error data.
     *
     * If request is web request:
     *  - If not view-name is specified, the render will be redirected and show a danger banner with the error message
     *  - If view-name is specified, the render will output the view with specified error message and http status code
     *
     * @param Request $request
     * @return Response|JsonResponse|RedirectResponse
     */
    public final function render(Request $request): Response|JsonResponse|RedirectResponse
    {
        $message = $this->getErrorMessageIfNotNull();
        $code = $this->getStatusCodeIfNotNull();
        if ($request->is('api/*') || $request->expectsJson()) {
            $response = new JsonDataResponse(['message' => $message], $code);
            return $response->renderResponse();
        } else {
            if (!$this->viewName()) {
                return redirect()->to(url()->previous())->dangerBanner($message);
            }
            return response()->view($this->viewName(), ['message' => $message], $code);
        }
    }
}
