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
    protected final const DEFAULT_STATUS_CODE = 500;

    private readonly string $_message;
    private readonly int $_code;
    private readonly string $_viewName;


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

    private function renderWebException(string|array|null $isLivewire): false|Response
    {
        if (!$isLivewire) {
            if (isset($this->_viewName)) {
                return response()->view($this->viewName(), ['message' => $this->_message], $this->_code);
            } else {
                return redirect()->to(url()->previous())->dangerBanner($this->_message);
            }
        }
        return false;
    }

    private function renderApiException(): JsonResponse
    {
        $response = new JsonDataResponse(['message' => $this->_message], $this->_code);
        return $response->renderResponse();
    }

    private function setRenderValues(): void
    {
        $this->_message = $this->getErrorMessageIfNotNull();
        $this->_code = $this->getStatusCodeIfNotNull();
        $this->_viewName = $this->viewName();
    }

    public final function render(Request $request): Response|bool|JsonResponse|RedirectResponse
    {
        $this->setRenderValues();
        $isApiRequest = $request->is('api/*') || $request->expectsJson();
        if ($isApiRequest) {
            return $this->renderApiException();
        } else {
            $isLivewire = $request->header('X-Livewire');
            return $this->renderWebException($isLivewire);
        }
    }
}
