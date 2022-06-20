<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Throwable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    public function __construct(private readonly string $error = '')
    {
    }

    #[ArrayShape(['message' => "string"])]
    public function toArray(): array
    {
        return [
            'message' => $this->error
        ];
    }

    #[ArrayShape(['error' => "string", 'help' => "string"])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @throws Throwable
     */
    public function toJson($options = 0.0): bool|string
    {
        $jsonEncoded = json_encode($this->jsonSerialize(), $options);
        throw_unless($jsonEncoded, JsonEncodeException::class);
        return $jsonEncoded;
    }
}
