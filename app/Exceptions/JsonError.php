<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;
use JsonSerializable;
use Throwable;

class JsonError implements Arrayable, Jsonable, JsonSerializable
{
    public function __construct(private readonly string $error = '')
    {
    }

    public function toArray(): array
    {
        return api_res(['message' => $this->error], false);
    }

    #[ArrayShape(['success' => "false", 'message' => "string"])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @throws Throwable
     */
    public function toJson($options = 0): bool|string
    {
        $jsonEncoded = json_encode($this->jsonSerialize(), $options);
        throw_unless($jsonEncoded, JsonException::class);
        return $jsonEncoded;
    }
}
