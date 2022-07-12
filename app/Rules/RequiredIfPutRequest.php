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

    /** @var callable|bool */
    public $condition;

    public function __construct(Request $request)
    {
        $this->httpRequest = $request;
        $this->setCondition();
        $this->checkIfUsedCorrectly();
        parent::__construct($this->condition);
    }

    /**
     * @throws BadRequestHttpException
     */
    private function checkIfUsedCorrectly()
    {
        $errMsg = (App::environment('local'))
            ? 'This rule can only be used on a PUT or PATCH request.' : 'Error: Bad request';
        $requestMethod = strtoupper($this->httpRequest->getMethod());
        if (self::requestIsNotPutOrPatch($requestMethod)) {
            throw new BadRequestHttpException($errMsg);
        }
    }

    private static function requestIsNotPutOrPatch(string $httpMethod): bool
    {
        return $httpMethod !== 'PUT' && $httpMethod !== 'PATCH';
    }

    private function setCondition(): void
    {
        $this->condition = $this->httpRequest->getMethod() === 'PUT';
    }
}
