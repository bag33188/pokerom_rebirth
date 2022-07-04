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

    private readonly ?string $_message;
    private readonly ?int $_code;
    private readonly ?string $_viewName;
    private readonly ?Request $_request;

    // ABSTRACT METHODS //

    /**
     * Return desired http status code (if none, default inherited error status code will be used)
     *
     * @return int|null
     */
    abstract protected function status(): ?int;

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
     * @return string|null
     */
    abstract protected function errorMessage(): ?string;


    /**
     * Set custom message in case default inherited error message's string length is `0`
     *
     * @param string $customMessage
     * @return string
     */
    protected final function makeCustomMessageIfDefaultIsNull(string $customMessage): string
    {
        return $this->lengthOfMessageIsNotZero() ? $this->getMessage() : $customMessage;
    }

    // PRIVATE METHODS //

    private function lengthOfMessageIsNotZero(): bool
    {
        return strlen($this->getMessage()) != 0;
    }

    /**
     * Returns default exception message for given exception if defined-message is null.
     *
     * @return string
     */
    private function getErrorMessageIfNotNull(): string
    {
        return $this->errorMessage() ?? $this->getMessage();
    }

    /**
     * Returns default exception code for given exception if defined-code is null.
     *
     * @return int
     */
    private function getStatusCodeIfNotNull(): int
    {
        return $this->status() ?? (int)$this->getCode();
    }

    /**
     * Redirects to previous request url and renders a danger banner in the UI containing
     * exception message.
     *
     * @return RedirectResponse
     */
    private function redirectAndRenderBanner(): RedirectResponse
    {
        return redirect()->to(url()->previous())->dangerBanner($this->_message);
    }

    /**
     * Renders a view template containing exception message.
     *
     * @return Response
     */
    private function renderViewResponse(): Response
    {
        return response()->view($this->viewName(), ['message' => $this->_message], $this->_code);
    }

    /**
     * Checks if viewName global is initiated (or has value).
     *
     * @return bool
     */
    private function viewNameIsNotNull(): bool
    {
        return isset($this->_viewName);
    }

    /**
     * Renders exception on website-based request/response
     *
     * @return Response|false|RedirectResponse
     */
    private function renderWebException(): Response|false|RedirectResponse
    {
        if (!$this->isLivewireRequest()) {
            return $this->viewNameIsNotNull() ? $this->renderViewResponse() : $this->redirectAndRenderBanner();
        }
        return false;
    }

    /**
     * Renders exception on api-based request/response
     *
     * @return JsonResponse
     */
    private function renderApiException(): JsonResponse
    {
        $response = new JsonDataResponse(['message' => $this->_message], $this->_code);
        return $response->renderResponse();
    }

    /**
     * Checks if request is API request
     *  + uses the `Accept: application/json` header
     *  + is sent from uri containing `api/`
     *
     * @return bool
     */
    private function isApiRequest(): bool
    {
        return $this->_request->is("api/*") || $this->_request->expectsJson();
    }

    /**
     * Checks if request is livewire request
     *  + references the `X-Livewire` header
     *
     * @return bool
     */
    private function isLivewireRequest(): bool
    {
        $livewireHeader = $this->_request->header('X-Livewire');
        return isset($livewireHeader);
    }

    /**
     * Sets all nullable globals for exception rendering/handling
     *
     * Takes in request object (non-injectable)
     *
     * @param Request $request
     * @return void
     */
    private function setRenderValues(Request $request): void
    {
        $this->_request = $request;
        $this->_message = $this->getErrorMessageIfNotNull();
        $this->_code = $this->getStatusCodeIfNotNull();
        $this->_viewName = $this->viewName();
    }

    // RENDER METHOD //

    /**
     * Renders the exception response appropriately
     *
     * @param Request $request
     * @return Response|bool|JsonResponse|RedirectResponse
     */
    public final function render(Request $request): Response|bool|JsonResponse|RedirectResponse
    {
        $this->setRenderValues($request);
        return $this->isApiRequest() ? $this->renderApiException() : $this->renderWebException();
    }

}
