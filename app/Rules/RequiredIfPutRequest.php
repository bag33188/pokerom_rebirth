<?php

namespace App\Rules;

use App;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/** Use this rule to require a field on a PUT request, and leave it optional/not required on a PATCH request */
class RequiredIfPutRequest extends RequiredIf
{
    private readonly Request $httpRequest;

    private const ALLOWED_HTTP_METHODS = ['put' => 'PUT', 'patch' => 'PATCH'];

    /** @var callable|bool */
    public $condition;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->httpRequest = $request;
        $this->condition = $this->httpRequestMethodIsAPutRequest();

        $this->validateIfRuleIsBeingUsedCorrectly();

        parent::__construct($this->condition);
    }

    /**
     * @throws BadRequestHttpException
     */
    private function validateIfRuleIsBeingUsedCorrectly(): void
    {
        $exceptionMessage = self::generateExceptionMessage();
        if ($this->requestMethodIsNotPutOrPatch()) {
            throw new BadRequestHttpException($exceptionMessage);
        }
    }

    private function httpRequestMethodIsAPutRequest(): bool
    {
        return $this->getRequestMethod() === self::ALLOWED_HTTP_METHODS['put'];
    }

    private function requestMethodIsNotPutOrPatch(): bool
    {
        $requestMethod = $this->getRequestMethod();

        return
            $requestMethod !== self::ALLOWED_HTTP_METHODS['put']
            and
            $requestMethod !== self::ALLOWED_HTTP_METHODS['patch'];
    }

    private function getRequestMethod(): string
    {
        return $this->httpRequest->method();
    }

    private static function generateExceptionMessage(): string
    {
        if (App::isLocal()) {
            return sprintf(
                "This rule can only be used on a %s or %s request.",
                self::ALLOWED_HTTP_METHODS['put'],
                self::ALLOWED_HTTP_METHODS['patch']
            );
        } else {
            return 'Error: Bad request';
        }
    }
}
