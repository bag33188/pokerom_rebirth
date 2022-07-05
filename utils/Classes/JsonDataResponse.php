<?php

namespace Utils\Classes;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

/**
 * Render a JSON Response using this class
 *
 * Takes data input, status code, and any additional headers you with to include.
 */
class JsonDataResponse implements Jsonable
{
    public readonly array $data;
    public readonly int $code;
    public readonly array $headers;

    /**
     * @param array $data Data to include as JSON
     * @param int $code HTTP Status Code
     * @param array $headers Include Optional Headers
     */
    public function __construct(array $data, int $code, array $headers = [])
    {
        self::setSuccessState($data, $code);
        $this->data = $data;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * return RenderResult when class is invoked
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->renderResponse();
    }


    /**
     * Sets the success state depending on the status code.
     *
     * > _This method is static since instance properties are readonly; they can only be set once._
     *
     * <code>
     *  success => true|false
     * </code>
     *
     * @param array $data
     * @param int $statusCode
     * @return void
     */
    private static function setSuccessState(array &$data, int $statusCode): void
    {
        $data['success'] = $statusCode < 400 && $statusCode >= 200;
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->data);
    }

    /**
     * Render `response->json(....);`
     *
     * @return JsonResponse
     */
    public final function renderResponse(): JsonResponse
    {
        return response()->json($this->data, $this->code, $this->headers);
    }
}
