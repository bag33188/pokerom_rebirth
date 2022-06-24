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

    abstract protected function status(): int;

    abstract protected function viewName(): ?string;

    abstract protected function errorMessage(): string;

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

    public final function render(Request $request): Response|JsonResponse|RedirectResponse
    {
        $message = $this->getErrorMessageIfNotNull();
        $code = $this->getStatusCodeIfNotNull();
        if ($request->is('api/*')) {
            $response = new JsonDataResponse(['message' => $message], $code);
            return $response->renderResponse();
        } else {
            session()->flash('success', $message);
            if (!$this->viewName()) {
                return redirect()->to(url()->previous())->dangerBanner($message);
            }
            return response()->view($this->viewName(), ['message' => $message], $code);
        }
    }
}
