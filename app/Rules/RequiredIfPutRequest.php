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
        $exceptionMessage = self::parseExceptionMessage();
        if ($this->requestIsNotPutOrPatch()) {
            throw new BadRequestHttpException($exceptionMessage);
        }
    }

    private function httpRequestMethodIsPUT(): bool
    {
        return $this->httpRequest->getMethod() === self::ALLOWED_METHODS['put'];
    }

    private function requestIsNotPutOrPatch(): bool
    {
        $requestMethod = $this->httpRequest->method();
        return $requestMethod !== self::ALLOWED_METHODS['put'] && $requestMethod !== self::ALLOWED_METHODS['patch'];
    }

    private static function parseExceptionMessage(): string
    {
        if (App::environment('local')) {
            return sprintf(
                "This rule can only be used on a %s or %s request.",
                self::ALLOWED_METHODS['put'],
                self::ALLOWED_METHODS['patch']
            );
        } else {
            return 'Error: Bad request';
        }
    }
}
