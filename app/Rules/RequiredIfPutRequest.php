<?php

namespace App\Rules;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules\RequiredIf;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/** Use this rule to require a field on a PUT request, and leave it optional on a PATCH request */
class RequiredIfPutRequest extends RequiredIf
{
    private Request $httpRequest;

    /**
     * @throws BadRequestHttpException
     */
    public function __construct(Request $request)
    {
        $this->httpRequest = $request;
        $this->checkIfUsedCorrectly();
        parent::__construct($this->condition());
    }

    /**
     * @throws BadRequestHttpException
     */
    private function checkIfUsedCorrectly()
    {
        $errMsg = (App::environment('local'))
            ? 'This rule can only be used on a PUT or PATCH request.' : 'Error: Bad request';
        if ($this->httpRequest->getMethod() !== 'PUT' && $this->httpRequest->getMethod() !== 'PATCH') {
            throw new BadRequestHttpException($errMsg);
        }
    }

    private function condition(): bool
    {
        return $this->httpRequest->getMethod() === 'PUT';
    }
}
