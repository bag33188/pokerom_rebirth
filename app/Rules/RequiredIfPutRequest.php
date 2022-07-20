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

    private const ALLOWED_METHODS = ['put' => 'PUT', 'patch' => 'PATCH'];

    /** @var callable|bool */
    public $condition;

    public function __construct(Request $request)
    {
        $this->httpRequest = $request;
        $this->condition = $this->httpRequestMethodIsPUT();
        $this->validateIfRuleIsBeingUsedCorrectly();
        parent::__construct($this->condition);
    }

    /**
     * @throws BadRequestHttpException
     */
    private function validateIfRuleIsBeingUsedCorrectly(): void
    {
        $errMsg = (App::environment('local'))
            ? self::localErrorMessage()
            : 'Error: Bad request';
        $requestMethod = strtoupper($this->httpRequest->getMethod());
        if (self::requestIsNotPutOrPatch($requestMethod)) {
            throw new BadRequestHttpException($errMsg);
        }
    }

    private function httpRequestMethodIsPUT(): bool
    {
        return $this->httpRequest->getMethod() === self::ALLOWED_METHODS['put'];
    }

    private static function requestIsNotPutOrPatch(string $httpMethod): bool
    {
        return $httpMethod !== self::ALLOWED_METHODS['put'] && $httpMethod !== self::ALLOWED_METHODS['patch'];
    }

    private static function localErrorMessage(): string
    {
        return sprintf(
            "This rule can only be used on a %s or %s request.",
            self::ALLOWED_METHODS['put'],
            self::ALLOWED_METHODS['patch']
        );
    }
}
